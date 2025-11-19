<x-admin.app>

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold" style="color:#b3d33c;">Bids for "{{ $project->title }}"</h5>

        <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-outline-dark">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- BIDS TABLE --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-2 border-0">
            <h6 class="fw-bold mb-0">
                <i class="fa fa-gavel me-2" style="color:#b3d33c;"></i>Contractor Bids
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
                            <th width="120">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($bids as $bid)
                        <tr>
                            <td>{{ $bid->id }}</td>
                            <td>{{ $bid->contractor->name }}</td>
                            <td>₹{{ $bid->bid_amount }}</td>
                            <td>{{ $bid->delivery_days }} days</td>
                            <td>{{ $bid->proposal_text }}</td>

                            <td>
                                @can('award bids')
                                @if ($project->status !== 'awarded')

                                    <form action="{{ route('admin.projects.award', [$project->id, $bid->id]) }}"
                                          method="POST">
                                        @csrf

                                        <button class="btn btn-sm btn-success px-2 fw-bold"
                                            onclick="return confirm('Award this project?')">
                                            <i class="fa fa-trophy"></i> Award
                                        </button>

                                    </form>

                                @else
                                    <span class="badge bg-success">Awarded</span>
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

</x-admin.app>
