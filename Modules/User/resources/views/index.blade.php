<x-user.user-layout title="My Dashboard" header="Dashboard">

    {{-- Custom Animations --}}
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }
    </style>

    {{-- MOBILE SEARCH (Visible only on small screens) --}}
    <div class="md:hidden mb-6 animate-fade-in">
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i
                    class="fa-solid fa-magnifying-glass text-slate-400 group-focus-within:text-primary transition-colors"></i>
            </div>
            <input type="text" placeholder="Search projects, contractors..."
                class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        {{-- Card 1 --}}
        <div
            class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 animate-fade-in delay-100 group">
            <div class="flex justify-between items-start mb-3">
                <div
                    class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-city text-lg"></i>
                </div>
                <span
                    class="bg-slate-50 text-slate-500 text-[10px] font-bold px-2 py-1 rounded-md border border-slate-100 tracking-wide">TOTAL</span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-slate-800">4</h3>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Active Properties</p>
            </div>
        </div>

        {{-- Card 2 --}}
        <div
            class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 animate-fade-in delay-200 group">
            <div class="flex justify-between items-start mb-3">
                <div
                    class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-person-digging text-lg"></i>
                </div>
                <span
                    class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2 py-1 rounded-md border border-emerald-200 tracking-wide">LIVE</span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-slate-800">1</h3>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Under Construction</p>
            </div>
        </div>

        {{-- Card 3 --}}
        <div
            class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 animate-fade-in delay-300 group">
            <div class="flex justify-between items-start mb-3">
                <div
                    class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-wallet text-lg"></i>
                </div>
                <span
                    class="bg-slate-50 text-slate-500 text-[10px] font-bold px-2 py-1 rounded-md border border-slate-100 tracking-wide">SPENT</span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-slate-800">₹ 85.5 L</h3>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Total Investment</p>
            </div>
        </div>

        {{-- Card 4 --}}
        <div
            class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 animate-fade-in delay-100 group">
            <div class="flex justify-between items-start mb-3">
                <div
                    class="w-10 h-10 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-bell text-lg"></i>
                </div>
                <span
                    class="bg-rose-100 text-rose-600 text-[10px] font-bold px-2 py-1 rounded-md border border-rose-200 tracking-wide">ACTION</span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-slate-800">2</h3>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Approvals Pending</p>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT LAYOUT --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fade-in delay-200">

        {{-- LEFT COLUMN: Ongoing Project --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Section Header --}}
            <div class="flex justify-between items-center px-1">
                <div>
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        Ongoing Project
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Green Valley Residency • Noida</p>
                </div>
                <a href="#"
                    class="group flex items-center gap-1 text-xs font-bold text-primary hover:text-primary-dark transition-colors">
                    View Details <i
                        class="fa-solid fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            {{-- Project Card --}}
            <div
                class="bg-white rounded-3xl shadow-md border border-slate-100 overflow-hidden group hover:shadow-xl transition-all duration-500">

                {{-- Image Hero --}}
                <div class="relative h-64 overflow-hidden">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent z-10 pointer-events-none">
                    </div>
                    <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=2070&auto=format&fit=crop"
                        alt="Construction Site"
                        class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700 ease-out">

                    {{-- Status Badge --}}
                    <div class="absolute top-4 left-4 z-20">
                        <div
                            class="flex items-center gap-2 bg-white/95 backdrop-blur-md px-3 py-1.5 rounded-full shadow-sm border border-white/20">
                            <span class="relative flex h-2.5 w-2.5">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                            </span>
                            <span class="text-[10px] font-bold text-slate-700 uppercase tracking-wide">Live Feed</span>
                        </div>
                    </div>

                    {{-- Title Overlay --}}
                    <div class="absolute bottom-0 left-0 p-6 z-20 w-full">
                        <h3 class="text-2xl font-bold text-white mb-1">Structural Framework Phase</h3>
                        <p class="text-slate-300 text-xs flex items-center gap-2">
                            <i class="fa-regular fa-clock"></i> Estimated Completion: Dec 2025
                        </p>
                    </div>
                </div>

                {{-- Progress Bar --}}
                <div class="px-6 pt-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Completion Status</span>
                        <span class="text-sm font-bold text-primary">62%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div
                            class="bg-gradient-to-r from-primary to-teal-400 h-full rounded-full relative transition-all duration-1000 w-[62%]">
                            <div
                                class="absolute top-0 bottom-0 right-0 w-full animate-shimmer bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Grid (Modernized) --}}
                <div class="p-6">
                    <div class="grid grid-cols-4 gap-4">
                        <button
                            class="flex flex-col items-center gap-2 p-3 rounded-2xl hover:bg-slate-50 transition-colors group/btn">
                            <div
                                class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center group-hover/btn:bg-blue-100 group-hover/btn:scale-110 transition-all">
                                <i class="fa-solid fa-camera"></i>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-600">Photos</span>
                        </button>
                        <button
                            class="flex flex-col items-center gap-2 p-3 rounded-2xl hover:bg-slate-50 transition-colors group/btn">
                            <div
                                class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center group-hover/btn:bg-purple-100 group-hover/btn:scale-110 transition-all">
                                <i class="fa-solid fa-timeline"></i>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-600">Timeline</span>
                        </button>
                        <button
                            class="flex flex-col items-center gap-2 p-3 rounded-2xl hover:bg-slate-50 transition-colors group/btn">
                            <div
                                class="w-10 h-10 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center group-hover/btn:bg-orange-100 group-hover/btn:scale-110 transition-all">
                                <i class="fa-solid fa-file-invoice"></i>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-600">Bills</span>
                        </button>
                        <button
                            class="flex flex-col items-center gap-2 p-3 rounded-2xl hover:bg-slate-50 transition-colors group/btn">
                            <div
                                class="w-10 h-10 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center group-hover/btn:bg-rose-100 group-hover/btn:scale-110 transition-all">
                                <i class="fa-solid fa-video"></i>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-600">Live Cam</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Info & Updates --}}
        <div class="space-y-6">

            {{-- Contractor Card --}}
            <div
                class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Allotted Contractor</h3>
                    <span
                        class="bg-green-50 text-green-700 text-[10px] px-2.5 py-1 rounded-full border border-green-100 font-bold flex items-center gap-1">
                        <i class="fa-solid fa-circle-check"></i> Verified
                    </span>
                </div>

                <div class="flex items-center gap-4 mb-6">
                    <img src="https://ui-avatars.com/api/?name=Sharma+Builders&background=0f766e&color=fff"
                        alt="Contractor" class="w-14 h-14 rounded-2xl object-cover shadow-sm border border-slate-100">
                    <div>
                        <h4 class="font-bold text-slate-800 text-base">Sharma Builders</h4>
                        <p class="text-xs text-slate-500">Civil & Structural Expert</p>
                        <div class="flex gap-1 mt-1 text-yellow-400 text-[10px]">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-stroke"></i>
                            <span class="text-slate-400 ml-1">(4.8)</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <button
                        class="flex items-center justify-center gap-2 w-full bg-slate-50 text-slate-700 border border-slate-200 py-2.5 rounded-xl text-xs font-bold hover:bg-slate-100 transition-colors">
                        <i class="fa-regular fa-comment-dots"></i> Message
                    </button>
                    <button
                        class="flex items-center justify-center gap-2 w-full bg-primary text-white py-2.5 rounded-xl text-xs font-bold hover:bg-primary-dark transition-colors shadow-lg shadow-primary/20">
                        <i class="fa-solid fa-phone"></i> Call Now
                    </button>
                </div>
            </div>

            {{-- Site Updates Timeline --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 h-full">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide mb-5">Latest Updates</h3>

                <div class="relative pl-2 space-y-8">
                    {{-- Vertical Line --}}
                    <div
                        class="absolute top-2 bottom-2 left-[19px] w-0.5 bg-gradient-to-b from-slate-200 to-transparent">
                    </div>

                    {{-- Item 1 --}}
                    <div class="relative flex gap-4 group">
                        <div
                            class="absolute left-[13px] mt-1.5 w-3 h-3 rounded-full bg-primary border-2 border-white ring-2 ring-primary/20 z-10 group-hover:scale-125 transition-transform">
                        </div>
                        <div class="pl-8">
                            <p class="text-xs font-semibold text-slate-400 mb-0.5">Today, 10:30 AM</p>
                            <p class="text-sm font-bold text-slate-800 leading-tight">Cement Delivery Received</p>
                            <p
                                class="text-xs text-slate-500 mt-1 bg-slate-50 p-2 rounded-lg border border-slate-100 inline-block">
                                <i class="fa-solid fa-truck-fast mr-1 text-slate-400"></i> 50 Bags Delivered
                            </p>
                        </div>
                    </div>

                    {{-- Item 2 --}}
                    <div class="relative flex gap-4 group">
                        <div
                            class="absolute left-[13px] mt-1.5 w-3 h-3 rounded-full bg-slate-300 border-2 border-white z-10 group-hover:scale-125 transition-transform">
                        </div>
                        <div class="pl-8">
                            <p class="text-xs font-semibold text-slate-400 mb-0.5">Yesterday</p>
                            <p class="text-sm font-bold text-slate-800 leading-tight">Labour Payment Due</p>
                            <a href="#"
                                class="text-[10px] font-bold text-primary mt-1 inline-flex items-center hover:underline">
                                Pay Now <i class="fa-solid fa-chevron-right text-[8px] ml-1"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Item 3 --}}
                    <div class="relative flex gap-4 group">
                        <div
                            class="absolute left-[13px] mt-1.5 w-3 h-3 rounded-full bg-slate-300 border-2 border-white z-10 group-hover:scale-125 transition-transform">
                        </div>
                        <div class="pl-8">
                            <p class="text-xs font-semibold text-slate-400 mb-0.5">12 Dec 2025</p>
                            <p class="text-sm font-bold text-slate-800 leading-tight">Foundation Inspection Passed</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-user.user-layout>
