<x-contractor-layout>
    <div class="p-3 md:p-6 space-y-4 md:space-y-8 animate-fade-in">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-3 md:p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4">
                <a href="{{ route('contractor.feedback.index') }}" class="w-10 h-10 flex items-center justify-center bg-gray-50 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-colors">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">#ISSUE-{{ str_pad($feedback->id, 4, '0', STR_PAD_LEFT) }}</h1>
                    <p class="text-xs text-gray-500">{{ $feedback->created_at->format('M d, Y - h:i A') }}</p>
                </div>
            </div>
            <div>
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
                <span class="px-4 py-2 text-xs font-black uppercase tracking-widest rounded-xl border {{ $statusClasses[$feedback->status] }}">
                    {{ $statusLabel[$feedback->status] }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-8">
            <div class="lg:col-span-2 space-y-4 md:space-y-8">
                <!-- Main Issue Card -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 md:p-8">
                    <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-50">
                        @if($feedback->type === 'bug')
                            <div class="w-12 h-12 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center text-xl">
                                <i class="bi bi-bug-fill"></i>
                            </div>
                        @elseif($feedback->type === 'issue')
                            <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center text-xl">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>
                        @else
                            <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center text-xl">
                                <i class="bi bi-info-circle-fill"></i>
                            </div>
                        @endif
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ ucfirst($feedback->type) }}</p>
                            <h2 class="text-xl font-bold text-gray-900">{{ $feedback->subject }}</h2>
                        </div>
                    </div>

                    <div class="prose prose-sm max-w-none text-gray-600">
                        {!! nl2br(e($feedback->description)) !!}
                    </div>

                    @if($feedback->attachment)
                        <div class="mt-8 pt-6 border-t border-gray-50">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4"><i class="bi bi-paperclip"></i> {{ __('Attachment') }}</p>
                            <a href="{{ $feedback->attachment_url }}" target="_blank" class="block max-w-sm rounded-xl overflow-hidden border border-gray-200 hover:border-indigo-300 transition-colors">
                                <img src="{{ $feedback->attachment_url }}" alt="Attachment" class="w-full h-auto object-cover">
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Admin Reply Card -->
                @if($feedback->admin_reply)
                    <div class="bg-indigo-50 rounded-2xl border border-indigo-100 shadow-sm p-4 md:p-8 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-8 text-indigo-100 opacity-50">
                            <i class="bi bi-chat-quote-fill text-6xl"></i>
                        </div>
                        <div class="relative z-10">
                            <h3 class="text-sm font-black text-indigo-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <i class="bi bi-person-badge-fill text-indigo-500"></i> {{ __('Admin Response') }}
                            </h3>
                            <div class="bg-white/60 backdrop-blur-sm rounded-xl p-6 text-gray-700 text-sm leading-relaxed border border-indigo-50">
                                {!! nl2br(e($feedback->admin_reply)) !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Details Sidebar -->
            <div class="space-y-4 md:space-y-8">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6 border-b border-gray-50 pb-4">{{ __('Ticket Details') }}</h3>
                    <div class="space-y-4 text-sm">
                        <div>
                            <p class="text-gray-500">{{ __('Submitted On') }}</p>
                            <p class="font-bold text-gray-900">{{ $feedback->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">{{ __('Related Site') }}</p>
                            @if($feedback->project)
                                <p class="font-bold text-indigo-600">{{ $feedback->project->title }}</p>
                            @else
                                <p class="font-bold text-gray-900">{{ __('General Platform') }}</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-gray-500">{{ __('Last Updated') }}</p>
                            <p class="font-bold text-gray-900">{{ $feedback->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-contractor-layout>
