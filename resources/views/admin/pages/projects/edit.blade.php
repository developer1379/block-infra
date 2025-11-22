<x-admin.app>

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-1" style="color:#b3d33c;">Edit Project</h5>

        <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-outline-dark">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- EDIT FORM --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-2 border-0">
            <h6 class="fw-bold mb-0">
                <i class="fa fa-edit me-2" style="color:#b3d33c;"></i>Edit Project
            </h6>
        </div>

        <div class="card-body p-3">

            <form action="{{ route('admin.projects.update', $project->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- Title --}}
                    <div class="col-md-6">
                        <label class="small fw-semibold">Project Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $project->title) }}"
                            class="form-control form-control-sm border-secondary" required>
                    </div>

                    {{-- Budget Min --}}
                    <div class="col-md-3">
                        <label class="small fw-semibold">Budget Min (₹)</label>
                        <input type="number" name="budget_min" step="0.01"
                            value="{{ old('budget_min', $project->budget_min) }}"
                            class="form-control form-control-sm border-secondary">
                    </div>

                    {{-- Budget Max --}}
                    <div class="col-md-3">
                        <label class="small fw-semibold">Budget Max (₹)</label>
                        <input type="number" name="budget_max" step="0.01"
                            value="{{ old('budget_max', $project->budget_max) }}"
                            class="form-control form-control-sm border-secondary">
                    </div>

                    {{-- Location --}}
                    <div class="col-md-6">
                        <label class="small fw-semibold">Location</label>
                        <input type="text" name="location" value="{{ old('location', $project->location) }}"
                            class="form-control form-control-sm border-secondary">
                    </div>

                    {{--  QUILL DESCRIPTION EDITOR --}}
                    <div class="col-md-12">
                        <label class="small fw-semibold">Description</label>

                        {{-- Hidden Input --}}
                        <input type="hidden" name="description" id="descriptionInput">

                        {{-- Quill Editor --}}
                        <div id="quillEditor" style="height:250px; border:1px solid #ced4da; background:#fff;"></div>

                        @error('description')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- ⭐ MULTIPLE CATEGORIES --}}
                    @php
                        $parentCategories = \App\Models\Category::whereNull('parent_id')
                            ->with(['subcategories' => fn($q) => $q->where('is_active', 1)])
                            ->where('is_active', 1)
                            ->orderBy('name')
                            ->get();

                        $selectedCategories = $project->categories->pluck('id')->toArray();
                    @endphp

                    <div class="col-md-12">
                        <label class="small fw-semibold">Select Categories (Multiple)</label>

                        <select name="categories[]" multiple
                            class="form-control form-control-sm border-secondary category-select"
                            style="min-height: 160px;">

                            @foreach ($parentCategories as $parent)
                                @php $children = $parent->subcategories; @endphp

                                @if ($children->count())
                                    <optgroup label="{{ $parent->name }}">
                                        @foreach ($children as $child)
                                            <option value="{{ $child->id }}"
                                                {{ in_array($child->id, old('categories', $selectedCategories)) ? 'selected' : '' }}>
                                                {{ $child->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @else
                                    <option value="{{ $parent->id }}"
                                        {{ in_array($parent->id, old('categories', $selectedCategories)) ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endif
                            @endforeach

                        </select>

                        <small class="text-muted">Hold CTRL to select multiple categories.</small>
                    </div>

                </div>

                {{-- Update Button --}}
                <div class="text-end mt-3">
                    <button class="btn btn-sm fw-bold px-4" style="background-color:#b3d33c;color:#000;">
                        <i class="fa fa-save me-1"></i> Update Project
                    </button>
                </div>

            </form>
        </div>
    </div>
    {{-- UI Enhancements --}}
    <style>
        .category-select option {
            padding: 6px;
        }

        .category-select optgroup {
            font-weight: 700;
            color: #333;
        }

        .category-select option:hover {
            background-color: #b3d33c30 !important;
        }
    </style>



</x-admin.app>
<script>
    $(document).ready(function() {

        // Initialize Quill
        var quill = new Quill('#quillEditor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, 3, false]
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        var existingContent = @json($project->description);


        quill.root.innerHTML = existingContent;

        $('form').on('submit', function() {
            $('#descriptionInput').val(quill.root.innerHTML);
        });

    });
</script>
