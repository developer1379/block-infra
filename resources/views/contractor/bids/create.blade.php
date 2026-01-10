<x-app-layout>

    {{-- 1. STYLES --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <style>
        /* Quill Editor Polish */
        .ql-toolbar.ql-snow {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            border-color: #e2e8f0;
            background-color: #f8fafc;
            padding: 8px;
        }

        .ql-container.ql-snow {
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
            border-color: #e2e8f0;
            background-color: #fff;
            min-height: 220px;
            font-size: 0.95rem;
            color: #334155;
            /* Slate-700 */
        }

        .ql-editor.ql-blank::before {
            font-style: normal;
            color: #94a3b8;
            /* Slate-400 */
        }

        /* File Upload Customization */
        .file-upload-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        input[type="file"]::file-selector-button {
            display: none;
            /* Hide default button for custom styling */
        }
    </style>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Submit Proposal</h2>
            <p class="text-slate-500 text-sm mt-1">
                For Project: <span class="font-semibold text-primary">{{ $project->title }}</span>
            </p>
        </div>

        <a href="{{ route('admin.projects.show', $project->id) }}"
            class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:text-slate-900 hover:border-slate-300 text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition-all">
            <i class="fa-solid fa-arrow-left text-xs"></i> Back to Project
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-4xl mx-auto overflow-hidden">

        <div class="bg-slate-50/50 border-b border-slate-100 px-8 py-5">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                    <i class="fa-solid fa-file-contract text-sm"></i>
                </div>
                Proposal Details
            </h3>
        </div>

        <div class="p-8">
            <form action="{{ route('contractor.projects.bid.store', $project->id) }}" method="POST"
                enctype="multipart/form-data" id="bidForm">
                @csrf

                <div class="space-y-8">

                    {{-- 1. Cost & Timeline Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Bid Amount --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                                Bid Amount (₹) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-400 font-bold">₹</span>
                                </div>
                                <input type="number" name="bid_amount" step="0.01" min="0" required
                                    class="block w-full pl-8 pr-12 py-2.5 border-slate-200 rounded-lg text-slate-800 font-semibold placeholder-slate-300 focus:ring-primary focus:border-primary transition-colors bg-white shadow-sm"
                                    placeholder="0.00">
                            </div>
                        </div>

                        {{-- Delivery Days --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                                Delivery Time <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="delivery_days" min="1" required
                                    class="block w-full pl-4 pr-12 py-2.5 border-slate-200 rounded-lg text-slate-800 font-semibold placeholder-slate-300 focus:ring-primary focus:border-primary transition-colors bg-white shadow-sm"
                                    placeholder="e.g. 15">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-xs font-bold text-slate-400 uppercase">Days</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Proposal Description --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                            Proposal Description <span class="text-red-500">*</span>
                        </label>
                        <input type="hidden" name="proposal_text" id="proposalInput">
                        <div id="quillEditor" class="shadow-sm"></div>
                        @error('proposal_text')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 3. File Attachment --}}
                    <div
                        class="bg-slate-50 rounded-xl border border-dashed border-slate-300 p-6 text-center hover:bg-slate-50/80 transition-colors">
                        <label for="pdfInput" class="cursor-pointer block w-full h-full">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <div
                                    class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center shadow-sm text-slate-400">
                                    <i class="fa-solid fa-paperclip"></i>
                                </div>
                                <div>
                                    <span class="text-sm font-semibold text-primary hover:text-teal-700">Upload PDF
                                        Proposal</span>
                                    <span class="text-sm text-slate-500"> or drag and drop</span>
                                </div>
                                <p class="text-xs text-slate-400">PDF up to 5MB (Optional)</p>
                            </div>
                            <input type="file" name="proposal_pdf" id="pdfInput" accept="application/pdf"
                                class="hidden">
                        </label>

                        {{-- File Preview --}}
                        <div id="filePreview"
                            class="mt-4 hidden text-left bg-white border border-slate-200 rounded-lg p-3 shadow-sm flex items-center justify-between">
                            <div class="flex items-center gap-3 overflow-hidden">
                                <div
                                    class="w-8 h-8 rounded bg-red-50 text-red-500 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </div>
                                <div class="min-w-0">
                                    <p id="fileName" class="text-sm font-medium text-slate-700 truncate">filename.pdf
                                    </p>
                                    <p class="text-[10px] text-slate-400">Ready to upload</p>
                                </div>
                            </div>
                            <button type="button" id="removeFile"
                                class="text-slate-400 hover:text-red-500 p-1 rounded-full hover:bg-slate-50 transition-colors">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>

                </div>

                {{-- Footer Actions --}}
                <div class="flex items-center justify-end gap-4 pt-8 mt-2 border-t border-slate-100">
                    <a href="{{ route('admin.projects.show', $project->id) }}"
                        class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-primary hover:bg-teal-700 text-white text-sm font-bold px-6 py-2.5 rounded-lg shadow-md shadow-teal-100/50 transition-all transform hover:-translate-y-0.5 focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i class="fa-solid fa-paper-plane text-xs"></i> Submit Proposal
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

                // --- 1. Quill Editor ---
                var quill = new Quill('#quillEditor', {
                    theme: 'snow',
                    placeholder: 'Outline your proposal details, approach, and key deliverables...',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline'],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],
                            [{
                                'header': [2, 3, false]
                            }],
                            ['clean']
                        ]
                    }
                });

                // Sync on Submit
                $('#bidForm').on('submit', function() {
                    var html = quill.root.innerHTML;
                    if (html === '<p><br></p>') html = '';
                    $('#proposalInput').val(html);
                });

                // --- 2. Custom File Upload UI ---
                const fileInput = $('#pdfInput');
                const preview = $('#filePreview');
                const fileName = $('#fileName');
                const removeBtn = $('#removeFile');

                fileInput.on('change', function() {
                    if (this.files && this.files[0]) {
                        if (this.files[0].type !== 'application/pdf') {
                            alert('Please upload a PDF file.');
                            this.value = '';
                            return;
                        }
                        fileName.text(this.files[0].name);
                        preview.removeClass('hidden').addClass('flex');
                    }
                });

                removeBtn.on('click', function() {
                    fileInput.val('');
                    preview.addClass('hidden').removeClass('flex');
                });

            });
        </script>
    @endpush

</x-app-layout>
