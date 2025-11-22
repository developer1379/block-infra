<x-admin.app>

    {{-- Custom Styles --}}
    <style>
        .form-label-custom {
            font-size: 12px;
            font-weight: 600;
            color: #555;
        }

        .badge-accepted {
            background: #28a745;
            color: #fff;
        }

        .badge-rejected {
            background: #dc3545;
            color: #fff;
        }

        .badge-pending {
            background: #6c757d;
            color: #fff;
        }
    </style>
    <style>
        /* Make proposal content scroll inside modal */
        #proposalModal .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        /* Fix images from Quill editor */
        #proposalContent img {
            max-width: 100%;
            height: auto !important;
            display: block;
            margin: 10px 0;
            border-radius: 6px;
        }

        /* Improve text formatting */
        #proposalContent {
            font-size: 14px;
            line-height: 1.5;
            color: #222;
            white-space: normal !important;
            word-wrap: break-word;
        }
    </style>


    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold" style="color:#b3d33c;">Bids for "{{ $project->title }}"</h5>

        <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-outline-dark">
            <i class="fa fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    {{-- BID LIST --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-2 border-0">
            <h6 class="fw-bold mb-0">
                <i class="fa fa-gavel mr-2" style="color:#b3d33c;"></i> Contractor Bids
            </h6>
        </div>

        <div class="card-body p-2">

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Contractor</th>
                            <th>Bid Amount</th>
                            <th>Delivery Days</th>
                            <th>Proposal</th>
                            <th>PDF</th>
                            <th>Status</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($bids as $bid)
                            {{-- Contractors can only see their own bid --}}
                            @if (auth()->user()->hasRole('contractor') && $bid->contractor_id != auth()->id())
                                @continue
                            @endif

                            <tr>
                                <td>{{ $bid->id }}</td>

                                <td>{{ $bid->contractor->name }}</td>

                                <td>₹{{ number_format($bid->bid_amount, 2) }}</td>

                                <td>{{ $bid->delivery_days }} days</td>

                                {{-- PROPOSAL --}}
                                <td>
                                    @if ($bid->proposal_text)
                                        @php
                                            $encodedProposal = base64_encode($bid->proposal_text ?? '');
                                        @endphp

                                        <button class="btn btn-sm btn-info viewProposalBtn"
                                            data-proposal="{{ $encodedProposal }}">
                                            <i class="fa fa-eye"></i> View
                                        </button>
                                    @else
                                        <span class="text-muted small">No proposal</span>
                                    @endif
                                </td>

                                {{-- PDF --}}
                                <td>
                                    @if ($bid->proposal_pdf)
                                        <a href="{{ asset('storage/' . $bid->proposal_pdf) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-file-pdf"></i> View
                                        </a>
                                    @else
                                        <span class="text-muted small">No PDF</span>
                                    @endif
                                </td>

                                {{-- STATUS --}}
                                <td>
                                    @if ($bid->status == 'accepted')
                                        <span class="badge badge-accepted px-2 py-1">
                                            <i class="fa fa-check"></i> Awarded
                                        </span>
                                    @elseif ($bid->status == 'rejected')
                                        <span class="badge badge-rejected px-2 py-1">
                                            <i class="fa fa-times"></i> Rejected
                                        </span>
                                    @else
                                        <span class="badge badge-pending px-2 py-1">Pending</span>
                                    @endif
                                </td>

                                {{-- ACTION --}}
                                <td>
                                    @can('award bids')
                                        @if ($bid->status == 'pending' && $project->status != 'awarded')
                                            <button class="btn btn-sm btn-success fw-bold awardBtn"
                                                data-id="{{ $bid->id }}" data-project="{{ $project->id }}">
                                                <i class="fa fa-trophy"></i> Award
                                            </button>
                                        @else
                                            {{-- Already handled by badge --}}
                                        @endif
                                    @endcan
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>

        </div>

    </div>

    {{-- Hidden Award Form --}}
    <form id="awardForm" method="POST" style="display:none;">
        @csrf
    </form>

    {{-- PROPOSAL MODAL --}}
    <div class="modal fade" id="proposalModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Proposal Details</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div id="proposalContent"></div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).on("click", ".viewProposalBtn", function() {

                let encoded = $(this).data("proposal");
                let decoded = atob(encoded);

                $("#proposalContent").html(decoded);
                $("#proposalModal").modal("show");
            });


            $(document).on("click", ".awardBtn", function() {

                let bidId = $(this).data("id");
                let projectId = $(this).data("project");

                Swal.fire({
                    title: "Award this bid?",
                    text: "This action cannot be undone.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#28a745",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Award"
                }).then((result) => {

                    if (result.isConfirmed) {
                        let form = $("#awardForm");
                        form.attr("action", `/admin/projects/${projectId}/award/${bidId}`);
                        form.submit();
                    }

                });
            });
        </script>
    @endpush


</x-admin.app>
