<x-contractor-layout>
    <div class="p-6 space-y-8 animate-fade-in">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center gap-5 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <a href="{{ route('contractor.attendance.index') }}" class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">{{ __('Mark Attendance') }}</h1>
                <p class="text-gray-500 text-sm font-medium">{{ __('Record worker attendance with real-time GPS location.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-indigo-100/20 border border-gray-100 overflow-hidden">
            <form action="{{ route('contractor.attendance.store') }}" method="POST" enctype="multipart/form-data" id="attendanceForm" class="p-8 space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Project Selection -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Project Site') }}</label>
                        <select name="project_id" required class="select2-init w-full">
                            <option value="">{{ __('Select Project Site') }}</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Worker Selection -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Worker') }}</label>
                        <select name="worker_id" required class="select2-init w-full">
                            <option value="">{{ __('Select Worker') }}</option>
                            @foreach($workers as $worker)
                                <option value="{{ $worker->id }}">{{ $worker->name }} ({{ __($worker->specialization) }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Status -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Attendance Status') }}</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer group">
                                <input type="radio" name="status" value="present" checked class="peer sr-only">
                                <div class="py-4 text-center rounded-2xl border border-gray-100 bg-gray-50 text-gray-400 font-black text-[10px] uppercase tracking-widest peer-checked:bg-emerald-50 peer-checked:border-emerald-200 peer-checked:text-emerald-600 transition-all shadow-sm group-hover:bg-white">
                                    {{ __('Present') }}
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="status" value="half_day" class="peer sr-only">
                                <div class="py-4 text-center rounded-2xl border border-gray-100 bg-gray-50 text-gray-400 font-black text-[10px] uppercase tracking-widest peer-checked:bg-amber-50 peer-checked:border-amber-200 peer-checked:text-amber-600 transition-all shadow-sm group-hover:bg-white">
                                    {{ __('Half Day') }}
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Attendance Date -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Date') }}</label>
                        <div class="relative">
                            <input type="text" value="{{ date('M d, Y') }}" readonly
                                class="w-full px-6 py-4 bg-gray-50 border-transparent rounded-2xl text-sm font-black text-gray-400 cursor-not-allowed">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-indigo-500 uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                                {{ __('Today') }}
                            </span>
                        </div>
                        <input type="hidden" name="attendance_date" value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <!-- Camera & Geo-Tagging Section -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 pt-8 border-t border-gray-50">
                    <div class="lg:col-span-7 space-y-4">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Live Camera Verification') }}</label>
                        <div class="relative bg-gray-900 rounded-[2.5rem] overflow-hidden aspect-[4/3] md:aspect-video shadow-2xl border-8 border-white ring-1 ring-gray-100">
                            <video id="video" class="w-full h-full object-cover scale-x-[-1]" autoplay playsinline></video>
                            <canvas id="canvas" class="hidden"></canvas>
                            
                            <div id="cameraFeedback" class="absolute inset-0 flex items-center justify-center bg-gray-900/90 text-white transition-opacity duration-500">
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                                        <i class="fa-solid fa-camera text-2xl"></i>
                                    </div>
                                    <p class="text-xs font-black uppercase tracking-widest opacity-60">{{ __('Initializing Camera...') }}</p>
                                </div>
                            </div>

                            <!-- GPS Overlay -->
                            <div class="absolute bottom-6 left-6 right-6 bg-gray-900/40 backdrop-blur-xl rounded-2xl p-4 text-white border border-white/20 shadow-2xl">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest">
                                        <i class="fa-solid fa-satellite-dish text-indigo-400 animate-pulse"></i> 
                                        {{ __('GPS Signal') }}
                                    </span>
                                    <span id="gpsStatus" class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded bg-amber-500/20 text-amber-400">
                                        {{ __('Searching...') }}
                                    </span>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <p class="text-[8px] font-black text-white/40 uppercase tracking-widest">{{ __('Latitude') }}</p>
                                        <p id="displayLat" class="text-xs font-mono font-bold">--.------</p>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="text-[8px] font-black text-white/40 uppercase tracking-widest">{{ __('Longitude') }}</p>
                                        <p id="displayLng" class="text-xs font-mono font-bold">--.------</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="button" onclick="startCamera()" class="flex-1 py-4 bg-gray-100 hover:bg-gray-200 text-gray-500 text-[10px] font-black uppercase tracking-widest rounded-2xl transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-rotate"></i> {{ __('Restart Camera') }}
                            </button>
                            <button type="button" id="captureBtn" onclick="captureAndMark()" class="flex-[2] py-4 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-indigo-100 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-camera-retro"></i> {{ __('Capture & Mark Attendance') }}
                            </button>
                        </div>
                    </div>

                    <div class="lg:col-span-5 space-y-8">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Detailed Notes') }}</label>
                            <textarea name="notes" rows="5" placeholder="{{ __('Any remarks about the worker\'s performance or site conditions today...') }}"
                                class="w-full rounded-3xl border-transparent bg-gray-50/50 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all p-6 text-sm font-medium outline-none"></textarea>
                        </div>
                        
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Overtime') }} ({{ __('Hours') }})</label>
                            <div class="relative group">
                                <i class="fa-solid fa-clock absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-indigo-600 transition-colors"></i>
                                <input type="number" name="overtime_hours" step="0.5" value="0" min="0" max="12"
                                    class="w-full pl-12 pr-6 py-4 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none">
                            </div>
                        </div>

                        <!-- Info Alert -->
                        <div class="p-6 bg-indigo-50 rounded-3xl border border-indigo-100 space-y-2">
                            <div class="flex items-center gap-2 text-indigo-600">
                                <i class="fa-solid fa-circle-info"></i>
                                <span class="text-[10px] font-black uppercase tracking-widest">{{ __('Important Note') }}</span>
                            </div>
                            <p class="text-xs text-indigo-900/60 font-medium leading-relaxed">
                                {{ __('Attendance requires both a live photo and active GPS coordinates for verification. Please ensure you are at the project site.') }}
                            </p>
                        </div>
                        
                        <!-- Hidden Fields -->
                        <input type="hidden" name="latitude" id="lat">
                        <input type="hidden" name="longitude" id="lng">
                        <input type="hidden" name="location_address" id="address">
                        <input type="hidden" name="captured_image" id="captured_image">
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const capturedInput = document.getElementById('captured_image');
        const cameraFeedback = document.getElementById('cameraFeedback');
        
        // Start Camera
        async function startCamera() {
            try {
                cameraFeedback.classList.remove('hidden');
                cameraFeedback.style.opacity = '1';
                
                const stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { facingMode: "environment" }, 
                    audio: false 
                });
                video.srcObject = stream;
                cameraFeedback.style.opacity = '0';
                setTimeout(() => cameraFeedback.classList.add('hidden'), 500);
            } catch (err) {
                console.error("Camera Error:", err);
                cameraFeedback.innerHTML = `<div class='text-red-400 p-6'><i class='fa-solid fa-circle-exclamation text-3xl mb-3'></i><p class='text-[10px] font-black uppercase tracking-widest'>{{ __('Camera Access Denied') }}</p></div>`;
            }
        }

        // Start GPS Tracking
        function watchLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(
                    (pos) => {
                        document.getElementById('lat').value = pos.coords.latitude;
                        document.getElementById('lng').value = pos.coords.longitude;
                        document.getElementById('displayLat').textContent = pos.coords.latitude.toFixed(6);
                        document.getElementById('displayLng').textContent = pos.coords.longitude.toFixed(6);
                        
                        const status = document.getElementById('gpsStatus');
                        status.textContent = "{{ __('Signal Active') }}";
                        status.classList.remove('bg-amber-500/20', 'text-amber-400');
                        status.classList.add('bg-emerald-500/20', 'text-emerald-400');
                    },
                    (err) => {
                        const status = document.getElementById('gpsStatus');
                        status.textContent = "{{ __('GPS Error') }}";
                        status.classList.replace('text-amber-400', 'text-red-400');
                    },
                    { enableHighAccuracy: true }
                );
            }
        }

        async function captureAndMark() {
            const btn = document.getElementById('captureBtn');
            const lat = document.getElementById('lat').value;

            if (!lat) {
                Swal.fire({
                    icon: 'warning',
                    title: "{{ __('Waiting for GPS') }}",
                    text: "{{ __('Please wait for a valid GPS signal before marking attendance.') }}",
                    confirmButtonText: "{{ __('Got it') }}",
                    customClass: { confirmButton: 'bg-indigo-600 px-6 py-3 rounded-xl text-white font-bold' }
                });
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner animate-spin"></i> {{ __('Processing...') }}';

            // Snap photo
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            
            // Convert to base64
            const imageData = canvas.toDataURL('image/jpeg', 0.8);
            capturedInput.value = imageData;

            // Submit form
            document.getElementById('attendanceForm').submit();
        }

        // Initialize
        $(document).ready(function() {
            startCamera();
            watchLocation();
            
            $('.select2-init').select2({
                placeholder: '{{ __('Search and select...') }}',
                width: '100%'
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
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 54px;
        }
    </style>
    @endpush
</x-contractor-layout>
