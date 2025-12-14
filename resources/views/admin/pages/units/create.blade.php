<x-admin.app>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Add Unit</h2>
            <p class="text-slate-500 text-sm">Create a new measurement unit</p>
        </div>

        <a href="{{ route('admin.units.index') }}"
            class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-2xl">
        <div class="border-b border-gray-100 px-6 py-4">
            <h3 class="font-bold text-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-ruler-combined text-primary"></i> New Unit
            </h3>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('admin.units.store') }}" method="POST">
                @csrf

                <div class="space-y-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Unit Name --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                                Unit Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                placeholder="e.g. Square Feet" required>
                        </div>

                        {{-- Symbol --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                                Symbol <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="symbol"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                placeholder="e.g. sqft" required>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Description (Optional)
                        </label>
                        <textarea name="description" rows="3"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="Short note about the unit..."></textarea>
                    </div>

                    {{-- Status --}}
                    <div class="flex items-center gap-3 bg-slate-50 p-3 rounded-lg border border-slate-100 w-max">
                        <input type="checkbox" id="isActive" name="is_active" value="1" checked
                            class="w-4 h-4 text-primary bg-white border-gray-300 rounded focus:ring-primary">
                        <label for="isActive" class="text-sm font-medium text-slate-700 cursor-pointer select-none">
                            Active Status
                        </label>
                    </div>

                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end pt-6 mt-6 border-t border-slate-100">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg text-sm font-bold text-white bg-primary hover:bg-teal-700 shadow-md shadow-teal-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-save mr-2"></i> Save Unit
                    </button>
                </div>

            </form>
        </div>
    </div>

</x-admin.app>
