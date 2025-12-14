<x-admin.app>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Permissions</h2>
            <p class="text-slate-500 text-sm">Manage all system permissions</p>
        </div>

        <a href="{{ route('admin.permissions.create') }}"
            class="inline-flex items-center gap-2 bg-primary hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-md shadow-teal-100 transition-all transform hover:-translate-y-0.5">
            <i class="fa-solid fa-plus"></i> Add Permission
        </a>
    </div>

    {{-- TOAST ALERTS (Fixed Position) --}}
    @if (session('success') || session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            class="fixed top-5 right-5 z-[60] flex w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-lg border border-slate-100">

            <div class="flex items-center justify-center w-12 {{ session('success') ? 'bg-green-500' : 'bg-red-500' }}">
                <i class="fa-solid {{ session('success') ? 'fa-check' : 'fa-triangle-exclamation' }} text-white"></i>
            </div>

            <div class="px-4 py-3 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold {{ session('success') ? 'text-green-500' : 'text-red-500' }}">
                        {{ session('success') ? 'Success' : 'Error' }}
                    </span>
                    <p class="text-sm text-gray-600">{{ session('success') ?? session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- PERMISSIONS TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 border-b border-slate-200 text-xs font-semibold uppercase text-slate-500 tracking-wider">
                        <th class="px-6 py-4 w-16 text-center">#</th>
                        <th class="px-6 py-4">Permission Name</th>
                        <th class="px-6 py-4 text-right w-40">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($permissions as $index => $perm)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4 text-center font-mono text-slate-400">{{ $index + 1 }}</td>

                            <td class="px-6 py-4">
                                <span
                                    class="font-bold text-slate-700 font-mono text-xs bg-slate-100 px-2 py-1 rounded border border-slate-200">
                                    {{ $perm->name }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div
                                    class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.permissions.edit', $perm->id) }}"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 transition-all shadow-sm"
                                        title="Edit Permission">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.permissions.destroy', $perm->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this permission?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-red-600 hover:bg-red-50 border border-transparent hover:border-red-100 transition-all shadow-sm"
                                            title="Delete Permission">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-16 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div
                                        class="w-14 h-14 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                        <i class="fa-solid fa-key text-3xl text-slate-300"></i>
                                    </div>
                                    <p class="font-medium text-slate-600">No permissions found</p>
                                    <p class="text-xs mt-1">Start by adding a new permission.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin.app>
