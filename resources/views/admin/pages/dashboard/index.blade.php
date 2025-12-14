<x-admin.app>
    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Dashboard Overview</h2>
                <p class="text-slate-500 text-sm">Welcome back, <strong
                        class="text-slate-800">{{ Auth::user()->name ?? 'Admin' }}</strong> 👋</p>
            </div>

            {{-- Optional Date Filter Button for UI polish --}}
            <button
                class="flex items-center gap-2 bg-white border border-gray-200 px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-primary hover:border-primary transition-colors shadow-sm">
                <i class="fa-regular fa-calendar"></i>
                <span>This Month</span>
                <i class="fa-solid fa-chevron-down text-xs ml-1"></i>
            </button>
        </div>

        {{-- STATS CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            @php
                $stats = [
                    [
                        'title' => 'Active Projects',
                        'value' => '24',
                        'icon' => 'fa-solid fa-building',
                        'bg_color' => 'bg-emerald-50',
                        'text_color' => 'text-emerald-600',
                    ],
                    [
                        'title' => 'Contractors',
                        'value' => '82',
                        'icon' => 'fa-solid fa-user-tie',
                        'bg_color' => 'bg-blue-50',
                        'text_color' => 'text-blue-600',
                    ],
                    [
                        'title' => 'Clients',
                        'value' => '142',
                        'icon' => 'fa-solid fa-users',
                        'bg_color' => 'bg-indigo-50',
                        'text_color' => 'text-indigo-600',
                    ],
                    [
                        'title' => 'Pending Invoices',
                        'value' => '12',
                        'icon' => 'fa-solid fa-file-invoice-dollar',
                        'bg_color' => 'bg-rose-50',
                        'text_color' => 'text-rose-600',
                    ],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div
                    class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                                {{ $stat['title'] }}</p>
                            <h3 class="text-3xl font-bold text-slate-800">{{ $stat['value'] }}</h3>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl flex items-center justify-center {{ $stat['bg_color'] }} {{ $stat['text_color'] }}">
                            <i class="{{ $stat['icon'] }} text-xl"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- CHARTS + QUICK STATS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Chart Section --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex justify-between items-center mb-6 border-b border-gray-50 pb-4">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-chart-column text-primary"></i>
                        Project Progress
                    </h3>
                    <button class="text-slate-400 hover:text-primary"><i class="fa-solid fa-ellipsis"></i></button>
                </div>
                <div class="relative h-72 w-full">
                    <canvas id="projectChart"></canvas>
                </div>
            </div>

            {{-- Quick Stats List --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex justify-between items-center mb-6 border-b border-gray-50 pb-4">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-gauge-high text-primary"></i>
                        Quick Stats
                    </h3>
                </div>

                <div class="space-y-4">
                    <div
                        class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors group">
                        <span class="text-sm font-medium text-slate-600 group-hover:text-slate-800">Completed
                            Projects</span>
                        <span
                            class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold shadow-sm">18</span>
                    </div>

                    <div
                        class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors group">
                        <span class="text-sm font-medium text-slate-600 group-hover:text-slate-800">Ongoing
                            Projects</span>
                        <span
                            class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold shadow-sm">6</span>
                    </div>

                    <div
                        class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors group">
                        <span class="text-sm font-medium text-slate-600 group-hover:text-slate-800">Total Staff</span>
                        <span
                            class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold shadow-sm">56</span>
                    </div>

                    <div
                        class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors group">
                        <span class="text-sm font-medium text-slate-600 group-hover:text-slate-800">New Leads</span>
                        <span
                            class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold shadow-sm">12</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- RECENT ACTIVITY TABLE --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-primary"></i>
                    Recent Activities
                </h3>
                <a href="#" class="text-xs font-semibold text-primary hover:underline">View All</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-slate-500 uppercase border-b border-gray-200 bg-gray-50">
                            <th class="px-6 py-4">#</th>
                            <th class="px-6 py-4">Activity</th>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        {{-- Row 1 --}}
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-bold text-slate-700">1</td>
                            <td class="px-6 py-4 text-sm text-slate-700 font-medium">Project “Metro Line Extension”
                                updated</td>
                            <td class="px-6 py-4 text-sm text-slate-500">Arvind Verma</td>
                            <td class="px-6 py-4 text-sm text-slate-500">Nov 5, 2025</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                    Completed
                                </span>
                            </td>
                        </tr>
                        {{-- Row 2 --}}
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-bold text-slate-700">2</td>
                            <td class="px-6 py-4 text-sm text-slate-700 font-medium">New contractor registration
                                approved</td>
                            <td class="px-6 py-4 text-sm text-slate-500">Admin</td>
                            <td class="px-6 py-4 text-sm text-slate-500">Nov 4, 2025</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-sky-100 text-sky-800">
                                    Approved
                                </span>
                            </td>
                        </tr>
                        {{-- Row 3 --}}
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-bold text-slate-700">3</td>
                            <td class="px-6 py-4 text-sm text-slate-700 font-medium">Payment request generated #BLC-233
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">Finance Dept.</td>
                            <td class="px-6 py-4 text-sm text-slate-500">Nov 3, 2025</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                                    Pending
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- JS --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const ctx = document.getElementById('projectChart');

            // Global Chart Defaults for better font
            Chart.defaults.font.family = "'Poppins', sans-serif";
            Chart.defaults.color = '#64748b';

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    datasets: [{
                        label: 'Projects Completed',
                        data: [3, 5, 8, 10, 9, 13, 15],
                        // Updated to match the Primary Teal Color (#0f766e)
                        backgroundColor: '#0f766e',
                        hoverBackgroundColor: '#115e59',
                        borderRadius: 8,
                        barThickness: 24,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#fff',
                            bodyColor: '#cbd5e1',
                            padding: 10,
                            cornerRadius: 8,
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9',
                                borderDash: [4, 4]
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            },
                            border: {
                                display: false
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-admin.app>
