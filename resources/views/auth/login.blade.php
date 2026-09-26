@extends('layouts.app')

@section('title', 'Dashboard | Azzurro Hotels')

@section('content')

<div class="min-h-screen flex">

    {{-- Left branding panel --}}
    <div class="hidden lg:flex lg:w-1/2 bg-[#101828] relative overflow-hidden">

        {{-- Decorative elements --}}
        <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-pink-500/10"></div>
        <div class="absolute -bottom-40 -right-32 w-[500px] h-[500px] rounded-full bg-pink-500/5"></div>

        <div class="relative z-10 flex flex-col justify-between w-full p-14">

            {{-- Logo --}}
            <div>
                <a
                    href="/"
                    class="font-display leading-none font-extrabold text-[30px] text-white"
                >
                    Azzurro<span class="text-pink-500">.</span>
                </a>
            </div>


            {{-- Main message --}}
            <div class="max-w-lg">

                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-pink-400 mb-5">
                    Review Intelligence
                </p>

                <h1 class="text-5xl font-bold leading-tight text-white">
                    Turn guest reviews into
                    <span class="text-pink-400"> actionable insights.</span>
                </h1>

                <p class="mt-6 text-lg leading-8 text-slate-300">
                    Understand guest sentiment, identify operational trends,
                    and monitor review performance across Azzurro Hotels.
                </p>

                {{-- Simple metrics --}}
                <div class="mt-10 grid grid-cols-3 gap-8">
                    <div>
                        <p class="text-2xl font-bold text-white">24/7</p>
                        <p class="mt-1 text-sm text-slate-400">Insights</p>
                    </div>

                    <div>
                        <p class="text-2xl font-bold text-white">360°</p>
                        <p class="mt-1 text-sm text-slate-400">Review View</p>
                    </div>

                </div>

            </div>

            {{-- Footer --}}
            <p class="text-sm text-slate-500">
                Azzurro Hotels Review Insights Dashboard
            </p>

        </div>
    </div>


    {{-- Right login panel --}}
    <div class="flex-1 flex items-center justify-center px-6 py-12">

        <div class="w-full max-w-md">

            {{-- Mobile logo --}}
            <div class="lg:hidden text-center mb-10">

                <a
                    href="/"
                    class="font-display leading-none font-extrabold text-[28px] text-[#101828]"
                >
                    Azzurro<span class="text-pink-500">.</span>
                </a>

            </div>


            {{-- Login heading --}}
            <div class="mb-8">

                <p class="text-sm font-semibold text-pink-500 mb-2">
                    Welcome back
                </p>

                <h2 class="text-3xl font-bold tracking-tight text-[#101828]">
                    Sign in to your dashboard
                </h2>

                <p class="mt-2 text-sm text-slate-500">
                    Access your hotel review insights and analytics.
                </p>

            </div>


            {{-- Login card --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-7 shadow-sm">

                <form
                    method="POST"
                    action="{{ route('login.submit') }}"
                    class="space-y-5"
                >

                    @csrf

                    {{-- Email --}}
                    <div>

                        <label
                            for="email"
                            class="block text-sm font-medium text-slate-700 mb-2"
                        >
                            Email address
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="email"
                            placeholder="you@example.com"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 placeholder-slate-400 outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-500/10"
                        >

                        @error('email')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>


                    {{-- Password --}}
                    <div>

                        <div class="flex items-center justify-between mb-2">

                            <label
                                for="password"
                                class="block text-sm font-medium text-slate-700"
                            >
                                Password
                            </label>

                        </div>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Enter your password"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 placeholder-slate-400 outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-500/10"
                        >

                        @error('password')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>


                    {{-- Remember me --}}
                    <div class="flex items-center">

                        <input
                            id="remember"
                            type="checkbox"
                            name="remember"
                            value="1"
                            class="h-4 w-4 rounded border-slate-300 text-pink-500 focus:ring-pink-500"
                        >

                        <label
                            for="remember"
                            class="ml-2 text-sm text-slate-600"
                        >
                            Remember me
                        </label>

                    </div>


                    {{-- Login button --}}
                    <button
                        type="submit"
                        class="w-full rounded-xl bg-[#101828] px-4 py-3.5 text-sm font-semibold text-white transition hover:bg-[#1d2939] focus:outline-none focus:ring-4 focus:ring-slate-300"
                    >
                        Sign in
                    </button>

                </form>

            </div>


            {{-- Bottom text --}}
            <p class="mt-6 text-center text-xs text-slate-400">
                © {{ date('Y') }} Azzurro Hotels. Review Insights Dashboard.
            </p>

        </div>

    </div>

</div>

@endsection
