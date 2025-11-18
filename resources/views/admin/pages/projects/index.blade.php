<x-admin.app>

    <style>
        .filter-label {
            font-size: 12px;
            font-weight: 600;
            color: #555;
        }

        .project-status-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }
    </style>

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h5 class="fw-bold mb-1" style="color:#b3d33c;">Projects</h5>

        <a href="{{ route('admin.projects.create') }}" class="btn btn-sm btn-dark mt-2 mt-sm-0">
            <i class="fa fa-plus-circle"></i> Add Project
        </a>
    </div>

    {{-- FILTER CARD --}}
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body py-3">

            <form action="" method="GET">
                <div class="row align-items-end">

                    {{-- Search --}}
                    <div class="col-md-4 mb-2">
                        <label class="filter-label">Search Title</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control form-control-sm border-secondary" placeholder="Search project title...">
                    </div>

                    {{-- Status Filter --}}
                    <div class="col-md-3 mb-2">
                        <label class="filter-label">Status</label>
                        <select name="status" class="form-control form-control-sm border-secondary">
                            <option value="">All</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            <option value="awarded" {{ request('status') == 'awarded' ? 'selected' : '' }}>Awarded
                            </option>
                        </select>
                    </div>

                    {{-- Created By --}}
                    <div class="col-md-3 mb-2">
                        <label class="filter-label">Created By</label>
                        <select name="created_by" class="form-control form-control-sm border-secondary">
                            <option value="">All</option>
                            @foreach ($createdByUsers as $user)
                                <option value="{{ $user->id }}"
                                    {{ request('created_by') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Button --}}
                    <div class="col-md-2 mb-2 text-right">
                        <button class="btn btn-sm px-3 fw-bold" style="background:#b3d33c; color:#000;">
                            <i class="fa fa-filter mr-1"></i> Filter
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    {{-- PROJECT LIST TABLE --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-2 border-0">
            <h6 class="fw-bold mb-0">
                <i class="fa fa-list mr-2" style="color:#b3d33c;"></i>All Projects
            </h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-sm mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Title</th>
                            <th>Budget</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Bids</th>
                            <th width="160">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($projects as $project)
                            <tr>
                                <td class="text-center">{{ $project->id }}</td>

                                <td class="font-weight-bold">
                                    {{ $project->title }}
                                    <div class="text-muted small">
                                        {{ \Illuminate\Support\Str::limit($project->description, 40) }}
                                    </div>
                                </td>

                                <td>₹{{ number_format($project->budget_min) }} -
                                    ₹{{ number_format($project->budget_max) }}</td>

                                <td>
                                    <span
                                        class="project-status-badge
                                    {{ $project->status == 'open' ? 'badge badge-success' : '' }}
                                    {{ $project->status == 'closed' ? 'badge badge-secondary' : '' }}
                                    {{ $project->status == 'awarded' ? 'badge badge-warning' : '' }}">
                                        {{ ucfirst($project->status) }}
                                    </span>
                                </td>

                                <td>{{ $project->createdBy->name }}</td>

                                <td>
                                    <a href="{{ route('admin.projects.bids', $project->id) }}"
                                        class="badge badge-dark px-2 py-1 text-white">
                                        <i class="fa fa-gavel"></i> Bids
                                    </a>
                                </td>

                                <td class="text-center">

                                    <a href="{{ route('admin.projects.show', $project->id) }}"
                                        class="btn btn-sm btn-info mb-1">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.projects.edit', $project->id) }}"
                                        class="btn btn-sm btn-warning mb-1">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')

                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this project?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>

                                    @if ($project->status == 'open')
                                        @can('create bids')
                                            <a href="{{ route('admin.projects.bid.create', $project->id) }}"
                                                class="btn btn-sm text-dark" style="background-color:#b3d33c;">
                                                <i class="fa fa-gavel"></i> Submit Bid
                                            </a>
                                        @endcan
                                    @endif


                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-3 text-muted">
                                    No projects found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</x-admin.app>
