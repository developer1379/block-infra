<x-admin.app>
    <style>
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
        }

        .status-badge {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 5px;
            transition: all .3s ease;
        }

        .status-active {
            background: #b3d33c;
            color: #000;
        }

        .status-inactive {
            background: #adb5bd;
            color: #fff;
        }

        .table td {
            vertical-align: middle !important;
        }

        .toggle-switch {
            cursor: pointer;
            transition: all .3s ease;
        }

        .toast {
            border-radius: 6px;
            min-width: 250px;
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
                <h4 class="fw-bold text-uppercase mb-0 text-dark">Contractors</h4>
                <small class="text-muted">Manage contractor registrations, categories & status</small>
            </div>
            <a href="{{ route('admin.contractors.create') }}" class="btn btn-add shadow-sm">
                <i class="fa fa-plus mr-1"></i> Add Contractor
            </a>
        </div>

        {{-- Toast Container --}}
        <div id="toast-container" class="position-fixed" style="top:15px; right:15px; z-index:1100;"></div>

        {{-- Contractor Table --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="table-responsive-lg">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase small">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Category</th>
                                <th>City</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($contractors as $i => $c)
                                <tr id="row-{{ $c->id }}">
                                    <td>{{ $i + 1 }}</td>
                                    <td class="fw-semibold text-dark">{{ $c->name }}</td>
                                    <td>{{ $c->company_name ?? '—' }}</td>
                                    <td>{{ $c->category ?? '—' }}</td>
                                    <td>{{ $c->city ?? '—' }}</td>
                                    <td>{{ $c->email ?? '—' }}</td>
                                    <td>{{ $c->phone ?? '—' }}</td>
                                    <td>
                                        <span id="status-badge-{{ $c->id }}"
                                            class="status-badge {{ $c->is_active ? 'status-active' : 'status-inactive' }}">
                                            {{ $c->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{-- Toggle --}}
                                        <button type="button"
                                            class="btn btn-sm toggle-switch {{ $c->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                                            data-id="{{ $c->id }}" title="Toggle Status">
                                            <i
                                                class="fa {{ $c->is_active ? 'fa-ban text-danger' : 'fa-check text-success' }}"></i>
                                        </button>

                                        {{-- View --}}
                                        <a href="{{ route('admin.contractors.show', $c->id) }}"
                                            class="btn btn-sm btn-outline-info" title="View Details">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.contractors.edit', $c->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit Contractor">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.contractors.destroy', $c->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this contractor?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fa fa-folder-open mb-2"></i><br>
                                        No contractors found
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
            // Toast Generator
            function showToast(type, message) {
                const bg = type === 'success' ? 'toast-success' : 'toast-error';
                const toastHTML = `
                    <div class="toast show fade border-0 ${bg} mb-2">
                        <div class="d-flex align-items-center">
                            <div class="toast-body fw-semibold">${message}</div>
                            <button type="button" class="close ml-3 ${type === 'success' ? '' : 'text-white'}" data-dismiss="toast">&times;</button>
                        </div>
                    </div>`;
                $('#toast-container').append(toastHTML);
                setTimeout(() => {
                    $('#toast-container .toast').first().remove();
                }, 3500);
            }

            // Toggle Contractor Status
            $(document).on('click', '.toggle-switch', function() {
                const btn = $(this);
                const id = btn.data('id');
                const badge = $(`#status-badge-${id}`);

                btn.prop('disabled', true);

                $.ajax({
                    url: '{{ url('admin/contractors') }}/' + id + '/toggle-status',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.success) {
                            const isActive = res.status === 'active';

                            // Update badge dynamically
                            badge.removeClass('status-active status-inactive')
                                .addClass(isActive ? 'status-active' : 'status-inactive')
                                .text(isActive ? 'Active' : 'Inactive');

                            // Update button color & icon
                            btn.removeClass('btn-outline-success btn-outline-secondary')
                                .addClass(isActive ? 'btn-outline-secondary' : 'btn-outline-success')
                                .html(isActive ?
                                    '<i class="fa fa-ban text-danger"></i>' :
                                    '<i class="fa fa-check text-success"></i>'
                                );

                            showToast('success',
                                `Contractor ${isActive ? 'activated' : 'deactivated'} successfully.`);
                        } else {
                            showToast('error', 'Failed to update status.');
                        }
                    },
                    error: function() {
                        showToast('error', 'Something went wrong!');
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                    }
                });
            });
        </script>
    @endpush
</x-admin.app>
