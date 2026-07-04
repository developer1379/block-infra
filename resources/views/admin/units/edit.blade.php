<x-admin-layout>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Unit</h2>
            <p class="text-slate-500 text-sm mt-0.5">Modify properties and operational status of unit</p>
        </div>

        <a href="{{ route('admin.units.index') }}"
            class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold px-4 py-2.5 rounded-xl border border-slate-200/60 transition-all">
            <i class="fa-solid fa-arrow-left text-xs"></i> Back to List
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-2xl overflow-hidden">
        <div class="border-b border-slate-100 px-6 py-4.5 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 flex items-center gap-2 text-sm">
                <i class="fa-solid fa-pen-to-square text-teal-600"></i> Modify Unit Properties
            </h3>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('admin.units.update', $unit->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Unit Name --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Unit Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $unit->name) }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all placeholder:text-slate-400"
                            placeholder="e.g. Square Feet" required>
                    </div>

                    {{-- Symbol --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Symbol <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="symbol" value="{{ old('symbol', $unit->symbol) }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all placeholder:text-slate-400"
                            placeholder="e.g. sqft" required>
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Description (Optional)
                    </label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all placeholder:text-slate-400"
                        placeholder="Write a short description details about the unit...">{{ old('description', $unit->description) }}</textarea>
                </div>

                {{-- Status Toggle / Radio --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2.5">Status</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer bg-slate-50 border border-slate-200/60 p-3 rounded-xl hover:bg-slate-100/50 transition-colors w-32 justify-center select-none">
                            <input type="radio" id="active" name="is_active" value="1"
                                class="w-4 h-4 text-teal-600 bg-white border-slate-300 focus:ring-teal-500 cursor-pointer"
                                {{ $unit->is_active ? 'checked' : '' }}>
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Active</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer bg-slate-50 border border-slate-200/60 p-3 rounded-xl hover:bg-slate-100/50 transition-colors w-32 justify-center select-none">
                            <input type="radio" id="inactive" name="is_active" value="0"
                                class="w-4 h-4 text-teal-600 bg-white border-slate-300 focus:ring-teal-500 cursor-pointer"
                                {{ !$unit->is_active ? 'checked' : '' }}>
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Inactive</span>
                        </label>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('admin.units.index') }}"
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 shadow-md shadow-teal-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-floppy-disk mr-1.5 text-xs"></i> Update Unit
                    </button>
                </div>

            </form>
        </div>
    </div>

</x-admin-layout>
