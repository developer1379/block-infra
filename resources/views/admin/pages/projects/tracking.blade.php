<x-admin.app>
    {{-- No custom CSS push required, handled by Tailwind utilities --}}

    <div class="p-6">
        <div class="w-full max-w-7xl mx-auto">

            <div class="py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex-grow">
                    <h4 class="text-lg font-semibold text-gray-800 m-0">Project Tracking</h4>
                    <p class="text-gray-500 text-sm mb-0">Manage milestones and view progress for:
                        <strong>{{ $project->title }}</strong>
                    </p>
                </div>
                <div class="text-right">
                    <a href="{{ route('admin.projects.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <i class="bi bi-arrow-left mr-1"></i> Back to Projects
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 h-full">
                    <div class="p-6">
                        <h6 class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-1">Total Budget</h6>
                        <h3 class="text-2xl font-bold text-gray-800 mb-0">
                            ₹{{ number_format($project->award->bid->bid_amount ?? 0, 2) }}</h3>
                        <small class="text-green-600 font-medium">Awarded Amount</small>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 h-full">
                    <div class="p-6">
                        <h6 class="text-gray-400 text-xs uppercase font-bold tracking-wider">Contractor</h6>
                        <div class="flex items-center mt-3">
                            @if ($project->award->awardedTo->profile_photo_path)
                                <img src="{{ asset('storage/' . $project->award->awardedTo->profile_photo_path) }}"
                                    class="h-10 w-10 rounded-full object-cover mr-3">
                            @else
                                <div
                                    class="h-10 w-10 rounded-full bg-gray-500 text-white flex items-center justify-center mr-3 text-sm font-bold">
                                    {{ substr($project->award->awardedTo->name ?? 'U', 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <h6 class="text-sm font-semibold text-gray-800 mb-0">
                                    {{ $project->award->awardedTo->name ?? 'Unknown' }}</h6>
                                <small
                                    class="text-gray-500 text-xs">{{ $project->award->awardedTo->email ?? '' }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 h-full">
                    <div class="p-6">
                        <h6 class="text-gray-400 text-xs uppercase font-bold tracking-wider">Completion Status</h6>
                        <div class="w-full bg-gray-200 rounded-lg h-6 mt-3 overflow-hidden relative">
                            <div class="bg-green-500 h-6 rounded-lg flex items-center justify-center text-xs text-white font-semibold transition-all duration-500"
                                style="width: {{ $project->current_progress }}%;">
                                {{ $project->current_progress }}%
                            </div>
                        </div>
                        <small class="text-gray-500 text-xs mt-2 block">Based on latest contractor report</small>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

                <div class="xl:col-span-7">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white">
                            <h5 class="font-semibold text-lg text-gray-800 mb-0">Project Milestones</h5>
                            <button type="button"
                                class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-700 active:bg-blue-900 focus:outline-none transition ease-in-out duration-150"
                                onclick="document.getElementById('addMilestoneModal').classList.remove('hidden')">
                                <i class="bi bi-plus-lg mr-1"></i> Add Milestone
                            </button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Title</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Due Date</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Amount</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($project->milestones as $milestone)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $milestone->title }}
                                                </div>
                                                @if ($milestone->description)
                                                    <div class="text-xs text-gray-500">
                                                        {{ Str::limit($milestone->description, 40) }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $milestone->due_date ? $milestone->due_date->format('M d, Y') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                ${{ number_format($milestone->amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @switch($milestone->status)
                                                    @case('completed')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Completed</span>
                                                    @break

                                                    @case('paid')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Paid</span>
                                                    @break

                                                    @case('in_progress')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">In
                                                            Progress</span>
                                                    @break

                                                    @default
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Pending</span>
                                                @endswitch
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="relative inline-block text-left group" tabindex="0">
                                                    <button
                                                        class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <div
                                                        class="hidden group-focus-within:block absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                                        <div class="py-1" role="menu">
                                                            <span
                                                                class="block px-4 py-2 text-xs text-gray-400 uppercase font-semibold">Update
                                                                Status</span>

                                                            <form
                                                                action="{{ route('admin.milestones.status', $milestone->id) }}"
                                                                method="POST">
                                                                @csrf @method('PATCH')
                                                                <input type="hidden" name="status" value="completed">
                                                                <button type="submit"
                                                                    class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                                    role="menuitem">Mark Completed</button>
                                                            </form>

                                                            <form
                                                                action="{{ route('admin.milestones.status', $milestone->id) }}"
                                                                method="POST">
                                                                @csrf @method('PATCH')
                                                                <input type="hidden" name="status" value="paid">
                                                                <button type="submit"
                                                                    class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                                    role="menuitem">Mark Paid</button>
                                                            </form>

                                                            <div class="border-t border-gray-100 my-1"></div>

                                                            <form
                                                                action="{{ route('admin.milestones.destroy', $milestone->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Delete milestone?')">
                                                                @csrf @method('DELETE')
                                                                <button type="submit"
                                                                    class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                                                                    role="menuitem">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 text-sm">
                                                    No milestones created yet. Divide the project into chunks to begin
                                                    tracking.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="xl:col-span-5">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 h-full">
                            <div class="px-6 py-4 border-b border-gray-100 bg-white">
                                <h5 class="font-semibold text-lg text-gray-800 mb-0">Progress Reports</h5>
                            </div>
                            <div class="p-6">
                                <div class="relative">
                                    @forelse($project->progressUpdates as $update)
                                        <div class="relative pl-6 pb-6 border-l-2 border-gray-200 last:border-0 last:pb-0">
                                            <div
                                                class="absolute -left-[7px] top-[6px] h-3 w-3 rounded-full bg-blue-600 ring-4 ring-white">
                                            </div>

                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h6 class="font-bold text-gray-800 text-sm mb-1">
                                                        Reached {{ $update->progress_percentage }}% Completion
                                                    </h6>
                                                    <small class="text-gray-500 text-xs flex items-center">
                                                        <i class="bi bi-clock mr-1"></i>
                                                        {{ $update->created_at->format('M d, Y h:i A') }}
                                                    </small>
                                                </div>
                                                @if ($update->report_file_path)
                                                    <a href="{{ asset('storage/' . $update->report_file_path) }}"
                                                        target="_blank"
                                                        class="inline-flex items-center p-1 border border-gray-300 rounded shadow-sm text-gray-500 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                        title="View Attachment">
                                                        <i class="bi bi-paperclip"></i>
                                                    </a>
                                                @endif
                                            </div>

                                            @if ($update->report_description)
                                                <div class="mt-2 p-3 bg-gray-50 rounded-md text-sm text-gray-600">
                                                    {{ $update->report_description }}
                                                </div>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="text-center py-8 text-gray-500">
                                            <i class="bi bi-clipboard-data text-4xl block mb-2 text-gray-300"></i>
                                            <span class="text-sm">No progress reports submitted by the contractor
                                                yet.</span>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="addMilestoneModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title"
                role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                        onclick="document.getElementById('addMilestoneModal').classList.add('hidden')"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                        <form action="{{ route('admin.milestones.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">

                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                            Create New Milestone
                                        </h3>

                                        <div class="mt-4 space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Milestone Title
                                                    <span class="text-red-500">*</span></label>
                                                <input type="text" name="title"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                                    placeholder="e.g. Foundation Work" required>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Amount
                                                        ($)</label>
                                                    <input type="number" step="0.01" name="amount"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                                        placeholder="0.00">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Due Date</label>
                                                    <input type="date" name="due_date"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                                <textarea name="description" rows="3"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                                    placeholder="Details about this phase..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg -blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Save Milestone
                                </button>
                                <button type="button"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                    onclick="document.getElementById('addMilestoneModal').classList.add('hidden')">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </x-admin.app>
