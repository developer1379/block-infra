<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            {{-- MAIN --}}
            <li class="nav-label first">Main Menu</li>

            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="icon icon-single-04"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            {{-- MANAGEMENT --}}
            <li class="nav-label">Management</li>

            {{-- Categories --}}
            @can('view categories')
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="icon icon-app-store"></i>
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

            {{-- Contractors --}}
            @can('view contractors')
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-users" style="margin-right: 10px;"></i>
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
                        <i class="icon icon-lock"></i>
                        <span class="nav-text">Roles & Permissions</span>
                    </a>
                    <ul aria-expanded="false">
                        @can('view roles')
                            <li><a href="{{ route('admin.roles.index') }}">All Roles</a></li>
                        @endcan
                        @can('view permissions')
                            <li><a href="{{ route('admin.permissions.index') }}">All Permissions</a></li>
                        @endcan
                        @can('create roles')
                            <li><a href="{{ route('admin.roles.create') }}">Add Role</a></li>
                        @endcan
                        @can('create permissions')
                            <li><a href="{{ route('admin.permissions.create') }}">Add Permission</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany


        </ul>
    </div>
</div>
