<x-admin.app>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Work</h2>
            <p class="text-slate-500 text-sm">Update work details and pricing information</p>
        </div>

        <a href="{{ route('admin.works.index') }}"
            class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-4xl">
        <div class="border-b border-gray-100 px-6 py-4">
            <h3 class="font-bold text-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-primary"></i> Work Information
            </h3>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('admin.works.update', $work->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                    {{-- Work Name --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Work Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $work->name) }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="Enter work name" required>
                    </div>

                    {{-- Category --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="category_id" required
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm appearance-none focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $work->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Unit --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Measurement Unit
                        </label>
                        <div class="relative">
                            <select name="unit_id"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm appearance-none focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                                <option value="">Select Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}"
                                        {{ $work->unit_id == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->name }} {{ $unit->symbol ? "($unit->symbol)" : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Pricing Section --}}
                <div class="mb-6">
                    <h4 class="text-sm font-bold text-slate-700 border-b border-gray-100 pb-2 mb-4">Pricing Details (₹)
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Labor Min</label>
                            <input type="number" step="0.01" name="labor_min"
                                value="{{ old('labor_min', $work->labor_min) }}"
                                class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                placeholder="0.00">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Labor Max</label>
                            <input type="number" step="0.01" name="labor_max"
                                value="{{ old('labor_max', $work->labor_max) }}"
                                class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                placeholder="0.00">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Material Min</label>
                            <input type="number" step="0.01" name="labor_material_min"
                                value="{{ old('labor_material_min', $work->labor_material_min) }}"
                                class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                placeholder="0.00">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Material Max</label>
                            <input type="number" step="0.01" name="labor_material_max"
                                value="{{ old('labor_material_max', $work->labor_material_max) }}"
                                class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                placeholder="0.00">
                        </div>

                    </div>
                </div>

                {{-- Status Checkbox --}}
                <div class="flex items-center gap-3 bg-slate-50 p-3 rounded-lg border border-slate-100 mb-6 w-max">
                    <input type="checkbox" id="isActive" name="is_active" value="1"
                        {{ $work->is_active ? 'checked' : '' }}
                        class="w-4 h-4 text-primary bg-white border-gray-300 rounded focus:ring-primary">
                    <label for="isActive" class="text-sm font-medium text-slate-700 cursor-pointer select-none">
                        Active Status
                    </label>
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end pt-4 border-t border-slate-100">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg text-sm font-bold text-white bg-primary hover:bg-teal-700 shadow-md shadow-teal-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-check mr-2"></i> Update Work
                    </button>
                </div>

            </form>
        </div>
    </div>

</x-admin.app>
