<x-admin-layout>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Work</h2>
            <p class="text-slate-500 text-sm mt-0.5">Modify baseline details and pricing parameters for work item</p>
        </div>

        <a href="{{ route('admin.works.index') }}"
            class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold px-4 py-2.5 rounded-xl border border-slate-200/60 transition-all">
            <i class="fa-solid fa-arrow-left text-xs"></i> Back to List
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-4xl overflow-hidden">
        <div class="border-b border-slate-100 px-6 py-4.5 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 flex items-center gap-2 text-sm">
                <i class="fa-solid fa-pen-to-square text-teal-600"></i> Modify Work Specifications
            </h3>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('admin.works.update', $work->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Work Name --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Work Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $work->name) }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all placeholder:text-slate-400"
                            placeholder="Enter work name" required>
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Category <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="category_id" required
                                class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm appearance-none focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all cursor-pointer">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $work->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Unit --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Measurement Unit
                        </label>
                        <div class="relative">
                            <select name="unit_id"
                                class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm appearance-none focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all cursor-pointer">
                                <option value="">Select Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}"
                                        {{ $work->unit_id == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->name }} {{ $unit->symbol ? "($unit->symbol)" : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Unit Label --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Unit Label (Optional)
                        </label>
                        <input type="text" name="unit_label" value="{{ old('unit_label', $work->unit_label) }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all placeholder:text-slate-400"
                            placeholder="e.g. per sqft, per cum">
                    </div>

                </div>

                {{-- Pricing Section --}}
                <div class="pt-4">
                    <h4 class="text-xs font-bold text-slate-700 border-b border-slate-100 pb-2 mb-4 uppercase tracking-wider">Pricing Estimates (₹)</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">

                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1.5">Labor Min</label>
                            <input type="number" step="0.01" name="labor_min"
                                value="{{ old('labor_min', $work->labor_min) }}"
                                class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all placeholder:text-slate-400"
                                placeholder="0.00">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1.5">Labor Max</label>
                            <input type="number" step="0.01" name="labor_max"
                                value="{{ old('labor_max', $work->labor_max) }}"
                                class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all placeholder:text-slate-400"
                                placeholder="0.00">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1.5">Labor + Mat Min</label>
                            <input type="number" step="0.01" name="labor_material_min"
                                value="{{ old('labor_material_min', $work->labor_material_min) }}"
                                class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all placeholder:text-slate-400"
                                placeholder="0.00">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1.5">Labor + Mat Max</label>
                            <input type="number" step="0.01" name="labor_material_max"
                                value="{{ old('labor_material_max', $work->labor_material_max) }}"
                                class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all placeholder:text-slate-400"
                                placeholder="0.00">
                        </div>

                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Description (Optional)
                    </label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all placeholder:text-slate-400"
                        placeholder="Write a brief description or reference details for this work type...">{{ old('description', $work->description) }}</textarea>
                </div>

                {{-- Status Toggle / Radio --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2.5">Status</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer bg-slate-50 border border-slate-200/60 p-3 rounded-xl hover:bg-slate-100/50 transition-colors w-32 justify-center select-none">
                            <input type="radio" id="active" name="is_active" value="1"
                                class="w-4 h-4 text-teal-600 bg-white border-slate-300 focus:ring-teal-500 cursor-pointer"
                                {{ $work->is_active ? 'checked' : '' }}>
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Active</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer bg-slate-50 border border-slate-200/60 p-3 rounded-xl hover:bg-slate-100/50 transition-colors w-32 justify-center select-none">
                            <input type="radio" id="inactive" name="is_active" value="0"
                                class="w-4 h-4 text-teal-600 bg-white border-slate-300 focus:ring-teal-500 cursor-pointer"
                                {{ !$work->is_active ? 'checked' : '' }}>
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Inactive</span>
                        </label>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('admin.works.index') }}"
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 shadow-md shadow-teal-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-floppy-disk mr-1.5 text-xs"></i> Update Work
                    </button>
                </div>

            </form>
        </div>
    </div>

</x-admin-layout>
