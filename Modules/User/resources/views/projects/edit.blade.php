<x-user.user-layout title="Edit Project" header="Edit Project: {{ $project->title }}">

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <style>
            .select2-container .select2-selection--single {
                height: 42px;
                border-color: #d1d5db;
                display: flex;
                align-items: center;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                top: 8px;
            }

            .ql-editor {
                min-height: 200px;
            }
        </style>
    @endpush

    <div class="max-w-5xl mx-auto py-10 sm:px-6 lg:px-8">

        <div class="bg-white overflow-hidden shadow sm:rounded-lg">
            <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Edit Project Details</h3>
                    <p class="mt-1 text-sm text-gray-500">Update project requirements and estimations.</p>
                </div>
                <form action="{{ route('user.projects.destroy', $project->id) }}" method="POST"
                    class="delete-form-edit">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                        class="text-red-600 hover:text-red-900 text-sm font-bold bg-red-50 hover:bg-red-100 px-4 py-2 rounded-md transition-colors delete-btn-edit">
                        Delete Project
                    </button>
                </form>
            </div>

            <form action="{{ route('user.projects.update', $project->id) }}" method="POST" id="editForm"
                class="p-6 space-y-8">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Project Title <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Description <span
                                class="text-red-500">*</span></label>
                        <div id="editor-container" class="bg-white rounded-md border border-gray-300">
                            {!! old('description', $project->description) !!}
                        </div>
                        <input type="hidden" name="description" id="hidden_description">
                    </div>
                </div>

                <hr class="border-gray-200">

                <div>
                    <div class="flex justify-between items-end mb-4">
                        <div>
                            <h4 class="text-lg font-bold text-gray-900">Works Estimation</h4>
                            <p class="text-sm text-gray-500">Search and add works to update your budget.</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Search & Add
                            Work</label>
                        <select id="work_search" class="w-full">
                            <option></option>
                            @foreach ($works as $work)
                                @php
                                    $est = ($work->labor_material_min + $work->labor_material_max) / 2;
                                    if ($est == 0) {
                                        $est = ($work->labor_min + $work->labor_max) / 2;
                                    }
                                @endphp
                                <option value="{{ $work->id }}" data-name="{{ $work->name }}"
                                    data-unit="{{ $work->unit->name ?? 'Unit' }}" data-price="{{ $est }}">
                                    {{ $work->name }} — ₹{{ number_format($est, 2) }} /
                                    {{ $work->unit->name ?? 'Unit' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200" id="works_table">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Work Item
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">Est. Rate
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase w-32">
                                        Quantity</th>
                                    <th scope="col"
                                        class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase w-40">
                                        Total (₹)</th>
                                    <th scope="col"
                                        class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase w-16">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="works_list">
                                @foreach ($project->works as $pWork)
                                    @php
                                        // Use pivot data for quantity.
                                        // For rate, we use the CURRENT rate from the work definition (or stored if you want to lock it)
                                        // Assuming we use current Work rate for estimation updates:
                                        $rate = ($pWork->labor_material_min + $pWork->labor_material_max) / 2;
                                        if ($rate == 0) {
                                            $rate = ($pWork->labor_min + $pWork->labor_max) / 2;
                                        }

                                        $qty = $pWork->pivot->quantity;
                                        $total = $rate * $qty;
                                    @endphp
                                    <tr id="work_row_{{ $pWork->id }}"
                                        class="work-item-row hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">
                                            {{ $pWork->name }}
                                            <div class="text-xs text-gray-500">Unit: {{ $pWork->unit->name ?? 'Unit' }}
                                            </div>
                                            <input type="hidden" name="works[{{ $pWork->id }}][amount]"
                                                class="input-amount" value="{{ $total }}">
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500 text-right">
                                            ₹{{ number_format($rate, 2) }}
                                            <input type="hidden" class="row-price" value="{{ $rate }}">
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <input type="number" name="works[{{ $pWork->id }}][quantity]"
                                                value="{{ $qty }}" min="1"
                                                class="row-qty w-20 text-center border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 p-1">
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 text-right font-bold">
                                            ₹<span class="row-total">{{ number_format($total, 2) }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <button type="button" onclick="removeWork('{{ $pWork->id }}')"
                                                class="text-red-500 hover:text-red-700">
                                                <svg class="w-5 h-5 mx-auto" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                                <tr id="no_works_row" style="{{ $project->works->count() > 0 ? 'display:none' : '' }}">
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-400 text-sm">
                                        No works added yet. Search above to begin.
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-indigo-50 border-t border-indigo-100 font-bold">
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-right text-indigo-900">Total Estimated
                                        Budget:</td>
                                    <td class="px-4 py-3 text-right text-indigo-700 text-lg">
                                        ₹<span
                                            id="grand_total_display">{{ number_format($project->budget_max, 2) }}</span>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <hr class="border-gray-200">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="hidden">
                        <input type="number" name="budget_max" id="budget_max"
                            value="{{ old('budget_max', $project->budget_max) }}" readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700">Location</label>
                        <input type="text" name="location" id="location"
                            value="{{ old('location', $project->location) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border">
                    </div>

                    @php
                        $parentCategories = \App\Models\Category::query()
                            ->whereNull('parent_id')
                            ->where('is_active', 1)
                            ->orderBy('name')
                            ->get();
                        $selectedIds = old('categories', $project->categories->pluck('id')->toArray());
                    @endphp
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Project Category</label>
                        <select name="categories[]" id="categories" multiple class="w-full">
                            @foreach ($parentCategories as $parent)
                                <option value="{{ $parent->id }}"
                                    {{ in_array($parent->id, $selectedIds) ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end pt-4">
                    <a href="{{ route('user.projects.index') }}"
                        class="text-sm font-medium text-gray-600 hover:text-gray-900 mr-6">Cancel</a>
                    <button type="submit"
                        class="inline-flex justify-center py-2.5 px-6 border border-transparent shadow-sm text-sm font-bold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Project
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

        <script>
            $(document).ready(function() {
                // --- 1. Init UI Components ---
                $('#categories').select2({
                    placeholder: "Select categories...",
                    width: '100%'
                });
                $('#work_search').select2({
                    placeholder: "Type to search works...",
                    allowClear: true,
                    width: '100%'
                });

                // Quill with Image/Video
                var quill = new Quill('#editor-container', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'list'],
                            ['link', 'image', 'video'],
                            ['clean']
                        ]
                    }
                });

                // --- 2. Work List Logic ---

                // On Search Select
                $('#work_search').on('select2:select', function(e) {
                    var data = e.params.data;
                    var id = data.id;
                    var name = $(data.element).data('name');
                    var unit = $(data.element).data('unit');
                    var price = parseFloat($(data.element).data('price'));

                    if ($('#work_row_' + id).length > 0) {
                        alert('This work is already added.');
                        $('#work_search').val(null).trigger('change');
                        return;
                    }

                    $('#no_works_row').hide();
                    addWorkRow(id, name, unit, price);
                    $('#work_search').val(null).trigger('change');
                });

                function addWorkRow(id, name, unit, price) {
                    var html = `
                    <tr id="work_row_${id}" class="work-item-row hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">
                            ${name}
                            <div class="text-xs text-gray-500">Unit: ${unit}</div>
                            <input type="hidden" name="works[${id}][amount]" class="input-amount" value="${price}">
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500 text-right">
                            ₹${price.toFixed(2)}
                            <input type="hidden" class="row-price" value="${price}">
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="number" name="works[${id}][quantity]" value="1" min="1"
                                class="row-qty w-20 text-center border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 p-1">
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 text-right font-bold">
                            ₹<span class="row-total">${price.toFixed(2)}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button type="button" onclick="removeWork('${id}')" class="text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </td>
                    </tr>
                `;
                    $('#works_list').append(html);
                    calculateGrandTotal();
                }

                // Remove Row
                window.removeWork = function(id) {
                    $('#work_row_' + id).remove();
                    if ($('#works_list tr.work-item-row').length === 0) {
                        $('#no_works_row').show();
                    }
                    calculateGrandTotal();
                };

                // Calculate Row Total on Qty Change
                $(document).on('input', '.row-qty', function() {
                    var row = $(this).closest('tr');
                    var qty = parseFloat($(this).val()) || 0;
                    var price = parseFloat(row.find('.row-price').val()) || 0;
                    var total = qty * price;

                    row.find('.row-total').text(total.toFixed(2));
                    row.find('.input-amount').val(total.toFixed(2));

                    calculateGrandTotal();
                });

                function calculateGrandTotal() {
                    var grandTotal = 0;
                    $('.work-item-row').each(function() {
                        var qty = parseFloat($(this).find('.row-qty').val()) || 0;
                        var price = parseFloat($(this).find('.row-price').val()) || 0;
                        grandTotal += (qty * price);
                    });

                    $('#grand_total_display').text(grandTotal.toFixed(2));
                    $('#budget_max').val(grandTotal.toFixed(2));
                }

                // --- 3. Final Submit Sync ---
                $('#editForm').on('submit', function(e) {
                    var editorContent = document.querySelector('.ql-editor').innerHTML;
                    $('#hidden_description').val(editorContent);
                });

                // Delete Logic
                $('.delete-btn-edit').on('click', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to delete this project?')) {
                        $('.delete-form-edit').submit();
                    }
                });
            });
        </script>
    @endpush

</x-user.user-layout>
