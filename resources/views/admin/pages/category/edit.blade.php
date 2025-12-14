<x-admin.app>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Category</h2>
            <p class="text-slate-500 text-sm">Update details or change parent category</p>
        </div>
        <a href="{{ route('admin.categories.index') }}"
            class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-3xl">
        <div class="p-6 md:p-8">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Category Name
                    </label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors @error('name') border-red-500 @enderror"
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
                            <option value="">None (Top Level)</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}"
                                    {{ $parent->id == $category->parent_id ? 'selected' : '' }}>
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
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                    <div class="flex gap-4">
                        <div class="flex items-center">
                            <input type="radio" id="active" name="is_active" value="1"
                                class="w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-primary focus:ring-2"
                                {{ $category->is_active ? 'checked' : '' }}>
                            <label for="active"
                                class="ml-2 text-sm font-medium text-slate-700 cursor-pointer">Active</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="inactive" name="is_active" value="0"
                                class="w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-primary focus:ring-2"
                                {{ !$category->is_active ? 'checked' : '' }}>
                            <label for="inactive"
                                class="ml-2 text-sm font-medium text-slate-700 cursor-pointer">Inactive</label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-5 py-2.5 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-100 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-primary hover:bg-teal-700 shadow-md shadow-teal-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-save mr-2"></i> Update
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- ALERTS (Success/Error) --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            class="fixed top-5 right-5 z-[60] bg-lime-500 text-white px-6 py-4 rounded-xl shadow-lg flex items-center gap-3 transition-all duration-500">
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

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            class="fixed top-5 right-5 z-[60] bg-red-500 text-white px-6 py-4 rounded-xl shadow-lg flex items-center gap-3">
            <div class="bg-white/20 w-8 h-8 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm">Error!</h4>
                <p class="text-xs text-white/90">{{ session('error') }}</p>
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
                <h4 class="font-bold text-sm">Validation Error</h4>
                <p class="text-xs text-white/90">{{ $errors->first() }}</p>
            </div>
            <button @click="show = false" class="ml-4 text-white/60 hover:text-white"><i
                    class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

</x-admin.app>
