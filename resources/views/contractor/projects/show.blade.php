<x-contractor-layout>
    <div class="p-6 space-y-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('contractor.projects.index') }}" class="h-10 w-10 flex items-center justify-center bg-white border border-gray-100 rounded-xl text-gray-400 hover:text-indigo-600 hover:border-indigo-100 shadow-sm transition-all">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $project->name }}</h1>
                    <div class="flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">
                        <span class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded border border-indigo-100">
                            {{ __('Project Workspace') }}
                        </span>
                        <span>•</span>
                        <span><i class="bi bi-geo-alt"></i> {{ $project->location ?? __('Remote Site') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100 text-sm font-bold flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    {{ __('Active Project') }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Update & Info -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Progress Update Card -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden group">
                    <div class="p-6 bg-indigo-600 text-white flex justify-between items-center">
                        <h3 class="font-bold flex items-center gap-2">
                            <i class="bi bi-pencil-square"></i> {{ __('Update Progress') }}
                        </h3>
                        <span class="text-[10px] bg-white/20 px-2 py-1 rounded-lg backdrop-blur-sm uppercase font-bold tracking-wider">
                            {{ __('Daily Report') }}
                        </span>
                    </div>

                    <div class="p-8">
                        <form action="{{ route('contractor.projects.progress.store', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <!-- Progress Slider -->
                            <div x-data="{ progress: {{ $project->current_progress ?? 0 }} }">
                                <div class="flex justify-between items-end mb-3">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ __('Overall Completion') }}</label>
                                    <span class="text-xl font-black text-indigo-600" x-text="progress + '%'"></span>
                                </div>
                                <input type="range" name="progress_percentage" x-model="progress" min="0" max="100" step="1" 
                                    class="w-full h-2 bg-gray-100 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                <div class="flex justify-between mt-2">
                                    <span class="text-[8px] font-bold text-gray-300">0%</span>
                                    <span class="text-[8px] font-bold text-gray-300">100%</span>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="space-y-2">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ __('Work Summary') }}</label>
                                <textarea name="report_description" rows="4" required 
                                    class="w-full rounded-2xl border-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm bg-gray-50/50 p-4 transition-all" 
                                    placeholder="{{ __('What milestones were achieved today?') }}"></textarea>
                            </div>

                            <!-- File Upload -->
                            <div class="space-y-2">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ __('Site Proof / Documents') }}</label>
                                <div class="relative group/file">
                                    <input type="file" name="report_file" 
                                        class="block w-full text-xs text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all cursor-pointer">
                                </div>
                                <p class="text-[10px] text-gray-400 italic mt-1">{{ __('Upload site photos, invoices, or progress charts.') }}</p>
                            </div>

                            <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-xl shadow-indigo-100 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                                <i class="bi bi-cloud-arrow-up"></i>
                                {{ __('Submit Daily Report') }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Milestones Card -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 space-y-6">
                    <div class="flex items-center justify-between border-b border-gray-50 pb-4">
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ __('Project Milestones') }}</h4>
                        <i class="bi bi-flag text-indigo-600"></i>
                    </div>
                    <div class="space-y-4">
                        @forelse($project->milestones as $milestone)
                            <div class="flex items-center justify-between p-4 rounded-2xl border transition-all {{ $milestone->status == 'paid' ? 'border-emerald-100 bg-emerald-50/30' : 'border-gray-50 bg-gray-50/30' }}">
                                <div>
                                    <p class="text-xs font-bold text-gray-900">{{ $milestone->title }}</p>
                                    <p class="text-[10px] text-gray-400 mt-1">
                                        <i class="bi bi-calendar3 mr-1"></i> {{ $milestone->due_date ? $milestone->due_date->format('M d, Y') : __('TBD') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-black text-gray-900">₹{{ number_format($milestone->amount) }}</p>
                                    @if ($milestone->status == 'paid')
                                        <span class="text-[9px] text-emerald-600 font-bold flex items-center justify-end gap-1">
                                            <i class="bi bi-check-circle-fill"></i> {{ __('Paid') }}
                                        </span>
                                    @else
                                        <span class="text-[9px] text-gray-400 font-bold">{{ __('Pending') }}</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6">
                                <p class="text-xs text-gray-400">{{ __('No financial milestones established.') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column: Project Timeline -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm h-full flex flex-col overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                            <i class="bi bi-clock-history text-indigo-600"></i>
                            {{ __('Live Project Timeline') }}
                        </h3>
                        <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                            {{ $project->progressUpdates->count() }} {{ __('Updates Posted') }}
                        </span>
                    </div>

                    <div class="p-8 flex-1 overflow-y-auto custom-scrollbar">
                        <div class="relative space-y-10 pl-6">
                            <!-- Vertical Timeline Line -->
                            <div class="absolute top-2 bottom-2 left-[31px] w-[2px] bg-gradient-to-b from-indigo-100 via-gray-50 to-transparent"></div>

                            @forelse($project->progressUpdates->sortByDesc('created_at') as $update)
                                <div class="relative pl-12 animate-slide-in">
                                    <!-- Timeline Point -->
                                    <div class="absolute left-0 top-0 h-10 w-10 rounded-xl bg-white border-2 border-indigo-50 shadow-sm flex items-center justify-center z-10 group hover:border-indigo-600 transition-all">
                                        <span class="text-[10px] font-black text-indigo-600">{{ $update->progress_percentage }}%</span>
                                    </div>

                                    <!-- Content Card -->
                                    <div class="bg-gray-50/50 rounded-2xl p-6 border border-gray-50 hover:bg-white hover:shadow-xl hover:border-indigo-50 transition-all group">
                                        <div class="flex justify-between items-center mb-3">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-xs font-bold border border-indigo-100">
                                                    {{ substr($update->user->name ?? 'C', 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="text-xs font-bold text-gray-900">{{ $update->user->name ?? __('Contractor') }}</p>
                                                    <p class="text-[10px] text-gray-400 font-medium">
                                                        {{ $update->created_at->format('M d, Y') }} • {{ $update->created_at->format('h:i A') }}
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            @if ($update->report_file_path)
                                                <a href="{{ asset('storage/' . $update->report_file_path) }}" target="_blank" class="px-3 py-1 bg-white text-indigo-600 border border-indigo-100 rounded-lg text-[10px] font-bold hover:bg-indigo-600 hover:text-white transition-all flex items-center gap-1">
                                                    <i class="bi bi-paperclip"></i> {{ __('Attachment') }}
                                                </a>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600 leading-relaxed italic border-l-2 border-indigo-200 pl-4 py-1">
                                            "{{ $update->report_description }}"
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-24">
                                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-200 text-4xl">
                                        <i class="bi bi-journal-text"></i>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ __('No Timeline Activity') }}</h4>
                                    <p class="text-gray-500 text-sm max-w-xs mx-auto">{{ __('Submit your first daily report to start building the project history.') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        .animate-slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }
    </style>
</x-contractor-layout>
