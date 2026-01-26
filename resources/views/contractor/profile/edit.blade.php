<x-app-layout>

    {{-- 1. LOAD PLUGIN STYLES --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    {{-- 2. CUSTOM STYLES --}}
    <style>
        /* Modern Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Select2 Modern Override */
        .select2-container .select2-selection--multiple {
            min-height: 48px;
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            /* rounded-xl */
            padding: 8px 12px;
            background-color: #ffffff;
            transition: all 0.2s;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #0d9488 !important;
            /* teal-600 */
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #effcfc !important;
            border: 1px solid #ccfbf1 !important;
            color: #0f766e !important;
            /* teal-700 */
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 0.875rem;
            margin-right: 6px;
            margin-top: 4px;
            font-weight: 600;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #0f766e !important;
            border-right: none !important;
            margin-right: 8px;
            font-weight: bold;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #ef4444 !important;
            /* red-500 */
        }
    </style>

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- PAGE HEADER --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Account Settings</h2>
                    <p class="text-slate-500 mt-1">Manage your public profile and security preferences.</p>
                </div>

                <a href="{{ route('contractor.dashboard.index') }}"
                    class="group inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-600 hover:text-teal-700 hover:border-teal-200 text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
                    <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                    <span>Back to Dashboard</span>
                </a>
            </div>

            <form action="{{ route('contractor.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- LEFT COLUMN: Profile Card --}}
                    <div class="lg:col-span-1">
                        <div
                            class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 overflow-hidden sticky top-8 border border-slate-100">
                            {{-- Decorative Banner --}}
                            <div class="h-32 bg-gradient-to-r from-teal-500 to-cyan-600 relative">
                                <div class="absolute top-4 right-4 text-white/20">
                                    <i class="fa-solid fa-shapes text-6xl"></i>
                                </div>
                            </div>

                            {{-- Avatar Section --}}
                            <div class="px-6 pb-6 text-center relative">
                                <div class="relative -mt-16 inline-block">
                                    @php $imagePath = auth()->user()->contractor->image ?? null; @endphp
                                    <img src="{{ $imagePath ? $imagePath : asset('default-avatar.png') }}"
                                        alt="Profile"
                                        class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md bg-white">

                                    {{-- Camera Icon Overlay for Upload --}}
                                    <label for="profile_image"
                                        class="absolute bottom-1 right-1 bg-slate-800 text-white p-2 rounded-full cursor-pointer hover:bg-teal-600 transition-colors shadow-lg border-2 border-white">
                                        <i class="fa-solid fa-camera text-xs"></i>
                                    </label>
                                    <input type="file" id="profile_image" name="image" accept="image/*"
                                        class="hidden" onchange="previewImage(this)">
                                </div>

                                <h3 class="mt-3 text-xl font-bold text-slate-800">{{ auth()->user()->name }}</h3>
                                <p class="text-slate-500 text-sm font-medium">{{ auth()->user()->email }}</p>

                                <div class="mt-4 flex flex-wrap justify-center gap-2">
                                    <span
                                        class="px-3 py-1 bg-teal-50 text-teal-700 text-xs font-bold rounded-full border border-teal-100">
                                        Contractor
                                    </span>
                                    @if (auth()->user()->contractor->city)
                                        <span
                                            class="px-3 py-1 bg-slate-50 text-slate-600 text-xs font-bold rounded-full border border-slate-200">
                                            <i class="fa-solid fa-location-dot mr-1"></i>
                                            {{ auth()->user()->contractor->city }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: Form Details --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- CARD 1: Personal Information --}}
                        <div
                            class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 p-6 sm:p-8">
                            <h4
                                class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2">
                                <span
                                    class="bg-teal-100 text-teal-700 w-8 h-8 flex items-center justify-center rounded-lg">
                                    <i class="fa-regular fa-id-card"></i>
                                </span>
                                Personal Information
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Full Name --}}
                                <div class="col-span-1 md:col-span-2">
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Full
                                        Name <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i class="fa-regular fa-user"></i>
                                        </span>
                                        <input type="text" name="name" value="{{ auth()->user()->name }}" required
                                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all">
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email
                                        Address</label>
                                    <div class="relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i class="fa-regular fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email" value="{{ auth()->user()->email }}"
                                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all">
                                    </div>
                                </div>

                                {{-- Phone --}}
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Phone
                                        Number</label>
                                    <div class="relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i class="fa-solid fa-phone-flip"></i>
                                        </span>
                                        <input type="text" name="phone"
                                            value="{{ auth()->user()->contractor->phone ?? '' }}"
                                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all">
                                    </div>
                                </div>

                                {{-- City --}}
                                <div class="col-span-1 md:col-span-2">
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Location
                                        (City)</label>
                                    <div class="relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i class="fa-solid fa-map-pin"></i>
                                        </span>
                                        <input type="text" name="city"
                                            value="{{ auth()->user()->contractor->city ?? '' }}"
                                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- CARD 2: Professional Skills --}}
                        <div
                            class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 p-6 sm:p-8">
                            <h4
                                class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2">
                                <span
                                    class="bg-indigo-100 text-indigo-700 w-8 h-8 flex items-center justify-center rounded-lg">
                                    <i class="fa-solid fa-briefcase"></i>
                                </span>
                                Skills & Categories
                            </h4>

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

                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Specializations</label>
                                <select name="categories[]" multiple class="category-select w-full">
                                    @foreach ($parentCategories as $parent)
                                        @if ($parent->subcategories->count())
                                            <optgroup label="{{ $parent->name }}">
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
                                <p class="text-xs text-slate-400 mt-2 flex items-center gap-1">
                                    <i class="fa-solid fa-circle-info"></i> Type to search for categories.
                                </p>
                            </div>
                        </div>

                        {{-- CARD 3: Security --}}
                        <div
                            class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 p-6 sm:p-8">
                            <h4
                                class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2">
                                <span
                                    class="bg-red-100 text-red-700 w-8 h-8 flex items-center justify-center rounded-lg">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </span>
                                Security
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">New
                                        Password</label>
                                    <div class="relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i class="fa-solid fa-lock"></i>
                                        </span>
                                        <input type="password" name="password" placeholder="••••••••"
                                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all">
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Confirm
                                        Password</label>
                                    <div class="relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i class="fa-solid fa-check-double"></i>
                                        </span>
                                        <input type="password" name="password_confirmation" placeholder="••••••••"
                                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Area --}}
                        <div class="flex justify-end pt-4">
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-teal-600/30 transform transition-all hover:-translate-y-1 hover:shadow-xl">
                                <span>Save Changes</span>
                                <i class="fa-solid fa-floppy-disk"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 with cleaner options
            $('.category-select').select2({
                placeholder: "Select your skills...",
                allowClear: true,
                width: '100%',
                closeOnSelect: false
            });

            // SweetAlert Logic
            @if (session('success'))
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success') }}"
                })
            @endif
        });

        // Simple Image Preview Script
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // Update the image src in the DOM
                    $(input).parent().find('img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
