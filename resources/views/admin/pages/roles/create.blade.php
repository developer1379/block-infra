<x-admin.app>
    <style>
        .card{border-radius:10px}
        .btn-save{background:#b3d33c;color:#000;border-radius:6px}
        .btn-save:hover{background:#a0c32f;color:#000}
        .form-check-input:checked{background:#b3d33c;border-color:#b3d33c}
    </style>

    <div class="page-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-uppercase mb-0">Add Role</h4>
                <small class="text-muted">Create a role and assign permissions</small>
            </div>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary px-3">
                <i class="fa fa-arrow-left mr-1"></i> Back
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label class="form-label">Role Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. admin, staff" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label d-block">Assign Permissions</label>
                        <div class="row">
                            @foreach($permissions as $perm)
                                <div class="col-md-4">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="perm{{ $perm->id }}" name="permissions[]" value="{{ $perm->id }}">
                                        <label class="form-check-label" for="perm{{ $perm->id }}">{{ $perm->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-save px-4 fw-semibold">
                            <i class="fa fa-save mr-1"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin.app>
