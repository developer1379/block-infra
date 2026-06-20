<x-contractor-layout>
    <div class="p-3 md:p-6 space-y-4 md:space-y-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-3 md:gap-6">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3">
                    {{ __('Worker Payments') }}
                    <span class="bg-emerald-100 text-emerald-600 text-[10px] font-black uppercase px-3 py-1 rounded-full tracking-widest border border-emerald-200">
                        {{ $payments->total() }} {{ __('Records') }}
                    </span>
                </h1>
                <p class="text-gray-500 text-sm mt-1 font-medium">{{ __('Track wages and payment history for your construction workforce.') }}</p>
            </div>
            <a href="{{ route('contractor.payments.create') }}" 
                class="w-full lg:w-auto inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-black px-3 md:px-6 py-3.5 rounded-2xl transition-all shadow-xl shadow-emerald-100 transform active:scale-95">
                <i class="fa-solid fa-plus-circle"></i>
                {{ __('Record New Payment') }}
            </a>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-6">
            <div class="bg-white p-3 md:p-6 rounded-[2.5rem] border border-gray-100 shadow-sm group hover:border-emerald-200 transition-all">
                <div class="flex items-center gap-5">
                    <div class="h-14 w-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-wallet text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Total Paid') }} ({{ __('Month') }})</p>
                        <p class="text-2xl font-black text-gray-900">₹{{ number_format($payments->where('payment_date', '>=', now()->startOfMonth())->sum('amount'), 0) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-3 md:p-6 rounded-[2.5rem] border border-gray-100 shadow-sm group hover:border-indigo-200 transition-all">
                <div class="flex items-center gap-5">
                    <div class="h-14 w-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-receipt text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Average Payment') }}</p>
                        <p class="text-2xl font-black text-gray-900">₹{{ number_format($payments->avg('amount') ?? 0, 0) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-3 md:p-6 rounded-[2.5rem] border border-gray-100 shadow-sm group hover:border-amber-200 transition-all">
                <div class="flex items-center gap-5">
                    <div class="h-14 w-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-users-viewfinder text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Unique Workers') }}</p>
                        <p class="text-2xl font-black text-gray-900">{{ $payments->pluck('worker_id')->unique()->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments Content -->
        <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-50">
                            <th class="px-4 md:px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Date') }}</th>
                            <th class="px-4 md:px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Worker') }}</th>
                            <th class="px-4 md:px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Amount') }}</th>
                            <th class="px-4 md:px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">{{ __('Method') }}</th>
                            <th class="px-4 md:px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Period') }}</th>
                            <th class="px-4 md:px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Reference') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($payments as $payment)
                            <tr class="hover:bg-gray-50/80 transition-all group">
                                <td class="px-4 md:px-8 py-3 md:py-6">
                                    <span class="text-sm font-black text-gray-900">{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</span>
                                </td>
                                <td class="px-4 md:px-8 py-3 md:py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 font-black text-xs group-hover:scale-110 transition-transform">
                                            {{ substr($payment->worker->name, 0, 1) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-gray-900">{{ $payment->worker->name }}</span>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ __($payment->worker->specialization) }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 md:px-8 py-3 md:py-6">
                                    <span class="text-base font-black text-gray-900">₹{{ number_format($payment->amount, 2) }}</span>
                                </td>
                                <td class="px-4 md:px-8 py-3 md:py-6">
                                    <div class="flex justify-center">
                                        @php
                                            $methodClasses = [
                                                'cash' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                'bank_transfer' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                'upi' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $methodClasses[$payment->payment_method] ?? 'bg-gray-100 text-gray-600 border-gray-200' }}">
                                            {{ __(str_replace('_', ' ', $payment->payment_method)) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 md:px-8 py-3 md:py-6">
                                    @if($payment->period_start)
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-gray-600">{{ \Carbon\Carbon::parse($payment->period_start)->format('M d') }} - {{ \Carbon\Carbon::parse($payment->period_end)->format('M d') }}</span>
                                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">{{ __('Cycle') }}</span>
                                        </div>
                                    @else
                                        <span class="text-[10px] font-bold text-gray-300 italic">{{ __('No Period') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 md:px-8 py-3 md:py-6 font-mono text-[10px] text-gray-400">
                                    {{ $payment->transaction_id ?? 'N/A' }}
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile List -->
            <div class="md:hidden divide-y divide-gray-50">
                @forelse ($payments as $payment)
                    <div class="p-3 md:p-6 space-y-4 hover:bg-gray-50 transition-all">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-3">
                                <div class="h-12 w-12 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 font-black">
                                    {{ substr($payment->worker->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-base font-black text-gray-900">{{ $payment->worker->name }}</h4>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-black text-gray-900">₹{{ number_format($payment->amount, 0) }}</p>
                                <span class="text-[9px] font-black uppercase tracking-widest text-emerald-600">{{ __(str_replace('_', ' ', $payment->payment_method)) }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 bg-gray-50/50 rounded-2xl border border-gray-50">
                                <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Period') }}</p>
                                <p class="text-[10px] font-bold text-gray-700">
                                    {{ $payment->period_start ? \Carbon\Carbon::parse($payment->period_start)->format('M d') . ' - ' . \Carbon\Carbon::parse($payment->period_end)->format('M d') : 'N/A' }}
                                </p>
                            </div>
                            <div class="p-3 bg-gray-50/50 rounded-2xl border border-gray-50">
                                <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Reference') }}</p>
                                <p class="text-[10px] font-mono text-gray-500 truncate">{{ $payment->transaction_id ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>

            @if($payments->isEmpty())
                <div class="py-32 flex flex-col items-center justify-center text-center px-3 md:px-6">
                    <div class="w-32 h-32 bg-gray-50 rounded-full flex items-center justify-center text-gray-200 text-6xl mb-8">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <h3 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">{{ __('No Payments Found') }}</h3>
                    <p class="text-gray-500 mt-3 max-w-sm font-medium leading-relaxed">{{ __('You haven\'t recorded any wage payments yet. Keep your workforce happy by tracking their dues.') }}</p>
                    <a href="{{ route('contractor.payments.create') }}" class="mt-10 px-10 py-4 bg-emerald-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-2xl shadow-emerald-100 hover:bg-emerald-700 transition-all transform active:scale-95">
                        {{ __('Record First Payment') }}
                    </a>
                </div>
            @endif
        </div>

        @if($payments->hasPages())
            <div class="mt-8">
                {{ $payments->links() }}
            </div>
        @endif
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</x-contractor-layout>
