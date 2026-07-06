<head>
    <meta charset="utf-8">
    <title>{{ isset($title) ? $title : 'Bloc-Infra - Construction & Infrastructure Company' }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="{{ isset($keywords) ? $keywords : 'Kanpur Construction, Best Builders, Bloc-Infra, Construction Company Kanpur' }}" name="keywords">
    <meta content="{{ isset($description) ? $description : 'Bloc-Infra Pvt. Ltd. connects builders, contractors, and clients under one powerful digital construction platform.' }}" name="description">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ isset($canonical) ? $canonical : url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ isset($title) ? $title : 'Bloc-Infra - Construction & Infrastructure Company' }}">
    <meta property="og:description" content="{{ isset($description) ? $description : 'Bloc-Infra Pvt. Ltd. connects builders, contractors, and clients under one powerful digital construction platform.' }}">
    <meta property="og:image" content="{{ asset('logo.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ isset($title) ? $title : 'Bloc-Infra - Construction & Infrastructure Company' }}">
    <meta property="twitter:description" content="{{ isset($description) ? $description : 'Bloc-Infra Pvt. Ltd. connects builders, contractors, and clients under one powerful digital construction platform.' }}">
    <meta property="twitter:image" content="{{ asset('logo.png') }}">

    <!-- Structured Data (JSON-LD) for Local Business / Construction Company -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "ConstructionBusiness",
      "name": "Bloc-Infra Pvt. Ltd.",
      "image": "{{ asset('logo.png') }}",
      "@id": "{{ url('/') }}",
      "url": "{{ url('/') }}",
      "telephone": "+91-XXXXXXXXXX",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Kakadeo",
        "addressLocality": "Kanpur",
        "addressRegion": "Uttar Pradesh",
        "postalCode": "208025",
        "addressCountry": "IN"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 26.4744,
        "longitude": 80.3013
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday"
        ],
        "opens": "09:00",
        "closes": "18:00"
      },
      "sameAs": [
        "https://www.facebook.com/blocinfra",
        "https://twitter.com/blocinfra",
        "https://www.linkedin.com/company/blocinfra"
      ]
    }
    </script>

    <!-- Favicon -->
    <link href="{{ asset('website/img/fav.jpg') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('website/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('website/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('website/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('website/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('website/css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <meta name="google" content="notranslate"> --}}

    <!-- PWA -->
    <meta name="theme-color" content="#0f766e"/>
    <link rel="apple-touch-icon" href="/logo.png">
    <link rel="manifest" href="/manifest.json">
    <!-- PWA end -->

</head>
