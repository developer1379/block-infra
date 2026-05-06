<x-contractor-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('contractor.attendance.index') }}" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors mb-4">
                    <i class="bi bi-arrow-left mr-2"></i> Back to History
                </a>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Mark Attendance</h1>
                <p class="text-gray-500 mt-1">Record worker attendance with real-time GPS location.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <form action="{{ route('contractor.attendance.store') }}" method="POST" enctype="multipart/form-data" id="attendanceForm" class="p-8 space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Project Selection -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Project</label>
                            <select name="project_id" required class="select2 w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all py-3 px-4">
                                <option value="">Select Project Site</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Attendance Date</label>
                            <div class="relative">
                                <input type="date" name="attendance_date" required value="{{ date('Y-m-d') }}" readonly
                                    class="w-full rounded-2xl border-gray-200 bg-gray-100 cursor-not-allowed focus:ring-0 transition-all py-3 px-4 text-gray-500 font-semibold">
                                <span class="absolute right-4 top-3.5 text-[10px] font-black text-indigo-500 uppercase tracking-tighter bg-indigo-50 px-2 py-0.5 rounded-lg border border-indigo-100">Today Only</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Worker Selection -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Worker</label>
                            <select name="worker_id" required class="select2 w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all py-3 px-4">
                                <option value="">Select Worker</option>
                                @foreach($workers as $worker)
                                    <option value="{{ $worker->id }}">{{ $worker->name }} ({{ $worker->specialization }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Status</label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="cursor-pointer">
                                    <input type="radio" name="status" value="present" checked class="peer sr-only">
                                    <div class="flex items-center justify-center p-3 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-500 peer-checked:bg-green-50 peer-checked:border-green-500 peer-checked:text-green-700 transition-all">
                                        Present
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="status" value="half_day" class="peer sr-only">
                                    <div class="flex items-center justify-center p-3 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-500 peer-checked:bg-amber-50 peer-checked:border-amber-500 peer-checked:text-amber-700 transition-all">
                                        Half Day
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Camera & Geo-Tagging Integrated Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Live Camera Verification</label>
                            <div class="relative bg-black rounded-3xl overflow-hidden aspect-video shadow-inner border-4 border-white ring-1 ring-gray-200">
                                <video id="video" class="w-full h-full object-cover" autoplay playsinline></video>
                                <canvas id="canvas" class="hidden"></canvas>
                                
                                <div id="cameraFeedback" class="absolute inset-0 flex items-center justify-center bg-black/60 text-white text-xs font-bold transition-opacity duration-300">
                                    <div class="text-center">
                                        <i class="bi bi-camera text-3xl mb-2 animate-pulse"></i>
                                        <p>Initializing Camera...</p>
                                    </div>
                                </div>

                                <!-- GPS Overlay -->
                                <div class="absolute bottom-4 left-4 right-4 bg-black/40 backdrop-blur-md rounded-xl p-3 text-[10px] text-white border border-white/20">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="flex items-center gap-1"><i class="bi bi-geo-alt-fill text-red-400"></i> GPS TRACKING</span>
                                        <span id="gpsStatus" class="text-amber-400">WAITING FOR SIGNAL...</span>
                                    </div>
                                    <div class="flex gap-3 font-mono opacity-80">
                                        <span>LAT: <span id="displayLat">--</span></span>
                                        <span>LNG: <span id="displayLng">--</span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button type="button" onclick="startCamera()" class="flex-1 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                                    <i class="bi bi-arrow-clockwise"></i> Restart Camera
                                </button>
                                <button type="button" id="captureBtn" onclick="captureAndMark()" class="flex-[2] py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-lg transition-all transform hover:scale-[1.02] flex items-center justify-center gap-2">
                                    <i class="bi bi-camera-fill"></i> Capture & Mark Attendance
                                </button>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Detailed Notes</label>
                                <textarea name="notes" rows="4" placeholder="Any remarks about the worker's performance or site conditions today..."
                                    class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all p-4 text-sm"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Overtime (Hours)</label>
                                <input type="number" name="overtime_hours" step="0.5" value="0" min="0" max="12"
                                    class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 transition-all py-3 px-4">
                            </div>
                            
                            <!-- Hidden Fields for Internal Submission -->
                            <input type="hidden" name="latitude" id="lat">
                            <input type="hidden" name="longitude" id="lng">
                            <input type="hidden" name="location_address" id="address">
                            <input type="hidden" name="captured_image" id="captured_image">
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100 hidden">
                        <button type="submit" id="submitBtn">Submit</button>
                    </div>
                </form>
            </div>
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
                const stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { facingMode: "environment" }, // Prefer back camera
                    audio: false 
                });
                video.srcObject = stream;
                cameraFeedback.style.opacity = '0';
                setTimeout(() => cameraFeedback.classList.add('hidden'), 300);
            } catch (err) {
                console.error("Camera Error:", err);
                cameraFeedback.innerHTML = `<div class='text-red-400'><i class='bi bi-exclamation-triangle text-2xl'></i><p>Camera Permission Denied</p></div>`;
            }
        }

        // Start GPS Tracking
        function watchLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(
                    (pos) => {
                        document.getElementById('lat').value = pos.coords.latitude;
                        document.getElementById('lng').value = pos.coords.longitude;
                        document.getElementById('displayLat').textContent = pos.coords.latitude.toFixed(4);
                        document.getElementById('displayLng').textContent = pos.coords.longitude.toFixed(4);
                        document.getElementById('gpsStatus').textContent = "SIGNAL ACTIVE";
                        document.getElementById('gpsStatus').classList.replace('text-amber-400', 'text-green-400');
                    },
                    (err) => {
                        document.getElementById('gpsStatus').textContent = "GPS ERROR: " + err.message;
                        document.getElementById('gpsStatus').classList.add('text-red-400');
                    },
                    { enableHighAccuracy: true }
                );
            }
        }

        async function captureAndMark() {
            const btn = document.getElementById('captureBtn');
            const lat = document.getElementById('lat').value;

            if (!lat) {
                alert("Please wait for GPS signal before marking attendance.");
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-hourglass-split animate-spin"></i> Processing...';

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
        window.onload = () => {
            startCamera();
            watchLocation();
            
            // Initialize Select2
            $('.select2').select2({
                placeholder: 'Search and select...',
                width: '100%'
            });
        };
    </script>
    @endpush
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function getLocation() {
            const status = document.getElementById('locationStatus');
            const btn = document.getElementById('locationBtn');
            const latInput = document.getElementById('lat');
            const lngInput = document.getElementById('lng');
            const addrInput = document.getElementById('address');

            if (!navigator.geolocation) {
                status.textContent = "Geolocation is not supported by your browser";
                return;
            }

            status.textContent = "Locating...";
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin"></i> Locating...';

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    latInput.value = lat.toFixed(6);
                    lngInput.value = lng.toFixed(6);
                    
                    status.textContent = "Location captured successfully!";
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-check-lg"></i> Captured';
                    btn.classList.replace('bg-indigo-600', 'bg-green-600');

                    // Optional: Reverse Geocoding (simple)
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.display_name) {
                                addrInput.value = data.display_name;
                            }
                        })
                        .catch(err => console.log("Geocoding error:", err));
                },
                (error) => {
                    status.textContent = `Error: ${error.message}`;
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Try Again';
                },
                { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
            );
        }
    </script>
    @endpush
</x-contractor-layout>
