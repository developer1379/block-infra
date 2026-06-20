<x-contractor-layout>
    <div class="p-3 md:p-6 space-y-4 md:space-y-8 animate-fade-in">
        <div class="flex items-center gap-4 bg-white p-3 md:p-6 rounded-2xl border border-gray-100 shadow-sm">
            <a href="{{ route('contractor.feedback.index') }}" class="w-10 h-10 flex items-center justify-center bg-gray-50 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-colors">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-900">{{ __('Submit New Issue') }}</h1>
                <p class="text-xs text-gray-500">{{ __('Report a problem with a site or request support.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-3 md:p-8">
            <form action="{{ route('contractor.feedback.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Project Site') }} ({{ __('Optional') }})</label>
                        <select name="project_id" class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="">{{ __('General Platform Issue') }}</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Issue Type') }}</label>
                        <select name="type" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="issue">{{ __('Site Issue') }}</option>
                            <option value="bug">{{ __('Platform Bug') }}</option>
                            <option value="suggestion">{{ __('Improvement Suggestion') }}</option>
                            <option value="other">{{ __('Other') }}</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Subject') }}</label>
                    <input type="text" name="subject" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="{{ __('Brief description of the problem') }}">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Detailed Description') }}</label>
                    <textarea name="description" rows="6" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="{{ __('Provide as many details as possible so we can help you faster...') }}"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Attach Screenshot') }} ({{ __('Optional') }})</label>
                    <input type="file" name="attachment" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:uppercase file:tracking-widest file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors">
                    <p class="text-xs text-gray-400 mt-2">{{ __('Max file size: 5MB. Formats: JPG, PNG') }}</p>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-all">
                        {{ __('Submit Ticket') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-contractor-layout>
