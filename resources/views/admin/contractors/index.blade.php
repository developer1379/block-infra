<x-admin-layout>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Contractors</h2>
            <p class="text-slate-500 text-sm">Manage contractor registrations, categories & status</p>
        </div>

        <a href="{{ route('admin.contractors.create') }}"
            class="inline-flex items-center gap-2 bg-primary hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-sm shadow-teal-100 transition-all transform hover:-translate-y-0.5">
            <i class="fa-solid fa-plus"></i> Add Contractor
        </a>
    </div>

    {{-- TOAST CONTAINER (Fixed Position) --}}
    <div id="toast-container" class="fixed top-5 right-5 z-[60] space-y-3"></div>

    {{-- CONTRACTORS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($contractors as $contractor)
            <div
                class="bg-white rounded-xl shadow-sm border border-slate-200 flex flex-col hover:shadow-md transition-all duration-200 group">

                {{-- Card Header --}}
                <div class="p-5 flex justify-between items-start border-b border-slate-50">
                    <div class="flex items-center gap-3">
                        {{-- Avatar / Icon --}}
                        <div
                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 border border-slate-200 shadow-sm">
                            <i class="fa-solid fa-helmet-safety"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base leading-tight">{{ $contractor->name }}</h3>
                            <p class="text-xs text-slate-500">{{ $contractor->company_name ?? 'Freelancer' }}</p>
                        </div>
                    </div>

                    {{-- Status Badge (Dynamic ID for AJAX) --}}
                    <span id="status-badge-{{ $contractor->id }}"
                        class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-bold border uppercase tracking-wide
                        {{ $contractor->is_active
                            ? 'bg-green-100 text-green-700 border-green-200'
                            : 'bg-gray-100 text-gray-500 border-gray-200' }}">
                        {{ $contractor->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                {{-- Contact Info --}}
                <div class="p-5 py-4 flex-1 space-y-3">

                    <div class="flex items-center gap-3 text-sm text-slate-600">
                        <div class="w-6 flex justify-center"><i class="fa-solid fa-envelope text-slate-400"></i></div>
                        <span class="truncate">{{ $contractor->email ?? 'N/A' }}</span>
                    </div>

                    <div class="flex items-center gap-3 text-sm text-slate-600">
                        <div class="w-6 flex justify-center"><i class="fa-solid fa-phone text-slate-400"></i></div>
                        <span>{{ $contractor->phone ?? 'N/A' }}</span>
                    </div>

                    <div class="flex items-center gap-3 text-sm text-slate-600">
                        <div class="w-6 flex justify-center"><i class="fa-solid fa-location-dot text-slate-400"></i>
                        </div>
                        <span>{{ $contractor->city ?? 'N/A' }}</span>
                    </div>

                </div>

                {{-- Footer Actions --}}
                <div
                    class="bg-slate-50 px-5 py-3 border-t border-slate-200 rounded-b-xl flex justify-between items-center">

                    {{-- Toggle Status Button --}}
                    <button type="button"
                        class="toggle-switch flex items-center gap-1.5 text-xs font-bold transition-colors
                        {{ $contractor->is_active ? 'text-red-500 hover:text-red-700' : 'text-green-600 hover:text-green-800' }}"
                        data-id="{{ $contractor->id }}" title="Toggle Status">
                        <i class="fa-solid {{ $contractor->is_active ? 'fa-ban' : 'fa-check-circle' }}"></i>
                        <span class="status-text">{{ $contractor->is_active ? 'Deactivate' : 'Activate' }}</span>
                    </button>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.contractors.show', $contractor->id) }}"
                            class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-blue-600 hover:bg-blue-50 flex items-center justify-center transition-colors shadow-sm"
                            title="View">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </a>

                        <a href="{{ route('admin.contractors.edit', $contractor->id) }}"
                            class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-amber-600 hover:bg-amber-50 flex items-center justify-center transition-colors shadow-sm"
                            title="Edit">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </a>

                        <form action="{{ route('admin.contractors.destroy', $contractor->id) }}" method="POST"
                            onsubmit="return confirm('Delete this contractor?');">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-red-600 hover:bg-red-50 flex items-center justify-center transition-colors shadow-sm"
                                title="Delete">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-helmet-safety text-3xl text-slate-300"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-700">No contractors found</h3>
                <p class="text-slate-500 text-sm mt-1">Get started by adding a new contractor.</p>
                <a href="{{ route('admin.contractors.create') }}"
                    class="inline-block mt-4 text-primary font-semibold text-sm hover:underline">
                    Add Contractor
                </a>
            </div>
        @endforelse
    </div>

    {{-- AJAX SCRIPT --}}
    @push('scripts')
        <script>
            // Toast Function
            function showToast(type, message) {
                const icon = type === 'success' ? '<i class="fa-solid fa-check-circle"></i>' :
                    '<i class="fa-solid fa-circle-xmark"></i>';
                const colorClass = type === 'success' ? 'bg-emerald-500' : 'bg-red-500';

                const toastHTML = `
                    <div class="flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg text-white ${colorClass} transition-all duration-500 transform translate-y-0 opacity-100 mb-2">
                        <div class="text-lg">${icon}</div>
                        <div class="text-sm font-semibold">${message}</div>
                        <button onclick="this.parentElement.remove()" class="ml-auto text-white/70 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
                    </div>`;

                $('#toast-container').append(toastHTML);

                // Auto remove after 3s
                setTimeout(() => {
                    $('#toast-container').children().first().fadeOut(500, function() {
                        $(this).remove();
                    });
                }, 3000);
            }

            // AJAX Toggle Logic
            $(document).on('click', '.toggle-switch', function() {
                const btn = $(this);
                const id = btn.data('id');
                const badge = $(`#status-badge-${id}`);
                const icon = btn.find('i');
                const textSpan = btn.find('.status-text');

                // Disable button temporarily
                btn.prop('disabled', true).addClass('opacity-50 cursor-wait');

                $.ajax({
                    url: '{{ url('admin/contractors') }}/' + id + '/toggle-status',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.success) {
                            const isActive = res.status === 'active';

                            // 1. Update Badge Styles
                            badge.removeClass(
                                    'bg-green-100 text-green-700 border-green-200 bg-gray-100 text-gray-500 border-gray-200'
                                    )
                                .addClass(isActive ?
                                    'bg-green-100 text-green-700 border-green-200' :
                                    'bg-gray-100 text-gray-500 border-gray-200')
                                .text(isActive ? 'Active' : 'Inactive');

                            // 2. Update Button Styles & Icon
                            btn.removeClass(
                                    'text-red-500 hover:text-red-700 text-green-600 hover:text-green-800')
                                .addClass(isActive ? 'text-red-500 hover:text-red-700' :
                                    'text-green-600 hover:text-green-800');

                            icon.removeClass('fa-ban fa-check-circle')
                                .addClass(isActive ? 'fa-ban' : 'fa-check-circle');

                            textSpan.text(isActive ? 'Deactivate' : 'Activate');

                            showToast('success',
                                `Contractor ${isActive ? 'activated' : 'deactivated'} successfully.`);
                        } else {
                            showToast('error', 'Failed to update status.');
                        }
                    },
                    error: function() {
                        showToast('error', 'Something went wrong!');
                    },
                    complete: function() {
                        btn.prop('disabled', false).removeClass('opacity-50 cursor-wait');
                    }
                });
            });
        </script>
    @endpush

</x-admin-layout>

