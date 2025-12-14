<x-admin.app>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Roles</h2>
            <p class="text-slate-500 text-sm">Manage system roles and their assigned permissions</p>
        </div>

        <a href="{{ route('admin.roles.create') }}"
            class="inline-flex items-center gap-2 bg-primary hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-md shadow-teal-100 transition-all transform hover:-translate-y-0.5">
            <i class="fa-solid fa-plus"></i> Add New Role
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

    {{-- ROLES TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 border-b border-slate-200 text-xs font-semibold uppercase text-slate-500 tracking-wider">
                        <th class="px-6 py-4 w-16 text-center">#</th>
                        <th class="px-6 py-4 w-48">Role Name</th>
                        <th class="px-6 py-4">Permissions</th>
                        <th class="px-6 py-4 text-right w-40">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @php $count = 1; @endphp
                    @forelse($roles as $role)
                        @if ($role->name !== 'admin')
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="px-6 py-4 text-center font-mono text-slate-400">{{ $count++ }}</td>

                                <td class="px-6 py-4 font-bold text-slate-800">
                                    {{ ucfirst($role->name) }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1.5">
                                        @php
                                            $perms = $role->permissions;
                                            $visiblePerms = $perms->take(4);
                                            $remainingCount = $perms->count() - $visiblePerms->count();
                                        @endphp

                                        @forelse ($visiblePerms as $p)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded bg-slate-100 text-slate-600 border border-slate-200 text-xs font-medium">
                                                {{ $p->name }}
                                            </span>
                                        @empty
                                            <span class="text-slate-400 italic text-xs">No permissions assigned</span>
                                        @endforelse

                                        @if ($remainingCount > 0)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded bg-slate-200 text-slate-700 text-xs font-bold cursor-help"
                                                title="{{ $perms->skip(4)->pluck('name')->join(', ') }}">
                                                +{{ $remainingCount }} more
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        {{-- Edit --}}
                                        <a href="{{ route('admin.roles.edit', $role->id) }}"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 transition-all shadow-sm"
                                            title="Edit Role">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this role?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-red-600 hover:bg-red-50 border border-transparent hover:border-red-100 transition-all shadow-sm"
                                                title="Delete Role">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div
                                        class="w-14 h-14 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                        <i class="fa-solid fa-user-shield text-3xl text-slate-300"></i>
                                    </div>
                                    <p class="font-medium text-slate-600">No roles found</p>
                                    <p class="text-xs mt-1">Get started by creating a new role.</p>
                                    <a href="{{ route('admin.roles.create') }}"
                                        class="mt-4 text-primary text-xs font-bold hover:underline">Create Role</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin.app>
