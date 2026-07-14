<x-admin-layout>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Email Settings</h2>
            <p class="text-slate-500 text-sm">Configure outbound SMTP mail server settings</p>
        </div>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-4xl">
        <div class="border-b border-gray-100 px-6 py-4">
            <h3 class="font-bold text-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-envelope-open-text text-primary"></i> SMTP Credentials & Sender Info
            </h3>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Mailer --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                                Mailer Driver <span class="text-red-500">*</span>
                            </label>
                            <select name="mail_mailer" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" required>
                                <option value="smtp" {{ ($settings['mail_mailer'] ?? 'smtp') === 'smtp' ? 'selected' : '' }}>SMTP</option>
                                <option value="sendmail" {{ ($settings['mail_mailer'] ?? '') === 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                <option value="log" {{ ($settings['mail_mailer'] ?? '') === 'log' ? 'selected' : '' }}>Log (Testing)</option>
                            </select>
                        </div>

                        {{-- Host --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                                Mail Host <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="mail_host" value="{{ old('mail_host', $settings['mail_host'] ?? '') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                   placeholder="e.g. smtp.hostinger.com" required>
                        </div>

                        {{-- Port --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                                Mail Port <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="mail_port" value="{{ old('mail_port', $settings['mail_port'] ?? '') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                   placeholder="e.g. 465" required>
                        </div>

                        {{-- Encryption --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                                Mail Encryption
                            </label>
                            <select name="mail_encryption" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                                <option value="" {{ empty($settings['mail_encryption']) ? 'selected' : '' }}>None</option>
                                <option value="ssl" {{ ($settings['mail_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL (Recommended for Port 465)</option>
                                <option value="tls" {{ ($settings['mail_encryption'] ?? '') === 'tls' ? 'selected' : '' }}>TLS (Recommended for Port 587)</option>
                            </select>
                        </div>

                        {{-- Username --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                                Mail Username <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="mail_username" value="{{ old('mail_username', $settings['mail_username'] ?? '') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                   placeholder="e.g. hr@rawsio.com" required>
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                                Mail Password <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="mail_password" value="{{ old('mail_password', $settings['mail_password'] ?? '') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                   placeholder="SMTP Password" required>
                        </div>

                        {{-- From Address --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                                Mail From Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="mail_from_address" value="{{ old('mail_from_address', $settings['mail_from_address'] ?? '') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                   placeholder="e.g. hr@rawsio.com" required>
                        </div>

                        {{-- From Name --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                                Mail From Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="mail_from_name" value="{{ old('mail_from_name', $settings['mail_from_name'] ?? '') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                   placeholder="e.g. Rawsio.com" required>
                        </div>
                    </div>

                </div>

                {{-- ImgBB Settings --}}
                <div class="mt-8 pt-6 border-t border-slate-100 space-y-4">
                    <h4 class="font-bold text-slate-700 flex items-center gap-2">
                        <i class="fa-solid fa-image text-primary"></i> Third-Party Image Hosting (ImgBB)
                    </h4>
                    <p class="text-xs text-slate-400">Configure ImgBB API settings to upload blog featured images directly to the cloud rather than local disk storage.</p>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                            ImgBB API Key
                        </label>
                        <input type="text" name="imgbb_api_key" value="{{ old('imgbb_api_key', $settings['imgbb_api_key'] ?? '') }}"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                               placeholder="Enter your ImgBB API key">
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end pt-6 mt-6 border-t border-slate-100">
                    <button type="submit"
                            class="px-6 py-2.5 rounded-lg text-sm font-bold text-white bg-primary hover:bg-teal-700 shadow-md shadow-teal-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-check mr-2"></i> Save Settings
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- SYNC IMAGES CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-4xl mt-6">
        <div class="border-b border-gray-100 px-6 py-4">
            <h3 class="font-bold text-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-arrows-rotate text-primary"></i> Sync Images to Cloud
            </h3>
        </div>

        <div class="p-6 md:p-8">
            <p class="text-sm text-slate-500 mb-6">
                This utility scans the database for any locally stored images and Base64 strings (such as contractor profile pictures, daily site photos, attendance verification photos, feedback screenshots, progress logs, etc.), converts them to WebP format, uploads them to ImgBB, and updates the database records automatically.
            </p>

            <div class="flex justify-start">
                <button type="button" id="btnStartSync"
                        class="px-6 py-2.5 rounded-lg text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-md shadow-indigo-100 transition-all transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Sync Legacy Images to ImgBB
                </button>
            </div>

            {{-- Progress Bar --}}
            <div id="syncProgressContainer" class="hidden mt-8 border-t border-slate-100 pt-6">
                <div class="flex justify-between items-center mb-2">
                    <span id="syncProgressText" class="text-xs font-bold text-slate-600 uppercase tracking-wide">Syncing: 0 / 0 images (0%)</span>
                    <span id="syncProgressPercent" class="text-xs font-bold text-indigo-600">0%</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                    <div id="syncProgressBar" class="bg-indigo-600 h-full rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            {{-- Logs --}}
            <div id="syncLogContainer" class="hidden mt-6">
                <h5 class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-2 flex items-center gap-1">
                    <i class="fa-solid fa-list-ul"></i> Sync Logs
                </h5>
                <div id="syncLogs" class="bg-slate-900 text-slate-300 font-mono text-[10px] p-4 rounded-xl max-h-60 overflow-y-auto space-y-1.5 scrollbar-thin">
                    <!-- Logs will be populated dynamically -->
                </div>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('btnStartSync').addEventListener('click', function(e) {
        e.preventDefault();
        if (!confirm('Are you sure you want to sync all legacy images? This process will scan the database and upload local images/Base64 strings to ImgBB.')) {
            return;
        }
        
        const btn = this;
        const progressContainer = document.getElementById('syncProgressContainer');
        const progressBar = document.getElementById('syncProgressBar');
        const progressText = document.getElementById('syncProgressText');
        const progressPercent = document.getElementById('syncProgressPercent');
        const logContainer = document.getElementById('syncLogContainer');
        const logsDiv = document.getElementById('syncLogs');
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Scanning...';
        
        logsDiv.innerHTML = '';
        progressBar.style.width = '0%';
        progressPercent.innerText = '0%';
        progressText.innerText = 'Syncing: 0 / 0 images (0%)';
        
        progressContainer.classList.remove('hidden');
        logContainer.classList.remove('hidden');
        
        function log(message, type = 'info') {
            const p = document.createElement('p');
            const time = new Date().toLocaleTimeString();
            let color = 'text-slate-300';
            if (type === 'success') color = 'text-emerald-400 font-bold';
            if (type === 'error') color = 'text-rose-400 font-bold';
            p.className = `leading-relaxed ${color}`;
            p.innerHTML = `[${time}] ${message}`;
            logsDiv.appendChild(p);
            logsDiv.scrollTop = logsDiv.scrollHeight;
        }
        
        log('Scanning database for local images and Base64 strings...');
        
        fetch('{{ route("admin.settings.sync-images.scan") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            if (status !== 200 || !body.success) {
                throw new Error(body.message || 'Scanning failed.');
            }
            
            const total = body.total;
            const items = body.items;
            
            log(`Scan complete. Found ${total} images/items to sync.`, total > 0 ? 'info' : 'success');
            
            if (total === 0) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-cloud-arrow-up mr-2"></i> Sync Legacy Images to ImgBB';
                return;
            }
            
            let processed = 0;
            
            function processNext() {
                if (items.length === 0) {
                    log('All images have been successfully processed and synced!', 'success');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-check mr-2"></i> Sync Completed';
                    return;
                }
                
                const item = items.shift();
                log(`Syncing ${item.type} #${item.id}...`);
                
                fetch('{{ route("admin.settings.sync-images.item") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ type: item.type, id: item.id })
                })
                .then(res => res.json().then(data => ({ ok: res.ok, body: data })))
                .then(({ ok, body }) => {
                    processed++;
                    const percent = Math.round((processed / total) * 100);
                    progressBar.style.width = percent + '%';
                    progressPercent.innerText = percent + '%';
                    progressText.innerText = `Syncing: ${processed} / ${total} images (${percent}%)`;
                    
                    if (ok && body.success) {
                        log(body.message, 'success');
                    } else {
                        log(body.message || 'Sync failed.', 'error');
                    }
                    
                    // Process next item
                    processNext();
                })
                .catch(err => {
                    processed++;
                    const percent = Math.round((processed / total) * 100);
                    progressBar.style.width = percent + '%';
                    progressPercent.innerText = percent + '%';
                    progressText.innerText = `Syncing: ${processed} / ${total} images (${percent}%)`;
                    
                    log(`Failed to sync ${item.type} #${item.id}: ${err.message}`, 'error');
                    
                    // Process next item
                    processNext();
                });
            }
            
            // Start processing queue
            processNext();
        })
        .catch(error => {
            log(`Error: ${error.message}`, 'error');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-cloud-arrow-up mr-2"></i> Try Sync Again';
        });
    });
    </script>

</x-admin-layout>
