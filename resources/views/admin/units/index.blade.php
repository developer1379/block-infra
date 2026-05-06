<x-admin-layout>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Units</h2>
            <p class="text-slate-500 text-sm">Manage measurement units used in works</p>
        </div>

        <a href="{{ route('admin.units.create') }}"
            class="inline-flex items-center gap-2 bg-primary hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-sm shadow-teal-100 transition-all transform hover:-translate-y-0.5">
            <i class="fa-solid fa-plus"></i> Add Unit
        </a>
    </div>

    {{-- ALERTS (Success/Error) --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            class="fixed top-5 right-5 z-[60] bg-lime-500 text-white px-6 py-4 rounded-xl shadow-lg flex items-center gap-3 transition-all duration-500">
            <div class="bg-white/20 w-8 h-8 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-check"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm">Success!</h4>
                <p class="text-xs text-white/90">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="ml-4 text-white/60 hover:text-white"><i
                    class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show"
            class="fixed top-5 right-5 z-[60] bg-red-500 text-white px-6 py-4 rounded-xl shadow-lg flex items-center gap-3">
            <div class="bg-white/20 w-8 h-8 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm">Error!</h4>
                <p class="text-xs text-white/90">{{ session('error') }}</p>
            </div>
            <button @click="show = false" class="ml-4 text-white/60 hover:text-white"><i
                    class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    {{-- UNITS TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 border-b border-gray-200 text-xs font-semibold uppercase text-slate-500 tracking-wider">
                        <th class="px-6 py-4 w-16 text-center">#</th>
                        <th class="px-6 py-4">Unit Name</th>
                        <th class="px-6 py-4">Symbol</th>
                        <th class="px-6 py-4">Description</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center w-32">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($units as $key => $unit)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4 text-center text-slate-500 font-medium">{{ $key + 1 }}</td>

                            <td class="px-6 py-4 font-semibold text-slate-800 text-sm">{{ $unit->name }}</td>

                            <td class="px-6 py-4">
                                <span
                                    class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs font-mono border border-slate-200">
                                    {{ $unit->symbol }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-500 truncate max-w-xs">
                                {{ $unit->description ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($unit->is_active)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-lime-100 text-lime-700 border border-lime-200">
                                        Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-500 border border-gray-200">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div
                                    class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.units.edit', $unit->id) }}"
                                        class="w-8 h-8 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-50 transition-colors border border-transparent hover:border-blue-100">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>

                                    <form action="{{ route('admin.units.destroy', $unit->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this unit?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 rounded-lg flex items-center justify-center text-red-600 hover:bg-red-50 transition-colors border border-transparent hover:border-red-100">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                        <i class="fa-solid fa-ruler-combined text-3xl text-slate-300"></i>
                                    </div>
                                    <p class="font-medium text-slate-600">No units found</p>
                                    <p class="text-sm mt-1">Get started by adding a new unit above.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>

