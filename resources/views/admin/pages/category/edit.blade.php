<x-admin.app>
    <style>
        /* === Layout === */
        .page-wrapper {
            padding: 30px;
            background-color: #f8f9fa;
            min-height: 100vh;
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

        .btn-back {
            background-color: #b3d33c;
            color: #000;
            border: none;
            border-radius: 6px;
            transition: all 0.2s ease-in-out;
        }

        .btn-back:hover {
            background-color: #a0c32f;
            color: #000;
            transform: translateY(-1px);
        }

        /* === Form === */
        label.form-label {
            color: #212529;
            font-weight: 600;
        }

        input.form-control,
        select.form-control {
            border: 1px solid #ced4da;
            border-radius: 6px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input.form-control:focus,
        select.form-control:focus {
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

        .btn-outline-secondary:hover {
            background-color: #e9ecef;
        }

        /* === Toasts === */
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
                <h4 class="fw-bold text-uppercase mb-0">Edit Category</h4>
                <small>Update details or change parent category</small>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-back fw-semibold px-3 shadow-sm btn-sm">
                <i class="fa fa-arrow-left mr-1"></i> Back to List
            </a>
        </div>

        {{-- FORM CARD --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter category name"
                            required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="parent_id" class="form-label">Parent Category</label>
                        <select id="parent_id" name="parent_id" class="form-control">
                            <option value="">None (Top Level)</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}"
                                    {{ $parent->id == $category->parent_id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label d-block mb-2">Status</label>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="active" name="is_active" value="1"
                                class="form-check-input" {{ $category->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="inactive" name="is_active" value="0"
                                class="form-check-input" {{ !$category->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="inactive">Inactive</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-save fw-semibold px-4">
                            <i class="fa fa-save mr-1"></i> Update
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary px-4">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- TOASTS --}}
        <div class="position-fixed" style="top:15px; right:15px; z-index:1100;">
            @if (session('success'))
                <div class="toast show fade border-0 toast-success" role="alert">
                    <div class="d-flex">
                        <div class="toast-body fw-semibold">{{ session('success') }}</div>
                        <button type="button" class="close m-auto mr-2" data-dismiss="toast">&times;</button>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="toast show fade border-0 toast-error" role="alert">
                    <div class="d-flex">
                        <div class="toast-body fw-semibold">{{ session('error') }}</div>
                        <button type="button" class="close text-white m-auto mr-2"
                            data-dismiss="toast">&times;</button>
                    </div>
                </div>
            @endif
        </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/js/fontawesome.min.js"></script>
        <script>
            $(function() {
                $('.toast').toast({
                    delay: 3500
                }).toast('show');
            });
        </script>
    @endpush
</x-admin.app>
