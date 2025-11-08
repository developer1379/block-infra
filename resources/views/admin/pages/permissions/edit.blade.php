<x-admin.app>
    <style>
        .btn-save {
            background: #b3d33c;
            color: #000;
            border-radius: 6px
        }

        .btn-save:hover {
            background: #a0c32f;
            color: #000
        }

        .card {
            border-radius: 10px
        }
    </style>

    <div class="page-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-uppercase mb-0">Edit Permission</h4>
                <small class="text-muted">Update existing permission name</small>
            </div>
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary px-3">
                <i class="fa fa-arrow-left mr-1"></i> Back
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold">Permission Name</label>
                        <input type="text" name="name" value="{{ old('name', $permission->name) }}"
                            class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-save px-4 fw-semibold">
                            <i class="fa fa-save mr-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin.app>
