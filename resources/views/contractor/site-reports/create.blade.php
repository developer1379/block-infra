<x-contractor-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('contractor.site-reports.index') }}" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors mb-4">
                    <i class="bi bi-arrow-left mr-2"></i> Back to Reports
                </a>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Create Site Report</h1>
                <p class="text-gray-500 mt-1">Submit daily progress, challenges, and photos from the site.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <form action="{{ route('contractor.site-reports.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                    @csrf

                    <!-- Project & Date -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Project</label>
                            <select name="project_id" required class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all py-3 px-4">
                                <option value="">Select Project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Report Date</label>
                            <input type="date" name="report_date" required value="{{ date('Y-m-d') }}"
                                class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all py-3 px-4">
                        </div>
                    </div>

                    <!-- Progress & Weather -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Progress Percentage (%)</label>
                            <div class="flex items-center gap-4">
                                <input type="range" name="progress_percentage" min="0" max="100" value="0" step="5"
                                    oninput="this.nextElementSibling.value = this.value + '%'"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                <output class="text-lg font-bold text-indigo-600 min-w-[3rem]">0%</output>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Weather Condition</label>
                            <select name="weather_condition" class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all py-3 px-4">
                                <option value="Clear">☀️ Clear / Sunny</option>
                                <option value="Cloudy">☁️ Cloudy</option>
                                <option value="Rainy">🌧️ Rainy</option>
                                <option value="Stormy">⛈️ Stormy</option>
                                <option value="Windy">💨 Windy</option>
                            </select>
                        </div>
                    </div>

                    <!-- Detailed Info -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Work Summary</label>
                            <textarea name="work_summary" rows="4" required placeholder="What work was performed today?"
                                class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all p-4"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Challenges / Issues (Optional)</label>
                            <textarea name="challenges" rows="2" placeholder="Any blockers or material delays?"
                                class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all p-4"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Next Day Plan (Optional)</label>
                            <textarea name="next_day_plan" rows="2" placeholder="What is scheduled for tomorrow?"
                                class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all p-4"></textarea>
                        </div>
                    </div>

                    <!-- Photo Upload -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Site Photos</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-3xl bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="space-y-1 text-center">
                                <i class="bi bi-images text-4xl text-gray-400 mb-2"></i>
                                <div class="flex text-sm text-gray-600">
                                    <label for="photos" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Upload site photos</span>
                                        <input id="photos" name="photos[]" type="file" multiple class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG up to 2MB each</p>
                                <div id="photo-preview" class="flex flex-wrap gap-2 mt-4"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('contractor.site-reports.index') }}" class="px-8 py-3 text-sm font-bold text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-2xl transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="px-12 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-2xl shadow-lg shadow-indigo-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                            Submit Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('photos').addEventListener('change', function(e) {
            const preview = document.getElementById('photo-preview');
            preview.innerHTML = '';
            
            [...e.target.files].forEach(file => {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.className = 'h-16 w-16 object-cover rounded-xl shadow-sm border border-gray-200';
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        });
    </script>
    @endpush
</x-contractor-layout>
