<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Otentikasi') | Al-Falah Putak</title>

    {{-- Import Font dan Icon --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- CSS KUSTOM BACKGROUND & UX --}}
    <style>
        /* ============================================== */
        /* BASE STYLES & BACKGROUND */
        /* ============================================== */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #333; 
            background-image: url("{{ asset('Images/2Putak.jpg') }}"); 
            background-size: cover;
            background-position: center center;
            background-attachment: fixed; 
        }

        /* Container Pembungkus Form (Overlay) */
        .auth-wrapper {
            display: flex;
            flex-direction: column; 
            justify-content: flex-start; /* Memulai dari atas */
            align-items: center;
            min-height: 100vh;
            padding: 40px 0;
            background-color: rgba(0, 0, 0, 0.65); 
        }

        /* Card Form */
        .card {
            background-color: rgba(255, 255, 255, 1) !important; 
            border: none;
        }

        .shadow-lg-custom {
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.4) !important; 
        }
        
        /* Warna Pondok */
        .bg-primary { background-color: #1a5e3a !important; }
        .text-primary { color: #1a5e3a !important; }
        .bg-warning { background-color: #ffc107 !important; }

        /* UX: Focus State Input */
        .form-control:focus {
            border-color: #1a5e3a; 
            box-shadow: 0 0 0 0.25rem rgba(26, 94, 58, 0.25);
        }

        .input-group-text {
            background-color: #fff;
            cursor: pointer;
        }

        /* Style untuk Container Login Utama */
        .container {
            width: 100%;
            /* Margin auto di atas akan mendorong container ke tengah, */
            /* meninggalkan ruang untuk footer di bawah. */
            margin-top: auto; 
            margin-bottom: auto; /* Ini membantu pemusatan vertikal konten utama */
        }
        
        /* Style untuk Footer Copyright */
        .auth-footer {
            margin-top: auto; /* Mendorong footer ke batas bawah */
            margin-bottom: 20px; /* Jarak dari batas bawah viewport */
            padding-top: 20px; 
            color: rgba(255, 255, 255, 0.8); 
            text-align: center;
            font-size: 0.8rem;
        }

        /* ============================================== */
        /* MOBILE ADJUSTMENTS */
        /* ============================================== */
        @media (max-width: 768px) {
            body {
                background-attachment: scroll; 
            }
            .auth-wrapper {
                padding: 15px 0; 
            }
            .auth-footer {
                margin-bottom: 10px; /* Jarak lebih kecil di mobile */
            }
        }
    </style>
</head>

<body class="h-100">
    <div class="auth-wrapper">
        <div class="container">
            @yield('content') 
        </div>

        {{-- START: COPYRIGHT FOOTER --}}
        <footer class="auth-footer">
            &copy; {{ date('Y') }} By Jakastra Official. Hak Cipta Dilindungi
        </footer>
        {{-- END: COPYRIGHT FOOTER --}}
    </div>

    {{-- Script Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Memuat script kustom (misalnya, toggle password) --}}
    @stack('scripts')
</body>
</html>