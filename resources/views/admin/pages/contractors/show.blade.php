<x-admin.app>
    <style>
        .card {
            border-radius: 10px;
        }

        .info-label {
            font-weight: 600;
            color: #212529;
        }

        .info-value {
            color: #555;
        }

        .badge-verified {
            background-color: #b3d33c;
            color: #000;
            border-radius: 4px;
            padding: 4px 8px;
        }

        .badge-pending {
            background-color: #ffc107;
            color: #000;
            border-radius: 4px;
            padding: 4px 8px;
        }

        .btn-verify {
            background-color: #b3d33c;
            color: #000;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 13px;
        }

        .btn-verify:hover {
            background-color: #a0c32f;
            color: #000;
        }

        .document-card {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 10px 15px;
            background: #f8f9fa;
            margin-bottom: 10px;
        }

        .document-card a {
            color: #000;
            text-decoration: none;
        }

        .document-card a:hover {
            text-decoration: underline;
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
        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-uppercase mb-0 text-dark">Contractor Details</h4>
                <small class="text-muted">View profile and documents</small>
            </div>
            <a href="{{ route('admin.contractors.index') }}" class="btn btn-outline-secondary px-3">
                <i class="fa fa-arrow-left mr-1"></i> Back
            </a>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                {{-- Contractor Info --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p class="mb-1 info-label">Name</p>
                        <p class="info-value">{{ $contractor->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 info-label">Company Name</p>
                        <p class="info-value">{{ $contractor->company_name ?? '—' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 info-label">Email</p>
                        <p class="info-value">{{ $contractor->email ?? '—' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 info-label">Phone</p>
                        <p class="info-value">{{ $contractor->phone ?? '—' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 info-label">City</p>
                        <p class="info-value">{{ $contractor->city ?? '—' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 info-label">Category</p>
                        <p class="info-value">{{ $contractor->categoryRelation->name ?? '—' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 info-label">Status</p>
                        @if ($contractor->is_active)
                            <span class="badge badge-success px-2 py-1">Active</span>
                        @else
                            <span class="badge badge-secondary px-2 py-1">Inactive</span>
                        @endif
                    </div>
                </div>

                <hr>

                {{-- Documents Section --}}
                <h5 class="fw-bold text-dark mb-3">Uploaded Documents</h5>

                @if ($contractor->documents->count() > 0)
                    <div class="row">
                        @foreach ($contractor->documents as $doc)
                            <div class="col-md-6">
                                <div class="document-card d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fa fa-file text-secondary mr-2"></i>
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">
                                            {{ ucfirst($doc->document_type) }}
                                        </a>
                                    </div>
                                    <div class="text-right">
                                        @if ($doc->is_verified)
                                            <span class="badge-verified">Verified</span>
                                        @else
                                            <span class="badge-pending">Pending</span>
                                            <form action="{{ route('admin.contractor-documents.verify', $doc->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-verify ml-2">
                                                    <i class="fa fa-check mr-1"></i> Verify
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">No documents uploaded yet.</p>
                @endif
            </div>
        </div>
    </div>
</x-admin.app>
