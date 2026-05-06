<x-admin-layout>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Works</h2>
            <p class="text-slate-500 text-sm">Manage work items and pricing</p>
        </div>

        <a href="{{ route('admin.works.create') }}"
            class="inline-flex items-center gap-2 bg-primary hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-sm shadow-teal-100 transition-all transform hover:-translate-y-0.5">
            <i class="fa-solid fa-plus"></i> Add New Work
        </a>
    </div>

    {{-- ALERTS --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            class="fixed top-5 right-5 z-[60] bg-lime-500 text-white px-6 py-4 rounded-xl shadow-lg flex items-center gap-3 transition-all duration-500 transform translate-y-0">
            <div class="bg-white/20 w-8 h-8 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-check"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm">Success!</h4>
                <p class="text-xs text-white/90">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="ml-4 text-white/60 hover:text-white"><i
                    class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    {{-- WORKS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($works as $work)
            <div
                class="bg-white rounded-xl shadow-sm border border-slate-200 flex flex-col hover:shadow-md transition-shadow duration-200 group">

                {{-- Card Header --}}
                <div class="p-5 pb-0 flex justify-between items-start">
                    <div>
                        <span
                            class="inline-flex items-center px-2 py-1 rounded bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-wide border border-slate-200 mb-2">
                            {{ $work->category->name ?? 'Uncategorized' }}
                        </span>
                        <h3
                            class="font-bold text-slate-800 text-lg leading-tight mb-1 group-hover:text-primary transition-colors">
                            {{ $work->name }}
                        </h3>
                    </div>

                    {{-- Status Badge --}}
                    @if ($work->is_active)
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500 shadow-sm" title="Active"></span>
                    @else
                        <span class="w-2.5 h-2.5 rounded-full bg-gray-300 shadow-sm" title="Inactive"></span>
                    @endif
                </div>

                {{-- Pricing Info --}}
                <div class="p-5 flex-1">
                    <div class="grid grid-cols-2 gap-3 mt-2">
                        {{-- Labor Cost --}}
                        <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Labor Cost</p>
                            <p class="text-sm font-mono font-bold text-slate-700">
                                @if ($work->labor_min || $work->labor_max)
                                    ₹{{ $work->labor_min }} - {{ $work->labor_max }}
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </p>
                        </div>

                        {{-- Total Cost --}}
                        <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Lab + Mat</p>
                            <p class="text-sm font-mono font-bold text-slate-700">
                                @if ($work->labor_material_min || $work->labor_material_max)
                                    ₹{{ $work->labor_material_min }} - {{ $work->labor_material_max }}
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Card Footer / Actions --}}
                <div
                    class="px-5 py-3 bg-slate-50 border-t border-slate-100 rounded-b-xl flex justify-between items-center">
                    <div class="text-xs text-slate-500 font-medium">
                        Unit: <span
                            class="text-slate-700 font-bold">{{ $work->unit->symbol ?? ($work->unit_label ?? 'N/A') }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.works.edit', $work->id) }}"
                            class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-blue-600 hover:bg-blue-50 hover:border-blue-200 flex items-center justify-center transition-all shadow-sm"
                            title="Edit Work">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </a>

                        <form action="{{ route('admin.works.destroy', $work->id) }}" method="POST"
                            onsubmit="return confirm('Delete this work?');">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-red-600 hover:bg-red-50 hover:border-red-200 flex items-center justify-center transition-all shadow-sm"
                                title="Delete Work">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-person-digging text-3xl text-slate-300"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-700">No works found</h3>
                    <p class="text-slate-500 text-sm mt-1">Get started by creating a new work item.</p>
                    <a href="{{ route('admin.works.create') }}"
                        class="inline-block mt-4 text-primary font-semibold text-sm hover:underline">
                        Add New Work
                    </a>
                </div>
            </div>
        @endforelse
    </div>

</x-admin-layout>

