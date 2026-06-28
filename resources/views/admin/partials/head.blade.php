<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title ?? 'Admin Dashboard - BlocInfra' }}</title>

<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/images/favicon.png') }}">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#0f766e', // Teal 700
                    'primary-dark': '#115e59',
                    'primary-light': '#ccfbf1',
                    secondary: '#64748b',
                },
                fontFamily: {
                    sans: ['Poppins', 'sans-serif'],
                }
            }
        }
    }
</script>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    /* Custom Overrides for Third Party Libraries to match Tailwind */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8fafc;
    }

    /* Scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Select2 Tailwind Fixes */
    .select2-container .select2-selection--single {
        height: 42px !important;
        border-color: #e2e8f0 !important;
        border-radius: 0.5rem !important;
        padding-top: 6px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 8px !important;
    }

    .select2-dropdown {
        border-color: #e2e8f0 !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
    }

    /* Quill Editor Fix */
    .ql-toolbar.ql-snow {
        border-color: #e2e8f0;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .ql-container.ql-snow {
        border-color: #e2e8f0;
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        background: white;
        min-height: 150px;
    }

    /* Loading Spinner */
    .loader {
        border-top-color: #0f766e;
        -webkit-animation: spinner 1.5s linear infinite;
        animation: spinner 1.5s linear infinite;
    }

    @keyframes spinner {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    [x-cloak] {
        display: none !important;
    }

    /* Globally remove border radius from all elements to ensure a flat design */
    [class*="rounded-"] {
        border-radius: 0px !important;
    }
</style>
@PwaHead
