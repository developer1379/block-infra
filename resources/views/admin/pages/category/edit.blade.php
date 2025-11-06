<x-admin.app>
    <div class="container-fluid py-4">

        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-uppercase mb-0" style="color:#b3d33c;">Edit Category</h4>
                <small class="text-muted">Update details or change parent category</small>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-sm fw-semibold px-3"
                style="background-color:#b3d33c; color:#000;">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to List
            </a>
        </div>

        {{-- FORM CARD --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Category Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-dark">Category Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                            class="form-control border-dark-subtle @error('name') is-invalid @enderror"
                            placeholder="Enter category name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Parent Category --}}
                    <div class="mb-3">
                        <label for="parent_id" class="form-label fw-semibold text-dark">Parent Category</label>
                        <select id="parent_id" name="parent_id" class="form-select border-dark-subtle">
                            <option value="">None (Top Level)</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}"
                                    {{ $parent->id == $category->parent_id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark d-block mb-2">Status</label>
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

                    {{-- Buttons --}}
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn fw-semibold px-4"
                            style="background-color:#b3d33c; color:#000;">
                            <i class="fa-solid fa-save me-1"></i> Update
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary px-4">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- TOASTS --}}
        <div class="position-fixed top-0 end-0 p-3" style="z-index:1100;">
            @if (session('success'))
                <div class="toast align-items-center text-bg-success show fade border-0"
                    style="background-color:#b3d33c !important;color:#000;" role="alert">
                    <div class="d-flex">
                        <div class="toast-body fw-semibold">{{ session('success') }}</div>
                        <button type="button" class="btn-close btn-close-black me-2 m-auto"
                            data-bs-dismiss="toast"></button>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="toast align-items-center text-bg-danger show fade border-0" style="background:red;"
                    role="alert">
                    <div class="d-flex">
                        <div class="toast-body fw-semibold">{{ session('error') }}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto"
                            data-bs-dismiss="toast"></button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toastElList = [].slice.call(document.querySelectorAll('.toast'));
                toastElList.map(toastEl => new bootstrap.Toast(toastEl, {
                    delay: 3500
                }).show());
            });
        </script>
    @endpush
</x-admin.app>
