<x-admin-layout>
    <div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
        <!-- Premium Header -->
        <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center gap-5">
                <a href="{{ route('admin.workers.index') }}" class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-teal-600 hover:bg-teal-50 hover:border-teal-100 border border-transparent transition-all duration-300">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight">Onboard New Worker</h1>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-0.5">Workforce / Registration</p>
                </div>
            </div>
            <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-teal-50 text-teal-700 rounded-xl border border-teal-100">
                <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                <span class="text-[10px] font-black uppercase tracking-wider">Live System</span>
            </div>
        </div>

        <form action="{{ route('admin.workers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Section: Basic Info -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30">
                            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                <i class="fa-solid fa-id-card text-teal-600"></i>
                                Personal Credentials
                            </h3>
                        </div>
                        <div class="p-8 space-y-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Legal Name</label>
                                <div class="relative group">
                                    <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-teal-600 transition-colors"></i>
                                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="e.g. Rajesh Kumar"
                                        class="w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-all outline-none">
                                </div>
                                @error('name') <p class="text-[10px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Phone Number</label>
                                    <div class="relative group">
                                        <i class="fa-solid fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-teal-600 transition-colors"></i>
                                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+91 98765 43210"
                                            class="w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-all outline-none">
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Identity Proof ID</label>
                                    <div class="relative group">
                                        <i class="fa-solid fa-fingerprint absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-teal-600 transition-colors"></i>
                                        <input type="text" name="identity_proof" value="{{ old('identity_proof') }}" placeholder="Aadhar / Voter ID"
                                            class="w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-all outline-none">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Work Details -->
                    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30">
                            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                <i class="fa-solid fa-briefcase text-teal-600"></i>
                                Professional Assignment
                            </h3>
                        </div>
                        <div class="p-8 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Skill Specialization</label>
                                    <div class="relative">
                                        <select name="specialization" class="select2-init w-full px-4 py-3.5 bg-slate-50/50 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-all outline-none cursor-pointer">
                                            <option value="">General Labor</option>
                                            @foreach($works as $work)
                                                <option value="{{ $work->name }}" {{ old('specialization') == $work->name ? 'selected' : '' }}>
                                                    {{ $work->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Identity Type</label>
                                    <div class="relative">
                                        <select name="identity_type" class="w-full px-4 py-3.5 bg-slate-50/50 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-all outline-none">
                                            <option value="aadhar">Aadhar Card</option>
                                            <option value="pan">PAN Card</option>
                                            <option value="voter_id">Voter ID</option>
                                            <option value="driving_license">Driving License</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Identity Proof (Image/PDF)</label>
                                    <div class="relative group">
                                        <i class="fa-solid fa-file-arrow-up absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-teal-600 transition-colors"></i>
                                        <input type="file" name="identity_proof"
                                            class="w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-all outline-none file:hidden">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Section: Status & Save -->
                <div class="space-y-8">
                    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-8 space-y-8">
                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Assigned Contractor</label>
                            <div class="relative">
                                <select name="contractor_id" class="select2-init w-full px-5 py-3.5 bg-slate-50/50 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-all outline-none cursor-pointer">
                                    <option value="">Direct Hire</option>
                                    @foreach($contractors as $contractor)
                                        <option value="{{ $contractor->id }}">{{ $contractor->user->name ?? 'Contractor' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Profile Status</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="relative flex flex-col items-center justify-center p-4 bg-slate-50 rounded-2xl border-2 border-transparent cursor-pointer hover:bg-teal-50/30 transition-all group/status">
                                    <input type="radio" name="status" value="active" checked class="absolute top-3 right-3 text-teal-600 focus:ring-teal-500">
                                    <i class="fa-solid fa-circle-check text-slate-300 group-hover:text-teal-500 mb-2 transition-colors"></i>
                                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 group-hover:text-teal-700">Active</span>
                                </label>
                                <label class="relative flex flex-col items-center justify-center p-4 bg-slate-50 rounded-2xl border-2 border-transparent cursor-pointer hover:bg-red-50/30 transition-all group/status">
                                    <input type="radio" name="status" value="inactive" class="absolute top-3 right-3 text-red-600 focus:ring-red-500">
                                    <i class="fa-solid fa-circle-xmark text-slate-300 group-hover:text-red-500 mb-2 transition-colors"></i>
                                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 group-hover:text-red-700">Inactive</span>
                                </label>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full py-4 bg-teal-600 text-white rounded-[1.5rem] font-black uppercase text-xs tracking-widest shadow-xl shadow-teal-100 hover:bg-teal-700 hover:-translate-y-1 active:scale-95 transition-all">
                                Complete Onboarding
                            </button>
                            <p class="text-[9px] text-slate-400 text-center mt-4 italic font-medium">Verify all credentials before saving the worker profile.</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</x-admin-layout>
