<x-admin.app>

    {{-- 1. LOAD PLUGIN STYLES --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    {{-- 2. CUSTOM STYLES --}}
    <style>
        /* Select2 Override */
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

        .select2-container--default.select2-container--focus .select2-selection--multiple,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #0f766e !important;
            box-shadow: 0 0 0 1px #0f766e;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0f766e !important;
            border: none !important;
            color: white !important;
            border-radius: 4px;
            padding: 2px 8px;
            margin-top: 4px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white !important;
            border-right: 1px solid rgba(255, 255, 255, 0.3) !important;
            margin-right: 6px;
        }

        /* Quill Editor Override */
        .ql-toolbar.ql-snow {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            border-color: #e2e8f0;
            background-color: #f8fafc;
        }

        .ql-container.ql-snow {
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
            border-color: #e2e8f0;
            background-color: white;
            font-family: inherit;
        }

        .ql-editor {
            min-height: 200px;
        }
    </style>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Add Project</h2>
            <p class="text-slate-500 text-sm">Create a new project listing with estimations</p>
        </div>

        <a href="{{ route('admin.projects.index') }}"
            class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-5xl">
        <div class="border-b border-gray-100 px-6 py-4">
            <h3 class="font-bold text-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-plus-circle text-primary"></i> Create New Project
            </h3>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('admin.projects.store') }}" method="POST" id="createForm">
                @csrf

                <div class="space-y-8">

                    {{-- SECTION 1: BASIC INFO --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                placeholder="Project Title" required>
                        </div>
                    </div>

                    {{-- SECTION 2: WORKS & ESTIMATION --}}
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide">
                                Works Estimation
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
                                        {{ $work->name }} (₹{{ number_format($est, 2) }} /
                                        {{ $work->unit->name ?? 'Unit' }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-slate-500 mt-2">Search and select works to add them to the estimation
                                table.</p>
                        </div>

                        {{-- Works Table --}}
                        <div class="border border-slate-200 rounded-b-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-100">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Work
                                            Item</th>
                                        <th class="px-4 py-3 text-right text-xs font-bold text-slate-500 uppercase">Est.
                                            Rate</th>
                                        <th
                                            class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase w-32">
                                            Qty</th>
                                        <th
                                            class="px-4 py-3 text-right text-xs font-bold text-slate-500 uppercase w-40">
                                            Total (₹)</th>
                                        <th
                                            class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase w-16">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200" id="works_list">
                                    <tr id="no_works_row">
                                        <td colspan="5" class="px-4 py-8 text-center text-slate-400 text-sm">
                                            No works added yet. Search above to begin.
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-slate-50 border-t border-slate-200">
                                    <tr>
                                        <td colspan="3"
                                            class="px-4 py-3 text-right text-slate-700 font-bold text-sm">Total
                                            Estimated Budget:</td>
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
                            Description <span class="text-red-500">*</span>
                        </label>
                        <input type="hidden" name="description" id="descriptionInput"
                            value="{{ old('description') }}">
                        <div id="quillEditor"></div>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SECTION 4: BUDGET & META --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Estimated Budget (Readonly) --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                                Estimated Budget (₹)
                            </label>
                            <input type="number" step="0.01" name="budget_max" id="budget_max" readonly
                                class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-lg text-sm text-slate-500 cursor-not-allowed"
                                placeholder="0.00">
                            <p class="text-[10px] text-slate-400 mt-1">* Auto-calculated from works</p>
                        </div>

                        {{-- Location --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                                Location
                            </label>
                            <input type="text" name="location" value="{{ old('location') }}"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                placeholder="City, Area">
                        </div>

                        {{-- Categories --}}
                        @php
                            $parentCategories = \App\Models\Category::query()
                                ->with(['subcategories' => fn($q) => $q->where('is_active', 1)])
                                ->whereNull('parent_id')
                                ->where('is_active', 1)
                                ->orderBy('name')
                                ->get();
                        @endphp

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                                Select Categories
                            </label>
                            <select name="categories[]" id="categories" multiple class="category-select w-full">
                                @foreach ($parentCategories as $parent)
                                    @php $children = $parent->subcategories; @endphp
                                    @if ($children->count())
                                        <optgroup label="{{ $parent->name }}">
                                            @foreach ($children as $child)
                                                <option value="{{ $child->id }}"
                                                    {{ collect(old('categories'))->contains($child->id) ? 'selected' : '' }}>
                                                    {{ $child->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @else
                                        <option value="{{ $parent->id }}"
                                            {{ collect(old('categories'))->contains($parent->id) ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('categories')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end pt-8 border-t border-slate-100 mt-8">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg text-sm font-bold text-white bg-primary hover:bg-teal-700 shadow-md shadow-teal-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-save mr-2"></i> Save Project
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 3. INITIALIZATION SCRIPTS --}}
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

        <script>
            $(document).ready(function() {

                // --- 1. Select2 Initialization ---
                $('#categories').select2({
                    placeholder: "Select categories...",
                    allowClear: true,
                    width: '100%',
                    closeOnSelect: false
                });

                // Works Search
                $('#work_search').select2({
                    placeholder: "Type to search works...",
                    allowClear: true,
                    width: '100%'
                });

                // --- 2. Quill Editor Initialization ---
                var quill;
                if (document.getElementById('quillEditor')) {
                    quill = new Quill('#quillEditor', {
                        theme: 'snow',
                        placeholder: 'Write full project description here...',
                        modules: {
                            toolbar: [
                                [{
                                    'header': [1, 2, 3, false]
                                }],
                                ['bold', 'italic', 'underline', 'strike'],
                                [{
                                    'list': 'ordered'
                                }, {
                                    'list': 'bullet'
                                }],
                                [{
                                    'color': []
                                }, {
                                    'background': []
                                }],
                                ['link', 'image', 'video'],
                                ['clean']
                            ]
                        }
                    });

                    // Custom Image/Video Handler
                    function handleFileUpload(type) {
                        var input = $("<input>").attr("type", "file").attr("accept", type + "/*");
                        input.trigger("click");
                        input.on("change", function() {
                            var file = this.files[0];
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                var base64 = e.target.result;
                                var range = quill.getSelection(true);
                                quill.insertEmbed(range.index, type, base64);
                            };
                            reader.readAsDataURL(file);
                        });
                    }

                    quill.getModule("toolbar").addHandler("image", function() {
                        handleFileUpload("image");
                    });
                    quill.getModule("toolbar").addHandler("video", function() {
                        handleFileUpload("video");
                    });

                    // Load Old Content
                    var oldContent = `{!! old('description') !!}`;
                    if (oldContent) {
                        quill.root.innerHTML = oldContent;
                    }
                }

                // --- 3. Works Table Logic ---

                // Add Work
                $('#work_search').on('select2:select', function(e) {
                    var data = e.params.data;
                    var id = data.id;

                    // Prevent duplicates
                    if ($('#work_row_' + id).length > 0) {
                        alert('This work is already added.');
                        $('#work_search').val(null).trigger('change');
                        return;
                    }

                    var name = $(data.element).data('name');
                    var unit = $(data.element).data('unit');
                    var price = parseFloat($(data.element).data('price'));

                    $('#no_works_row').hide();

                    var row = `
                        <tr id="work_row_${id}" class="work-item-row hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 text-sm text-slate-700 font-medium">
                                ${name}
                                <div class="text-xs text-slate-400">Unit: ${unit}</div>
                                <input type="hidden" name="works[${id}][amount]" class="input-amount" value="${price}">
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-500 text-right">
                                ₹${price.toFixed(2)}
                                <input type="hidden" class="row-price" value="${price}">
                            </td>
                            <td class="px-4 py-3 text-center">
                                <input type="number" name="works[${id}][quantity]" value="1" min="1"
                                    class="row-qty w-20 text-center border-slate-200 rounded-md shadow-sm sm:text-sm focus:ring-primary focus:border-primary p-1">
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-800 text-right font-bold">
                                ₹<span class="row-total">${price.toFixed(2)}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" onclick="removeWork('${id}')" class="text-red-500 hover:text-red-700 transition-colors">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    $('#works_list').append(row);
                    $('#work_search').val(null).trigger('change');
                    calculateGrandTotal();
                });

                // Update Totals on Quantity Change
                $(document).on('input', '.row-qty', function() {
                    var row = $(this).closest('tr');
                    var qty = parseFloat($(this).val()) || 0;
                    var price = parseFloat(row.find('.row-price').val()) || 0;
                    var total = qty * price;

                    row.find('.row-total').text(total.toFixed(2));
                    row.find('.input-amount').val(total.toFixed(2));
                    calculateGrandTotal();
                });

                // Remove Work (Global function)
                window.removeWork = function(id) {
                    $('#work_row_' + id).remove();
                    if ($('#works_list tr.work-item-row').length === 0) {
                        $('#no_works_row').show();
                    }
                    calculateGrandTotal();
                };

                // Calculate Grand Total
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

                // --- 4. Final Form Submit ---
                $('#createForm').on('submit', function() {
                    if (quill) {
                        var html = quill.root.innerHTML;
                        if (html === '<p><br></p>') html = '';
                        $('#descriptionInput').val(html);
                    }
                });
            });
        </script>
    @endpush

</x-admin.app>
