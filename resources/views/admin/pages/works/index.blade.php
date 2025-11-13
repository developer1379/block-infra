<x-admin.app>
    <div class="">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-uppercase mb-0" style="color:#b3d33c;">Works</h4>
            <a href="{{ route('admin.works.create') }}" class="btn btn-sm fw-semibold px-3"
                style="background-color:#b3d33c;color:#000;">
                <i class="fa-solid fa-plus me-1"></i> Add
            </a>
        </div>

        {{-- TABLE --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-2">
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>#</th>
                                <th>Work</th>
                                <th>Cat.</th>
                                <th>Unit</th>
                                <th>Labor</th>
                                <th>Lab + Mat</th>
                                <th>Status</th>
                                <th class="text-center" style="width:70px;">Act</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($works as $key => $work)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td class="fw-semibold small">{{ $work->name }}</td>

                                    <td class="small">
                                        {{ $work->category->name ?? '-' }}
                                    </td>

                                    <td class="small">
                                        {{ $work->unit->symbol ?? ($work->unit_label ?? '-') }}
                                    </td>

                                    <td class="small">
                                        @if ($work->labor_min || $work->labor_max)
                                            {{ $work->labor_min }} - {{ $work->labor_max }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="small">
                                        @if ($work->labor_material_min || $work->labor_material_max)
                                            {{ $work->labor_material_min }} - {{ $work->labor_material_max }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        <span
                                            class="badge {{ $work->is_active ? 'bg-success' : 'bg-secondary' }} badge-sm">
                                            {{ $work->is_active ? 'A' : 'I' }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('admin.works.edit', $work->id) }}"
                                            class="btn btn-sm btn-outline-primary p-1 me-1">
                                            <i class="fa-solid fa-pen fa-xs"></i>
                                        </a>

                                        <form action="{{ route('admin.works.destroy', $work->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Delete this work?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger p-1">
                                                <i class="fa-solid fa-trash fa-xs"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3 small">
                                        No Works Found
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
