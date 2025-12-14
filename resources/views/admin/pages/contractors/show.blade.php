<x-admin.app>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Contractor Details</h2>
            <p class="text-slate-500 text-sm">Profile overview and documents</p>
        </div>

        <a href="{{ route('admin.contractors.index') }}"
            class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:text-slate-900 hover:border-slate-300 text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
    </div>

    {{-- MAIN CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-5xl mx-auto overflow-hidden">

        <div class="p-6 md:p-8">

            {{-- PROFILE SECTION --}}
            <div class="flex flex-col items-center justify-center mb-8">
                @php
                    $contractorImage = $contractor->image ? $contractor->image : asset('default-avatar.png');
                @endphp

                <div class="relative group cursor-pointer" onclick="openModal('{{ $contractorImage }}')">
                    <img src="{{ $contractorImage }}" alt="Profile"
                        class="w-32 h-32 rounded-full object-cover border-4 border-primary/20 shadow-md transition-transform group-hover:scale-105">
                    <div
                        class="absolute inset-0 rounded-full bg-black/0 group-hover:bg-black/10 transition-colors pointer-events-none">
                    </div>
                    <div
                        class="absolute bottom-0 right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm border border-slate-100 text-slate-400 group-hover:text-primary">
                        <i class="fa-solid fa-expand text-xs"></i>
                    </div>
                </div>

                <h3 class="mt-4 text-2xl font-bold text-slate-800">{{ $contractor->name }}</h3>
                <p class="text-slate-500 text-sm">{{ $contractor->email }}</p>
            </div>

            <hr class="border-slate-100 mb-8">

            {{-- BASIC INFO --}}
            <h4 class="text-sm font-bold text-slate-400 uppercase tracking-wide mb-4">Basic Information</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mb-8">

                <div>
                    <p class="text-xs font-semibold text-slate-500 mb-1">Company Name</p>
                    <p class="text-slate-800 font-medium">{{ $contractor->company_name ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-500 mb-1">Phone</p>
                    <p class="text-slate-800 font-medium font-mono">{{ $contractor->phone ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-500 mb-1">City</p>
                    <p class="text-slate-800 font-medium flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-slate-300"></i> {{ $contractor->city ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-500 mb-1">Status</p>
                    @if ($contractor->is_active)
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                            Active
                        </span>
                    @else
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-500 border border-gray-200">
                            Inactive
                        </span>
                    @endif
                </div>

                <div class="md:col-span-2">
                    <p class="text-xs font-semibold text-slate-500 mb-2">Categories</p>
                    <div class="flex flex-wrap gap-2">
                        @forelse($contractor->categories as $cat)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-slate-50 text-slate-700 border border-slate-200">
                                {{ $cat->name }}
                            </span>
                        @empty
                            <span class="text-slate-400 text-sm italic">No categories assigned</span>
                        @endforelse
                    </div>
                </div>

            </div>

            <hr class="border-slate-100 mb-8">

            {{-- DOCUMENTS --}}
            <h4 class="text-sm font-bold text-slate-400 uppercase tracking-wide mb-4">Uploaded Documents</h4>

            @if ($contractor->documents->count())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($contractor->documents as $doc)
                        <div
                            class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex justify-between items-center hover:shadow-sm transition-shadow">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-red-500 shadow-sm">
                                    <i class="fa-solid fa-file-pdf text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-700 leading-tight mb-0.5">
                                        {{ ucfirst($doc->document_type) }}</p>
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                        class="text-xs text-blue-600 hover:underline">View Document</a>
                                </div>
                            </div>

                            <div class="flex flex-col items-end gap-2">
                                @if ($doc->is_verified)
                                    <span
                                        class="inline-flex items-center gap-1 text-[10px] font-bold text-green-600 bg-green-50 px-2 py-1 rounded border border-green-100">
                                        <i class="fa-solid fa-check-circle"></i> Verified
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded border border-amber-100">
                                        <i class="fa-solid fa-clock"></i> Pending
                                    </span>
                                    <form action="{{ route('admin.contractor-documents.verify', $doc->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="text-xs font-bold text-primary hover:text-teal-800 transition-colors">
                                            Verify Now
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 bg-slate-50 rounded-xl border border-dashed border-slate-300">
                    <p class="text-slate-400 text-sm">No documents uploaded yet.</p>
                </div>
            @endif

        </div>
    </div>

    {{-- IMAGE PREVIEW MODAL (Tailwind) --}}
    <div id="imageModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-slate-900/75 transition-opacity backdrop-blur-sm" onclick="closeModal()"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

                {{-- Modal Panel --}}
                <div
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                    <div class="absolute right-4 top-4 z-10">
                        <button type="button" onclick="closeModal()"
                            class="rounded-full bg-white/20 p-1 text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>

                    <div class="p-6 text-center">
                        <img id="modalImage" src=""
                            class="w-full rounded-lg shadow-inner mb-6 max-h-[500px] object-contain mx-auto">

                        <a id="downloadImage" href="" download
                            class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold px-6 py-2.5 rounded-lg transition-colors">
                            <i class="fa-solid fa-download"></i> Download Image
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL SCRIPT --}}
    @push('scripts')
        <script>
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            const downloadLink = document.getElementById('downloadImage');

            function openModal(imageSrc) {
                modalImg.src = imageSrc;
                downloadLink.href = imageSrc;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            }

            function closeModal() {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto'; // Re-enable scrolling
            }

            // Close on Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === "Escape") {
                    closeModal();
                }
            });
        </script>
    @endpush

</x-admin.app>
