<x-contractor-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Material Inventory Logs</h1>
                    <p class="text-gray-500 mt-1">Track material consumption, purchases, and adjustments across your projects.</p>
                </div>
                <button @click="$dispatch('open-modal', 'add-inventory-log')" 
                    class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                    <i class="bi bi-plus-lg mr-2"></i>
                    Add Material Log
                </button>
            </div>

            <!-- Inventory Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
                    <div class="h-12 w-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                        <i class="bi bi-cart-check-fill text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Purchases</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $inventoryLogs->where('type', 'purchase')->count() }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
                    <div class="h-12 w-12 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600">
                        <i class="bi bi-hammer text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Consumption Logs</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $inventoryLogs->where('type', 'consumption')->count() }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
                    <div class="h-12 w-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                        <i class="bi bi-clipboard-data-fill text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Active Projects</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $projects->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Recent Logs Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-clock-history text-indigo-600"></i>
                        Recent Material Activity
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Project</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Material</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Qty</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($inventoryLogs as $log)
                                <tr class="hover:bg-gray-50/80 transition-colors group">
                                    <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                        {{ \Carbon\Carbon::parse($log->entry_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-semibold text-gray-900 truncate max-w-[200px]">{{ $log->project->title }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                            {{ $log->material->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $typeClasses = [
                                                'purchase' => 'bg-green-100 text-green-700',
                                                'consumption' => 'bg-amber-100 text-orange-700',
                                                'adjustment' => 'bg-blue-100 text-blue-700',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide {{ $typeClasses[$log->type] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ $log->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900 text-right">
                                        {{ number_format($log->quantity, 2) }} <span class="text-gray-400 font-normal text-xs">{{ $log->material->unit }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 italic truncate max-w-[150px]">
                                        {{ $log->notes ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="bi bi-box-seam text-4xl mb-2 opacity-20"></i>
                                            <p>No material logs found.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($inventoryLogs->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $inventoryLogs->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add Log Modal -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'add-inventory-log') open = true" 
         @close-modal.window="open = false"
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
                 class="inline-block w-full max-w-xl p-8 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl">
                
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 tracking-tight">New Material Log</h3>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-500 transition-colors">
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>
                </div>

                <form action="{{ route('contractor.inventory.store') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Project</label>
                            <select name="project_id" required class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all py-2.5">
                                <option value="">Select Awarded Project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Material</label>
                            <select name="material_id" required class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all py-2.5">
                                <option value="">Select Material</option>
                                @foreach($materials as $material)
                                    <option value="{{ $material->id }}">{{ $material->name }} ({{ $material->unit }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Log Type</label>
                            <select name="type" required class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all py-2.5">
                                <option value="purchase">Purchase (Stock In)</option>
                                <option value="consumption">Consumption (Stock Out)</option>
                                <option value="adjustment">Adjustment</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Quantity</label>
                            <div class="relative">
                                <input type="number" name="quantity" step="0.01" required placeholder="0.00"
                                       class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all py-2.5 pl-4 pr-12">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Entry Date</label>
                            <input type="date" name="entry_date" required value="{{ date('Y-m-d') }}"
                                   class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all py-2.5">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Unit Price (Optional)</label>
                            <input type="number" name="unit_price" step="0.01" placeholder="₹ 0.00"
                                   class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all py-2.5">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Vendor (Optional)</label>
                            <input type="text" name="vendor_name" placeholder="Vendor Name"
                                   class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all py-2.5">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Notes</label>
                        <textarea name="notes" rows="3" placeholder="Any additional details..."
                                  class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all py-2.5"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4">
                        <button type="button" @click="open = false" 
                                class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-8 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md transition-all transform hover:scale-[1.02]">
                            Save Log
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-contractor-layout>
