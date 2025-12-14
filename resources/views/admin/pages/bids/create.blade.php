<x-admin.app>

    {{-- 1. LOAD REQUIRED STYLES --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    {{-- 2. CUSTOM OVERRIDES --}}
    <style>
        /* Match Quill Toolbar to Tailwind Inputs */
        .ql-toolbar.ql-snow {
            border-color: #e2e8f0;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            background-color: #f8fafc;
        }

        .ql-container.ql-snow {
            border-color: #e2e8f0;
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
            background-color: #fff;
            min-height: 200px;
            font-family: 'Inter', sans-serif;
            /* Match site font */
        }

        /* Custom File Input Styling */
        input[type="file"]::file-selector-button {
            background-color: #0f766e;
            color: white;
            border: none;
            padding: 0.3rem 0.8rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 1rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        input[type="file"]::file-selector-button:hover {
            background-color: #115e59;
        }
    </style>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Submit Bid</h2>
            <p class="text-slate-500 text-sm">Create a proposal for <span
                    class="font-semibold text-primary">{{ $project->title }}</span></p>
        </div>

        <a href="{{ route('admin.projects.show', $project->id) }}"
            class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:text-slate-900 hover:border-slate-300 text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Back to Project
        </a>
    </div>

    {{-- BID FORM CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-5xl mx-auto">

        <div class="border-b border-gray-100 px-6 py-4">
            <h3 class="font-bold text-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-gavel text-primary"></i> Proposal Details
            </h3>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('admin.projects.bid.store', $project->id) }}" method="POST"
                enctype="multipart/form-data" id="bidForm">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                    {{-- Bid Amount --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Bid Amount (₹) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 font-bold">₹</span>
                            <input type="number" name="bid_amount" step="0.01"
                                class="w-full pl-8 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                placeholder="0.00" required>
                        </div>
                    </div>

                    {{-- Delivery Days --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Delivery Days <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="delivery_days"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                placeholder="e.g. 7" required>
                            <span
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 font-bold uppercase">Days</span>
                        </div>
                    </div>

                    {{-- Proposal Text (Quill) --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Proposal Description <span class="text-red-500">*</span>
                        </label>

                        <input type="hidden" name="proposal_text" id="proposalInput">

                        <div id="quillEditor"></div>

                        @error('proposal_text')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- PDF Upload --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">
                            Attach PDF Proposal (Optional)
                        </label>

                        {{-- Upload Input --}}
                        <input type="file" name="proposal_pdf" id="pdfInput" accept="application/pdf"
                            class="block w-full text-sm text-slate-500
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-full file:border-0
                                   file:text-xs file:font-semibold
                                   file:bg-primary/10 file:text-primary
                                   hover:file:bg-primary/20
                                   cursor-pointer bg-slate-50 border border-slate-200 rounded-lg p-1">
                        <p class="text-[10px] text-slate-400 mt-1 pl-1">Max file size: 5MB. Formats allowed: .pdf</p>

                        {{-- PDF Preview Container --}}
                        <div id="pdfPreviewContainer" class="mt-4 hidden animate-pulse">
                            <div
                                class="border-2 border-dashed border-slate-300 rounded-xl p-6 bg-slate-50/50 flex flex-col items-center justify-center text-center">
                                <div id="pdfIcon"
                                    class="w-12 h-12 bg-red-100 text-red-500 rounded-full flex items-center justify-center mb-3">
                                    <i class="fa-solid fa-file-pdf text-xl"></i>
                                </div>
                                <p id="pdfName" class="text-sm font-bold text-slate-700 mb-2"></p>
                                <embed id="pdfEmbed" src="" type="application/pdf"
                                    class="w-full h-[400px] rounded-lg border border-slate-200 shadow-sm hidden">
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end pt-6 border-t border-slate-100">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-primary hover:bg-teal-700 text-white text-sm font-bold px-6 py-2.5 rounded-lg shadow-md shadow-teal-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-paper-plane"></i> Submit Bid
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- SCRIPTS --}}
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

        <script>
            $(document).ready(function() {

                // --- 1. Initialize Quill Editor ---
                var quill = new Quill('#quillEditor', {
                    theme: 'snow',
                    placeholder: 'Describe your proposal details here...',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline'],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],
                            [{
                                'header': [1, 2, false]
                            }],
                            ['clean']
                        ]
                    }
                });

                // Sync Quill to Hidden Input
                $('#bidForm').on('submit', function() {
                    var html = quill.root.innerHTML;
                    if (html === '<p><br></p>') html = '';
                    $('#proposalInput').val(html);
                });

                // --- 2. PDF Preview Logic ---
                $('#pdfInput').on('change', function() {
                    let file = this.files[0];
                    let container = $('#pdfPreviewContainer');
                    let embed = $('#pdfEmbed');
                    let nameLabel = $('#pdfName');

                    if (file && file.type === "application/pdf") {
                        let fileURL = URL.createObjectURL(file);

                        container.removeClass('hidden').removeClass('animate-pulse');
                        nameLabel.text(file.name);
                        embed.attr('src', fileURL).removeClass('hidden');

                        // Scroll to preview
                        $('html, body').animate({
                            scrollTop: container.offset().top - 100
                        }, 500);

                    } else {
                        container.addClass('hidden');
                        embed.addClass('hidden').attr('src', '');
                    }
                });

            });
        </script>
    @endpush

</x-admin.app>
