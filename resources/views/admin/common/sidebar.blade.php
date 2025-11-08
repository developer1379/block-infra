<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>

            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="icon icon-single-04"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-label">Management</li>

            {{-- Categories --}}
            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="icon icon-app-store"></i>
                    <span class="nav-text">Categories</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.categories.index') }}">All Categories</a></li>
                    <li><a href="{{ route('admin.categories.create') }}">Add New</a></li>
                </ul>
            </li>

            {{-- Roles & Permissions --}}
            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="icon icon-lock"></i>
                    <span class="nav-text">Roles & Permissions</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.roles.index') }}">All Roles</a></li>
                    <li><a href="{{ route('admin.permissions.index') }}">All Permissions</a></li>
                    <li><a href="{{ route('admin.roles.create') }}">Add Role</a></li>
                    <li><a href="{{ route('admin.permissions.create') }}">Add Permission</a></li>
                </ul>

            </li>


        </ul>
    </div>
</div>
