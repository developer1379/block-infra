<x-admin-layout>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Category</h2>
            <p class="text-slate-500 text-sm mt-0.5">Modify properties and operational status of category</p>
        </div>
        <a href="{{ route('admin.categories.index') }}"
            class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold px-4 py-2.5 rounded-xl border border-slate-200/60 transition-all">
            <i class="fa-solid fa-arrow-left text-xs"></i> Back to Categories
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-3xl overflow-hidden">
        <div class="p-6 md:p-8">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Category Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all @error('name') border-rose-500 @enderror"
                            placeholder="Enter category name" required>
                        @error('name')
                            <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Parent Category</label>
                        <div class="relative">
                            <select name="parent_id"
                                class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm appearance-none focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all cursor-pointer">
                                <option value="">— None (Top Level) —</option>
                                @foreach ($parents as $parent)
                                    @if ($parent->id != $category->id) {{-- Prevent assigning to self --}}
                                        <option value="{{ $parent->id }}"
                                            {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Icon (Optional)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <i class="fa-solid fa-icons text-sm"></i>
                            </span>
                            <input type="text" name="icon" value="{{ old('icon', $category->icon) }}"
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all placeholder:text-slate-400"
                                placeholder="e.g. fa-solid fa-hammer">
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1.5">Enter a valid Font Awesome 6 class string.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all placeholder:text-slate-400"
                        placeholder="Write a short description details for this category...">{{ old('description', $category->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2.5">Status</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer bg-slate-50 border border-slate-200/60 p-3 rounded-xl hover:bg-slate-100/50 transition-colors w-32 justify-center select-none">
                            <input type="radio" id="active" name="is_active" value="1"
                                class="w-4 h-4 text-teal-600 bg-white border-slate-300 focus:ring-teal-500 cursor-pointer"
                                {{ $category->is_active ? 'checked' : '' }}>
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Active</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer bg-slate-50 border border-slate-200/60 p-3 rounded-xl hover:bg-slate-100/50 transition-colors w-32 justify-center select-none">
                            <input type="radio" id="inactive" name="is_active" value="0"
                                class="w-4 h-4 text-teal-600 bg-white border-slate-300 focus:ring-teal-500 cursor-pointer"
                                {{ !$category->is_active ? 'checked' : '' }}>
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Inactive</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 shadow-md shadow-teal-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-floppy-disk mr-1.5 text-xs"></i> Update Category
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- ALERTS --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            class="fixed top-5 right-5 z-[60] bg-emerald-600 text-white px-5 py-4 rounded-xl shadow-xl flex items-center gap-3 transition-all duration-500">
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

</x-admin-layout>
