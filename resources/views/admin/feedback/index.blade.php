<x-admin-layout>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ __('Contractor Support & Issues') }}</h1>
                <p class="text-sm text-slate-500">{{ __('Manage feedback, bugs, and site issues reported by contractors.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('Ticket') }}</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('Contractor / Site') }}</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('Subject') }}</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">{{ __('Status') }}</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">{{ __('Date') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($feedbacks as $feedback)
                            <tr class="hover:bg-slate-50/50 transition-colors cursor-pointer" onclick="window.location='{{ route('admin.feedback.show', $feedback->id) }}'">
                                <td class="px-6 py-4">
                                    <span class="text-xs font-mono font-bold text-indigo-600">#ISSUE-{{ str_pad($feedback->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">{{ ucfirst($feedback->type) }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-800">{{ $feedback->contractor->user->name }}</p>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-tighter">{{ $feedback->project ? $feedback->project->title : 'General Platform' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-slate-700 font-medium line-clamp-1">{{ $feedback->subject }}</span>
                                        @if($feedback->attachment)
                                            <i class="bi bi-paperclip text-slate-400"></i>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'in_progress' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'resolved' => 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                        ];
                                        $statusLabel = [
                                            'pending' => __('Pending'),
                                            'in_progress' => __('In Progress'),
                                            'resolved' => __('Resolved')
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-widest rounded-lg border {{ $statusClasses[$feedback->status] }}">
                                        {{ $statusLabel[$feedback->status] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm text-slate-500">
                                    {{ $feedback->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <i class="bi bi-check2-circle text-4xl mb-3 text-slate-300"></i>
                                    <p class="text-sm font-medium">{{ __('No support tickets found.') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($feedbacks->hasPages())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                    {{ $feedbacks->links() }}
                </div>
            @endif
        </div>
    </div>

</x-admin-layout>
