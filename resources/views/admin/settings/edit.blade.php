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

</x-admin-layout>
