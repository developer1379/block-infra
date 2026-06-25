<x-contractor-layout>
    <div class="p-3 md:p-6 space-y-4 md:space-y-8 animate-fade-in">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center gap-5 bg-white p-3 md:p-6 rounded-3xl border border-gray-100 shadow-sm">
            <a href="{{ route('contractor.site-reports.index') }}" class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">{{ __('Create Site Report') }}</h1>
                <p class="text-gray-500 text-sm font-medium">{{ __('Submit daily progress, challenges, and photos from the site.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-indigo-100/20 border border-gray-100 overflow-hidden">
            <form action="{{ route('contractor.site-reports.store') }}" method="POST" enctype="multipart/form-data" class="p-4 md:p-8 space-y-4 md:space-y-8">
                @csrf

                <!-- Project & Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Target Project') }}</label>
                        <select name="project_id" required class="select2-init w-full">
                            <option value="">{{ __('Select Project') }}</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Report Date') }}</label>
                        <div class="relative group">
                            <i class="fa-solid fa-calendar absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-indigo-600 transition-colors"></i>
                            <input type="date" name="report_date" required value="{{ date('Y-m-d') }}"
                                class="w-full pl-12 pr-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">
                        </div>
                    </div>
                </div>

                <!-- Progress & Weather -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                    <div class="p-4 md:p-8 bg-indigo-50/30 rounded-[2rem] border border-indigo-100/50 space-y-4">
                        <div class="flex justify-between items-center">
                            <label class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">{{ __('Completion Progress') }}</label>
                            <output id="progress-val" class="text-xl font-black text-indigo-600">0%</output>
                        </div>
                        <input type="range" name="progress_percentage" min="0" max="100" value="0" step="5"
                            oninput="document.getElementById('progress-val').value = this.value + '%'"
                            class="w-full h-2 bg-indigo-100 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Weather Condition') }}</label>
                        <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                            @foreach(['Clear' => '☀️', 'Cloudy' => '☁️', 'Rainy' => '🌧️', 'Stormy' => '⛈️', 'Windy' => '💨'] as $val => $icon)
                                <label class="relative group cursor-pointer">
                                    <input type="radio" name="weather_condition" value="{{ $val }}" {{ $val == 'Clear' ? 'checked' : '' }} class="peer sr-only">
                                    <div class="p-3 text-center bg-gray-50 border border-transparent rounded-2xl peer-checked:bg-white peer-checked:border-indigo-500 peer-checked:shadow-sm transition-all">
                                        <span class="text-xl block">{{ $icon }}</span>
                                        <span class="text-[9px] font-black uppercase text-gray-400 peer-checked:text-indigo-600 tracking-tighter">{{ __($val) }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Detailed Info -->
                <div class="space-y-4 md:space-y-8">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Detailed Work Summary') }}</label>
                        <textarea name="work_summary" rows="4" required placeholder="{{ __('Describe the work performed today in detail...') }}"
                            class="w-full px-3 md:px-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none min-h-[120px]"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Challenges & Blockers') }} ({{ __('Optional') }})</label>
                            <textarea name="challenges" rows="2" placeholder="{{ __('Any site delays, material shortages, or issues?') }}"
                                class="w-full px-3 md:px-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none"></textarea>
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Next Day Strategy') }} ({{ __('Optional') }})</label>
                            <textarea name="next_day_plan" rows="2" placeholder="{{ __('What are the key goals for tomorrow?') }}"
                                class="w-full px-3 md:px-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Photo Upload -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Site Visuals & Photos') }}</label>
                    <label for="photos" class="relative group cursor-pointer block">
                        <input id="photos" name="photos[]" type="file" multiple class="hidden" accept="image/*">
                        <div class="p-6 md:p-12 border-2 border-dashed border-gray-200 rounded-[2.5rem] bg-gray-50/50 group-hover:bg-indigo-50/30 group-hover:border-indigo-200 transition-all text-center">
                            <div class="h-16 w-16 bg-white rounded-2xl shadow-sm flex items-center justify-center text-indigo-600 mx-auto mb-4 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-cloud-arrow-up text-2xl"></i>
                            </div>
                            <p class="text-sm font-black text-gray-900">{{ __('Drop site photos here or click to browse') }}</p>
                            <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-widest">{{ __('Maximum 50MB per image • PNG, JPG') }}</p>
                        </div>
                    </label>
                    <div id="photo-preview-grid" class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4"></div>
                </div>

                <!-- Material Consumption Log -->
                <div class="p-4 md:p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 space-y-3 md:space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-black text-slate-800">{{ __('Material Consumption Log') }}</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ __('Track inventory used today') }}</p>
                        </div>
                        <button type="button" onclick="addMaterialRow()" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/20">
                            <i class="fa-solid fa-plus mr-1"></i> {{ __('Add Item') }}
                        </button>
                    </div>

                    <div id="material-log-container" class="space-y-4">
                        <!-- Dynamic rows will be added here -->
                    </div>

                    <template id="material-row-template">
                        <div class="material-row grid grid-cols-1 md:grid-cols-12 gap-4 items-end animate-fade-in bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                            <div class="md:col-span-5 space-y-2">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ __('Material') }}</label>
                                <select name="materials[INDEX][id]" required class="w-full px-5 py-3 bg-slate-50 border-transparent rounded-xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none">
                                    <option value="">{{ __('Select Material') }}</option>
                                    @foreach($materials as $material)
                                        <option value="{{ $material->id }}">{{ $material->name }} ({{ $material->unit }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-4 space-y-2">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ __('Link to Milestone') }} ({{ __('Optional') }})</label>
                                <select name="materials[INDEX][milestone_id]" class="milestone-select w-full px-5 py-3 bg-slate-50 border-transparent rounded-xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none">
                                    <option value="">{{ __('Select Milestone') }}</option>
                                </select>
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ __('Quantity Used') }}</label>
                                <input type="number" step="0.01" name="materials[INDEX][quantity]" required placeholder="0.00"
                                    class="w-full px-5 py-3 bg-slate-50 border-transparent rounded-xl text-xs font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none">
                            </div>
                            <div class="md:col-span-1 flex justify-end md:justify-center">
                                <button type="button" onclick="this.closest('.material-row').remove()" class="w-10 h-10 rounded-xl bg-red-50 text-red-500 hover:bg-red-100 transition-colors flex items-center justify-center">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-8 border-t border-gray-50">
                    <a href="{{ route('contractor.site-reports.index') }}" class="w-full sm:w-auto px-10 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-all text-center">
                        {{ __('Discard Changes') }}
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-12 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i>
                        {{ __('Finalize Report') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        let materialIndex = 0;
        let projectMilestones = [];

        function addMaterialRow() {
            const container = document.getElementById('material-log-container');
            const template = document.getElementById('material-row-template').innerHTML;
            let html = template.replace(/INDEX/g, materialIndex);
            
            // Build milestone options from cached milestones
            let options = '<option value="">{{ __("General Project Stock") }}</option>';
            projectMilestones.forEach(m => {
                options += `<option value="${m.id}">${m.title}</option>`;
            });
            
            // Replace the milestone-select content in the template
            // Note: This is a bit hacky because the template is a string. 
            // Better to use DOM manipulation.
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            const select = tempDiv.querySelector('.milestone-select');
            if (select) {
                select.innerHTML = options;
            }
            container.insertAdjacentHTML('beforeend', tempDiv.innerHTML);
            materialIndex++;
        }

        $(document).ready(function() {
            $('.select2-init').select2({
                placeholder: '{{ __('Search project...') }}',
                width: '100%'
            }).on('change', function() {
                const projectId = $(this).val();
                if (projectId) {
                    fetch(`/contractor/projects/${projectId}/milestones`)
                        .then(response => response.json())
                        .then(data => {
                            projectMilestones = data;
                            // Clear existing rows or at least their milestone selects if needed
                            // For now, new rows will have the new milestones
                        });
                }
            });

            // Trigger change if project is already selected (e.g. on validation error back)
            if ($('.select2-init').val()) {
                $('.select2-init').trigger('change');
            }

            // Add initial row after a short delay to allow milestones to load
            setTimeout(addMaterialRow, 500);

            document.getElementById('photos').addEventListener('change', function(e) {
                const previewGrid = document.getElementById('photo-preview-grid');
                previewGrid.innerHTML = '';
                
                [...e.target.files].forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const container = document.createElement('div');
                        container.className = 'relative group aspect-square rounded-2xl overflow-hidden shadow-sm border border-gray-100 animate-fade-in';
                        container.innerHTML = `
                            <img src="${event.target.result}" class="h-full w-full object-cover transition-transform group-hover:scale-110">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="text-[10px] font-black text-white uppercase tracking-widest">${(file.size / 1024 / 1024).toFixed(1)}MB</span>
                            </div>
                        `;
                        previewGrid.appendChild(container);
                    }
                    reader.readAsDataURL(file);
                });
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
            border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }
    </style>
    @endpush
</x-contractor-layout>
