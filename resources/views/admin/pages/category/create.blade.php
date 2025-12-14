<x-admin.app>
    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Add New Category</h2>
            <p class="text-slate-500 text-sm">Create a new category or subcategory</p>
        </div>
        <a href="{{ route('admin.categories.index') }}"
            class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Back to Categories
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-3xl">
        <div class="p-6 md:p-8">
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                        placeholder="Enter category name" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Parent Category</label>
                    <div class="relative">
                        <select name="parent_id"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm appearance-none focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                            <option value="">— None (Top Level Category) —</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}"
                                    {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                        placeholder="Write a short description...">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Icon (Optional)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <i class="fa-solid fa-icons"></i>
                        </span>
                        <input type="text" name="icon" value="{{ old('icon') }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="e.g. fa-solid fa-hammer">
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Use a valid Font Awesome 6 class name.</p>
                </div>

                <div class="flex items-center gap-3 bg-slate-50 p-3 rounded-lg border border-slate-100">
                    <input type="checkbox" id="is_active" name="is_active" value="1" checked
                        class="w-4 h-4 text-primary bg-white border-gray-300 rounded focus:ring-primary">
                    <label for="is_active" class="text-sm font-medium text-slate-700 cursor-pointer select-none">
                        Active Status
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-5 py-2.5 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-100 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-primary hover:bg-teal-700 shadow-md shadow-teal-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-save mr-2"></i> Save Category
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- ALERTS (Handled via Alpine.js or Tailwind) --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-5 right-5 z-50 bg-teal-600 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3 transition-opacity duration-500">
            <i class="fa-solid fa-check-circle"></i>
            <span class="font-medium">{{ session('success') }}</span>
            <button @click="show = false" class="text-white/80 hover:text-white"><i
                    class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    @if ($errors->any())
        <div x-data="{ show: true }" x-show="show"
            class="fixed top-5 right-5 z-50 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span class="font-medium">{{ $errors->first() }}</span>
            <button @click="show = false" class="text-white/80 hover:text-white"><i
                    class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

</x-admin.app>
