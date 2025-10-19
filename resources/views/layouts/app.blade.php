<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Boxicons CDN -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- Flatpickr DateTime Picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex flex-col md:flex-row">
        <!-- Mobile nav toggle -->
        <div class="md:hidden flex items-center justify-between bg-white border-b border-gray-200 px-4 py-3">
            <span class="text-xl font-bold text-blue-600 flex items-center gap-2">
                <i class='bx bxs-dashboard text-2xl'></i> CRM_L12
            </span>
            <button @click="sidebarOpen = !sidebarOpen" x-data="{ sidebarOpen: false }" x-on:click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none">
                <i class='bx bx-menu text-3xl'></i>
            </button>
        </div>
        <!-- Sidebar -->
        <aside x-data="{ sidebarOpen: false }" :class="{'block': sidebarOpen, 'hidden': !sidebarOpen}" class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 flex flex-col py-6 px-4 space-y-4 md:static md:block md:translate-x-0 md:w-64 md:z-auto md:relative transition-transform duration-200 ease-in-out hidden md:flex">
            <div class="flex items-center mb-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-xl font-bold text-blue-600">
                    <i class='bx bxs-dashboard text-2xl'></i>
                    CRM_L12
                </a>
            </div>
            <nav class="flex flex-col gap-2">
                <a href="{{ route('clients.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-blue-50 text-gray-700 @if(request()->routeIs('clients.*')) bg-blue-100 font-semibold @endif">
                    <i class='bx bxs-user-detail text-xl'></i>
                    Clients
                </a>
                <a href="{{ route('visits.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-blue-50 text-gray-700 @if(request()->routeIs('visits.*')) bg-blue-100 font-semibold @endif">
                    <i class='bx bxs-calendar-event text-xl'></i>
                    Visits
                </a>
            </nav>
        </aside>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1 min-w-0">
                @yield('content')
            </main>
        </div>
    </div>
    <script>
        (function initFlatpickrOnce() {
            function attachPickers() {
                document.querySelectorAll('input.js-datetime').forEach(function(el) {
                    if (el._flatpickr) return;
                    flatpickr(el, {
                        enableTime: true,
                        dateFormat: 'Y-m-d H:i',
                        allowInput: true
                    });
                });
            }
            document.addEventListener('DOMContentLoaded', attachPickers);
            window.addEventListener('open-modal', attachPickers);
        })();
    </script>
</body>

</html>