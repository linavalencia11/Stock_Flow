
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
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <div class="flex min-h-[calc(100vh-4rem)]">
                @include('layouts.sidebar')

                <div class="flex-1">
                    @isset($header)
                        <header class="bg-white dark:bg-gray-800 shadow">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <main class="p-4 sm:p-6 lg:p-8 space-y-6">
                        @if (session('success') || session('error'))
                            <div class="max-w-7xl mx-auto space-y-3">
                                @if (session('success'))
                                    <div class="rounded-xl border border-green-600 bg-green-700/10 px-4 py-4 text-sm font-semibold text-green-100 shadow-sm">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="rounded-xl border border-red-600 bg-red-700/10 px-4 py-4 text-sm font-semibold text-red-100 shadow-sm" style= "color:aliceblue">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                        @endif

                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
