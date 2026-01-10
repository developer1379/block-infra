<x-app-layout>

    {{-- CUSTOM STYLES FOR WYSIWYG CONTENT --}}
    <style>
        #proposalContent img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1rem 0;
        }

        #proposalContent ul,
        #proposalContent ol {
            padding-left: 1.5rem;
            list-style: disc;
        }

        #proposalContent p {
            margin-bottom: 0.75rem;
        }
    </style>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Project Bids</h2>
            <p class="text-slate-500 text-sm">Bids submitted for <span
                    class="font-semibold text-primary">{{ $project->title }}</span></p>
        </div>

        <a href="{{ route('admin.projects.index') }}"
            class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:text-slate-900 hover:border-slate-300 text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Back to Projects
        </a>
    </div>

    {{-- BIDS TABLE CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

        <div class="border-b border-slate-100 px-6 py-4 flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                <i class="fa-solid fa-gavel"></i>
            </div>
            <h3 class="font-bold text-slate-700">Contractor Proposals</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 border-b border-slate-200 text-xs font-semibold uppercase text-slate-500 tracking-wider">
                        <th class="px-6 py-4 w-12">#</th>
                        <th class="px-6 py-4">Contractor</th>
                        <th class="px-6 py-4">Bid Amount</th>
                        <th class="px-6 py-4">Delivery</th>
                        <th class="px-6 py-4 text-center">Proposal</th>
                        <th class="px-6 py-4 text-center">PDF</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($bids as $index => $bid)
                        {{-- Contractor Visibility Logic --}}
                        @if (auth()->user()->hasRole('contractor') && $bid->contractor_id != auth()->id())
                            @continue
                        @endif

                        <tr class="hover:bg-slate-50 transition-colors text-sm text-slate-600">
                            <td class="px-6 py-4 font-mono text-slate-400">{{ $index + 1 }}</td>

                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $bid->contractor->name }}</div>
                                <div class="text-xs text-slate-400">{{ $bid->contractor->company_name ?? 'Individual' }}
                                </div>
                            </td>

                            <td class="px-6 py-4 font-mono font-bold text-slate-700">
                                ₹{{ number_format($bid->bid_amount, 2) }}
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center gap-1 bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs font-medium border border-slate-200">
                                    <i class="fa-regular fa-clock"></i> {{ $bid->delivery_days }} Days
                                </span>
                            </td>

                            {{-- PROPOSAL VIEW --}}
                            <td class="px-6 py-4 text-center">
                                @if ($bid->proposal_text)
                                    <button
                                        class="viewProposalBtn text-blue-600 hover:text-blue-800 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition-colors font-medium text-xs flex items-center justify-center gap-1 mx-auto"
                                        data-proposal="{{ base64_encode($bid->proposal_text) }}">
                                        <i class="fa-regular fa-eye"></i> Read
                                    </button>
                                @else
                                    <span class="text-slate-400 text-xs italic">Empty</span>
                                @endif
                            </td>

                            {{-- PDF VIEW --}}
                            <td class="px-6 py-4 text-center">
                                @if ($bid->proposal_pdf)
                                    <a href="{{ asset('storage/' . $bid->proposal_pdf) }}" target="_blank"
                                        class="text-red-600 hover:text-red-800 hover:bg-red-50 px-3 py-1.5 rounded-lg transition-colors font-medium text-xs flex items-center justify-center gap-1 mx-auto">
                                        <i class="fa-regular fa-file-pdf"></i> PDF
                                    </a>
                                @else
                                    <span class="text-slate-400 text-xs italic">-</span>
                                @endif
                            </td>

                            {{-- STATUS BADGES --}}
                            <td class="px-6 py-4 text-center">
                                @if ($bid->status == 'accepted')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                        <i class="fa-solid fa-trophy mr-1"></i> Awarded
                                    </span>
                                @elseif ($bid->status == 'rejected')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                        <i class="fa-solid fa-xmark mr-1"></i> Rejected
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                        Pending
                                    </span>
                                @endif
                            </td>

                            {{-- ACTIONS --}}
                            <td class="px-6 py-4 text-right">
                                @can('award bids')
                                    @if ($bid->status == 'pending' && $project->status != 'awarded')
                                        <button
                                            class="awardBtn inline-flex items-center gap-1.5 bg-primary hover:bg-teal-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm transition-all transform active:scale-95"
                                            data-id="{{ $bid->id }}" data-project="{{ $project->id }}">
                                            <i class="fa-solid fa-award"></i> Award
                                        </button>
                                    @else
                                        <span class="text-slate-300 text-xs">—</span>
                                    @endif
                                @else
                                    <span class="text-slate-300 text-xs">—</span>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div
                                        class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                        <i class="fa-solid fa-inbox text-2xl text-slate-300"></i>
                                    </div>
                                    <p class="font-medium text-slate-600 text-sm">No bids received yet</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- HIDDEN FORM FOR AWARDING --}}
    <form id="awardForm" method="POST" style="display:none;">
        @csrf
    </form>

    {{-- TAILWIND MODAL FOR PROPOSAL --}}
    <div id="proposalModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

                {{-- Modal Panel --}}
                <div
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-slate-100">

                    {{-- Header --}}
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-regular fa-file-lines text-primary"></i> Proposal Details
                        </h3>
                        <button type="button" onclick="closeModal()"
                            class="text-slate-400 hover:text-red-500 transition-colors">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>

                    {{-- Body --}}
                    <div class="px-6 py-6 max-h-[70vh] overflow-y-auto bg-white">
                        <div id="proposalContent" class="text-sm text-slate-600 leading-relaxed">
                            {{-- Content injected via JS --}}
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="bg-slate-50 px-6 py-3 flex justify-end">
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                            Close
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
                    title: "Award this bid?",
                    text: "This action will reject all other pending bids.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#0f766e", // primary teal
                    cancelButtonColor: "#64748b", // slate
                    confirmButtonText: "Yes, Award Project",
                    customClass: {
                        popup: 'rounded-xl',
                        confirmButton: 'px-4 py-2 rounded-lg font-bold',
                        cancelButton: 'px-4 py-2 rounded-lg font-medium'
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

</x-app-layout>
