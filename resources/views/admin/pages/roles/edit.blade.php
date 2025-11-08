<x-admin.app>
    <style>
        .card {
            border-radius: 10px
        }

        .btn-save {
            background: #b3d33c;
            color: #000;
            border-radius: 6px
        }

        .btn-save:hover {
            background: #a0c32f;
            color: #000
        }

        .form-check-input:checked {
            background: #b3d33c;
            border-color: #b3d33c
        }

        .form-check-label {
            font-weight: 500
        }
    </style>

    <div class="page-wrapper">
        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-uppercase mb-0">Edit Role</h4>
                <small class="text-muted">Update role name or change permissions</small>
            </div>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary px-3">
                <i class="fa fa-arrow-left mr-1"></i> Back
            </a>
        </div>

        {{-- FORM CARD --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Role Name --}}
                    <div class="form-group mb-3">
                        <label class="form-label">Role Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $role->name) }}"
                            class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Permissions --}}
                    <div class="form-group">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label mb-0 fw-semibold">Permissions</label>

                            {{-- ✅ Select All Checkbox --}}
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkAllPermissions">
                                <label for="checkAllPermissions" class="form-check-label text-primary small">
                                    Select / Deselect All
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            @foreach ($permissions as $perm)
                                <div class="col-md-4">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input permission-checkbox"
                                            id="perm{{ $perm->id }}" name="permissions[]"
                                            value="{{ $perm->id }}"
                                            {{ in_array($perm->id, $assigned) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm{{ $perm->id }}">
                                            {{ $perm->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-save px-4 fw-semibold">
                            <i class="fa fa-save mr-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ✅ jQuery script for check all --}}
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#checkAllPermissions').on('change', function() {
                    $('.permission-checkbox').prop('checked', this.checked);
                });

                // Update "Select All" if all are checked manually
                $('.permission-checkbox').on('change', function() {
                    $('#checkAllPermissions').prop(
                        'checked',
                        $('.permission-checkbox:checked').length === $('.permission-checkbox').length
                    );
                });
            });
        </script>
    @endpush
</x-admin.app>
