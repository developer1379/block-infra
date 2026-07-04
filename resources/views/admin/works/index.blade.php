<x-admin-layout>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Works</h2>
            <p class="text-slate-500 text-sm mt-0.5">Manage project work specifications, measurements, and pricing ranges</p>
        </div>

        <a href="{{ route('admin.works.create') }}"
            class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm shadow-teal-100 transition-all duration-200 transform hover:-translate-y-0.5">
            <i class="fa-solid fa-plus text-xs"></i> Add New Work
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

    {{-- WORKS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($works as $work)
            <div
                class="bg-white rounded-2xl shadow-sm border border-slate-100 flex flex-col hover-lift group relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-teal-500/10 group-hover:bg-teal-500 transition-colors duration-300"></div>

                {{-- Card Header --}}
                <div class="p-6 pb-0 flex justify-between items-start">
                    <div class="space-y-2">
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-teal-50 text-teal-700 border border-teal-100/50 uppercase tracking-wider">
                            {{ $work->category->name ?? 'Uncategorized' }}
                        </span>
                        <h3
                            class="font-bold text-slate-800 text-base leading-tight group-hover:text-teal-600 transition-colors duration-150">
                            {{ $work->name }}
                        </h3>
                    </div>

                    {{-- Status Badge --}}
                    @if ($work->is_active)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-wider shrink-0">
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-slate-50 text-slate-400 border border-slate-200 uppercase tracking-wider shrink-0">
                            Inactive
                        </span>
                    @endif
                </div>

                {{-- Pricing Info --}}
                <div class="p-6 flex-1">
                    <div class="grid grid-cols-2 gap-3.5">
                        {{-- Labor Cost --}}
                        <div class="bg-slate-50/50 p-3 rounded-xl border border-slate-100">
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider mb-1">Labor Cost</p>
                            <p class="text-sm font-bold text-slate-700 tracking-tight">
                                @if ($work->labor_min || $work->labor_max)
                                    ₹{{ number_format($work->labor_min) }} - ₹{{ number_format($work->labor_max) }}
                                @else
                                    <span class="text-slate-400 text-xs italic">Not set</span>
                                @endif
                            </p>
                        </div>

                        {{-- Total Cost --}}
                        <div class="bg-slate-50/50 p-3 rounded-xl border border-slate-100">
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider mb-1">Lab + Mat</p>
                            <p class="text-sm font-bold text-slate-700 tracking-tight">
                                @if ($work->labor_material_min || $work->labor_material_max)
                                    ₹{{ number_format($work->labor_material_min) }} - ₹{{ number_format($work->labor_material_max) }}
                                @else
                                    <span class="text-slate-400 text-xs italic">Not set</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Card Footer / Actions --}}
                <div
                    class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 rounded-b-2xl flex justify-between items-center">
                    <div class="text-[11px] text-slate-500 font-semibold uppercase tracking-wider">
                        Unit: <span
                            class="text-slate-800 font-bold">{{ $work->unit->symbol ?? ($work->unit_label ?? 'N/A') }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.works.edit', $work->id) }}"
                            class="w-8 h-8 rounded-lg bg-white border border-slate-200/80 text-teal-600 hover:bg-teal-50 hover:text-teal-700 flex items-center justify-center transition-all shadow-sm"
                            title="Edit Work">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </a>

                        <form action="{{ route('admin.works.destroy', $work->id) }}" method="POST"
                            onsubmit="return confirm('Delete this work?');">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="w-8 h-8 rounded-lg bg-white border border-slate-200/80 text-rose-600 hover:bg-rose-50 hover:text-rose-700 flex items-center justify-center transition-all shadow-sm"
                                title="Delete Work">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-16 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                        <i class="fa-solid fa-person-digging text-2xl text-slate-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-700">No works found</h3>
                    <p class="text-slate-400 text-sm mt-1">Get started by creating a new work specification.</p>
                    <a href="{{ route('admin.works.create') }}"
                        class="inline-flex items-center gap-2 mt-4 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-4 py-2 rounded-lg transition-colors">
                        <i class="fa-solid fa-plus text-[10px]"></i> Add New Work
                    </a>
                </div>
            </div>
        @endforelse
    </div>

</x-admin-layout>
