<x-user.user-layout title="My Dashboard" header="Project Overview">

    <div class="md:hidden">
        <div class="relative shadow-md rounded-2xl">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-primary"></i>
            <input type="text" placeholder="Find project or contractor..."
                class="w-full pl-11 pr-4 py-3.5 bg-white border-none rounded-2xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-primary">
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex justify-between items-start mb-2">
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="fa-solid fa-building"></i>
                </div>
                <span class="bg-slate-100 text-slate-500 text-[10px] px-2 py-1 rounded-full font-bold">TOTAL</span>
            </div>
            <p class="text-3xl font-bold text-slate-800">4</p>
            <p class="text-xs text-slate-400 font-medium">Active Properties</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex justify-between items-start mb-2">
                <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-amber-600">
                    <i class="fa-solid fa-person-digging"></i>
                </div>
                <span class="bg-green-100 text-green-700 text-[10px] px-2 py-1 rounded-full font-bold">LIVE</span>
            </div>
            <p class="text-3xl font-bold text-slate-800">1</p>
            <p class="text-xs text-slate-400 font-medium">Under Construction</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex justify-between items-start mb-2">
                <div class="w-10 h-10 rounded-full bg-primary-light flex items-center justify-center text-primary">
                    <i class="fa-solid fa-indian-rupee-sign"></i>
                </div>
                <span class="bg-slate-100 text-slate-500 text-[10px] px-2 py-1 rounded-full font-bold">SPENT</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">₹ 85.5 L</p>
            <p class="text-xs text-slate-400 font-medium">Total Investment</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex justify-between items-start mb-2">
                <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-500">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <span class="bg-red-100 text-red-600 text-[10px] px-2 py-1 rounded-full font-bold">ACTION</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">2</p>
            <p class="text-xs text-slate-400 font-medium">Approvals Pending</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-5">
            <div class="flex justify-between items-end px-1">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Ongoing Project (चालू परियोजना)</h2>
                    <p class="text-xs text-slate-500">Last updated: Today, 9:00 AM</p>
                </div>
                <button
                    class="text-primary text-sm font-semibold hover:bg-primary-light px-3 py-1 rounded-lg transition">View
                    All <i class="fa-solid fa-arrow-right ml-1"></i></button>
            </div>

            <div
                class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden group">
                <div class="h-52 md:h-64 relative overflow-hidden">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent z-10">
                    </div>
                    <img src="https://www.sydle.com/blog/assets/post/what-is-a-construction-method-6852c77d2a791427913e61fd/AdobeStock_68632352%20(1).webp"
                        alt="Construction Site"
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700 ease-in-out">

                    <div class="absolute top-4 left-4 z-20">
                        <span
                            class="bg-white/90 backdrop-blur text-primary px-3 py-1.5 rounded-full text-xs font-bold shadow-sm flex items-center gap-2">
                            <span class="relative flex h-2.5 w-2.5">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                            </span>
                            Site Active
                        </span>
                    </div>

                    <div class="absolute bottom-0 left-0 p-6 z-20 text-white w-full">
                        <div class="flex justify-between items-end">
                            <div>
                                <h3 class="text-2xl md:text-3xl font-bold tracking-tight">Green Valley Residency</h3>
                                <p class="text-slate-300 text-sm mt-1 flex items-center gap-2">
                                    <i class="fa-solid fa-location-dot"></i> Sector 62, Noida
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-6 border-b border-gray-100">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Structure
                            Completion</span>
                        <span class="text-lg font-bold text-primary">62%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                        <div class="bg-primary h-3 rounded-full relative" style="width: 62%"></div>
                    </div>
                </div>

                <div class="grid grid-cols-4 divide-x divide-gray-100 bg-gray-50/50">
                    <button class="flex flex-col items-center justify-center py-4 hover:bg-white transition">
                        <i class="fa-solid fa-camera text-blue-600 mb-1"></i>
                        <span class="text-[10px] font-semibold text-slate-600">Photos</span>
                    </button>
                    <button class="flex flex-col items-center justify-center py-4 hover:bg-white transition">
                        <i class="fa-solid fa-timeline text-purple-600 mb-1"></i>
                        <span class="text-[10px] font-semibold text-slate-600">Timeline</span>
                    </button>
                    <button class="flex flex-col items-center justify-center py-4 hover:bg-white transition">
                        <i class="fa-solid fa-file-invoice text-orange-600 mb-1"></i>
                        <span class="text-[10px] font-semibold text-slate-600">Bills</span>
                    </button>
                    <button class="flex flex-col items-center justify-center py-4 hover:bg-white transition">
                        <i class="fa-solid fa-video text-teal-600 mb-1"></i>
                        <span class="text-[10px] font-semibold text-slate-600">Live Cam</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-3xl p-6 shadow-lg shadow-slate-200/50 border border-slate-100">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-base font-bold text-slate-800">Allotted Contractor</h2>
                    <span class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded font-bold">VERIFIED</span>
                </div>

                <div class="flex items-center gap-4 mb-5">
                    <img src="https://i.pravatar.cc/150?img=13" alt="Contractor"
                        class="w-16 h-16 rounded-2xl object-cover border-2 border-white shadow-md">
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">Sharma Builders</h3>
                        <p class="text-xs text-slate-500">Civil & Structural Expert</p>
                    </div>
                </div>

                <button
                    class="w-full bg-primary text-white py-3 rounded-xl font-semibold text-sm shadow-lg shadow-teal-200 hover:bg-primary-dark transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-phone"></i> Call Contractor
                </button>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-lg shadow-slate-200/50 border border-slate-100">
                <h2 class="text-base font-bold text-slate-800 mb-4">Site Updates</h2>
                <div class="relative pl-4 border-l-2 border-gray-100 space-y-6">
                    <div class="relative">
                        <div
                            class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-primary border-2 border-white ring-4 ring-primary-light">
                        </div>
                        <p class="text-sm font-bold text-slate-800">Cement Delivery Received</p>
                        <p class="text-[10px] text-slate-400 mt-1">10:30 AM Today</p>
                    </div>
                    <div class="relative">
                        <div
                            class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-gray-300 border-2 border-white">
                        </div>
                        <p class="text-sm font-bold text-slate-700">Labour Payment Due</p>
                        <p class="text-[10px] text-slate-400 mt-1">Yesterday</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-user.user-layout>
