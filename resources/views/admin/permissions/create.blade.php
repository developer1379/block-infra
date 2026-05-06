<x-admin-layout>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Add Permission</h2>
            <p class="text-slate-500 text-sm">Create a new system permission</p>
        </div>

        <a href="{{ route('admin.permissions.index') }}"
            class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-4xl">
        <div class="border-b border-gray-100 px-6 py-4">
            <h3 class="font-bold text-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-key text-primary"></i> Permission Details
            </h3>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('admin.permissions.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                        Permission Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                        placeholder="e.g. create_post, edit_user, delete_project" required>

                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <p class="text-xs text-slate-400 mt-2">
                        <i class="fa-solid fa-circle-info mr-1"></i>
                        Use lowercase letters and underscores (e.g., <code>view_dashboard</code>).
                    </p>
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end pt-6 border-t border-slate-100">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-primary hover:bg-teal-700 text-white text-sm font-bold px-6 py-2.5 rounded-lg shadow-md shadow-teal-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-save"></i> Save Permission
                    </button>
                </div>

            </form>
        </div>
    </div>

</x-admin-layout>

