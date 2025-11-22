<x-admin.app>

    <style>
        .card {
            border-radius: 12px;
            border: none;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #b3d33c;
            cursor: pointer;
            transition: .2s;
        }

        .profile-img:hover {
            opacity: .8;
        }

        .info-label {
            font-weight: 600;
            color: #343a40;
        }

        .info-value {
            font-size: 15px;
            color: #555;
            margin-bottom: 12px;
        }

        .badge-category {
            background: #17a2b8;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            color: #fff;
        }
    </style>

    <div class="page-wrapper">

        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">Contractor Details</h4>
                <small class="text-muted">Profile overview and documents</small>
            </div>

            <a href="{{ route('admin.contractors.index') }}" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left mr-1"></i> Back
            </a>
        </div>

        {{-- MAIN CARD --}}
        <div class="card shadow-sm">
            <div class="card-body p-4">

                {{-- Profile Image --}}
                <div class="text-center mb-4">
                    @php
                        $contractorImage = $contractor->image ? $contractor->image : asset('default-avatar.png');
                    @endphp

                    <img src="{{ $contractorImage }}" class="profile-img" id="profileImage"
                        data-img="{{ $contractorImage }}">

                    <h5 class="fw-bold mt-3 mb-0">{{ $contractor->name }}</h5>
                    <p class="text-muted small mb-0">{{ $contractor->email }}</p>
                </div>

                <hr>

                {{-- BASIC INFO --}}
                <h5 class="fw-bold text-dark mb-3">Basic Information</h5>
                <div class="row">

                    <div class="col-md-6">
                        <p class="info-label">Company Name</p>
                        <p class="info-value">{{ $contractor->company_name ?? '—' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="info-label">Phone</p>
                        <p class="info-value">{{ $contractor->phone ?? '—' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="info-label">City</p>
                        <p class="info-value">{{ $contractor->city ?? '—' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="info-label">Categories</p>
                        <p class="info-value">
                            @forelse($contractor->categories as $cat)
                                <span class="badge badge-category mr-1">{{ $cat->name }}</span>
                            @empty
                                <span class="text-muted">No categories</span>
                            @endforelse
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p class="info-label">Status</p>
                        @if ($contractor->is_active)
                            <span class="badge badge-success px-3 py-1">Active</span>
                        @else
                            <span class="badge badge-secondary px-3 py-1">Inactive</span>
                        @endif
                    </div>
                </div>

                <hr>

                {{-- DOCUMENTS --}}
                <h5 class="fw-bold text-dark mb-3">Uploaded Documents</h5>

                @if ($contractor->documents->count())
                    <div class="row">
                        @foreach ($contractor->documents as $doc)
                            <div class="col-md-6 mb-3">
                                <div class="document-card">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="doc-title">
                                                <i class="fa fa-file mr-2 text-secondary"></i>
                                                {{ ucfirst($doc->document_type) }}
                                            </div>

                                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">
                                                View Document
                                            </a>
                                        </div>

                                        <div>
                                            @if ($doc->is_verified)
                                                <span class="badge badge-success">Verified</span>
                                            @else
                                                <span class="badge badge-warning">Pending</span>
                                                <form
                                                    action="{{ route('admin.contractor-documents.verify', $doc->id) }}"
                                                    method="POST" class="mt-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-verify btn-sm">
                                                        <i class="fa fa-check mr-1"></i> Verify
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No documents uploaded yet.</p>
                @endif

            </div>
        </div>
    </div>


    {{-- IMAGE PREVIEW MODAL --}}
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Profile Image</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded mb-3" style="max-height: 450px;">

                    <a id="downloadImage" href="" download class="btn btn-primary">
                        <i class="fa fa-download mr-1"></i> Download
                    </a>
                </div>

            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            // CLICK PROFILE IMAGE → OPEN MODAL
            $(document).on('click', '#profileImage', function() {
                let img = $(this).data('img');

                $("#modalImage").attr("src", img);
                $("#downloadImage").attr("href", img);

                $("#imageModal").modal("show");
            });
        </script>
    @endpush

</x-admin.app>
