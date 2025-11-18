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
                @csrf @method('PUT')

                <div class="row g-3">

                    {{-- Title --}}
                    <div class="col-md-6">
                        <label class="small fw-semibold">Project Title</label>
                        <input type="text" name="title" value="{{ $project->title }}"
                            class="form-control form-control-sm border-secondary" required>
                    </div>

                    {{-- Budget Min --}}
                    <div class="col-md-3">
                        <label class="small fw-semibold">Budget Min</label>
                        <input type="number" name="budget_min" value="{{ $project->budget_min }}"
                            class="form-control form-control-sm border-secondary">
                    </div>

                    {{-- Budget Max --}}
                    <div class="col-md-3">
                        <label class="small fw-semibold">Budget Max</label>
                        <input type="number" name="budget_max" value="{{ $project->budget_max }}"
                            class="form-control form-control-sm border-secondary">
                    </div>

                    {{-- Location --}}
                    <div class="col-md-6">
                        <label class="small fw-semibold">Location</label>
                        <input type="text" name="location" value="{{ $project->location }}"
                            class="form-control form-control-sm border-secondary">
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <label class="small fw-semibold">Description</label>
                        <textarea name="description" rows="3" class="form-control form-control-sm border-secondary">{{ $project->description }}</textarea>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button class="btn btn-sm fw-bold px-4" style="background-color:#b3d33c;color:#000;">
                        <i class="fa fa-save me-1"></i> Update Project
                    </button>
                </div>

            </form>

        </div>
    </div>

</x-admin.app>
