<x-admin-layout>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Categories</h2>
            <p class="text-slate-500 text-sm mt-0.5">Configure operational categories & subcategories hierarchy</p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
            class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm shadow-teal-100 transition-all duration-200 transform hover:-translate-y-0.5">
            <i class="fa-solid fa-plus text-xs"></i> Add New Category
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

    @if ($errors->any())
        <div x-data="{ show: true }" x-show="show"
            class="fixed top-5 right-5 z-[60] bg-rose-600 text-white px-5 py-4 rounded-xl shadow-xl flex items-center gap-3">
            <div class="bg-white/20 w-8 h-8 rounded-full flex items-center justify-center shrink-0">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs uppercase tracking-wider">Error</h4>
                <p class="text-xs text-rose-50 mt-0.5">{{ $errors->first() }}</p>
            </div>
            <button @click="show = false" class="ml-4 text-rose-200 hover:text-white transition-colors shrink-0">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    @endif

    {{-- CATEGORY GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories as $category)
            <div
                class="bg-white rounded-2xl shadow-sm border border-slate-100 flex flex-col hover-lift group relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-teal-500/10 group-hover:bg-teal-500 transition-colors duration-300"></div>

                {{-- Card Header: Category Info --}}
                <div class="p-6 pb-4 flex justify-between items-start">
                    <div class="flex items-start gap-3">
                        <div
                            class="w-11 h-11 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-lg shadow-sm border border-teal-100/50 shrink-0">
                            @if ($category->icon)
                                <i class="{{ $category->icon }}"></i>
                            @else
                                <i class="fa-solid fa-layer-group"></i>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base leading-tight mb-1">{{ $category->name }}</h3>
                            <div class="flex flex-wrap items-center gap-1.5">
                                @if ($category->is_active)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-wider">
                                        Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-slate-50 text-slate-400 border border-slate-200 uppercase tracking-wider">
                                        Inactive
                                    </span>
                                @endif

                                @if ($category->parent)
                                    <span
                                        class="text-[9px] text-slate-400 font-bold uppercase bg-slate-50 px-2 py-0.5 rounded border border-slate-100">
                                        Sub: {{ $category->parent->name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Action Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                            class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-teal-600 hover:bg-slate-50 transition-all">
                            <i class="fa-solid fa-ellipsis-vertical text-sm"></i>
                        </button>
                        <div x-show="open" x-transition.origin.top.right
                            class="absolute right-0 mt-1 w-36 bg-white rounded-xl shadow-lg border border-slate-100 z-10 py-1.5"
                            style="display: none;">
                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                class="flex items-center px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-teal-600 transition-colors">
                                <i class="fa-solid fa-pen mr-2 text-[10px] text-slate-400"></i> Edit Category
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                onsubmit="return confirm('Delete category? This will delete all subcategories too.');">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-full flex items-center text-left px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50/50 transition-colors">
                                    <i class="fa-solid fa-trash mr-2 text-[10px] text-rose-400"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Subcategories List --}}
                <div class="px-6 pb-6 flex-1 flex flex-col justify-between">
                    @if ($category->subcategories->count() > 0)
                        <div class="mt-2 pt-4 border-t border-slate-100">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-2.5">Subcategories
                            </p>
                            <div class="space-y-1.5">
                                @foreach ($category->subcategories as $sub)
                                    <div
                                        class="flex items-center justify-between group p-2 rounded-lg hover:bg-slate-50 border border-transparent hover:border-slate-100/50 transition-all duration-200">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-1.5 h-1.5 rounded-full {{ $sub->is_active ? 'bg-emerald-400' : 'bg-slate-300' }}">
                                            </div>
                                            <span class="text-xs font-medium text-slate-600">{{ $sub->name }}</span>
                                        </div>

                                        <div
                                            class="flex items-center gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.categories.edit', $sub->id) }}"
                                                class="p-1 text-slate-400 hover:text-teal-600 transition-colors" title="Edit">
                                                <i class="fa-solid fa-pen text-[10px]"></i>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $sub->id) }}"
                                                method="POST" onsubmit="return confirm('Delete subcategory?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 transition-colors"
                                                    title="Delete">
                                                    <i class="fa-solid fa-trash text-[10px]"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div
                            class="mt-2 pt-8 pb-4 text-center border-t border-slate-100 h-full flex flex-col items-center justify-center">
                            <i class="fa-regular fa-folder text-slate-300 text-lg mb-1"></i>
                            <span class="text-xs text-slate-400 italic">No subcategories registered</span>
                        </div>
                    @endif
                </div>

                {{-- Footer Info --}}
                <div class="bg-slate-50/50 px-6 py-3 border-t border-slate-100 rounded-b-2xl flex items-center justify-between">
                    <span class="text-[10px] text-slate-400">Created {{ optional($category->created_at)->format('M d, Y') }}</span>
                    <span class="text-[10px] font-bold text-slate-400">{{ $category->subcategories->count() }} sub-elements</span>
                </div>

            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-16 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                        <i class="fa-regular fa-folder-open text-2xl text-slate-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-700">No categories found</h3>
                    <p class="text-slate-400 text-sm mt-1">Get started by creating a new operational category.</p>
                    <a href="{{ route('admin.categories.create') }}"
                        class="inline-flex items-center gap-2 mt-4 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-4 py-2 rounded-lg transition-colors">
                        <i class="fa-solid fa-plus text-[10px]"></i> Create Category
                    </a>
                </div>
            </div>
        @endforelse
    </div>

</x-admin-layout>
