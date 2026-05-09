<x-contractor-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ __('Invoices & Payments') }}</h1>
                    <p class="text-gray-500 mt-1">{{ __('Manage your project billing and track payment status.') }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="max-w-md mx-auto">
                    <div class="h-20 w-20 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600 mx-auto mb-6">
                        <i class="bi bi-receipt-cutoff text-4xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ __('Billing System Coming Soon') }}</h2>
                    <p class="text-gray-600 mb-8">{{ __('We\'re working on a comprehensive invoicing system that will allow you to generate bills directly from your material logs and milestones.') }}</p>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center gap-3 text-left p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <i class="bi bi-check-circle-fill text-green-500"></i>
                            <span class="text-sm font-medium text-gray-700">{{ __('Automatic Invoice Generation') }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-left p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <i class="bi bi-check-circle-fill text-green-500"></i>
                            <span class="text-sm font-medium text-gray-700">{{ __('Payment Milestone Tracking') }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-left p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <i class="bi bi-check-circle-fill text-green-500"></i>
                            <span class="text-sm font-medium text-gray-700">{{ __('PDF Bill Downloads') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-contractor-layout>
