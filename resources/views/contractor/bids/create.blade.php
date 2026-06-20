<x-contractor-layout>

        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <style>
            /* Custom Quill Toolbar */
            .ql-toolbar.ql-snow {
                border-top-left-radius: 0.5rem;
                border-top-right-radius: 0.5rem;
                border-color: #d1d5db;
                background-color: #f9fafb;
                padding: 12px;
            }

            /* Custom Quill Container */
            .ql-container.ql-snow {
                border-bottom-left-radius: 0.5rem;
                border-bottom-right-radius: 0.5rem;
                border-color: #d1d5db;
                background-color: #fff;
                font-family: inherit;
                font-size: 0.95rem;
                color: #1f2937;
            }

            /* Placeholder Text Color */
            .ql-editor.ql-blank::before {
                color: #9ca3af;
                font-style: normal;
            }
        </style>
    <div class="min-h-screen bg-gray-50/50 p-3 md:p-6">
        <div class="max-w-5xl mx-auto space-y-3 md:space-y-6">

            {{-- PAGE HEADER --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">{{ __('Submit Proposal') }}</h2>
                    <p class="text-gray-500 text-sm mt-1">
                        {{ __('Bidding for') }}: <span class="font-semibold text-indigo-600">{{ $project->title }}</span>
                    </p>
                </div>

                <a href="{{ route('contractor.projects.show', $project->id) }}"
                    class="inline-flex items-center gap-2 bg-white border border-gray-200 text-gray-700 hover:text-gray-900 hover:bg-gray-50 text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition-all">
                    <i class="bi bi-arrow-left"></i> {{ __('Cancel & Back') }}
                </a>
            </div>

            {{-- FORM CARD --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                {{-- Header Bar --}}
                <div class="bg-gray-50/50 border-b border-gray-100 px-4 md:px-8 py-5 flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100">
                        <i class="bi bi-file-earmark-text text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">{{ __('Proposal Details') }}</h3>
                        <p class="text-xs text-gray-500">{{ __('Provide accurate estimates to increase your winning chance.') }}</p>
                    </div>
                </div>

                {{-- Bidding Suggestions --}}
                <div class="px-4 md:px-8 py-4 bg-amber-50 border-b border-amber-100 flex items-start gap-3">
                    <div class="mt-0.5 text-amber-600">
                        <i class="bi bi-lightbulb-fill"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-[11px] font-bold text-amber-800 uppercase tracking-wider mb-1">{{ __('Suggestions for winning') }}</p>
                        <ul class="text-[11px] text-amber-700 space-y-1 list-disc list-inside">
                            <li>{{ __('Keep your bid competitive but realistic.') }}</li>
                            <li>{{ __('A shorter timeline can be an advantage, but ensure you can deliver.') }}</li>
                            <li>{{ __('Upload a detailed PDF for complex project scopes.') }}</li>
                        </ul>
                    </div>
                </div>

                <div class="p-4 md:p-8">
                    <form action="{{ route('contractor.bids.store', $project->id) }}" method="POST"
                        enctype="multipart/form-data" id="bidForm">
                        @csrf

                        <div class="space-y-4 md:space-y-8">

                            {{-- 1. Cost & Timeline --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                                {{-- Bid Amount --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2 flex items-center gap-1.5">
                                        {{ __('Total Bid Amount') }} <span class="text-red-500">*</span>
                                        <i class="bi bi-info-circle text-gray-400 cursor-help" data-tooltip="{{ __('Include all taxes, labor costs, and material estimations.') }}"></i>
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <span class="text-gray-400 font-bold">₹</span>
                                        </div>
                                        <input type="number" name="bid_amount" step="0.01" min="0" required
                                            class="block w-full pl-8 pr-4 py-3 border-gray-300 rounded-lg text-gray-900 font-semibold placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm text-lg"
                                            placeholder="0.00">
                                    </div>
                                    <p class="text-[10px] text-gray-400 mt-1.5 ml-1">{{ __('Include all taxes and material costs.') }}</p>
                                </div>

                                {{-- Delivery Days --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2 flex items-center gap-1.5">
                                        {{ __('Estimated Timeline') }} <span class="text-red-500">*</span>
                                        <i class="bi bi-info-circle text-gray-400 cursor-help" data-tooltip="{{ __('Estimated number of days from the date the work order is issued.') }}"></i>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="delivery_days" min="1" required
                                            class="block w-full pl-4 pr-16 py-3 border-gray-300 rounded-lg text-gray-900 font-semibold placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm text-lg"
                                            placeholder="e.g. 45">
                                        <div
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <span
                                                class="text-xs font-bold text-gray-400 uppercase bg-gray-100 px-2 py-1 rounded">{{ __('Days') }}</span>
                                        </div>
                                    </div>
                                    </div>
                                    <p class="text-[10px] text-gray-400 mt-1.5 ml-1">{{ __('From project start date.') }}</p>
                                </div>
                            </div>

                            <hr class="border-gray-100">

                            {{-- 2. Proposal Description (Quill Editor) --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                                    {{ __('Detailed Proposal') }} <span class="text-red-500">*</span>
                                </label>

                                {{-- Hidden Input for Form Submission --}}
                                <input type="hidden" name="proposal_text" id="proposalInput">

                                {{-- Editor Container (Explicit Height Fix) --}}
                                <div id="quillEditor" style="height: 250px;"></div>

                                @error('proposal_text')
                                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <hr class="border-gray-100">

                            {{-- 3. File Attachment --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                                    {{ __('Attach PDF') }} ({{ __('Optional') }})
                                </label>

                                <div class="flex items-center justify-center w-full">
                                    <label for="pdfInput"
                                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-indigo-50 hover:border-indigo-300 transition-all group">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6"
                                            id="uploadPlaceholder">
                                            <div
                                                class="w-10 h-10 mb-3 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-400 group-hover:text-indigo-600 transition-colors shadow-sm">
                                                <i class="bi bi-cloud-arrow-up text-lg"></i>
                                            </div>
                                            <p class="mb-1 text-sm text-gray-500"><span
                                                    class="font-semibold text-indigo-600">{{ __('Click to upload') }}</span> {{ __('or drag and drop') }}</p>
                                            <p class="text-xs text-gray-400">{{ __('PDF documents only (Max 5MB)') }}</p>
                                        </div>

                                        {{-- Preview State --}}
                                        <div id="filePreview"
                                            class="hidden flex-col items-center justify-center w-full h-full">
                                            <div
                                                class="flex items-center gap-3 bg-white px-4 py-3 rounded-lg border border-gray-200 shadow-sm">
                                                <div
                                                    class="w-8 h-8 rounded bg-red-50 text-red-500 flex items-center justify-center shrink-0">
                                                    <i class="bi bi-file-earmark-pdf-fill"></i>
                                                </div>
                                                <div class="text-left">
                                                    <p id="fileName"
                                                        class="text-sm font-medium text-gray-700 truncate max-w-[200px]">
                                                        filename.pdf</p>
                                                    <p class="text-[10px] text-green-600 font-medium">{{ __('Ready to upload') }}
                                                    </p>
                                                </div>
                                                <button type="button" id="removeFile"
                                                    class="text-gray-400 hover:text-red-500 ml-2 transition-colors">
                                                    <i class="bi bi-x-circle-fill"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <input type="file" name="proposal_pdf" id="pdfInput"
                                            accept="application/pdf" class="hidden">
                                    </label>
                                </div>
                            </div>

                        </div>

                        {{-- Footer Actions --}}
                        <div class="flex items-center justify-end gap-4 pt-8 mt-4">
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-4 md:px-8 py-3 rounded-xl shadow-md shadow-indigo-200 transition-all transform hover:-translate-y-0.5 focus:ring-4 focus:ring-indigo-100">
                                <i class="bi bi-send-fill text-xs"></i> {{ __('Submit Proposal') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

        <script>
            $(document).ready(function() {

                // --- 1. Quill Editor Initialization ---
                if (document.getElementById('quillEditor')) {
                    var quill = new Quill('#quillEditor', {
                        theme: 'snow',
                        placeholder: '{{ __('Outline your methodology, key deliverables, and terms...') }}',
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

                    // Sync content to hidden input on form submit
                    $('#bidForm').on('submit', function() {
                        var html = quill.root.innerHTML;
                        // Avoid submitting empty paragraph
                        if (html === '<p><br></p>') html = '';
                        $('#proposalInput').val(html);
                    });
                }

                // --- 2. Custom File Upload Logic ---
                const fileInput = $('#pdfInput');
                const placeholder = $('#uploadPlaceholder');
                const preview = $('#filePreview');
                const fileName = $('#fileName');
                const removeBtn = $('#removeFile');

                fileInput.on('change', function() {
                    if (this.files && this.files[0]) {
                        if (this.files[0].type !== 'application/pdf') {
                            alert("{{ __('Please upload a PDF file.') }}");
                            this.value = '';
                            return;
                        }
                        fileName.text(this.files[0].name);
                        placeholder.addClass('hidden');
                        preview.removeClass('hidden').addClass('flex');
                    }
                });

                removeBtn.on('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    fileInput.val('');
                    preview.addClass('hidden').removeClass('flex');
                    placeholder.removeClass('hidden');
                });

            });
        </script>

</x-contractor-layout>

