<x-admin.app>
    <div class="">

        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-uppercase mb-0" style="color:#b3d33c;">Units</h4>
                <small class="text-muted">Manage measurement units used in works</small>
            </div>
            <a href="{{ route('admin.units.create') }}" class="btn fw-semibold px-3"
                style="background-color:#b3d33c;color:#000;">
                <i class="fa-solid fa-plus me-1"></i> Add Unit
            </a>
        </div>

        {{-- TOASTS --}}
        <div class="position-fixed top-0 end-0 p-3" style="z-index:1100;">
            @if(session('success'))
                <div class="toast show text-bg-success border-0 fade"
                    style="background-color:#b3d33c !important;color:#000;" role="alert">
                    <div class="d-flex">
                        <div class="toast-body fw-semibold">{{ session('success') }}</div>
                        <button type="button" class="btn-close btn-close-black me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="toast show text-bg-danger border-0 fade" style="background:red !important;" role="alert">
                    <div class="d-flex">
                        <div class="toast-body fw-semibold">{{ session('error') }}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            @endif
        </div>

        {{-- TABLE --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>#</th>
                                <th>Unit Name</th>
                                <th>Symbol</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($units as $key => $unit)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="fw-semibold">{{ $unit->name }}</td>
                                    <td>{{ $unit->symbol }}</td>
                                    <td>{{ $unit->description ?? '-' }}</td>
                                    <td>
                                        @if($unit->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.units.edit', $unit->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.units.destroy', $unit->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Delete this unit?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fa-solid fa-folder-open fa-2x mb-2"></i>
                                        <p class="mb-0">No units found.</p>
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
    @endpush
</x-admin.app>
