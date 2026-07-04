<x-contractor-layout>
    <div class="p-3 md:p-6 space-y-4 md:space-y-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-3 md:gap-6">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3">
                    {{ __('Material Inventory') }}
                    <span class="bg-indigo-100 text-indigo-600 text-[10px] font-black uppercase px-3 py-1 rounded-full tracking-widest border border-indigo-200">
                        {{ $inventoryLogs->total() }} {{ __('Logs') }}
                    </span>
                </h1>
                <p class="text-gray-500 text-sm mt-1 font-medium">{{ __('Track material consumption, purchases, and adjustments across projects.') }}</p>
            </div>
            <button @click="$dispatch('open-modal', 'add-inventory-log')" 
                class="w-full lg:w-auto inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-black px-3 md:px-6 py-3.5 rounded-2xl transition-all shadow-xl shadow-indigo-100 transform active:scale-95">
                <i class="fa-solid fa-plus-circle"></i>
                {{ __('Add Material Log') }}
            </button>
        </div>

        <!-- Inventory Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-6">
            <div class="bg-white p-3 md:p-6 rounded-[2.5rem] border border-gray-100 shadow-sm group hover:border-blue-200 transition-all">
                <div class="flex items-center gap-5">
                    <div class="h-14 w-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-cart-flatbed text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Total Purchases') }}</p>
                        <p class="text-2xl font-black text-gray-900">{{ $inventoryLogs->where('type', 'purchase')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-3 md:p-6 rounded-[2.5rem] border border-gray-100 shadow-sm group hover:border-orange-200 transition-all">
                <div class="flex items-center gap-5">
                    <div class="h-14 w-14 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-600 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-trowel-bricks text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Consumption Logs') }}</p>
                        <p class="text-2xl font-black text-gray-900">{{ $inventoryLogs->where('type', 'consumption')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-3 md:p-6 rounded-[2.5rem] border border-gray-100 shadow-sm group hover:border-purple-200 transition-all">
                <div class="flex items-center gap-5">
                    <div class="h-14 w-14 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-diagram-project text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Active Sites') }}</p>
                        <p class="text-2xl font-black text-gray-900">{{ $projects->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventory Content -->
        <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-50">
                            <th class="px-4 md:px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Date') }}</th>
                            <th class="px-4 md:px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Project') }}</th>
                            <th class="px-4 md:px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Material') }}</th>
                            <th class="px-4 md:px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Type') }}</th>
                            <th class="px-4 md:px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">{{ __('Quantity') }}</th>
                            <th class="px-4 md:px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Notes') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($inventoryLogs as $log)
                            <tr class="hover:bg-gray-50/80 transition-all group">
                                <td class="px-4 md:px-8 py-3 md:py-6">
                                    <span class="text-sm font-black text-gray-900">{{ \Carbon\Carbon::parse($log->entry_date)->format('M d, Y') }}</span>
                                </td>
                                <td class="px-4 md:px-8 py-3 md:py-6">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-gray-900">{{ $log->project->title }}</span>
                                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">{{ __('Site Location') }}</span>
                                    </div>
                                </td>
                                <td class="px-4 md:px-8 py-3 md:py-6">
                                    <span class="px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-slate-50 text-slate-600 border border-slate-100">
                                        {{ $log->material->name }}
                                    </span>
                                </td>
                                <td class="px-4 md:px-8 py-3 md:py-6">
                                    @php
                                        $typeClasses = [
                                            'purchase' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'consumption' => 'bg-orange-50 text-orange-600 border-orange-100',
                                            'adjustment' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $typeClasses[$log->type] ?? 'bg-gray-100 text-gray-600 border-gray-200' }}">
                                        {{ __($log->type) }}
                                    </span>
                                </td>
                                <td class="px-4 md:px-8 py-3 md:py-6 text-right">
                                    <span class="text-sm font-black text-gray-900">{{ number_format($log->quantity, 2) }}</span>
                                    <span class="text-[10px] font-bold text-gray-400 ml-1">{{ $log->material->unit }}</span>
                                </td>
                                <td class="px-4 md:px-8 py-3 md:py-6">
                                    <p class="text-xs font-bold text-gray-500 italic max-w-[200px] truncate">{{ $log->notes ?? '-' }}</p>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile List -->
            <div class="md:hidden divide-y divide-gray-50">
                @forelse ($inventoryLogs as $log)
                    <div class="p-3 md:p-6 space-y-4 hover:bg-gray-50 transition-all">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-base font-black text-gray-900">{{ $log->material->name }}</h4>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $log->project->title }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-black text-gray-900">{{ number_format($log->quantity, 1) }} {{ $log->material->unit }}</p>
                                <span class="text-[9px] font-black uppercase tracking-widest {{ $typeClasses[$log->type] ?? 'text-gray-500' }}">{{ __($log->type) }}</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-2">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($log->entry_date)->format('M d, Y') }}</span>
                            <p class="text-[10px] font-bold text-gray-500 italic truncate max-w-[150px]">{{ $log->notes ?? '' }}</p>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>

            @if($inventoryLogs->isEmpty())
                <div class="py-32 flex flex-col items-center justify-center text-center px-3 md:px-6">
                    <div class="w-32 h-32 bg-gray-50 rounded-full flex items-center justify-center text-gray-200 text-6xl mb-8">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">{{ __('No Inventory Logs') }}</h3>
                    <p class="text-gray-500 mt-3 max-w-sm font-medium leading-relaxed">{{ __('You haven\'t recorded any material activity yet. Start tracking your site inventory to prevent losses.') }}</p>
                    <button @click="$dispatch('open-modal', 'add-inventory-log')" class="mt-10 px-10 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-2xl shadow-indigo-100 hover:bg-indigo-700 transition-all transform active:scale-95">
                        {{ __('Add First Log') }}
                    </button>
                </div>
            @endif
        </div>

        @if($inventoryLogs->hasPages())
            <div class="mt-8">
                {{ $inventoryLogs->links() }}
            </div>
        @endif
    </div>

    <!-- Redesigned Add Log Modal -->
    <div x-data="{ open: false, selectedMaterial: '' }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'add-inventory-log') open = true" 
         @close-modal.window="open = false; selectedMaterial = ''"
         class="fixed inset-0 z-50 overflow-y-auto" 
         x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 transition-opacity bg-gray-900/60 backdrop-blur-sm" 
                 @click="open = false"></div>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block w-full max-w-2xl p-0 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-[2.5rem]">
                
                <div class="p-4 md:p-8 pb-0 flex items-center justify-between">
                    <div>
                        <h3 class="text-3xl font-black text-gray-900 tracking-tight">{{ __('New Material Log') }}</h3>
                        <p class="text-gray-500 text-sm font-medium mt-1">{{ __('Record consumption or stock-in for materials.') }}</p>
                    </div>
                    <button @click="open = false" class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 hover:text-indigo-600 transition-colors">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form action="{{ route('contractor.inventory.store') }}" method="POST" class="p-4 md:p-8 space-y-3 md:space-y-6">
                    @csrf
                    
                    <div class="space-y-3 md:space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Project Site') }}</label>
                                <select name="project_id" required class="w-full px-3 md:px-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none appearance-none cursor-pointer">
                                    <option value="">{{ __('Select Awarded Project') }}</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Material Item') }}</label>
                                <select name="material_id" x-model="selectedMaterial" required class="w-full px-3 md:px-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none appearance-none cursor-pointer">
                                    <option value="">{{ __('Select Material') }}</option>
                                    @foreach($materials as $material)
                                        <option value="{{ $material->id }}">{{ $material->name }} ({{ $material->unit }})</option>
                                    @endforeach
                                    <option value="other" class="text-indigo-600 font-extrabold">{{ __('Other - Add New Material') }}</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Log Type') }}</label>
                                <select name="type" required class="w-full px-3 md:px-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none appearance-none cursor-pointer">
                                    <option value="purchase">{{ __('Purchase (Stock In)') }}</option>
                                    <option value="consumption" selected>{{ __('Consumption (Stock Out)') }}</option>
                                    <option value="adjustment">{{ __('Adjustment') }}</option>
                                </select>
                            </div>

                            <!-- Dynamic fields for Adding New Material -->
                            <div x-show="selectedMaterial === 'other'" x-transition class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6 p-4 md:p-6 bg-indigo-50/30 rounded-3xl border border-indigo-100/50">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-indigo-900/60 uppercase tracking-widest ml-1">{{ __('New Material Name') }}</label>
                                    <input type="text" name="new_material_name" :required="selectedMaterial === 'other'" placeholder="{{ __('e.g., Cement, Sand') }}"
                                           class="w-full px-3 md:px-6 py-4 bg-white border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-indigo-900/60 uppercase tracking-widest ml-1">{{ __('New Material Unit') }}</label>
                                    <input type="text" name="new_material_unit" :required="selectedMaterial === 'other'" placeholder="{{ __('e.g., bags, kg, cu.ft') }}"
                                           class="w-full px-3 md:px-6 py-4 bg-white border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Quantity') }}</label>
                                <div class="relative">
                                    <input type="number" name="quantity" step="0.01" required placeholder="0.00"
                                           class="w-full px-3 md:px-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-xl font-black text-gray-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Entry Date') }}</label>
                                <input type="date" name="entry_date" required value="{{ date('Y-m-d') }}"
                                       class="w-full px-3 md:px-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">
                            </div>
                        </div>

                        <div class="p-3 md:p-6 bg-slate-50/50 rounded-3xl border border-slate-100 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Unit Price') }} ({{ __('Optional') }})</label>
                                    <input type="number" name="unit_price" step="0.01" placeholder="₹ 0.00"
                                           class="w-full px-5 py-3 bg-white border-transparent rounded-xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Vendor') }} ({{ __('Optional') }})</label>
                                    <input type="text" name="vendor_name" placeholder="{{ __('Vendor Name') }}"
                                           class="w-full px-5 py-3 bg-white border-transparent rounded-xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Notes & Remarks') }}</label>
                            <textarea name="notes" rows="2" placeholder="{{ __('Any additional details...') }}"
                                      class="w-full px-3 md:px-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none"></textarea>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-4">
                        <button type="button" @click="open = false" 
                                class="w-full sm:w-auto px-10 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-all text-center">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit" 
                                class="w-full sm:w-auto px-12 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-save"></i>
                            {{ __('Save Inventory Log') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        [x-cloak] { display: none !important; }
    </style>
</x-contractor-layout>
