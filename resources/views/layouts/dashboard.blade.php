<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', 'Azzurro Hotels')
    </title>

     {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('og_title', 'Azzurro Hotels Review Insights')">
    <meta property="og:description" content="@yield('og_description', 'Hotel review insights and analytics dashboard.')">
    <meta property="og:image" content="{{ asset('images/social-preview.png') }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'Azzurro Hotels Review Insights')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Hotel review insights and analytics dashboard.')">
    <meta name="twitter:image" content="{{ asset('images/social-preview.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">

    {{-- =========================================================
         SIDEBAR
         ========================================================= --}}
    <x-sidebar />


    {{-- =========================================================
         MAIN APPLICATION
         ========================================================= --}}
    <div class="min-h-screen lg:ml-64">

        {{-- Top Header --}}
        <header
            class="sticky top-0 z-30 flex h-20 items-center
                   justify-between border-b border-slate-200
                   bg-white/95 px-6 backdrop-blur lg:px-8"
        >

            <div>
                <h1 class="text-lg font-semibold text-slate-900">
                    @yield('page-title', 'Dashboard')
                </h1>

                <p class="mt-0.5 text-xs text-slate-500">
                    @yield('page-description', 'Guest Review Insights')
                </p>
            </div>


            {{-- User --}}
            <div class="flex items-center gap-3">

                <div class="hidden text-right sm:block">
                    <p class="text-sm font-semibold text-slate-800">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-slate-500">
                        {{ auth()->user()->email }}
                    </p>
                </div>

                <div
                    class="flex h-10 w-10 items-center justify-center
                           rounded-full
                           bg-gradient-to-br from-pink-500 to-purple-600
                           text-sm font-bold text-white"
                >
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

            </div>

        </header>


        {{-- =====================================================
             PAGE CONTENT
             ===================================================== --}}
        <main class="min-h-[calc(100vh-5rem)] p-6 lg:p-8">

            @yield('content')

        </main>

    </div>


    @stack('scripts')

</body>
</html>
