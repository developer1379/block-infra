<x-admin.app>

    {{-- 1. LOAD PLUGIN STYLES --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- 2. CUSTOM STYLES --}}
    <style>
        /* Select2 Override to match Tailwind */
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
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">My Profile </h2>
            <p class="text-slate-500 text-sm">Manage your account settings and preferences</p>
        </div>

        <a href="{{ route('dashboard') }}"
            class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:text-slate-900 hover:border-slate-300 text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    {{-- PROFILE CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-4xl mx-auto overflow-hidden">

        <div class="p-6 md:p-8">

            {{-- PROFILE IMAGE SECTION --}}
            <div class="flex flex-col items-center justify-center mb-8">
                @php
                    $imagePath = auth()->user()->contractor->image ?? null;
                @endphp
                <div class="relative group">
                    <img src="{{ $imagePath ? $imagePath : asset('default-avatar.png') }}" alt="Profile"
                        class="w-28 h-28 rounded-full object-cover border-4 border-primary/20 shadow-md">
                    <div
                        class="absolute inset-0 rounded-full bg-black/0 group-hover:bg-black/10 transition-colors pointer-events-none">
                    </div>
                </div>

                <h3 class="mt-4 text-xl font-bold text-slate-800">{{ auth()->user()->name }}</h3>
                <p class="text-slate-500 text-sm">{{ auth()->user()->email }}</p>
            </div>

            <hr class="border-slate-100 mb-8">

            {{-- PROFILE FORM --}}
            <form action="{{ route('contractor.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                    {{-- Full Name --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            required>
                    </div>

                    {{-- Email --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Email
                        </label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                    </div>

                    {{-- Phone --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Phone
                        </label>
                        <input type="text" name="phone" value="{{ auth()->user()->contractor->phone }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                    </div>

                    {{-- City --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            City
                        </label>
                        <input type="text" name="city" value="{{ auth()->user()->contractor->city }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                    </div>

                    {{-- Categories (Select2) --}}
                    @php
                        $parentCategories = \App\Models\Category::with('subcategories')
                            ->whereNull('parent_id')
                            ->where('is_active', 1)
                            ->orderBy('name')
                            ->get();

                        $selectedCategories = auth()->user()->contractor
                            ? auth()->user()->contractor->categories->pluck('id')->toArray()
                            : [];
                    @endphp

                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Select Categories (Multiple)
                        </label>
                        <div class="relative">
                            <select name="categories[]" multiple class="category-select w-full" style="display: none;">
                                @foreach ($parentCategories as $parent)
                                    @if ($parent->subcategories->count())
                                        <optgroup label="{{ $parent->name }}" class="font-bold text-slate-800">
                                            @foreach ($parent->subcategories as $child)
                                                <option value="{{ $child->id }}"
                                                    {{ in_array($child->id, old('categories', $selectedCategories)) ? 'selected' : '' }}>
                                                    {{ $child->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @else
                                        <option value="{{ $parent->id }}"
                                            {{ in_array($parent->id, old('categories', $selectedCategories)) ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Select the categories you specialize in.</p>
                    </div>

                    {{-- Profile Photo --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Profile Photo
                        </label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-teal-700">
                    </div>

                    {{-- Password Change Section --}}
                    <div class="col-span-1 md:col-span-2 mt-2 pt-6 border-t border-slate-100">
                        <h4 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-lock text-primary"></i> Change Password
                        </h4>
                    </div>

                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            New Password
                        </label>
                        <input type="password" name="password"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="Leave empty if not changing">
                    </div>

                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            Confirm Password
                        </label>
                        <input type="password" name="password_confirmation"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="Confirm new password">
                    </div>

                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end pt-6 border-t border-slate-100">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg text-sm font-bold text-white bg-primary hover:bg-teal-700 shadow-md shadow-teal-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-save mr-2"></i> Save Changes
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function() {
                // Initialize Select2
                $('.category-select').select2({
                    placeholder: "Select categories...",
                    allowClear: true,
                    width: '100%',
                    closeOnSelect: false
                });

                // Show Success Alert if session exists
                @if (session('success'))
                    Swal.fire({
                        title: "Profile Updated!",
                        text: "{{ session('success') }}",
                        icon: "success",
                        confirmButtonColor: "#0f766e", // primary color
                        customClass: {
                            popup: 'rounded-xl',
                            confirmButton: 'px-4 py-2 rounded-lg font-bold'
                        }
                    });
                @endif
            });
        </script>
    @endpush

</x-admin.app>
