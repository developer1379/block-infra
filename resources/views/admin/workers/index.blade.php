<x-admin-layout>
    <div class="p-6 space-y-8 animate-fade-in" 
         x-data="{ 
            confirmOpen: false, 
            confirmTitle: '', 
            confirmMessage: '', 
            confirmAction: '' 
         }">
         
        {{-- HEADER SECTION --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Workforce Management</h1>
                <p class="text-xs text-slate-400 font-medium mt-1">Manage all construction workers, credentials, wages, and track their attendance history.</p>
            </div>
            <a href="{{ route('admin.workers.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-teal-600 text-white rounded-xl text-xs font-bold hover:bg-teal-700 transition-all shadow-lg shadow-teal-500/10">
                <i class="fa-solid fa-plus text-[10px]"></i> Add Worker
            </a>
        </div>

        {{-- FILTERS SECTION --}}
        <form action="{{ route('admin.workers.index') }}" method="GET" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-4">
                {{-- Search Input --}}
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-[11px]"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, phone or skill..." 
                           class="w-full h-10 pl-9 pr-4 rounded-xl border border-slate-200 text-xs focus:ring-teal-500 focus:border-teal-500 bg-slate-50 transition-all">
                </div>

                {{-- Specialization Dropdown --}}
                <div class="relative">
                    <select name="specialization" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 text-xs focus:ring-teal-500 focus:border-teal-500 bg-slate-50 transition-all cursor-pointer">
                        <option value="">All Specializations</option>
                        @foreach($specializations as $spec)
                            <option value="{{ $spec }}" {{ request('specialization') == $spec ? 'selected' : '' }}>{{ $spec }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Status Dropdown --}}
                <div class="relative">
                    <select name="status" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 text-xs focus:ring-teal-500 focus:border-teal-500 bg-slate-50 transition-all cursor-pointer">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="h-10 px-5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-filter text-[10px]"></i> Apply Filters
                </button>
                @if(request()->anyFilled(['search', 'specialization', 'status']))
                    <a href="{{ route('admin.workers.index') }}" class="h-10 px-5 bg-white border border-slate-200 hover:border-rose-100 hover:text-rose-600 rounded-xl text-xs font-bold text-slate-600 transition-all flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-arrow-rotate-left"></i> Reset
                    </a>
                @endif
            </div>
        </form>

        {{-- WORKERS DATA TABLE --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="px-6 py-4">Worker Name</th>
                            <th class="px-6 py-4">Specialization</th>
                            <th class="px-6 py-4 text-center">Daily Wage</th>
                            <th class="px-6 py-4 text-center">Identity Type</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center w-36">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($workers as $worker)
                            <tr class="hover:bg-slate-50/40 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-slate-50 text-slate-600 flex items-center justify-center font-bold border border-slate-200/50 shadow-sm uppercase">
                                            {{ substr($worker->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-850">{{ $worker->name }}</p>
                                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $worker->phone ?? 'No phone' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-teal-50 text-teal-700 text-[9px] font-bold uppercase border border-teal-100/50 tracking-wider">
                                        {{ $worker->specialization ?? 'General Labor' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-slate-800">
                                    ₹{{ number_format($worker->daily_wage, 2) }}
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-[10px] text-slate-500 uppercase tracking-wider">
                                    {{ $worker->identity_type ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg text-[9px] font-bold uppercase tracking-wider border {{ $worker->status == 'active' ? 'bg-emerald-50 text-emerald-700 border-emerald-100/50' : 'bg-rose-50 text-rose-700 border-rose-100/50' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $worker->status == 'active' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                        {{ $worker->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.workers.attendance', $worker->id) }}" class="h-8 w-8 flex items-center justify-center bg-slate-50 border border-slate-200/50 hover:border-teal-100 hover:bg-teal-50 text-teal-600 rounded-lg transition-all shadow-sm" title="View Attendance History">
                                            <i class="fa-solid fa-calendar-check text-[11px]"></i>
                                        </a>
                                        <a href="{{ route('admin.workers.payments', $worker->id) }}" class="h-8 w-8 flex items-center justify-center bg-slate-50 border border-slate-200/50 hover:border-teal-100 hover:bg-teal-50 text-teal-600 rounded-lg transition-all shadow-sm" title="View Wage Payments">
                                            <i class="fa-solid fa-wallet text-[11px]"></i>
                                        </a>
                                        <a href="{{ route('admin.workers.edit', $worker->id) }}" class="h-8 w-8 flex items-center justify-center bg-slate-50 border border-slate-200/50 hover:border-teal-100 hover:bg-teal-50 text-teal-600 rounded-lg transition-all shadow-sm" title="Edit Worker Profile">
                                            <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                        </a>
                                        <button type="button" 
                                                @click="confirmTitle = 'Delete Worker'; confirmMessage = 'Are you sure you want to delete this worker profile? This action will permanently remove their records.'; confirmAction = '{{ route('admin.workers.destroy', $worker->id) }}'; confirmOpen = true;"
                                                class="h-8 w-8 flex items-center justify-center bg-slate-50 border border-slate-200/50 hover:border-rose-100 hover:bg-rose-50 text-rose-600 rounded-lg transition-all shadow-sm" title="Delete Worker Profile">
                                            <i class="fa-solid fa-trash text-[11px]"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center text-slate-400">
                                    <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-3 text-slate-400 border border-slate-100">
                                        <i class="fa-solid fa-users-slash text-base"></i>
                                    </div>
                                    <p class="text-xs font-bold text-slate-800">No workers found</p>
                                    <p class="text-[10px] text-slate-400 mt-1">Try modifying your filter search or create a new worker profile.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if($workers->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $workers->links() }}
                </div>
            @endif
        </div>

        {{-- CONFIRMATION MODAL --}}
        <div x-show="confirmOpen" class="fixed inset-0 z-[200] flex items-center justify-center p-4 animate-fade-in" x-cloak>
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="confirmOpen = false"></div>
            
            <!-- Modal Panel -->
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden relative z-[210] animate-scale-up border border-slate-100">
                <div class="p-6 text-center space-y-4">
                    <!-- Icon -->
                    <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-full flex items-center justify-center mx-auto border border-rose-100 animate-pulse">
                        <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                    </div>
                    
                    <!-- Content -->
                    <div class="space-y-1.5">
                        <h3 class="text-base font-bold text-slate-800" x-text="confirmTitle"></h3>
                        <p class="text-xs text-slate-500 leading-relaxed" x-text="confirmMessage"></p>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button @click="confirmOpen = false" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 text-xs font-bold rounded-xl hover:bg-slate-50 transition-all">
                        Cancel
                    </button>
                    <form :action="confirmAction" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-rose-600 text-white text-xs font-bold rounded-xl hover:bg-rose-700 shadow-sm transition-all">
                            Confirm Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</x-admin-layout>
