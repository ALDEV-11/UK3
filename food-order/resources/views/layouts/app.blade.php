<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if(View::hasSection('page_heading') || isset($header))
                <header class="shadow" style="background-color: #FFFFFF;">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @hasSection('page_heading')
                            @yield('page_heading')
                        @else
                            {{ $header ?? '' }}
                        @endif
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @hasSection('content')
                    @yield('content')
                @else
                    {{ $slot ?? '' }}
                @endif
            </main>
        </div>
        <!-- Base button style for all pages -->
        <style>
            .btn-primary {
                background-color: #E8612A;
                color: #FFF8F3;
                border-radius: 0.5rem;
                padding: 0.5rem 1.25rem;
                font-weight: 600;
                transition: background 0.2s;
                border: none;
            }
            .btn-primary:hover {
                background-color: #F5A623;
                color: #2C1810;
            }
            .btn-secondary {
                background-color: #2C1810;
                color: #FFF8F3;
                border-radius: 0.5rem;
                padding: 0.5rem 1.25rem;
                font-weight: 600;
                transition: background 0.2s;
                border: none;
            }
            .btn-secondary:hover {
                background-color: #E8612A;
                color: #FFF8F3;
            }
            .btn-add {
                background-color: #F5A623;
                color: #2C1810;
                border-radius: 0.5rem;
                padding: 0.5rem 1.25rem;
                font-weight: 700;
                border: none;
                transition: background 0.2s, color 0.2s;
            }
            .btn-add:hover {
                background-color: #E8612A;
                color: #FFF8F3;
            }
            .btn-detail {
                background-color: #FFF;
                color: #2C1810;
                border: 2px solid #2C1810;
                border-radius: 0.5rem;
                padding: 0.5rem 1.25rem;
                font-weight: 600;
                transition: background 0.2s, color 0.2s, border 0.2s;
            }
            .btn-detail:hover {
                background-color: #F5A623;
                color: #2C1810;
                border-color: #F5A623;
            }
            .btn-delete {
                background-color: #C03916;
                color: #FFF8F3;
                border-radius: 0.5rem;
                padding: 0.5rem 1.25rem;
                font-weight: 600;
                border: none;
                transition: background 0.2s, color 0.2s;
            }
            .btn-delete:hover {
                background-color: #E8612A;
                color: #FFF8F3;
            }
        </style>
    </body>
</html>
