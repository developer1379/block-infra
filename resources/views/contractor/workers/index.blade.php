<x-contractor-layout>
    <div class="p-6 space-y-8 animate-fade-in">
        <!-- Header & Stats -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3">
                    {{ __('My Workforce') }}
                    <span class="bg-indigo-100 text-indigo-600 text-[10px] font-black uppercase px-3 py-1 rounded-full tracking-widest border border-indigo-200">
                        {{ $workers->count() }}
                    </span>
                </h1>
                <p class="text-gray-500 text-sm mt-1 font-medium">{{ __('Manage laborers and skilled workers assigned to your projects') }}</p>
            </div>
            <div class="flex items-center gap-3 w-full lg:w-auto">
                <a href="{{ route('contractor.workers.create') }}" class="flex-1 lg:flex-none inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-black px-6 py-3.5 rounded-2xl transition-all shadow-xl shadow-indigo-100 transform active:scale-95">
                    <i class="fa-solid fa-plus-circle"></i>
                    {{ __('Add New Worker') }}
                </a>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="bg-white p-4 rounded-[2rem] border border-gray-100 shadow-sm flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative group">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-600 transition-colors"></i>
                <input type="text" id="workerSearch" placeholder="{{ __('Search workers by name or phone...') }}" 
                    class="w-full pl-12 pr-4 py-3 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all outline-none">
            </div>
            <div class="flex gap-2">
                <select id="statusFilter" class="px-4 py-3 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all outline-none appearance-none cursor-pointer pr-10">
                    <option value="all">{{ __('All Status') }}</option>
                    <option value="active">{{ __('Active') }}</option>
                    <option value="inactive">{{ __('Inactive') }}</option>
                </select>
            </div>
        </div>

        <!-- Worker Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="workerGrid">
            @forelse($workers as $worker)
                <div class="worker-card group bg-white rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-50 hover:border-indigo-100 transition-all duration-500 flex flex-col overflow-hidden relative" 
                     data-name="{{ strtolower($worker->name) }}" 
                     data-status="{{ $worker->status }}">
                    
                    <!-- Status Badge -->
                    <div class="absolute top-6 right-6 z-10">
                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border 
                            {{ $worker->status == 'active' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-red-50 text-red-600 border-red-100' }}">
                            {{ __($worker->status) }}
                        </span>
                    </div>

                    <div class="p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-16 h-16 rounded-3xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-all duration-500 border border-gray-100 group-hover:border-indigo-100 group-hover:scale-110">
                                <i class="fa-solid fa-user-gear text-2xl"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-lg font-black text-gray-900 truncate group-hover:text-indigo-600 transition-colors">
                                    {{ $worker->name }}
                                </h3>
                                <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mt-0.5">
                                    {{ __($worker->specialization ?? 'General Labor') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-2xl border border-gray-50 group-hover:bg-white group-hover:border-indigo-50 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-white flex items-center justify-center text-gray-400 shadow-sm">
                                        <i class="fa-solid fa-phone text-xs"></i>
                                    </div>
                                    <span class="text-sm font-bold text-gray-700">{{ $worker->phone ?? 'N/A' }}</span>
                                </div>
                                <div class="flex gap-2">
                                    @if($worker->phone)
                                        <a href="tel:{{ $worker->phone }}" class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all">
                                            <i class="fa-solid fa-phone text-xs"></i>
                                        </a>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $worker->phone) }}" target="_blank" class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all">
                                            <i class="fa-solid fa-whatsapp text-xs"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-2xl border border-gray-50 group-hover:bg-white group-hover:border-indigo-50 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-white flex items-center justify-center text-gray-400 shadow-sm">
                                        <i class="fa-solid fa-indian-rupee-sign text-xs"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">{{ __('Daily Wage') }}</span>
                                        <span class="text-sm font-black text-gray-900">₹{{ number_format($worker->daily_wage, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto p-8 pt-0 flex gap-3">
                        <a href="{{ route('contractor.workers.edit', $worker->id) }}" class="flex-1 py-3.5 bg-gray-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest text-center shadow-xl shadow-gray-100 hover:bg-gray-800 transition-all transform hover:-translate-y-1">
                            {{ __('Edit Profile') }}
                        </a>
                        <button type="button" class="px-4 py-3.5 bg-gray-50 text-gray-400 rounded-2xl hover:bg-red-50 hover:text-red-600 transition-all">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 flex flex-col items-center justify-center text-center">
                    <div class="w-32 h-32 bg-gray-50 rounded-full flex items-center justify-center text-gray-200 text-6xl mb-8">
                        <i class="fa-solid fa-users-slash"></i>
                    </div>
                    <h3 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">{{ __('No Workers Found') }}</h3>
                    <p class="text-gray-500 mt-3 max-w-sm font-medium leading-relaxed">{{ __('Your workforce is currently empty or no workers match your search criteria.') }}</p>
                    <a href="{{ route('contractor.workers.create') }}" class="mt-10 px-10 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-2xl shadow-indigo-100 hover:bg-indigo-700 transition-all">
                        {{ __('Add Your First Worker') }}
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('workerSearch').addEventListener('input', filterWorkers);
        document.getElementById('statusFilter').addEventListener('change', filterWorkers);

        function filterWorkers() {
            const search = document.getElementById('workerSearch').value.toLowerCase();
            const status = document.getElementById('statusFilter').value;
            const cards = document.querySelectorAll('.worker-card');

            cards.forEach(card => {
                const name = card.dataset.name;
                const cardStatus = card.dataset.status;
                const matchesSearch = name.includes(search);
                const matchesStatus = status === 'all' || cardStatus === status;

                if (matchesSearch && matchesStatus) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
    @endpush

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</x-contractor-layout>
