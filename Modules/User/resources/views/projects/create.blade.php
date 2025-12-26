<x-user.user-layout title="Create Project" header="Create Project">

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

        <style>
            /* Select2 Tailwind Fixes */
            .select2-container .select2-selection--multiple {
                min-height: 42px;
                border-color: #d1d5db;
            }

            /* Quill Editor Height */
            .ql-editor {
                min-height: 200px;
            }
        </style>
    @endpush

    <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">

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
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md border p-2">
                    @error('title')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description <span
                            class="text-red-500">*</span></label>

                    <div id="editor-container" class="bg-white">
                        {!! old('description') !!}
                    </div>

                    <input type="hidden" name="description" id="hidden_description">

                    <p class="mt-2 text-sm text-gray-500">Describe the requirements and deliverables in detail.</p>
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
                            <input type="number" name="budget_max" id="budget_max" min="0"
                                value="{{ old('budget_max') }}"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md border p-2"
                                placeholder="0.00">
                        </div>
                        @error('budget_max')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md border p-2"
                            placeholder="e.g. Remote, Mumbai, Delhi">
                    </div>
                </div>

                @php
                    $parentCategories = \App\Models\Category::query()
                        ->with(['subcategories' => fn($q) => $q->where('is_active', 1)])
                        ->whereNull('parent_id')
                        ->where('is_active', 1)
                        ->orderBy('name')
                        ->get();
                @endphp

                <div class="col-span-1 md:col-span-2 lg:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Select Categories (Multiple)
                    </label>
                    <div class="relative">
                        <select name="categories[]" id="categories" multiple class="w-full">
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

                <div class="flex items-center justify-end border-t border-gray-200 pt-5">
                    <a href="{{ route('user.projects.index') }}"
                        class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <button type="submit"
                        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create Project
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
                // 1. Initialize Select2
                $('#categories').select2({
                    placeholder: "Select categories...",
                    allowClear: true,
                    width: '100%'
                });

                // 2. Initialize Quill Editor with Image and Video
                var quill = new Quill('#editor-container', {
                    theme: 'snow',
                    placeholder: 'Write full project details here...',
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
                            ['link', 'image', 'video'], // <--- ADDED image and video here
                            ['clean']
                        ]
                    }
                });

                // 3. Sync Quill content to hidden input on form submit
                $('#projectForm').on('submit', function(e) {
                    var editorContent = document.querySelector('.ql-editor').innerHTML;
                    $('#hidden_description').val(editorContent);
                });
            });
        </script>
    @endpush

</x-user.user-layout>
