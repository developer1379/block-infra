<x-admin.app>

    <style>
        .form-label-custom {
            font-size: 12px;
            font-weight: 600;
            color: #555;
        }
    </style>

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h5 class="fw-bold mb-1" style="color:#b3d33c;">Submit Bid</h5>

        <a href="{{ route('contractor.projects.show', $project->id) }}" class="btn btn-sm btn-outline-dark">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- BID FORM CARD --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-2 border-0">
            <h6 class="fw-bold mb-0">
                <i class="fa fa-gavel mr-2" style="color:#b3d33c;"></i>
                Submit Your Bid for: {{ $project->title }}
            </h6>
        </div>

        <div class="card-body p-3">

            <form action="{{ route('contractor.projects.bid.store', $project->id) }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- BID AMOUNT --}}
                    <div class="col-md-6">
                        <label class="form-label-custom">Bid Amount (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="bid_amount" step="0.01" required
                            class="form-control form-control-sm border-secondary" placeholder="Enter your bid amount">
                    </div>

                    {{-- DELIVERY DAYS --}}
                    <div class="col-md-6">
                        <label class="form-label-custom">Delivery Days <span class="text-danger">*</span></label>
                        <input type="number" name="delivery_days" required
                            class="form-control form-control-sm border-secondary" placeholder="e.g. 7">
                    </div>

                    {{-- PROPOSAL --}}
                    <div class="col-md-12">
                        <label class="form-label-custom">Proposal Details (optional)</label>
                        <textarea name="proposal_text" rows="3" class="form-control form-control-sm border-secondary"
                            placeholder="Write a short description of your offer..."></textarea>
                    </div>

                </div>

                {{-- SUBMIT BUTTON --}}
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-sm px-4 fw-bold"
                        style="background-color:#b3d33c; color:#000;">
                        <i class="fa fa-paper-plane mr-1"></i> Submit Bid
                    </button>
                </div>

            </form>

        </div>

    </div>

</x-admin.app>
