<x-admin.app title="Create Project" header="Create Project">

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
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Project Details</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Fill in the information to post a new project.</p>
            </div>

            <form action="{{ route('user.projects.store') }}" method="POST" id="projectForm" class="p-6 space-y-6">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Project Title <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md border p-2.5">
                    @error('title')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <div class="flex justify-between items-end mb-2">
                        <label class="block text-sm font-medium text-gray-700">Project Works & Estimation</label>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-t-lg border border-b-0 border-gray-300">
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
                                    {{ $work->name }} (₹{{ number_format($est, 2) }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Search and select a work to add it to the estimation
                            table.</p>
                    </div>

                    <div class="border border-gray-300 rounded-b-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Work</th>
                                    <th class="px-4 py-2 text-right text-xs font-bold text-gray-500 uppercase">Rate</th>
                                    <th class="px-4 py-2 text-center text-xs font-bold text-gray-500 uppercase w-24">Qty
                                    </th>
                                    <th class="px-4 py-2 text-right text-xs font-bold text-gray-500 uppercase">Total
                                    </th>
                                    <th class="px-4 py-2 text-center text-xs font-bold text-gray-500 uppercase w-10">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="works_list">
                                <tr id="no_works_row">
                                    <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-400">No works
                                        added yet.</td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-gray-50 font-bold">
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-right text-gray-700">Total Estimate:</td>
                                    <td class="px-4 py-3 text-right text-indigo-700">₹<span
                                            id="grand_total_display">0.00</span></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description <span
                            class="text-red-500">*</span></label>
                    <div id="editor-container" class="bg-white rounded-md border border-gray-300">
                        {!! old('description') !!}</div>
                    <input type="hidden" name="description" id="hidden_description">
                    @error('description')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="budget_max" class="block text-sm font-medium text-gray-700">Estimated Budget
                            (₹)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">₹</span>
                            </div>
                            <input type="number" name="budget_max" id="budget_max" min="0" step="0.01"
                                value="{{ old('budget_max') }}" readonly
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md border p-2.5 bg-gray-50 cursor-not-allowed text-gray-500">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Auto-calculated from works table above.</p>
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md border p-2.5">
                    </div>
                </div>

                @php
                    $parentCategories = \App\Models\Category::query()
                        ->whereNull('parent_id')
                        ->where('is_active', 1)
                        ->orderBy('name')
                        ->get();
                @endphp
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Categories</label>
                    <select name="categories[]" id="categories" multiple class="w-full">
                        @foreach ($parentCategories as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end border-t border-gray-200 pt-5">
                    <a href="{{ route('user.projects.index') }}"
                        class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</a>
                    <button type="submit"
                        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Create
                        Project</button>
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
                // Init Select2
                $('#categories').select2({
                    placeholder: "Select categories...",
                    width: '100%'
                });
                $('#work_search').select2({
                    placeholder: "Type to search works...",
                    allowClear: true,
                    width: '100%'
                });

                // Init Quill
                var quill = new Quill('#editor-container', {
                    theme: 'snow',
                    placeholder: 'Write full project details here...',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'list'],
                            ['link', 'image', 'video'],
                            ['clean']
                        ]
                    }
                });

                // --- Work Table Logic ---
                $('#work_search').on('select2:select', function(e) {
                    var data = e.params.data;
                    var id = data.id;

                    if ($('#work_row_' + id).length > 0) {
                        alert('Work already added!');
                        $('#work_search').val(null).trigger('change');
                        return;
                    }

                    $('#no_works_row').hide();

                    var name = $(data.element).data('name');
                    var unit = $(data.element).data('unit');
                    var price = parseFloat($(data.element).data('price'));

                    var row = `
                    <tr id="work_row_${id}">
                        <td class="px-4 py-2 text-sm text-gray-900">
                            <div class="font-medium">${name}</div>
                            <div class="text-xs text-gray-500">${unit}</div>
                            <input type="hidden" name="works[${id}][amount]" class="row-amount-input" value="${price}">
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-500 text-right">₹${price.toFixed(2)}</td>
                        <td class="px-4 py-2 text-center">
                            <input type="number" name="works[${id}][quantity]" value="1" min="1"
                                class="row-qty w-16 text-center border-gray-300 rounded shadow-sm text-sm p-1" data-price="${price}">
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-900 text-right font-bold row-total">₹${price.toFixed(2)}</td>
                        <td class="px-4 py-2 text-center">
                            <button type="button" onclick="removeRow('${id}')" class="text-red-500 hover:text-red-700 font-bold">&times;</button>
                        </td>
                    </tr>
                `;

                    $('#works_list').append(row);
                    $('#work_search').val(null).trigger('change');
                    calcTotal();
                });

                // Handle Qty Change
                $(document).on('input', '.row-qty', function() {
                    var qty = parseFloat($(this).val()) || 0;
                    var price = parseFloat($(this).data('price'));
                    var total = qty * price;

                    $(this).closest('tr').find('.row-total').text('₹' + total.toFixed(2));
                    $(this).closest('tr').find('.row-amount-input').val(total.toFixed(2));
                    calcTotal();
                });

                // Remove Row
                window.removeRow = function(id) {
                    $('#work_row_' + id).remove();
                    if ($('#works_list tr').length <= 1) $('#no_works_row').show();
                    calcTotal();
                }

                function calcTotal() {
                    var grandTotal = 0;
                    $('.row-qty').each(function() {
                        var qty = parseFloat($(this).val()) || 0;
                        var price = parseFloat($(this).data('price'));
                        grandTotal += (qty * price);
                    });
                    $('#grand_total_display').text(grandTotal.toFixed(2));
                    $('#budget_max').val(grandTotal.toFixed(2));
                }

                // Sync Form
                $('#projectForm').on('submit', function() {
                    $('#hidden_description').val(document.querySelector('.ql-editor').innerHTML);
                });
            });
        </script>
    @endpush

</x-admin.app>
