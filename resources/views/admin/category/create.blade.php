<x-admin-layout>
    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Add New Category</h2>
            <p class="text-slate-500 text-sm mt-0.5">Establish a new parent category or subcategory</p>
        </div>
        <a href="{{ route('admin.categories.index') }}"
            class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold px-4 py-2.5 rounded-xl border border-slate-200/60 transition-all">
            <i class="fa-solid fa-arrow-left text-xs"></i> Back to Categories
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-3xl overflow-hidden">
        <div class="p-6 md:p-8">
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Category Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all placeholder:text-slate-400"
                            placeholder="e.g. Electrical Works" required>
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
                                    <option value="{{ $parent->id }}"
                                        {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
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
                            <input type="text" name="icon" value="{{ old('icon') }}"
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
                        placeholder="Write a short description details for this category...">{{ old('description') }}</textarea>
                </div>

                <div class="flex items-center gap-3 bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <input type="checkbox" id="is_active" name="is_active" value="1" checked
                        class="w-4 h-4 text-teal-600 bg-white border-slate-300 rounded focus:ring-teal-500 focus:ring-2 cursor-pointer">
                    <label for="is_active" class="text-xs font-bold text-slate-700 uppercase tracking-wider cursor-pointer select-none">
                        Active & Available for operations
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 shadow-md shadow-teal-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-floppy-disk mr-1.5 text-xs"></i> Save Category
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- ALERTS (Handled via Alpine.js or Tailwind) --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-5 right-5 z-50 bg-teal-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 transition-opacity duration-500">
            <i class="fa-solid fa-check-circle"></i>
            <span class="font-medium text-xs">{{ session('success') }}</span>
            <button @click="show = false" class="text-white/80 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

</x-admin-layout>
