<style>
    .quixnav .metismenu a {
        display: flex;
        align-items: center;
        gap: 18px;
        color: #eaeaea;
        font-weight: 500;
    }

    .quixnav .metismenu a:hover {
        color: #b3d33c !important;
    }

    .quixnav .metismenu i {
        font-size: 16px;
        width: 20px;
        text-align: center;
    }
</style>
<div class="quixnav">

    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">

            {{-- MAIN --}}
            <li class="nav-label first">MAIN MENU</li>

            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-gauge me-2"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            {{-- MANAGEMENT --}}
            <li class="nav-label">MANAGEMENT</li>

            {{-- Categories --}}
            @can('view categories')
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa-solid fa-layer-group me-2"></i>
                        <span class="nav-text">Categories</span>
                    </a>
                    <ul aria-expanded="false">
                        @can('view categories')
                            <li><a href="{{ route('admin.categories.index') }}">All Categories</a></li>
                        @endcan
                        @can('create categories')
                            <li><a href="{{ route('admin.categories.create') }}">Add New</a></li>
                        @endcan
                    </ul>
                </li>
            @endcan

            {{-- Works --}}
            @can('view works')
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa-solid fa-person-digging me-2"></i>
                        <span class="nav-text">Works</span>
                    </a>
                    <ul aria-expanded="false">
                        @can('view works')
                            <li><a href="{{ route('admin.works.index') }}">All Works</a></li>
                        @endcan
                        @can('create works')
                            <li><a href="{{ route('admin.works.create') }}">Add Work</a></li>
                        @endcan
                    </ul>
                </li>
            @endcan

            {{-- Units --}}
            @can('view units')
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa-solid fa-ruler-combined me-2"></i>
                        <span class="nav-text">Units</span>
                    </a>
                    <ul aria-expanded="false">
                        @can('view units')
                            <li><a href="{{ route('admin.units.index') }}">All Units</a></li>
                        @endcan
                        @can('create units')
                            <li><a href="{{ route('admin.units.create') }}">Add Unit</a></li>
                        @endcan
                    </ul>
                </li>
            @endcan

            {{-- Contractors --}}
            @can('view contractors')
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa-solid fa-helmet-safety me-2"></i>
                        <span class="nav-text">Contractors</span>
                    </a>
                    <ul aria-expanded="false">
                        @can('view contractors')
                            <li><a href="{{ route('admin.contractors.index') }}">All Contractors</a></li>
                        @endcan
                        @can('create contractors')
                            <li><a href="{{ route('admin.contractors.create') }}">Add Contractor</a></li>
                        @endcan
                    </ul>
                </li>
            @endcan

            {{-- Roles & Permissions --}}
            @canany(['view roles', 'view permissions'])
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa-solid fa-user-shield me-2"></i>
                        <span class="nav-text">Roles & Permissions</span>
                    </a>
                    <ul aria-expanded="false">
                        @can('view roles')
                            <li><a href="{{ route('admin.roles.index') }}">All Roles</a></li>
                        @endcan
                        @can('view permissions')
                            <li><a href="{{ route('admin.permissions.index') }}">All Permissions</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany

        </ul>
    </div>
</div>
