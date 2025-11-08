<x-admin.app>
    <style>
        .btn-add {
            background: #b3d33c;
            color: #000;
            border-radius: 6px
        }

        .btn-add:hover {
            background: #a0c32f;
            color: #000
        }

        .card {
            border-radius: 10px
        }

        .toast {
            border-radius: 6px
        }

        .toast-success {
            background: #b3d33c;
            color: #000
        }

        .toast-error {
            background: #dc3545;
            color: #fff
        }
    </style>

    <div class="page-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-uppercase mb-0">Permissions</h4>
                <small class="text-muted">Manage all system permissions</small>
            </div>
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-add fw-semibold px-3 shadow-sm">
                <i class="fa fa-plus mr-1"></i> Add Permission
            </a>
        </div>

        <div class="position-fixed" style="top:15px; right:15px; z-index:1100;">
            @if (session('success'))
                <div class="toast show fade border-0 toast-success">
                    <div class="d-flex">
                        <div class="toast-body fw-semibold">{{ session('success') }}</div>
                        <button type="button" class="close m-auto mr-2" data-dismiss="toast">&times;</button>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="toast show fade border-0 toast-error">
                    <div class="d-flex">
                        <div class="toast-body fw-semibold">{{ session('error') }}</div>
                        <button type="button" class="close text-white m-auto mr-2"
                            data-dismiss="toast">&times;</button>
                    </div>
                </div>
            @endif
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th width="140" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permissions as $i => $perm)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="fw-semibold text-dark">{{ $perm->name }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.permissions.edit', $perm->id) }}"
                                            class="btn btn-sm btn-outline-primary mr-1">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.permissions.destroy', $perm->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Delete this permission?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No permissions found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {
                $('.toast').toast({
                    delay: 3500
                }).toast('show');
            });
        </script>
    @endpush
</x-admin.app>
