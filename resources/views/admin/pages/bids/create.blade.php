<x-admin.app>

    <style>
        .form-label-custom {
            font-size: 12px;
            font-weight: 600;
            color: #444;
        }

        .pdf-preview-box {
            border: 1px dashed #aaa;
            padding: 15px;
            border-radius: 6px;
            background: #fafafa;
        }

        .pdf-preview-box i {
            font-size: 42px;
            color: #dc3545;
        }

        .pdf-preview-name {
            font-size: 13px;
            font-weight: 600;
            color: #333;
        }

        .pdf-preview-empty {
            color: #666;
        }

        .quill-container {
            background: #fff;
            border: 1px solid #ced4da;
            border-radius: 6px;
        }
    </style>

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h5 class="fw-bold mb-1" style="color:#b3d33c;">Submit Bid</h5>

        <a href="{{ route('admin.projects.show', $project->id) }}" class="btn btn-sm btn-outline-dark">
            <i class="fa fa-arrow-left mr-1"></i> Back to Project
        </a>
    </div>

    {{-- BID FORM CARD --}}
    <div class="card shadow border-0">

        <div class="card-header bg-white py-3 border-0">
            <h6 class="fw-bold mb-0">
                <i class="fa fa-gavel mr-2" style="color:#b3d33c;"></i>
                Submit Your Bid for <span class="text-primary">{{ $project->title }}</span>
            </h6>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('admin.projects.bid.store', $project->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- BID AMOUNT --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Bid Amount (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="bid_amount" step="0.01"
                            class="form-control form-control-sm border-secondary" placeholder="Enter your bid amount"
                            required>
                    </div>

                    {{-- DELIVERY DAYS --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Delivery Days <span class="text-danger">*</span></label>
                        <input type="number" name="delivery_days" class="form-control form-control-sm border-secondary"
                            placeholder="e.g. 7" required>
                    </div>

                    {{-- PROPOSAL --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label-custom">Proposal Details</label>

                        {{-- Hidden Field --}}
                        <input type="hidden" name="proposal_text" id="proposalInput">

                        {{-- Quill Editor --}}
                        <div class="quill-container">
                            <div id="quillEditor" style="height:240px;"></div>
                        </div>

                        @error('proposal_text')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- PDF UPLOAD --}}
                    <div class="col-md-12 mb-2">
                        <label class="form-label-custom">Upload PDF (optional)</label>
                        <input type="file" name="proposal_pdf" id="pdfInput" style="height: 35px;"
                            class="form-control form-control-sm border-secondary" accept="application/pdf">

                        <small class="text-muted">Max 5MB — PDF only</small>
                    </div>

                    {{-- PDF PREVIEW --}}
                    <div class="col-md-12">
                        <div id="pdfPreview" class="pdf-preview-box text-center">

                            <i class="fa fa-file-pdf-o"></i>
                            <p class="pdf-preview-empty mb-0">No PDF selected</p>

                            {{-- EMBED FRAME (hidden initially) --}}
                            <embed id="pdfEmbed" src="" type="application/pdf"
                                style="width:100%; height:400px; margin-top:15px; border:1px solid #ccc; display:none;">
                        </div>
                    </div>

                </div>

                {{-- SUBMIT --}}
                <div class="text-right mt-4">
                    <button class="btn px-4 fw-bold" style="background-color:#b3d33c; color:#000;">
                        <i class="fa fa-paper-plane mr-1"></i> Submit Bid
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-admin.app>
<script>
    $(document).ready(function() {

        // PDF Preview
        $('#pdfInput').on('change', function() {
            let file = this.files[0];
            let preview = $('#pdfPreview');
            let embed = $('#pdfEmbed');

            if (file && file.type === "application/pdf") {
                let fileURL = URL.createObjectURL(file);
                embed.attr('src', fileURL).show();
                preview.find('.pdf-preview-empty').hide();
                preview.find('.pdf-preview-name').remove();
                preview.prepend(`<p class="pdf-preview-name mt-2">${file.name}</p>`);
            } else {
                embed.hide();
                preview.html(`
                    <i class="fa fa-file-pdf-o"></i>
                    <p class="pdf-preview-empty mb-0">No PDF selected</p>
                `);
            }
        });

    });
</script>
