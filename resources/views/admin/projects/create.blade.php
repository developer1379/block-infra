<x-admin-layout>

    {{-- 1. STYLES --}}
    @push('styles')
        <style>
            /* Admin-specific overrides */
            .select2-container .select2-selection--multiple,
            .select2-container .select2-selection--single {
                min-height: 45px;
                border-color: #e2e8f0 !important;
                border-radius: 0.5rem !important;
                padding: 6px 8px;
                background-color: #f8fafc;
                display: flex;
                align-items: center;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                top: 10px;
            }

            .ql-editor {
                min-height: 200px;
            }
        </style>
    @endpush

    {{-- 2. HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Create Project</h2>
            <p class="text-slate-500 text-sm">Post a new project and set initial estimations</p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('admin.projects.index') }}"
                class="inline-flex items-center gap-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
                <i class="fa-solid fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    {{-- 3. FORM CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-5xl">
        <div class="p-6 md:p-8">
            <form action="{{ route('admin.projects.store') }}" method="POST" id="projectForm">
                @csrf

                <div class="space-y-8">

                    {{-- SECTION 1: BASIC INFO --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                                Project Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary"
                                placeholder="Enter project name">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- SECTION 2: WORKS & ESTIMATION --}}
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide">
                                Works & Estimation Table
                            </label>
                        </div>

                        {{-- Search Box --}}
                        <div class="bg-slate-50 p-4 rounded-t-lg border border-slate-200 border-b-0">
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
                            <p class="text-[10px] text-slate-400 mt-2 italic">Search and select a work item to add it to your estimate.</p>
                        </div>

                        {{-- Works Table --}}
                        <div class="border border-slate-200 rounded-b-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-100">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Work Item</th>
                                        <th class="px-4 py-3 text-right text-xs font-bold text-slate-500 uppercase">Rate</th>
                                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase w-32">Qty</th>
                                        <th class="px-4 py-3 text-right text-xs font-bold text-slate-500 uppercase w-40">Total (₹)</th>
                                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase w-16"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200" id="works_list">
                                    <tr id="no_works_row">
                                        <td colspan="5" class="px-4 py-8 text-center text-slate-400 text-sm italic">
                                            No works added yet. Use the search box above to add items.
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-slate-50 border-t border-slate-200">
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-right text-slate-700 font-bold text-sm">Grand Total Estimate:</td>
                                        <td class="px-4 py-3 text-right text-primary font-bold text-lg">
                                            ₹<span id="grand_total_display">0.00</span>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- SECTION 3: DESCRIPTION --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Project Description <span class="text-red-500">*</span>
                        </label>
                        {{-- The ID quillEditor triggers the global init in admin.partials.scripts --}}
                        <input type="hidden" name="description" id="descriptionInput" value="{{ old('description') }}">
                        <div id="quillEditor">
                            {!! old('description') !!}
                        </div>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SECTION 4: META --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">Estimated Budget (₹)</label>
                            <input type="number" step="0.01" name="budget_max" id="budget_max"
                                value="{{ old('budget_max', 0) }}" readonly
                                class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-lg text-sm text-slate-500 cursor-not-allowed">
                            <p class="text-[10px] text-slate-400 mt-1 italic">Auto-calculated from works table.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">Location</label>
                            <input type="text" name="location" value="{{ old('location') }}"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary"
                                placeholder="e.g. City, Region">
                        </div>

                        {{-- Categories --}}
                        @php
                            $parentCategories = \App\Models\Category::query()
                                ->whereNull('parent_id')
                                ->where('is_active', 1)
                                ->orderBy('name')
                                ->get();
                        @endphp
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">Project Categories</label>
                            <select name="categories[]" id="categories" multiple class="category-select w-full">
                                @foreach ($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" {{ in_array($parent->id, old('categories', [])) ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end pt-8 border-t border-slate-100 mt-8">
                    <button type="submit"
                        class="px-8 py-3 rounded-lg text-sm font-bold text-white bg-primary hover:bg-teal-700 shadow-lg shadow-teal-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-cloud-upload mr-2"></i> Create Project
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPTS --}}
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Select2 Initializer for work search (categories is handled by global category-select class)
                $('#work_search').select2({
                    placeholder: "Type to search work items...",
                    allowClear: true,
                    width: '100%'
                });

                // --- Works Logic ---
                $('#work_search').on('select2:select', function(e) {
                    var data = e.params.data;
                    var id = data.id;
                    if ($('#work_row_' + id).length > 0) {
                        alert('This work item has already been added.');
                        $('#work_search').val(null).trigger('change');
                        return;
                    }
                    $('#no_works_row').hide();

                    var name = $(data.element).data('name');
                    var unit = $(data.element).data('unit');
                    var price = parseFloat($(data.element).data('price'));

                    var row = `
                        <tr id="work_row_${id}" class="work-item-row hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 text-sm font-medium text-slate-700">
                                ${name}
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Unit: ${unit}</div>
                                <input type="hidden" name="works[${id}][amount]" class="input-amount" value="${price}">
                            </td>
                            <td class="px-4 py-3 text-sm text-right text-slate-500">
                                ₹${price.toFixed(2)}
                                <input type="hidden" class="row-price" value="${price}">
                            </td>
                            <td class="px-4 py-3 text-center">
                                <input type="number" name="works[${id}][quantity]" value="1" min="1" 
                                    class="row-qty w-20 text-center border-slate-200 rounded-md shadow-sm text-sm focus:ring-primary focus:border-primary p-1.5 bg-slate-50">
                            </td>
                            <td class="px-4 py-3 text-sm text-right font-bold text-slate-800">
                                ₹<span class="row-total">${price.toFixed(2)}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" onclick="removeWork('${id}')" class="text-red-400 hover:text-red-600 transition-colors">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    $('#works_list').append(row);
                    $('#work_search').val(null).trigger('change');
                    calculateGrandTotal();
                });

                $(document).on('input', '.row-qty', function() {
                    var row = $(this).closest('tr');
                    var qty = parseFloat($(this).val()) || 0;
                    var price = parseFloat(row.find('.row-price').val()) || 0;
                    var total = qty * price;
                    row.find('.row-total').text(total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                    row.find('.input-amount').val(total.toFixed(2));
                    calculateGrandTotal();
                });

                window.removeWork = function(id) {
                    $('#work_row_' + id).fadeOut(200, function() {
                        $(this).remove();
                        if ($('#works_list tr.work-item-row').length === 0) $('#no_works_row').show();
                        calculateGrandTotal();
                    });
                };

                function calculateGrandTotal() {
                    var grandTotal = 0;
                    $('.work-item-row').each(function() {
                        var qty = parseFloat($(this).find('.row-qty').val()) || 0;
                        var price = parseFloat($(this).find('.row-price').val()) || 0;
                        grandTotal += (qty * price);
                    });
                    $('#grand_total_display').text(grandTotal.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                    $('#budget_max').val(grandTotal.toFixed(2));
                }
            });
        </script>
    @endpush
</x-admin-layout>
