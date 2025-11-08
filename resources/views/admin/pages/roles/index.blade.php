<x-admin.app>
    <style>
        .card {
            border-radius: 12px;
        }

        .btn-add {
            background: #b3d33c;
            color: #000;
            border-radius: 6px;
            font-weight: 600;
            transition: all .2s ease-in-out;
        }

        .btn-add:hover {
            background: #a0c32f;
            color: #000;
            transform: translateY(-1px);
        }

        .badge-perm {
            background: #f1f3f5;
            color: #212529;
            border-radius: 4px;
            padding: 5px 8px;
            margin: 2px;
            font-size: 12px;
            display: inline-block;
            border: 1px solid #dee2e6;
        }

        .badge-more {
            background: #dee2e6;
            color: #495057;
            border-radius: 4px;
            padding: 5px 8px;
            margin: 2px;
            font-size: 12px;
            display: inline-block;
            cursor: pointer;
        }

        .badge-more:hover {
            background: #ced4da;
        }

        table thead th {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            vertical-align: middle;
        }

        .role-name {
            font-weight: 600;
            font-size: 15px;
            color: #212529;
        }

        .empty-state {
            padding: 40px 0;
        }

        .empty-state i {
            font-size: 24px;
            color: #adb5bd;
        }

        .toast {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .1);
        }

        .toast-success {
            background: #b3d33c;
            color: #000;
        }

        .toast-error {
            background: #dc3545;
            color: #fff;
        }
    </style>

    <div class="page-wrapper">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-uppercase mb-0 text-dark">Roles</h4>
                <small class="text-muted">Manage system roles and their assigned permissions</small>
            </div>
            <a href="{{ route('admin.roles.create') }}" class="btn btn-add shadow-sm">
                <i class="fa fa-plus mr-1"></i> Add New Role
            </a>
        </div>

        {{-- Toasts --}}
        <div class="position-fixed" style="top:15px; right:15px; z-index:1100;">
            @if (session('success'))
                <div class="toast show fade border-0 toast-success mb-2">
                    <div class="d-flex align-items-center">
                        <div class="toast-body fw-semibold">{{ session('success') }}</div>
                        <button type="button" class="close ml-3" data-dismiss="toast">&times;</button>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="toast show fade border-0 toast-error">
                    <div class="d-flex align-items-center">
                        <div class="toast-body fw-semibold">{{ session('error') }}</div>
                        <button type="button" class="close text-white ml-3" data-dismiss="toast">&times;</button>
                    </div>
                </div>
            @endif
        </div>

        {{-- Roles Table --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Role</th>
                                <th>Permissions</th>
                                <th class="text-center" style="width:140px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $count = 1; @endphp
                            @forelse($roles as $role)
                                @if ($role->name !== 'admin')
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td class="role-name">{{ ucfirst($role->name) }}</td>
                                        <td>
                                            @php
                                                $perms = $role->permissions;
                                                $visiblePerms = $perms->take(3);
                                                $remainingCount = $perms->count() - $visiblePerms->count();
                                            @endphp

                                            @forelse ($visiblePerms as $p)
                                                <span class="badge-perm">{{ $p->name }}</span>
                                            @empty
                                                <span class="text-muted small">No permissions</span>
                                            @endforelse

                                            @if ($remainingCount > 0)
                                                <span class="badge-more"
                                                    title="{{ $perms->skip(3)->pluck('name')->join(', ') }}">
                                                    +{{ $remainingCount }} more
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                class="btn btn-sm btn-outline-primary mr-1" title="Edit Role">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this role?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    title="Delete Role">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center empty-state">
                                        <i class="fa fa-folder-open mb-2"></i>
                                        <p class="mb-0 text-muted fw-semibold">No roles found</p>
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
        <script>
            $(function() {
                $('.toast').toast({
                    delay: 3500
                }).toast('show');
            });
        </script>
    @endpush
</x-admin.app>
