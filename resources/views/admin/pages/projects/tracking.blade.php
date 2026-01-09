<x-admin.app>
    @push('css')
        <style>
            .progress {
                height: 25px;
                font-size: 14px;
                background-color: #e9ecef;
                border-radius: 0.5rem;
            }

            .timeline-item {
                border-left: 2px solid #e9ecef;
                padding-left: 20px;
                padding-bottom: 20px;
                position: relative;
            }

            .timeline-item::before {
                content: '';
                width: 12px;
                height: 12px;
                background: #0d6efd;
                border-radius: 50%;
                position: absolute;
                left: -7px;
                top: 5px;
            }

            .timeline-item:last-child {
                padding-bottom: 0;
                border-left: none;
            }

            .timeline-item:last-child::before {
                left: 0;
            }
        </style>
    @endpush

    <div class="content">
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Project Tracking</h4>
                    <p class="text-muted mb-0">Manage milestones and view progress for:
                        <strong>{{ $project->title }}</strong></p>
                </div>
                <div class="text-end">
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left me-1"></i> Back to Projects
                    </a>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase fs-12">Total Budget</h6>
                            <h3 class="mb-0">${{ number_format($project->award->bid->bid_amount ?? 0, 2) }}</h3>
                            <small class="text-success">Awarded Amount</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase fs-12">Contractor</h6>
                            <div class="d-flex align-items-center mt-2">
                                @if ($project->award->awardedTo->profile_photo_path)
                                    <img src="{{ asset('storage/' . $project->award->awardedTo->profile_photo_path) }}"
                                        class="rounded-circle me-2" width="40" height="40">
                                @else
                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2"
                                        style="width: 40px; height: 40px;">
                                        {{ substr($project->award->awardedTo->name ?? 'U', 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0">{{ $project->award->awardedTo->name ?? 'Unknown' }}</h6>
                                    <small class="text-muted">{{ $project->award->awardedTo->email ?? '' }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase fs-12">Completion Status</h6>
                            <div class="progress mt-2">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $project->current_progress }}%;"
                                    aria-valuenow="{{ $project->current_progress }}" aria-valuemin="0"
                                    aria-valuemax="100">
                                    {{ $project->current_progress }}%
                                </div>
                            </div>
                            <small class="text-muted mt-1 d-block">Based on latest contractor report</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-7">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                            <h5 class="card-title mb-0">Project Milestones</h5>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addMilestoneModal">
                                <i class="bi bi-plus-lg me-1"></i> Add Milestone
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Title</th>
                                            <th>Due Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th class="text-end pe-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($project->milestones as $milestone)
                                            <tr>
                                                <td class="ps-4">
                                                    <span class="fw-medium">{{ $milestone->title }}</span>
                                                    @if ($milestone->description)
                                                        <br><small
                                                            class="text-muted">{{ Str::limit($milestone->description, 40) }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $milestone->due_date ? $milestone->due_date->format('M d, Y') : '-' }}
                                                </td>
                                                <td>${{ number_format($milestone->amount, 2) }}</td>
                                                <td>
                                                    @switch($milestone->status)
                                                        @case('completed')
                                                            <span class="badge bg-success-subtle text-success">Completed</span>
                                                        @break

                                                        @case('paid')
                                                            <span class="badge bg-info-subtle text-info">Paid</span>
                                                        @break

                                                        @case('in_progress')
                                                            <span class="badge bg-warning-subtle text-warning">In
                                                                Progress</span>
                                                        @break

                                                        @default
                                                            <span
                                                                class="badge bg-secondary-subtle text-secondary">Pending</span>
                                                    @endswitch
                                                </td>
                                                <td class="text-end pe-4">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-light btn-icon" type="button"
                                                            data-bs-toggle="dropdown">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <h6 class="dropdown-header">Update Status</h6>
                                                            </li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('admin.milestones.status', $milestone->id) }}"
                                                                    method="POST">
                                                                    @csrf @method('PATCH')
                                                                    <input type="hidden" name="status"
                                                                        value="completed">
                                                                    <button class="dropdown-item" type="submit">Mark
                                                                        Completed</button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('admin.milestones.status', $milestone->id) }}"
                                                                    method="POST">
                                                                    @csrf @method('PATCH')
                                                                    <input type="hidden" name="status" value="paid">
                                                                    <button class="dropdown-item" type="submit">Mark
                                                                        Paid</button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('admin.milestones.destroy', $milestone->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Delete milestone?')">
                                                                    @csrf @method('DELETE')
                                                                    <button class="dropdown-item text-danger"
                                                                        type="submit">Delete</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted">
                                                        No milestones created yet. Divide the project into chunks to begin
                                                        tracking.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-5 mt-4 mt-xl-0">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-transparent border-bottom py-3">
                                <h5 class="card-title mb-0">Progress Reports</h5>
                            </div>
                            <div class="card-body">
                                <div class="timeline-container">
                                    @forelse($project->progressUpdates as $update)
                                        <div class="timeline-item mb-4">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="fw-bold mb-1">
                                                        Reached {{ $update->progress_percentage }}% Completion
                                                    </h6>
                                                    <small class="text-muted">
                                                        <i class="bi bi-clock me-1"></i>
                                                        {{ $update->created_at->format('M d, Y h:i A') }}
                                                    </small>
                                                </div>
                                                @if ($update->report_file_path)
                                                    <a href="{{ asset('storage/' . $update->report_file_path) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-secondary"
                                                        title="View Attachment">
                                                        <i class="bi bi-paperclip"></i>
                                                    </a>
                                                @endif
                                            </div>

                                            @if ($update->report_description)
                                                <div class="mt-2 p-3 bg-light rounded fs-14 text-secondary">
                                                    {{ $update->report_description }}
                                                </div>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="text-center py-5 text-muted">
                                            <i class="bi bi-clipboard-data fs-1 d-block mb-2"></i>
                                            No progress reports submitted by the contractor yet.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="modal fade" id="addMilestoneModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('admin.milestones.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Create New Milestone</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label required">Milestone Title</label>
                                <input type="text" name="title" class="form-control"
                                    placeholder="e.g. Foundation Work" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Amount ($)</label>
                                    <input type="number" step="0.01" name="amount" class="form-control"
                                        placeholder="0.00">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Due Date</label>
                                    <input type="date" name="due_date" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Details about this phase..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Milestone</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </x-admin.app>
