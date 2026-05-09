<x-contractor-layout>
    <div class="p-6 space-y-8 animate-fade-in">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center gap-5 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <a href="{{ route('contractor.workers.index') }}" class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">{{ __('Add New Worker') }}</h1>
                <p class="text-gray-500 text-sm font-medium">{{ __('Register a new team member to your workforce') }}</p>
            </div>
        </div>

        <form action="{{ route('contractor.workers.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 xl:grid-cols-12 gap-8">
            @csrf
            
            <!-- Main Details -->
            <div class="xl:col-span-8 space-y-8">
                <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30 flex items-center justify-between">
                        <h3 class="font-black text-gray-900 flex items-center gap-3 text-sm uppercase tracking-widest">
                            <i class="fa-solid fa-id-card text-indigo-600"></i>
                            {{ __('Personal Information') }}
                        </h3>
                    </div>
                    <div class="p-8 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Full Name') }}</label>
                                <div class="relative group">
                                    <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-indigo-600 transition-colors"></i>
                                    <input type="text" name="name" required value="{{ old('name') }}"
                                        class="w-full pl-12 pr-4 py-4 bg-gray-50/50 border-gray-100 rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none"
                                        placeholder="{{ __('e.g. Ramesh Kumar') }}">
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Phone Number') }}</label>
                                <div class="relative group">
                                    <i class="fa-solid fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-indigo-600 transition-colors"></i>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="w-full pl-12 pr-4 py-4 bg-gray-50/50 border-gray-100 rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none"
                                        placeholder="+91 XXXXX XXXXX">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Skill Specialization') }}</label>
                                <div class="relative">
                                    <select name="specialization" class="select2-init w-full">
                                        <option value="">{{ __('General Labor') }}</option>
                                        @foreach($works as $work)
                                            <option value="{{ $work->name }}" {{ old('specialization') == $work->name ? 'selected' : '' }}>
                                                {{ $work->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Daily Wage') }} (₹)</label>
                                <div class="relative group">
                                    <i class="fa-solid fa-indian-rupee-sign absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-indigo-600 transition-colors"></i>
                                    <input type="number" name="daily_wage" value="{{ old('daily_wage') }}"
                                        class="w-full pl-12 pr-4 py-4 bg-gray-50/50 border-gray-100 rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none"
                                        placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Identity Type') }}</label>
                                <div class="relative">
                                    <select name="identity_type" class="w-full px-4 py-4 bg-gray-50/50 border-gray-100 rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none appearance-none">
                                        <option value="aadhar">{{ __('Aadhar Card') }}</option>
                                        <option value="pan">{{ __('PAN Card') }}</option>
                                        <option value="voter_id">{{ __('Voter ID') }}</option>
                                        <option value="driving_license">{{ __('Driving License') }}</option>
                                        <option value="other">{{ __('Other') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Identity Proof') }} ({{ __('Image/PDF') }})</label>
                                <div class="relative group">
                                    <input type="file" name="identity_proof"
                                        class="w-full px-4 py-3.5 bg-gray-50/50 border border-dashed border-gray-200 rounded-2xl text-sm font-bold text-gray-500 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Actions -->
            <div class="xl:col-span-4 space-y-8">
                <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm p-8 space-y-8 sticky top-8">
                    <div class="space-y-4">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Employment Status') }}</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer group">
                                <input type="radio" name="status" value="active" checked class="peer hidden">
                                <div class="py-4 text-center rounded-2xl border border-gray-100 bg-gray-50 text-gray-400 font-black text-[10px] uppercase tracking-widest peer-checked:bg-emerald-50 peer-checked:border-emerald-200 peer-checked:text-emerald-600 transition-all shadow-sm group-hover:bg-white">
                                    {{ __('Active') }}
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="status" value="inactive" class="peer hidden">
                                <div class="py-4 text-center rounded-2xl border border-gray-100 bg-gray-50 text-gray-400 font-black text-[10px] uppercase tracking-widest peer-checked:bg-red-50 peer-checked:border-red-200 peer-checked:text-red-600 transition-all shadow-sm group-hover:bg-white">
                                    {{ __('Inactive') }}
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-3 pt-4 border-t border-gray-50">
                        <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 transform active:scale-95 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            {{ __('Register Worker') }}
                        </button>
                        <a href="{{ route('contractor.workers.index') }}" class="block w-full py-4 bg-gray-50 text-gray-500 text-center rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-gray-100 transition-all border border-transparent">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2-init').select2({
                placeholder: "{{ __('Select Specialization') }}",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    <style>
        .select2-container--default .select2-selection--single {
            background-color: rgba(249, 250, 251, 0.5);
            border: 1px solid #f3f4f6;
            border-radius: 1rem;
            height: 56px;
            padding: 12px;
            font-size: 0.875rem;
            font-weight: 700;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 54px;
        }
    </style>
    @endpush
</x-contractor-layout>
>
