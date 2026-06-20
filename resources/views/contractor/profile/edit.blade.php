<x-contractor-layout>
    <div class="p-3 md:p-6 space-y-4 md:space-y-8 animate-fade-in">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 md:gap-6 bg-white p-4 md:p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3 md:gap-6">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-inner">
                    <i class="fa-solid fa-user-gear text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight">{{ __('Account Settings') }}</h1>
                    <p class="text-gray-500 text-sm font-medium">{{ __('Manage your professional identity and security credentials.') }}</p>
                </div>
            </div>
            <a href="{{ route('contractor.dashboard.index') }}" class="px-3 md:px-6 py-3 bg-gray-50 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                {{ __('Back to Command Center') }}
            </a>
        </div>

        <form action="{{ route('contractor.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-8">
            @csrf

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 md:gap-8">
                <!-- Sidebar: Profile Preview -->
                <div class="xl:col-span-1 space-y-4 md:space-y-8">
                    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-indigo-100/20 border border-gray-100 overflow-hidden sticky top-8">
                        <div class="h-32 bg-gradient-to-br from-indigo-600 to-violet-700 relative">
                            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
                        </div>
                        
                        <div class="px-4 md:px-8 pb-10 text-center relative">
                            <div class="relative -mt-16 inline-block">
                                @php $imagePath = auth()->user()->contractor->image ?? null; @endphp
                                <div class="w-32 h-32 rounded-[2.5rem] p-1.5 bg-white shadow-2xl relative group">
                                    <img id="avatar-preview" src="{{ $imagePath ? $imagePath : asset('default-avatar.png') }}" 
                                        class="w-full h-full object-cover rounded-[2rem]">
                                    <label for="image-upload" class="absolute inset-1.5 bg-black/40 rounded-[2rem] opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center cursor-pointer backdrop-blur-sm">
                                        <i class="fa-solid fa-camera text-white text-xl"></i>
                                    </label>
                                    <input type="file" id="image-upload" name="image" class="hidden" accept="image/*" onchange="previewImage(this)">
                                </div>
                            </div>

                            <h3 class="mt-4 text-2xl font-black text-gray-900 tracking-tight">{{ auth()->user()->name }}</h3>
                            <p class="text-indigo-600 text-xs font-black uppercase tracking-widest mb-6">{{ __('Verified Contractor') }}</p>

                            <div class="space-y-3">
                                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-2xl text-left border border-transparent hover:border-indigo-100 transition-all">
                                    <i class="fa-solid fa-envelope text-indigo-400"></i>
                                    <span class="text-xs font-bold text-gray-600 truncate">{{ auth()->user()->email }}</span>
                                </div>
                                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-2xl text-left border border-transparent hover:border-indigo-100 transition-all">
                                    <i class="fa-solid fa-phone text-indigo-400"></i>
                                    <span class="text-xs font-bold text-gray-600">{{ auth()->user()->contractor->phone ?? __('No phone listed') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content: Form Fields -->
                <div class="xl:col-span-2 space-y-4 md:space-y-8">
                    <!-- General Information -->
                    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10">
                        <div class="flex items-center gap-4 mb-10 pb-6 border-b border-gray-50">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                                <i class="fa-solid fa-id-badge text-xl"></i>
                            </div>
                            <h2 class="text-xl font-black text-gray-900 tracking-tight">{{ __('General Information') }}</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Full Professional Name') }}</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}" required
                                    class="w-full px-3 md:px-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Primary Email Address') }}</label>
                                <input type="email" name="email" value="{{ auth()->user()->email }}" required
                                    class="w-full px-3 md:px-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Phone Contact') }}</label>
                                <input type="text" name="phone" value="{{ auth()->user()->contractor->phone ?? '' }}"
                                    class="w-full px-3 md:px-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Operating City') }}</label>
                                <input type="text" name="city" value="{{ auth()->user()->contractor->city ?? '' }}"
                                    class="w-full px-3 md:px-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- Expertise & Specializations -->
                    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10">
                        <div class="flex items-center gap-4 mb-10 pb-6 border-b border-gray-50">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <i class="fa-solid fa-screwdriver-wrench text-xl"></i>
                            </div>
                            <h2 class="text-xl font-black text-gray-900 tracking-tight">{{ __('Expertise & Specializations') }}</h2>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Core Service Categories') }}</label>
                            @php
                                $parentCategories = \App\Models\Category::with('subcategories')->whereNull('parent_id')->where('is_active', 1)->orderBy('name')->get();
                                $selectedCategories = auth()->user()->contractor ? auth()->user()->contractor->categories->pluck('id')->toArray() : [];
                            @endphp
                            <select name="categories[]" multiple class="category-select-modern w-full">
                                @foreach ($parentCategories as $parent)
                                    @if ($parent->subcategories->count())
                                        <optgroup label="{{ $parent->name }}">
                                            @foreach ($parent->subcategories as $child)
                                                <option value="{{ $child->id }}" {{ in_array($child->id, old('categories', $selectedCategories)) ? 'selected' : '' }}>
                                                    {{ $child->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @else
                                        <option value="{{ $parent->id }}" {{ in_array($parent->id, old('categories', $selectedCategories)) ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <p class="text-[10px] font-bold text-gray-400 mt-2 flex items-center gap-1 uppercase tracking-tighter">
                                <i class="fa-solid fa-circle-info text-emerald-500"></i> {{ __('Selecting accurate categories helps in better project matching') }}
                            </p>
                        </div>
                    </div>

                    <!-- Security Credentials -->
                    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10">
                        <div class="flex items-center gap-4 mb-10 pb-6 border-b border-gray-50">
                            <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600">
                                <i class="fa-solid fa-shield-halved text-xl"></i>
                            </div>
                            <h2 class="text-xl font-black text-gray-900 tracking-tight">{{ __('Security Credentials') }}</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('New Access Key (Password)') }}</label>
                                <input type="password" name="password" placeholder="••••••••"
                                    class="w-full px-3 md:px-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Verify Access Key') }}</label>
                                <input type="password" name="password_confirmation" placeholder="••••••••"
                                    class="w-full px-3 md:px-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">
                            </div>
                        </div>
                        <p class="text-[10px] font-bold text-gray-400 mt-6 uppercase tracking-tighter">{{ __('Leave blank if you do not wish to change your password') }}</p>
                    </div>

                    <!-- Final Actions -->
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-4">
                        <button type="submit" class="w-full sm:w-auto px-12 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            {{ __('Synchronize Profile') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('.category-select-modern').select2({
                placeholder: "{{ __('Select specializations...') }}",
                width: '100%',
                closeOnSelect: false
            });

            @if (session('success'))
                Swal.fire({
                    title: "{{ __('Updated Successfully') }}",
                    text: "{{ session('success') }}",
                    icon: 'success',
                    background: '#ffffff',
                    borderRadius: '2rem',
                    confirmButtonColor: '#4f46e5',
                    customClass: {
                        popup: 'rounded-[2rem]',
                        confirmButton: 'rounded-xl px-4 md:px-8 py-3 font-black uppercase text-xs tracking-widest'
                    }
                });
            @endif
        });

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatar-preview').attr('src', e.target.result).addClass('animate-pulse');
                    setTimeout(() => $('#avatar-preview').removeClass('animate-pulse'), 1000);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <style>
        .select2-container--default .select2-selection--multiple {
            background-color: rgba(249, 250, 251, 0.5);
            border: 1px solid transparent;
            border-radius: 1.25rem;
            min-height: 56px;
            padding: 8px;
            transition: all 0.2s;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            background-color: white;
            border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #eff6ff;
            border: 1px solid #dbeafe;
            color: #1e40af;
            border-radius: 0.75rem;
            padding: 4px 12px;
            font-size: 0.75rem;
            font-weight: 800;
            margin-top: 4px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
    @endpush
</x-contractor-layout>
