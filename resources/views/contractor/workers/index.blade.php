<x-contractor-layout>
    <div class="p-6 space-y-6 animate-fade-in">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">My Workforce</h1>
                <p class="text-gray-500 text-sm">Manage laborers and skilled workers assigned to your projects</p>
            </div>
            <a href="{{ route('contractor.workers.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-all shadow-md shadow-indigo-100">
                <i class="fa-solid fa-plus-circle"></i> Add New Worker
            </a>
        </div>

        <!-- Worker Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($workers as $worker)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 border border-indigo-100">
                                <i class="fa-solid fa-user-gear text-xl"></i>
                            </div>
                            <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider {{ $worker->status == 'active' ? 'bg-green-50 text-green-700 border border-green-100' : 'bg-red-50 text-red-700 border border-red-100' }}">
                                {{ $worker->status }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">{{ $worker->name }}</h3>
                        <p class="text-xs font-bold text-indigo-600 uppercase tracking-widest mt-1">{{ $worker->specialization ?? 'General Labor' }}</p>
                        
                        <div class="mt-6 space-y-3">
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <i class="fa-solid fa-phone w-4 text-gray-400"></i>
                                <span>{{ $worker->phone ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <i class="fa-solid fa-indian-rupee-sign w-4 text-gray-400"></i>
                                <span>₹{{ number_format($worker->daily_wage, 2) }} / day</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50/50 px-6 py-4 border-t border-gray-100 flex justify-end gap-2">
                        <a href="{{ route('contractor.workers.edit', $worker->id) }}" class="p-2 text-gray-400 hover:text-indigo-600 transition-colors">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-2xl border border-dashed border-gray-200">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-users-slash text-3xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700">No workers found</h3>
                    <p class="text-gray-500 text-sm mt-1">Start by adding your team members here.</p>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }
    </style>
</x-contractor-layout>
