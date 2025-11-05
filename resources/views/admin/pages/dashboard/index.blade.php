<x-admin.app>
    <div class="">

        {{-- HEADER --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 border-bottom pb-2">
            <h4 class="fw-bold text-uppercase mb-0" style="color:#b3d33c;">Bloc Infra Dashboard</h4>
            <p class="text-dark mb-0 small">Welcome, <strong>{{ Auth::user()->name ?? 'Admin' }}</strong> 👋</p>
        </div>

        {{-- STATS CARDS --}}
        <div class="row g-3">
            @php
                $stats = [
                    [
                        'title' => 'Active Projects',
                        'value' => '24',
                        'icon' => 'fa-solid fa-building',
                        'color' => '#b3d33c',
                    ],
                    ['title' => 'Contractors', 'value' => '82', 'icon' => 'fa-solid fa-user-tie', 'color' => '#28a745'],
                    ['title' => 'Clients', 'value' => '142', 'icon' => 'fa-solid fa-users', 'color' => '#007bff'],
                    [
                        'title' => 'Pending Invoices',
                        'value' => '12',
                        'icon' => 'fa-solid fa-file-invoice-dollar',
                        'color' => '#dc3545',
                    ],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="col-xl-3 col-md-6 col-sm-12">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width:50px;height:50px;background-color:{{ $stat['color'] }}15;">
                                <i class="{{ $stat['icon'] }}" style="font-size:1.4rem;color:{{ $stat['color'] }}"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-uppercase fw-semibold text-secondary small">{{ $stat['title'] }}</p>
                                <h5 class="fw-bold text-black mb-0">{{ $stat['value'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- CHARTS + QUICK STATS --}}
        <div class="row g-3 mt-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-0 py-2 d-flex align-items-center justify-content-between">
                        <h6 class="fw-bold mb-0 text-black">
                            <i class="fa-solid fa-chart-column me-2" style="color:#b3d33c;"></i>
                            Project Progress
                        </h6>
                    </div>
                    <div class="card-body pt-2">
                        <canvas id="projectChart" height="140"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-0 py-2 d-flex align-items-center justify-content-between">
                        <h6 class="fw-bold mb-0 text-black">
                            <i class="fa-solid fa-gauge-high me-2" style="color:#b3d33c;"></i>
                            Quick Stats
                        </h6>
                    </div>
                    <div class="card-body pt-3">
                        <ul class="list-group list-group-flush">
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center text-black small">
                                Completed Projects
                                <span class="badge bg-success">18</span>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center text-black small">
                                Ongoing Projects
                                <span class="badge bg-warning text-dark">6</span>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center text-black small">
                                Total Staff
                                <span class="badge bg-primary">56</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- RECENT ACTIVITY --}}
        <div class="row g-3 mt-4">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 py-2 d-flex align-items-center justify-content-between">
                        <h6 class="fw-bold mb-0 text-black">
                            <i class="fa-solid fa-clock-rotate-left me-2" style="color:#b3d33c;"></i>
                            Recent Activities
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="color:#000;">
                                <thead class="table-light text-uppercase small">
                                    <tr>
                                        <th class="fw-semibold text-dark">#</th>
                                        <th class="fw-semibold text-dark">Activity</th>
                                        <th class="fw-semibold text-dark">User</th>
                                        <th class="fw-semibold text-dark">Date</th>
                                        <th class="fw-semibold text-dark">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    <tr>
                                        <td class="fw-semibold text-dark">1</td>
                                        <td class="text-dark">Project “Metro Line Extension” updated</td>
                                        <td class="text-secondary">Arvind Verma</td>
                                        <td class="text-secondary">Nov 5, 2025</td>
                                        <td><span class="badge rounded-pill"
                                                style="background:#28a745;color:#fff;">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark">2</td>
                                        <td class="text-dark">New contractor registration approved</td>
                                        <td class="text-secondary">Admin</td>
                                        <td class="text-secondary">Nov 4, 2025</td>
                                        <td><span class="badge rounded-pill"
                                                style="background:#17c1e8;color:#000;">Approved</span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark">3</td>
                                        <td class="text-dark">Payment request generated for project #BLC-233</td>
                                        <td class="text-secondary">Finance Dept.</td>
                                        <td class="text-secondary">Nov 3, 2025</td>
                                        <td><span class="badge rounded-pill"
                                                style="background:#ffc107;color:#000;">Pending</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    {{-- JS --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
        <script>
            const ctx = document.getElementById('projectChart');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    datasets: [{
                        label: 'Projects Completed',
                        data: [3, 5, 8, 10, 9, 13, 15],
                        backgroundColor: '#b3d33c',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            ticks: {
                                color: '#000',
                                font: {
                                    weight: '600'
                                }
                            },
                            grid: {
                                color: '#eaeaea'
                            }
                        },
                        y: {
                            ticks: {
                                color: '#000',
                                font: {
                                    weight: '600'
                                }
                            },
                            grid: {
                                color: '#eaeaea'
                            },
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        </script>
    @endpush
</x-admin.app>
