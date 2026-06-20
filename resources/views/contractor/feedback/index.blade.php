<x-contractor-layout>
    <div class="p-3 md:p-6 space-y-4 md:space-y-8 animate-fade-in">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-3 md:p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">{{ __('Site Issues & Feedback') }}</h1>
                <p class="text-gray-500 text-sm mt-1">{{ __('Report issues, request support, and track resolutions.') }}</p>
            </div>
            <a href="{{ route('contractor.feedback.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl shadow-sm hover:bg-indigo-700 transition-colors flex items-center justify-center gap-2">
                <i class="bi bi-plus-circle"></i> {{ __('Submit New Issue') }}
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-3 md:px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Reference') }}</th>
                            <th class="px-3 md:px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Subject') }}</th>
                            <th class="px-3 md:px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Site') }}</th>
                            <th class="px-3 md:px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Status') }}</th>
                            <th class="px-3 md:px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">{{ __('Date') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($feedbacks as $feedback)
                        <tr class="hover:bg-gray-50/50 transition-colors cursor-pointer" onclick="window.location='{{ route('contractor.feedback.show', $feedback->id) }}'">
                            <td class="px-3 md:px-6 py-4">
                                <span class="text-xs font-mono font-bold text-indigo-600">#ISSUE-{{ str_pad($feedback->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-3 md:px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @if($feedback->type === 'bug')
                                        <i class="bi bi-bug-fill text-rose-500 text-sm"></i>
                                    @elseif($feedback->type === 'issue')
                                        <i class="bi bi-exclamation-triangle-fill text-amber-500 text-sm"></i>
                                    @else
                                        <i class="bi bi-info-circle-fill text-blue-500 text-sm"></i>
                                    @endif
                                    <span class="text-sm font-bold text-gray-900">{{ $feedback->subject }}</span>
                                </div>
                            </td>
                            <td class="px-3 md:px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $feedback->project ? $feedback->project->title : 'General' }}</span>
                            </td>
                            <td class="px-3 md:px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'in_progress' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'resolved' => 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                    ];
                                    $statusLabel = [
                                        'pending' => __('Pending Review'),
                                        'in_progress' => __('In Progress'),
                                        'resolved' => __('Resolved')
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-widest rounded-lg border {{ $statusClasses[$feedback->status] }}">
                                    {{ $statusLabel[$feedback->status] }}
                                </span>
                            </td>
                            <td class="px-3 md:px-6 py-4 text-right">
                                <span class="text-xs text-gray-500">{{ $feedback->created_at->format('M d, Y') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-3 md:px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="bi bi-check-circle text-4xl mb-3 text-gray-300"></i>
                                    <p class="text-sm font-medium">{{ __('No issues reported.') }}</p>
                                    <p class="text-xs mt-1">{{ __('Everything looks good! Report issues if you find any.') }}</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($feedbacks->hasPages())
                <div class="px-3 md:px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $feedbacks->links() }}
                </div>
            @endif
        </div>
    </div>
</x-contractor-layout>
