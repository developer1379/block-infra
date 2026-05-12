<x-admin-layout>
    <div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
        <!-- Premium Header -->
        <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center gap-5">
                <a href="{{ route('admin.materials.index') }}" class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-100 border border-transparent transition-all duration-300">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight">Modify Material Specs</h1>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-0.5">Editing: {{ $material->name }}</p>
                </div>
            </div>
            <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-700 rounded-xl border border-amber-100">
                <i class="fa-solid fa-pen-nib text-[10px]"></i>
                <span class="text-[10px] font-black uppercase tracking-wider">Catalog Edit</span>
            </div>
        </div>

        <form action="{{ route('admin.materials.update', $material->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Form Section -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30">
                            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                <i class="fa-solid fa-box text-indigo-600"></i>
                                Material Specifications
                            </h3>
                        </div>
                        <div class="p-8 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Material Label <span class="text-red-500">*</span></label>
                                    <div class="relative group">
                                        <i class="fa-solid fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-600 transition-colors"></i>
                                        <input type="text" name="name" required value="{{ old('name', $material->name) }}" placeholder="e.g. Portland Cement"
                                            class="w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">
                                    </div>
                                    @error('name') <p class="text-[10px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Measurement Unit <span class="text-red-500">*</span></label>
                                    <div class="relative group">
                                        <i class="fa-solid fa-ruler absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-600 transition-colors"></i>
                                        <input type="text" name="unit" required value="{{ old('unit', $material->unit) }}" placeholder="e.g. Bag, Ton, Kg"
                                            class="w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">
                                    </div>
                                    @error('unit') <p class="text-[10px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Default Unit Price <span class="text-red-500">*</span></label>
                                    <div class="relative group">
                                        <i class="fa-solid fa-indian-rupee-sign absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-600 transition-colors"></i>
                                        <input type="number" name="price" step="0.01" required value="{{ old('price', $material->price) }}" placeholder="0.00"
                                            class="w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">
                                    </div>
                                    @error('price') <p class="text-[10px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Technical Description</label>
                                <textarea name="description" rows="5" placeholder="Specify grade, brand preferences, or handling instructions..."
                                    class="w-full px-5 py-4 bg-slate-50/50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">{{ old('description', $material->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="space-y-8">
                    <div class="bg-indigo-600 rounded-[2rem] p-8 text-white space-y-6 shadow-xl shadow-indigo-100">
                        <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
                        <div class="space-y-2">
                            <h4 class="font-bold text-lg">Update Note</h4>
                            <p class="text-indigo-100 text-[10px] leading-relaxed font-medium uppercase tracking-wider">
                                Changes to material names or units will update all historical stock records. Ensure data integrity before saving.
                            </p>
                        </div>
                        <div class="pt-4 border-t border-white/10">
                            <button type="submit" class="w-full py-4 bg-white text-indigo-600 rounded-[1.5rem] font-black uppercase text-xs tracking-widest hover:bg-indigo-50 active:scale-95 transition-all">
                                Update Material
                            </button>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-[2rem] border border-slate-100 p-8">
                        <p class="text-[10px] text-slate-400 font-medium italic text-center">Unit consistency is critical for inventory auditing.</p>
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
