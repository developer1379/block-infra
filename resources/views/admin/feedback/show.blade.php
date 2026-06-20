<x-admin-layout>
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.feedback.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-colors">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">#ISSUE-{{ str_pad($feedback->id, 4, '0', STR_PAD_LEFT) }}</h1>
                <p class="text-sm text-slate-500">{{ __('Reported by') }} {{ $feedback->contractor->user->name }} on {{ $feedback->created_at->format('M d, Y - h:i A') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <!-- Issue Details Card -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-6 pb-6 border-b border-slate-100">
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
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ ucfirst($feedback->type) }}</p>
                            <h2 class="text-xl font-bold text-slate-800">{{ $feedback->subject }}</h2>
                        </div>
                    </div>

                    <div class="prose prose-sm max-w-none text-slate-600 bg-slate-50/50 p-6 rounded-xl border border-slate-100">
                        {!! nl2br(e($feedback->description)) !!}
                    </div>

                    @if($feedback->attachment)
                        <div class="mt-8 pt-6 border-t border-slate-100">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4"><i class="bi bi-paperclip"></i> {{ __('Attachment / Screenshot') }}</p>
                            <a href="{{ asset('storage/' . $feedback->attachment) }}" target="_blank" class="block max-w-lg rounded-xl overflow-hidden border border-slate-200 hover:border-indigo-300 transition-colors shadow-sm">
                                <img src="{{ asset('storage/' . $feedback->attachment) }}" alt="Attachment" class="w-full h-auto object-cover">
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Resolution Form & Sidebar -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="text-sm font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <i class="bi bi-shield-check text-indigo-500"></i> {{ __('Resolution & Response') }}
                    </h3>

                    <form action="{{ route('admin.feedback.update', $feedback->id) }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">{{ __('Status') }}</label>
                            <select name="status" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="pending" {{ $feedback->status == 'pending' ? 'selected' : '' }}>{{ __('Pending Review') }}</option>
                                <option value="in_progress" {{ $feedback->status == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                                <option value="resolved" {{ $feedback->status == 'resolved' ? 'selected' : '' }}>{{ __('Resolved / Closed') }}</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">{{ __('Admin Reply') }}</label>
                            <textarea name="admin_reply" rows="5" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="{{ __('Provide a resolution or update to the contractor...') }}">{{ $feedback->admin_reply }}</textarea>
                            <p class="text-[10px] text-slate-400 mt-2">{{ __('This reply will be visible to the contractor.') }}</p>
                        </div>

                        <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white text-sm font-bold rounded-xl shadow-sm hover:bg-indigo-700 transition-colors">
                            {{ __('Update Ticket') }}
                        </button>
                    </form>
                </div>

                <div class="bg-slate-50 rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-200 pb-4">{{ __('Context') }}</h3>
                    <div class="space-y-4 text-sm">
                        <div>
                            <p class="text-slate-500">{{ __('Related Site/Project') }}</p>
                            @if($feedback->project)
                                <a href="{{ route('admin.projects.show', $feedback->project->id) }}" class="font-bold text-indigo-600 hover:underline">
                                    {{ $feedback->project->title }}
                                </a>
                            @else
                                <p class="font-bold text-slate-800">{{ __('General Platform') }}</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-slate-500">{{ __('Contractor Profile') }}</p>
                            <a href="{{ route('admin.contractors.show', $feedback->contractor->id) }}" class="font-bold text-indigo-600 hover:underline">
                                {{ $feedback->contractor->company_name ?? $feedback->contractor->user->name }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
