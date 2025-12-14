<x-admin.app>

    {{-- 1. LOAD PLUGIN STYLES --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    {{-- 2. CUSTOM STYLES --}}
    <style>
        /* Select2 Override */
        .select2-container .select2-selection--multiple {
            min-height: 45px;
            border-color: #e2e8f0 !important;
            border-radius: 0.5rem !important;
            padding: 6px 8px;
            background-color: #f8fafc;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
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
            <p class="text-slate-500 text-sm">Create a new project listing</p>
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
            <form action="{{ route('admin.projects.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

                    {{-- Title --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="Project Title" required>
                    </div>

                    {{-- Location --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Location
                        </label>
                        <input type="text" name="location" value="{{ old('location') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="City, Area">
                    </div>

                    {{-- Budget Min --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Budget Min (₹)
                        </label>
                        <input type="number" step="0.01" name="budget_min"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="0.00">
                    </div>

                    {{-- Budget Max --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Budget Max (₹)
                        </label>
                        <input type="number" step="0.01" name="budget_max"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="0.00">
                    </div>

                    {{-- Multiple Categories (Select2) --}}
                    @php
                        $parentCategories = \App\Models\Category::query()
                            ->with(['subcategories' => fn($q) => $q->where('is_active', 1)])
                            ->whereNull('parent_id')
                            ->where('is_active', 1)
                            ->orderBy('name')
                            ->get();
                    @endphp

                    <div class="col-span-1 md:col-span-2 lg:col-span-4">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Select Categories (Multiple)
                        </label>
                        <div class="relative">
                            <select name="categories[]" multiple class="category-select w-full" style="display: none;">
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
                        </div>
                        @error('categories')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description (Quill Editor) --}}
                    <div class="col-span-1 md:col-span-2 lg:col-span-4">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Description <span class="text-red-500">*</span>
                        </label>

                        {{-- Hidden Input for Quill Data --}}
                        <input type="hidden" name="description" id="descriptionInput"
                            value="{{ old('description') }}">

                        {{-- Quill Container --}}
                        <div class="bg-white">
                            <div id="quillEditor"></div>
                        </div>

                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end pt-6 border-t border-slate-100">
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
        {{-- Load Libraries --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

        <script>
            $(document).ready(function() {

                // --- 1. Select2 Initialization ---
                $('.category-select').select2({
                    placeholder: "Select categories...",
                    allowClear: true,
                    width: '100%',
                    closeOnSelect: false
                });

                // --- 2. Quill Editor Initialization ---
                if (document.getElementById('quillEditor')) {
                    var quill = new Quill('#quillEditor', {
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
                                ['link', 'image', 'video'], // Added Image and Video
                                ['clean']
                            ]
                        }
                    });

                    // --- Custom Handler for Image/Video Upload (Base64) ---
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

                    // Attach handlers to toolbar
                    quill.getModule("toolbar").addHandler("image", function() {
                        handleFileUpload("image");
                    });
                    quill.getModule("toolbar").addHandler("video", function() {
                        handleFileUpload("video");
                    });

                    // --- Load & Sync Data ---
                    var oldContent = `{!! old('description') !!}`;
                    if (oldContent) {
                        quill.root.innerHTML = oldContent;
                    }

                    $('form').on('submit', function() {
                        var html = quill.root.innerHTML;
                        if (html === '<p><br></p>') html = '';
                        $('#descriptionInput').val(html);
                    });
                }
            });
        </script>
    @endpush

</x-admin.app>
