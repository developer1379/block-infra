<x-admin-layout>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Role</h2>
            <p class="text-slate-500 text-sm">Update role name or change permissions</p>
        </div>

        <a href="{{ route('admin.roles.index') }}"
            class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 max-w-4xl">
        <div class="border-b border-gray-100 px-6 py-4">
            <h3 class="font-bold text-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-user-shield text-primary"></i> Update Role
            </h3>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Role Name --}}
                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">
                        Role Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $role->name) }}"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                        required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Permissions --}}
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-3">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide">
                            Permissions
                        </label>

                        {{-- Select All Checkbox --}}
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="checkAllPermissions"
                                class="w-4 h-4 text-primary border-slate-300 rounded focus:ring-primary">
                            <span class="ml-2 text-xs font-bold text-primary">Select All</span>
                        </label>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach ($permissions as $perm)
                                <label
                                    class="flex items-center p-3 bg-white rounded-lg border border-slate-200 cursor-pointer hover:border-primary/50 hover:bg-primary/5 transition-all group">
                                    <input type="checkbox" name="permissions[]" value="{{ $perm->id }}"
                                        class="permission-checkbox w-4 h-4 text-primary border-slate-300 rounded focus:ring-primary focus:ring-offset-0"
                                        {{ in_array($perm->id, $assigned) ? 'checked' : '' }}>
                                    <span
                                        class="ml-2 text-sm text-slate-700 font-medium group-hover:text-primary transition-colors">
                                        {{ $perm->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @error('permissions')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end pt-6 border-t border-slate-100">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-primary hover:bg-teal-700 text-white text-sm font-bold px-6 py-2.5 rounded-lg shadow-md shadow-teal-100 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-save"></i> Update Role
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- SCRIPT FOR SELECT ALL --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkAll = document.getElementById('checkAllPermissions');
                const checkboxes = document.querySelectorAll('.permission-checkbox');

                // Initial Check: If all individual boxes are checked, check "Select All"
                const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                checkAll.checked = allChecked;

                // Handle "Select All" Click
                checkAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                });

                // Handle Individual Click -> Update "Select All"
                checkboxes.forEach(cb => {
                    cb.addEventListener('change', function() {
                        checkAll.checked = Array.from(checkboxes).every(c => c.checked);
                    });
                });
            });
        </script>
    @endpush

</x-admin-layout>

