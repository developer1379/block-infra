<x-admin.app>
    <div class="">

        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-uppercase mb-0 text-dark">Categories</h4>
                <small class="text-muted">Manage categories & subcategories efficiently</small>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn fw-semibold px-3 shadow-sm"
                style="background-color:#b3d33c; color:#000;">
                <i class="fa-solid fa-plus me-1"></i> Add New Category
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

            @if (session('error'))
                <div class="toast align-items-center show fade border-0 bg-danger text-white" role="alert">
                    <div class="d-flex">
                        <div class="toast-body fw-semibold">{{ session('error') }}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto"
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

        {{-- CATEGORY TABLE --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light text-uppercase small">
                            <tr>
                                <th style="width:50px;">#</th>
                                <th>Name</th>
                                <th>Parent Category</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th class="text-center" style="width:140px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $key => $category)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="fw-semibold text-dark">{{ $category->name }}</td>
                                    <td>
                                        @if ($category->parent)
                                            <span class="badge bg-light text-dark border">
                                                {{ $category->parent->name }}
                                            </span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($category->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ optional($category->created_at)->format('d M, Y') ?? '-' }}</td>

                                    <td class="text-center">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                                            class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- Subcategories --}}
                                @if ($category->subcategories->count() > 0)
                                    @foreach ($category->subcategories as $sub)
                                        <tr class="bg-light">
                                            <td></td>
                                            <td class="ps-5 text-dark fw-semibold">
                                                <i class="fa-solid fa-angle-right me-2 text-muted"></i>
                                                {{ $sub->name }}
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary text-light">Subcategory</span>
                                            </td>
                                            <td>
                                                @if ($sub->is_active)
                                                    <span class="badge bg-dark">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{ optional($sub->created_at)->format('d M, Y') ?? '-' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.categories.edit', $sub->id) }}"
                                                    class="btn btn-sm btn-outline-primary me-1">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <form action="{{ route('admin.categories.destroy', $sub->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Delete this subcategory?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <i class="fa-solid fa-folder-open fa-2x mb-2 text-darkl"></i>
                                        <p class="mb-0 fw-semibold">No categories found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
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
