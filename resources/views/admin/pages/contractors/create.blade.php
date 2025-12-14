<x-admin.app>

    {{-- 1. LOAD PLUGIN STYLES --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- 2. CUSTOM STYLES --}}
    <style>
        /* Select2 Override */
        .select2-container .select2-selection--multiple {
            min-height: 45px;
            border-color: #e2e8f0 !important;
            border-radius: 0.5rem !important;
            padding: 6px 8px;
            background-color: #f8fafc;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #0f766e !important;
            box-shadow: 0 0 0 1px #0f766e;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0f766e !important;
            border: none !important;
            color: white !important;
            border-radius: 4px;
            padding: 2px 8px;
            margin-top: 4px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white !important;
            border-right: 1px solid rgba(255, 255, 255, 0.3) !important;
            margin-right: 6px;
        }
    </style>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Add Contractor</h2>
            <p class="text-slate-500 text-sm">Create contractor profile & assign category</p>
        </div>

        <a href="{{ route('admin.contractors.index') }}"
            class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-4xl">
        <div class="border-b border-gray-100 px-6 py-4">
            <h3 class="font-bold text-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-helmet-safety text-primary"></i> Contractor Details
            </h3>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('admin.contractors.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                    {{-- Full Name --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="Enter contractor name" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Company Name --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Company Name
                        </label>
                        <input type="text" name="company_name" value="{{ old('company_name') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="Enter company name">
                        @error('company_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="Enter email address" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Phone Number
                        </label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="Enter phone number">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- City --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            City
                        </label>
                        <input type="text" name="city" value="{{ old('city') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="Enter city">
                        @error('city')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Multiple Categories (Select2) --}}
                    @php
                        $parentCategories = \App\Models\Category::query()
                            ->with(['subcategories' => fn($q) => $q->where('is_active', 1)])
                            ->whereNull('parent_id')
                            ->where('is_active', 1)
                            ->orderBy('name')
                            ->get();
                    @endphp

                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Select Categories (Multiple)
                        </label>
                        <div class="relative">
                            <select name="categories[]" multiple class="category-select w-full" style="display: none;">
                                @foreach ($parentCategories as $parent)
                                    @php $children = $parent->subcategories; @endphp
                                    @if ($children->count())
                                        <optgroup label="{{ $parent->name }}">
                                            @foreach ($children as $child)
                                                <option value="{{ $child->id }}"
                                                    {{ collect(old('categories'))->contains($child->id) ? 'selected' : '' }}>
                                                    {{ $child->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @else
                                        <option value="{{ $parent->id }}"
                                            {{ collect(old('categories'))->contains($parent->id) ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Select the categories this contractor specializes in.</p>
                    </div>

                    {{-- Status --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">
                            Status
                        </label>
                        <div class="flex items-center gap-6">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="is_active" value="1"
                                    {{ old('is_active', 1) == 1 ? 'checked' : '' }}
                                    class="w-4 h-4 text-primary border-gray-300 focus:ring-primary">
                                <span class="ml-2 text-sm text-slate-700 font-medium">Active</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="is_active" value="0"
                                    {{ old('is_active') == 0 ? 'checked' : '' }}
                                    class="w-4 h-4 text-gray-400 border-gray-300 focus:ring-gray-400">
                                <span class="ml-2 text-sm text-slate-700 font-medium">Inactive</span>
                            </label>
                        </div>
                    </div>

                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end pt-6 border-t border-slate-100">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg text-sm font-bold text-white bg-primary hover:bg-teal-700 shadow-md shadow-teal-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-save mr-2"></i> Save Contractor
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- 3. INITIALIZATION SCRIPTS --}}
    @push('scripts')
        {{-- Load Libraries --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                // Initialize Select2
                $('.category-select').select2({
                    placeholder: "Select categories...",
                    allowClear: true,
                    width: '100%',
                    closeOnSelect: false
                });
            });
        </script>
    @endpush

</x-admin.app>
