<x-contractor-layout>
    <div class="p-6 space-y-8 animate-fade-in">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center gap-5 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <a href="{{ route('contractor.payments.index') }}" class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">{{ __('Record Wage Payment') }}</h1>
                <p class="text-gray-500 text-sm font-medium">{{ __('Submit a new payment record for a worker.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-emerald-100/20 border border-gray-100 overflow-hidden">
            <form action="{{ route('contractor.payments.store') }}" method="POST" class="p-8 space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Worker Selection -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Select Worker') }}</label>
                        <select name="worker_id" id="worker_select" required class="select2-init w-full">
                            <option value="">{{ __('Select Worker') }}</option>
                            @foreach($workers as $worker)
                                <option value="{{ $worker->id }}" data-wage="{{ $worker->daily_wage }}">
                                    {{ $worker->name }} ({{ __($worker->specialization ?? 'General') }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Project Selection -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Select Project Site') }}</label>
                        <select name="project_id" id="project_select" class="select2-init w-full">
                            <option value="">{{ __('General Payment (No Project)') }}</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ (isset($selected_project_id) && $selected_project_id == $project->id) ? 'selected' : '' }}>
                                    {{ $project->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Amount -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Payment Amount') }} (₹)</label>
                        <div class="relative group">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-emerald-600 font-black text-lg">₹</span>
                            <input type="number" name="amount" id="amount" step="0.01" required placeholder="0.00"
                                class="w-full pl-12 pr-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-xl font-black text-gray-900 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white transition-all outline-none">
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Payment Date') }}</label>
                        <div class="relative group">
                            <i class="fa-solid fa-calendar absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-emerald-600 transition-colors"></i>
                            <input type="date" name="payment_date" required value="{{ date('Y-m-d') }}"
                                class="w-full pl-12 pr-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white transition-all outline-none">
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Payment Method') }}</label>
                        <select name="payment_method" required class="w-full px-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white transition-all outline-none cursor-pointer appearance-none">
                            <option value="cash">{{ __('Cash') }}</option>
                            <option value="bank_transfer">{{ __('Bank Transfer') }}</option>
                            <option value="upi">{{ __('UPI (GPay/PhonePe)') }}</option>
                            <option value="other">{{ __('Other') }}</option>
                        </select>
                    </div>
                </div>

                <div class="p-8 bg-emerald-50/50 rounded-[2.5rem] border border-emerald-100/50 space-y-6">
                    <h3 class="text-[10px] font-black text-emerald-600 uppercase tracking-widest flex items-center gap-2">
                        <i class="fa-solid fa-calendar-range"></i> {{ __('Wage Period Selection') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Period Start') }}</label>
                            <input type="date" name="period_start" class="w-full px-5 py-3 bg-white border-transparent rounded-xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Period End') }}</label>
                            <input type="date" name="period_end" class="w-full px-5 py-3 bg-white border-transparent rounded-xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Transaction Reference / UPI ID') }}</label>
                        <div class="relative group">
                            <i class="fa-solid fa-hashtag absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-emerald-600 transition-colors"></i>
                            <input type="text" name="transaction_id" placeholder="{{ __('e.g. TXN123456789 or UPI Reference') }}"
                                class="w-full pl-12 pr-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white transition-all outline-none">
                        </div>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Notes') }}</label>
                        <textarea name="notes" rows="1" placeholder="{{ __('e.g. Paid for last week\'s foundation work...') }}"
                            class="w-full px-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white transition-all outline-none"></textarea>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-8 border-t border-gray-50">
                    <a href="{{ route('contractor.payments.index') }}" class="w-full sm:w-auto px-10 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-all text-center">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-12 py-4 bg-emerald-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl shadow-emerald-100 hover:bg-emerald-700 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i>
                        {{ __('Submit Payment Record') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2-init').select2({
                placeholder: '{{ __('Search and select...') }}',
                width: '100%'
            });
        });
    </script>
    <style>
        .select2-container--default .select2-selection--single {
            background-color: rgba(249, 250, 251, 0.5);
            border: 1px solid transparent;
            border-radius: 1rem;
            height: 56px;
            padding: 12px;
            font-size: 0.875rem;
            font-weight: 700;
            transition: all 0.2s;
        }
        .select2-container--default.select2-container--open .select2-selection--single {
            background-color: white;
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 54px;
        }
    </style>
    @endpush
</x-contractor-layout>
