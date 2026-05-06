<x-contractor-layout>
    <div class="p-6 space-y-6 animate-fade-in">
        <!-- Header -->
        <div class="flex items-center gap-5 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <a href="{{ route('contractor.workers.index') }}" class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Edit Worker Profile</h1>
                <p class="text-gray-500 text-sm italic">Update information for {{ $worker->name }}</p>
            </div>
        </div>

        <form action="{{ route('contractor.workers.update', $worker->id) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf
            @method('PUT')
            
            <!-- Main Details -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-id-card text-indigo-600"></i>
                            Worker Information
                        </h3>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Full Name</label>
                                <div class="relative group">
                                    <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-indigo-600 transition-colors"></i>
                                    <input type="text" name="name" required value="{{ old('name', $worker->name) }}"
                                        class="w-full pl-11 pr-4 py-3.5 bg-gray-50/50 border-gray-100 rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Phone Number</label>
                                <div class="relative group">
                                    <i class="fa-solid fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-indigo-600 transition-colors"></i>
                                    <input type="text" name="phone" value="{{ old('phone', $worker->phone) }}"
                                        class="w-full pl-11 pr-4 py-3.5 bg-gray-50/50 border-gray-100 rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Skill Specialization</label>
                                <div class="relative">
                                    <select name="specialization" class="select2-init w-full px-4 py-3.5 bg-gray-50/50 border-gray-100 rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">
                                        <option value="">General Labor</option>
                                        @foreach($works as $work)
                                            <option value="{{ $work->name }}" {{ old('specialization', $worker->specialization) == $work->name ? 'selected' : '' }}>
                                                {{ $work->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Daily Wage (₹)</label>
                                <div class="relative group">
                                    <i class="fa-solid fa-indian-rupee-sign absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-indigo-600 transition-colors"></i>
                                    <input type="number" name="daily_wage" value="{{ old('daily_wage', $worker->daily_wage) }}"
                                        class="w-full pl-11 pr-4 py-3.5 bg-gray-50/50 border-gray-100 rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Actions -->
            <div class="space-y-8">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 space-y-6">
                    <div class="space-y-4">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Current Status</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="cursor-pointer group">
                                <input type="radio" name="status" value="active" {{ $worker->status == 'active' ? 'checked' : '' }} class="peer hidden">
                                <div class="py-3 text-center rounded-xl border border-gray-100 bg-gray-50 text-gray-400 font-bold text-xs peer-checked:bg-indigo-50 peer-checked:border-indigo-200 peer-checked:text-indigo-600 transition-all">
                                    Active
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="status" value="inactive" {{ $worker->status == 'inactive' ? 'checked' : '' }} class="peer hidden">
                                <div class="py-3 text-center rounded-xl border border-gray-100 bg-gray-50 text-gray-400 font-bold text-xs peer-checked:bg-red-50 peer-checked:border-red-200 peer-checked:text-red-600 transition-all">
                                    Inactive
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">
                        <i class="fa-solid fa-save mr-2"></i> Update Profile
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2-init').select2({
                placeholder: "Select Specialization",
                allowClear: true
            });
        });
    </script>
    @endpush
</x-contractor-layout>
