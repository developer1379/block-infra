<!DOCTYPE html>
<html lang="en">
{{-- Head Section --}}
@include('website.common.head')

<body>
    <style>
        /* === Base Dark Theme === */
        body {
            background-color: #0d0d0d;
            color: #e5e5e5;
            font-family: 'Roboto', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #ffffff;
            font-weight: 600;
        }

        p,
        span {
            color: #cfcfcf;
        }

        /* === Primary Color (Bloc Infra Lime Green) === */
        .text-primary {
            color: #b3d33c !important;
        }

        .bg-primary {
            background-color: #b3d33c !important;
        }

        .btn-primary {
            background-color: #b3d33c !important;
            border: none;
            color: #000;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #c9ec4b !important;
            color: #000;
        }

        /* === Section Styling === */
        .bg-dark-section {
            background-color: #161616;
        }

        .service-item,
        .portfolio-box,
        .testimonial-item {
            background-color: #1c1c1c;
            border: 1px solid #2a2a2a;
            transition: 0.3s;
        }

        .service-item:hover,
        .portfolio-box:hover,
        .testimonial-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 15px rgba(179, 211, 60, 0.3);
        }

        /* === Carousel Captions === */
        .carousel-caption h1,
        .carousel-caption p {
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
        }

        /* === Links === */
        a {
            color: #b3d33c;
            text-decoration: none;
        }

        a:hover {
            color: #d8fa60;
        }
    </style>

    {{-- Header --}}
    @include('website.common.header')
    {{-- If you use Blade components for header, you can replace the above line with: --}}
    {{-- <x-header /> --}}


    {{-- Main Content --}}
    {{ $slot }}

    {{-- Footer --}}
    @include('website.common.footer')
    {{-- Or use component --}}
    {{-- <x-footer /> --}}

    {{-- JavaScript Includes --}}
    @include('website.common.js')
</body>

</html>
