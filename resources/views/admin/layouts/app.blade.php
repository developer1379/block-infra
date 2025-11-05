<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.common.head')
</head>

<body>
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="nav-header">
            <a href="{{ route('admin.dashboard.index') }}" class="brand-logo">
                <img class="logo-abbr" src="{{ asset('admin/images/logo.png') }}" alt="">
                <img class="brand-title" src="{{ asset('admin/images/logo-text.png') }}" alt="">
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>

        @include('admin.common.header')
        @include('admin.common.sidebar')

        <div class="content-body">
            <div class="container-fluid">
                {{ $slot ?? '' }}
            </div>
        </div>

        @include('admin.common.footer')
    </div>

    @include('admin.common.scripts')
</body>
</html>
