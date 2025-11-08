<x-admin.app>
    <style>
        /* === General Layout === */
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        /* === Header === */
        .page-header h4 {
            color: #2c3e50;
            letter-spacing: 0.5px;
        }

        .page-header small {
            color: #6c757d;
        }

        .btn-secondary {
            background-color: #343a40;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #212529;
        }

        /* === Form === */
        label.form-label {
            color: #212529;
            font-weight: 600;
        }

        input.form-control,
        textarea.form-control,
        select.form-select {
            border: 1px solid #ced4da;
            border-radius: 6px;
            box-shadow: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input.form-control:focus,
        textarea.form-control:focus,
        select.form-select:focus {
            border-color: #b3d33c;
            box-shadow: 0 0 0 0.2rem rgba(179, 211, 60, 0.25);
        }

        .form-check-input:checked {
            background-color: #b3d33c;
            border-color: #b3d33c;
        }

        /* === Buttons === */
        .btn-save {
            background-color: #b3d33c;
            color: #000;
            border-radius: 6px;
            transition: all 0.2s ease-in-out;
        }

        .btn-save:hover {
            background-color: #a0c32f;
            color: #000;
            transform: translateY(-1px);
        }

        .btn-light.border:hover {
            background-color: #e9ecef;
        }

        /* === Toast Notifications === */
        .toast {
            border-radius: 6px;
            font-size: 0.95rem;
        }

        .toast-success {
            background-color: #b3d33c;
            color: #000;
        }

        .toast-error {
            background-color: #dc3545;
            color: #fff;
        }
    </style>


    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 page-header">
        <div>
            <h4 class="fw-bold text-uppercase mb-0">Add New Category</h4>
            <small>Create a new category or subcategory</small>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary fw-semibold px-3 shadow-sm">
            <i class="fa fa-arrow-left mr-1"></i> Back to Categories
        </a>
    </div>

    {{-- TOASTS --}}
    <div class="position-fixed top-0 right-0 p-3" style="z-index:1100;">
        @if (session('success'))
            <div class="toast show fade border-0 toast-success" role="alert">
                <div class="d-flex">
                    <div class="toast-body fw-semibold">{{ session('success') }}</div>
                    <button type="button" class="close m-auto mr-2" data-dismiss="toast">&times;</button>
                </div>
            </div>
        @endif
        @if ($errors->any())
            <div class="toast show fade border-0 toast-error" role="alert">
                <div class="d-flex">
                    <div class="toast-body fw-semibold">{{ $errors->first() }}</div>
                    <button type="button" class="close text-white m-auto mr-2" data-dismiss="toast">&times;</button>
                </div>
            </div>
        @endif
    </div>

    {{-- FORM CARD --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                        placeholder="Enter category name" required>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Parent Category</label>
                    <select name="parent_id" class="form-control">
                        <option value="">— None (Top Level Category) —</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-control" placeholder="Write short description...">{{ old('description') }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Icon (optional)</label>
                    <input type="text" name="icon" value="{{ old('icon') }}" class="form-control"
                        placeholder="e.g. fa fa-car">
                    <small class="text-muted">Use a valid Font Awesome 4/5 class name</small>
                </div>

                <div class="form-group form-check mb-4">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                        checked>
                    <label class="form-check-label fw-semibold" for="is_active">Active</label>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light border">Cancel</a>
                    <button type="submit" class="btn btn-save fw-semibold px-4">
                        <i class="fa fa-save mr-1"></i> Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/js/fontawesome.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.toast').toast({
                    delay: 3500
                }).toast('show');
            });
        </script>
    @endpush
</x-admin.app>
