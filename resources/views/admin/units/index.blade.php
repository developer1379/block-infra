<x-admin-layout>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Units</h2>
            <p class="text-slate-500 text-sm mt-0.5">Manage operational measurement units used in contract specifications</p>
        </div>

        <a href="{{ route('admin.units.create') }}"
            class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm shadow-teal-100 transition-all duration-200 transform hover:-translate-y-0.5">
            <i class="fa-solid fa-plus text-xs"></i> Add Unit
        </a>
    </div>

    {{-- ALERTS --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            class="fixed top-5 right-5 z-[60] bg-emerald-600 text-white px-5 py-4 rounded-xl shadow-xl flex items-center gap-3 transition-all duration-500 transform translate-y-0">
            <div class="bg-white/20 w-8 h-8 rounded-full flex items-center justify-center shrink-0">
                <i class="fa-solid fa-check"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs uppercase tracking-wider">Success</h4>
                <p class="text-xs text-emerald-50 mt-0.5">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="ml-4 text-emerald-200 hover:text-white transition-colors shrink-0">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    @endif

    {{-- UNITS TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-100 text-[10px] font-bold uppercase text-slate-400 tracking-wider">
                        <th class="px-6 py-4.5 w-16 text-center">#</th>
                        <th class="px-6 py-4.5">Unit Name</th>
                        <th class="px-6 py-4.5">Symbol</th>
                        <th class="px-6 py-4.5">Description</th>
                        <th class="px-6 py-4.5">Status</th>
                        <th class="px-6 py-4.5 text-center w-32">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($units as $key => $unit)
                        <tr class="hover:bg-slate-50/40 transition-colors group">
                            <td class="px-6 py-4 text-center text-slate-400 font-semibold">{{ $key + 1 }}</td>

                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $unit->name }}</td>

                            <td class="px-6 py-4">
                                <span class="bg-slate-50 text-slate-600 px-2.5 py-1 rounded-lg text-xs font-bold font-mono border border-slate-200/50">
                                    {{ $unit->symbol }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-slate-500 truncate max-w-xs">
                                {{ $unit->description ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($unit->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-wider">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-slate-50 text-slate-400 border border-slate-200 uppercase tracking-wider">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.units.edit', $unit->id) }}"
                                        class="w-8 h-8 rounded-lg flex items-center justify-center text-teal-600 hover:bg-teal-50 hover:text-teal-700 transition-colors border border-slate-200/60 shadow-sm"
                                        title="Edit Unit">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>

                                    <form action="{{ route('admin.units.destroy', $unit->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this unit?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 rounded-lg flex items-center justify-center text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition-colors border border-slate-200/60 shadow-sm"
                                            title="Delete Unit">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-center mb-4">
                                        <i class="fa-solid fa-ruler-combined text-2xl text-slate-400"></i>
                                    </div>
                                    <p class="font-bold text-slate-700">No measurement units found</p>
                                    <p class="text-sm text-slate-400 mt-1">Get started by adding a new unit above.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>
