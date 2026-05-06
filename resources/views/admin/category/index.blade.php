<x-admin-layout>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Categories</h2>
            <p class="text-slate-500 text-sm">Manage categories & subcategories efficiently</p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
            class="inline-flex items-center gap-2 bg-primary hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-sm shadow-teal-100 transition-all transform hover:-translate-y-0.5">
            <i class="fa-solid fa-plus"></i> Add New Category
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

    @if ($errors->any())
        <div x-data="{ show: true }" x-show="show"
            class="fixed top-5 right-5 z-[60] bg-red-500 text-white px-6 py-4 rounded-xl shadow-lg flex items-center gap-3">
            <div class="bg-white/20 w-8 h-8 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm">Error!</h4>
                <p class="text-xs text-white/90">{{ $errors->first() }}</p>
            </div>
            <button @click="show = false" class="ml-4 text-white/60 hover:text-white"><i
                    class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    {{-- CATEGORY GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories as $category)
            <div
                class="bg-white rounded-xl shadow-sm border border-slate-200 flex flex-col hover:shadow-md transition-shadow duration-200">

                {{-- Card Header: Category Info --}}
                <div class="p-5 pb-4 flex justify-between items-start">
                    <div class="flex items-start gap-3">
                        <div
                            class="w-10 h-10 rounded-lg bg-teal-50 text-primary flex items-center justify-center text-lg shadow-sm border border-teal-100">
                            @if ($category->icon)
                                <i class="{{ $category->icon }}"></i>
                            @else
                                <i class="fa-solid fa-layer-group"></i>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg leading-tight mb-1">{{ $category->name }}</h3>
                            <div class="flex items-center gap-2">
                                @if ($category->is_active)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700 border border-green-200 uppercase tracking-wide">
                                        Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-500 border border-gray-200 uppercase tracking-wide">
                                        Inactive
                                    </span>
                                @endif

                                @if ($category->parent)
                                    <span
                                        class="text-[10px] text-slate-400 font-medium bg-slate-50 px-1.5 py-0.5 rounded border border-slate-100">
                                        Sub of: {{ $category->parent->name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Action Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                            class="text-slate-400 hover:text-primary transition-colors p-1">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <div x-show="open" x-transition.origin.top.right
                            class="absolute right-0 mt-1 w-32 bg-white rounded-lg shadow-lg border border-slate-100 z-10 py-1"
                            style="display: none;">
                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-primary">
                                <i class="fa-solid fa-pen mr-2 text-xs"></i> Edit
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                onsubmit="return confirm('Delete category?');">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fa-solid fa-trash mr-2 text-xs"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Subcategories List --}}
                <div class="px-5 pb-5 flex-1">
                    @if ($category->subcategories->count() > 0)
                        <div class="mt-2 pt-3 border-t border-slate-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Subcategories
                            </p>
                            <div class="space-y-2">
                                @foreach ($category->subcategories as $sub)
                                    <div
                                        class="flex items-center justify-between group p-2 rounded-lg hover:bg-slate-50 border border-transparent hover:border-slate-100 transition-colors">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-1.5 h-1.5 rounded-full {{ $sub->is_active ? 'bg-green-400' : 'bg-gray-300' }}">
                                            </div>
                                            <span class="text-sm font-medium text-slate-600">{{ $sub->name }}</span>
                                        </div>

                                        <div
                                            class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.categories.edit', $sub->id) }}"
                                                class="p-1 text-slate-400 hover:text-blue-600" title="Edit">
                                                <i class="fa-solid fa-pen text-[10px]"></i>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $sub->id) }}"
                                                method="POST" onsubmit="return confirm('Delete subcategory?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-1 text-slate-400 hover:text-red-600"
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
                            class="mt-2 pt-8 pb-4 text-center border-t border-slate-100 h-full flex items-center justify-center">
                            <span class="text-xs text-slate-400 italic">No subcategories</span>
                        </div>
                    @endif
                </div>

                {{-- Footer Info --}}
                <div class="bg-slate-50 px-5 py-3 border-t border-slate-200 rounded-b-xl text-center">
                    <p class="text-[10px] text-slate-400">Created
                        {{ optional($category->created_at)->format('M d, Y') }}</p>
                </div>

            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-regular fa-folder-open text-3xl text-slate-300"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-700">No categories found</h3>
                    <p class="text-slate-500 text-sm mt-1">Get started by creating a new category.</p>
                    <a href="{{ route('admin.categories.create') }}"
                        class="inline-block mt-4 text-primary font-semibold text-sm hover:underline">
                        Create Category
                    </a>
                </div>
            </div>
        @endforelse
    </div>

</x-admin-layout>

