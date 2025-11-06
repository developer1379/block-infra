<x-admin.app>
    <div class="">

        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-uppercase mb-0 text-dark">Add New Category</h4>
                <small class="text-muted">Create a new category or subcategory</small>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary fw-semibold px-3 shadow-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Categories
            </a>
        </div>

        {{-- SUCCESS / ERROR TOASTS --}}
        <div class="position-fixed top-0 end-0 p-3" style="z-index:1100;">
            @if (session('success'))
                <div class="toast align-items-center show fade border-0" style="background-color:#b3d33c;color:#000;"
                    role="alert">
                    <div class="d-flex">
                        <div class="toast-body fw-semibold">{{ session('success') }}</div>
                        <button type="button" class="btn-close btn-close-black me-2 m-auto"
                            data-bs-dismiss="toast"></button>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="toast align-items-center show fade border-0 bg-danger text-white" role="alert">
                    <div class="d-flex">
                        <div class="toast-body fw-semibold">{{ $errors->first() }}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto"
                            data-bs-dismiss="toast"></button>
                    </div>
                </div>
            @endif
        </div>

        {{-- FORM CARD --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf

                    {{-- Category Name --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                            placeholder="Enter category name" required>
                    </div>

                    {{-- Parent Category --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Parent Category</label>
                        <select name="parent_id" class="form-select">
                            <option value="">— None (Top Level Category) —</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="Write short description...">{{ old('description') }}</textarea>
                    </div>

                    {{-- Icon --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Icon (optional)</label>
                        <input type="text" name="icon" value="{{ old('icon') }}" class="form-control"
                            placeholder="e.g. fa-solid fa-car">
                        <small class="text-muted">Use a valid Font Awesome class name</small>
                    </div>

                    {{-- Status --}}
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                        <label class="form-check-label fw-semibold" for="is_active">Active</label>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn fw-semibold px-4" style="background-color:#b3d33c;color:#000;">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Save Category
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toastElList = [].slice.call(document.querySelectorAll('.toast'));
                toastElList.map(toastEl => new bootstrap.Toast(toastEl, { delay: 3500 }).show());
            });
        </script>
    @endpush
</x-admin.app>
