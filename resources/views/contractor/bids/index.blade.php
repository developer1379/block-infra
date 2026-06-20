<x-contractor-layout>
    <div class="min-h-screen bg-gray-50/50 p-3 md:p-6">
        <div class="max-w-7xl mx-auto space-y-3 md:space-y-6">

            {{-- 1. HEADER --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
                <div>
                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                        <a href="{{ route('admin.projects.index') }}" class="hover:text-indigo-600 transition-colors">{{ __('Projects') }}</a>
                        <span>/</span>
                        <span>{{ $project->title }}</span>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">{{ __('Bid Proposals') }}</h1>
                    <p class="text-gray-500 text-sm mt-1">{{ __('Review and manage') }} {{ $bids->count() }} {{ __('submitted proposals.') }}</p>
                </div>
                <a href="{{ route('contractor.projects.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 shadow-sm transition-all">
                    <i class="fa-solid fa-arrow-left"></i> {{ __('Back') }}
                </a>
            </div>

            {{-- 2. BIDS GRID --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-3 md:gap-6">
                @forelse ($bids as $bid)
                    {{-- Filter for Contractor View --}}
                    @if (auth()->user()->hasRole('contractor') && $bid->contractor_id != auth()->id())
                        @continue
                    @endif

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-200 flex flex-col group">

                        {{-- Card Header --}}
                        <div class="p-5 border-b border-gray-100 flex justify-between items-start bg-gray-50/50">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm border-2 border-white shadow-sm">
                                    {{ substr($bid->contractor->name, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-gray-900">{{ $bid->contractor->name }}</h3>
                                    <p class="text-xs text-gray-500">{{ $bid->contractor->email ?? __('No email') }}</p>
                                </div>
                            </div>

                            {{-- Status Badge --}}
                            @if ($bid->status == 'accepted')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-green-100 text-green-700 border border-green-200">
                                    <i class="fa-solid fa-check-circle mr-1"></i> {{ __('Awarded') }}
                                </span>
                            @elseif ($bid->status == 'rejected')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-red-100 text-red-700 border border-red-200">
                                    <i class="fa-solid fa-times-circle mr-1"></i> {{ __('Rejected') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-gray-100 text-gray-600 border border-gray-200">
                                    {{ __('Pending') }}
                                </span>
                            @endif
                        </div>

                        {{-- Card Body --}}
                        <div class="p-5 flex-1 space-y-4">

                            {{-- Key Stats --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 text-center">
                                    <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">{{ __('Bid Amount') }}</p>
                                    <p class="text-lg font-bold text-gray-900">₹{{ number_format($bid->bid_amount, 2) }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 text-center">
                                    <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">{{ __('Delivery') }}</p>
                                    <p class="text-sm font-semibold text-gray-700">{{ $bid->delivery_days }} {{ __('Days') }}</p>
                                </div>
                            </div>

                            {{-- Actions Row --}}
                            <div class="flex items-center justify-between pt-2">
                                {{-- View Proposal --}}
                                @if ($bid->proposal_text)
                                    <button class="viewProposalBtn flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg"
                                            data-proposal="{{ base64_encode($bid->proposal_text) }}">
                                        <i class="fa-regular fa-eye"></i> {{ __('Read Proposal') }}
                                    </button>
                                @else
                                    <span class="text-xs text-gray-400 italic">{{ __('No text proposal') }}</span>
                                @endif

                                {{-- PDF Link --}}
                                @if ($bid->proposal_pdf)
                                    <a href="{{ asset('storage/' . $bid->proposal_pdf) }}" target="_blank"
                                       class="flex items-center gap-1.5 text-xs font-semibold text-red-600 hover:text-red-800 transition-colors bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg">
                                        <i class="fa-regular fa-file-pdf"></i> PDF
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Card Footer (Admin Actions) --}}
                        @can('award bids')
                            @if ($bid->status == 'pending' && $project->status != 'awarded')
                                <div class="px-5 py-4 bg-gray-50 border-t border-gray-100 flex justify-end">
                                    <button class="awardBtn w-full flex justify-center items-center gap-2 bg-gray-900 hover:bg-gray-800 text-white text-xs font-bold uppercase tracking-wider py-2.5 rounded-lg shadow-sm transition-all transform active:scale-95"
                                            data-id="{{ $bid->id }}" data-project="{{ $project->id }}">
                                        <i class="fa-solid fa-award"></i> {{ __('Award Project') }}
                                    </button>
                                </div>
                            @endif
                        @endcan
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-xl border-2 border-dashed border-gray-200">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                            <i class="fa-solid fa-inbox text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">{{ __('No proposals yet') }}</h3>
                        <p class="text-gray-500 text-sm mt-1">{{ __('Contractors haven\'t submitted any bids for this project.') }}</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    {{-- HIDDEN FORM --}}
    <form id="awardForm" method="POST" style="display:none;">
        @csrf
    </form>

    {{-- PROPOSAL MODAL --}}
    <div id="proposalModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-gray-100">

                    {{-- Header --}}
                    <div class="bg-gray-50 px-3 md:px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <i class="fa-regular fa-file-lines text-indigo-600"></i> {{ __('Proposal Details') }}
                        </h3>
                        <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-red-500 transition-colors">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>

                    {{-- Body --}}
                    <div class="px-3 md:px-6 py-3 md:py-6 max-h-[60vh] overflow-y-auto custom-scrollbar">
                        <div id="proposalContent" class="prose prose-sm max-w-none text-gray-600">
                            {{-- Content injected via JS --}}
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="bg-gray-50 px-3 md:px-6 py-3 flex justify-end border-t border-gray-100">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                            {{ __('Close') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            // --- Modal Logic ---
            const modal = document.getElementById('proposalModal');
            const contentDiv = document.getElementById('proposalContent');

            function openModal() {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            // View Proposal Click
            $(document).on("click", ".viewProposalBtn", function() {
                let encoded = $(this).data("proposal");
                let decoded = atob(encoded); // Base64 decode
                contentDiv.innerHTML = decoded;
                openModal();
            });

            // Close on Escape Key
            document.addEventListener('keydown', function(event) {
                if (event.key === "Escape") closeModal();
            });

            // --- Award Logic (SweetAlert) ---
            $(document).on("click", ".awardBtn", function() {
                let bidId = $(this).data("id");
                let projectId = $(this).data("project");

                Swal.fire({
                    title: "{{ __('Award this bid?') }}",
                    text: "{{ __('This action will officially assign the project and reject all other pending bids.') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#111827", // gray-900
                    cancelButtonColor: "#9ca3af", // gray-400
                    confirmButtonText: "{{ __('Yes, Award Project') }}",
                    cancelButtonText: "{{ __('Cancel') }}",
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'px-5 py-2.5 rounded-lg font-bold',
                        cancelButton: 'px-5 py-2.5 rounded-lg font-medium text-gray-700 bg-gray-100'
                    }
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
</x-contractor-layout>

