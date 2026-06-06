<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ALKEMEA Hotel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- ALKEMEA Hotel Theme -->
    <style>
        :root {
            --navy: #0B1F3A;
            --dark-navy: #071527;
            --gold: #D4AF37;
            --light-gold: #F5D76E;
            --cream: #F8F6F0;
            --border-soft: #e5e0d0;
        }

        body {
            background-color: var(--cream) !important;
            color: #1f2937;
        }

        .min-h-screen {
            background-color: var(--cream) !important;
        }

        nav {
            background-color: var(--navy) !important;
            border-bottom: 3px solid var(--gold) !important;
        }

        nav a,
        nav span,
        nav button,
        nav div {
            color: var(--gold) !important;
        }

        nav a:hover,
        nav span:hover,
        nav button:hover {
            color: var(--light-gold) !important;
        }

        .luxury-brand {
            color: var(--gold) !important;
            font-weight: 800;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .luxury-page {
            background-color: var(--cream);
            min-height: 100vh;
        }

        .luxury-heading {
            color: var(--navy) !important;
            font-weight: 800;
        }

        .luxury-card {
            background: white;
            border: 1px solid var(--border-soft);
            border-radius: 14px;
            box-shadow: 0 8px 20px rgba(11, 31, 58, 0.10);
        }

        .luxury-card-title {
            color: var(--navy) !important;
            font-weight: 700;
        }

        .luxury-gold-text {
            color: var(--gold) !important;
        }

.btn-luxury,
.btn-navy {
    padding: 7px 12px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.2;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 78px;
    height: 38px;
    border: none;
    cursor: pointer;
    white-space: nowrap;
    box-sizing: border-box;
}
        .btn-luxury {
            background-color: var(--gold) !important;
            color: var(--navy) !important;
        }

        .btn-luxury:hover {
            background-color: var(--light-gold) !important;
            color: var(--dark-navy) !important;
        }

        .btn-navy {
            background-color: var(--navy) !important;
            color: white !important;
        }

        .btn-navy:hover {
            background-color: var(--dark-navy) !important;
            color: var(--gold) !important;
        }

        .luxury-btn {
    background-color: var(--gold) !important;
    color: var(--navy) !important;
    padding: 7px 12px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.2;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 78px;
    height: 38px;
    border: none;
    cursor: pointer;
    white-space: nowrap;
    box-sizing: border-box;
}

.luxury-btn:hover {
    background-color: var(--light-gold) !important;
    color: var(--dark-navy) !important;
}

.luxury-btn-navy {
    background-color: var(--navy) !important;
    color: white !important;
    padding: 7px 12px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.2;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 78px;
    height: 38px;
    border: none;
    cursor: pointer;
    white-space: nowrap;
    box-sizing: border-box;
}

.luxury-btn-navy:hover {
    background-color: var(--dark-navy) !important;
    color: var(--gold) !important;
}

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            background: white;
            border-radius: 12px;
        }

        .luxury-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
            font-size: 14px;
        }

        .luxury-table th {
            background-color: var(--navy);
            color: var(--gold);
            padding: 10px;
            text-align: left;
            white-space: nowrap;
            border: 1px solid var(--border-soft);
        }

        .luxury-table td {
            padding: 10px;
            border: 1px solid var(--border-soft);
            vertical-align: middle;
            word-break: normal;
        }

        .table-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        .navbar-links {
            display: flex;
            gap: 18px;
            align-items: center;
            flex-wrap: nowrap;
        }

        @media (max-width: 1100px) {
            .navbar-links {
                gap: 10px;
            }

            .navbar-links a,
            .navbar-links span {
                font-size: 13px;
            }

            .btn-luxury,
            .btn-navy {
                min-width: 80px;
                height: 40px;
                font-size: 14px;
                padding: 7px 12px;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Header -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>