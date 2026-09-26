<aside class="fixed inset-y-0 left-0 z-50 hidden h-screen w-64 flex-col border-r border-slate-800 bg-slate-950 lg:flex" >
    {{-- Brand --}}
    <div class="flex h-20 items-center border-b border-slate-800 px-6">

        <a
            href="{{ route('dashboard') }}"
            class="font-display text-3xl font-extrabold tracking-tight text-white"
        >
            Azzurro<span class="text-pink-500">.</span>
        </a>

    </div>


    {{-- Navigation --}}
    <nav class="min-h-0 flex-1 overflow-y-auto px-4 py-6">

        {{-- Overview --}}
        <div class="mb-8">

            <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Overview
            </p>

            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                {{ request()->routeIs('dashboard')
                    ? 'bg-pink-500/10 text-pink-400'
                    : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}"
            >
                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 12l9-9 9 9M5 10v10h14V10"
                    />
                </svg>

                Dashboard
            </a>

        </div>


        {{-- Management --}}
        <div class="mb-8">

            <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Management
            </p>

            {{-- Reviews --}}
            <a
                href="{{ route('reviews') }}"
                class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                {{ request()->routeIs('reviews*')
                    ? 'bg-pink-500/10 text-pink-400'
                    : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}"
            >
                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 15a4 4 0 01-4 4H8l-5 3V7a4 4 0 014-4h10a4 4 0 014 4v8z"
                    />
                </svg>

                Reviews
            </a>


            {{-- Properties --}}
            <a
                href="{{ route('properties') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                {{ request()->routeIs('properties*')
                    ? 'bg-pink-500/10 text-pink-400'
                    : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}"
            >
                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 21h18M5 21V5a2 2 0 012-2h6a2 2 0 012 2v16M15 21V9a2 2 0 012-2h2a2 2 0 012 2v12M9 7h2M9 11h2M9 15h2"
                    />
                </svg>

                Properties
            </a>

        </div>


        {{-- Analytics --}}
        <div>

            <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Analytics
            </p>

          <a
    href="{{ route('analytics.rating') }}"
    class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
    {{ request()->routeIs('analytics.rating')
        ? 'bg-pink-500/10 text-pink-400'
        : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}"
>
                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 19V5M4 19h16M8 16v-5M12 16V7M16 16v-9M20 16v-4"
                    />
                </svg>

                Rating Trends
            </a>


         <a
    href="{{ route('analytics.operational') }}"
    class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
    {{ request()->routeIs('analytics.operational')
        ? 'bg-pink-500/10 text-pink-400'
        : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}"
>
                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 14l2 2 4-5M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                    />
                </svg>

                Operational Insights
            </a>

            <a
    href="{{ route('analytics.sentiment') }}"
    class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
    {{ request()->routeIs('analytics.sentiment')
        ? 'bg-pink-500/10 text-pink-400'
        : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}"
>
    <svg
        class="h-5 w-5"
        fill="none"
        stroke="currentColor"
        stroke-width="1.8"
        viewBox="0 0 24 24"
    >
        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M9 14l2 2 4-5M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
        />
    </svg>

    Sentiment Analysis
</a>

        </div>

    </nav>


    {{-- Bottom User / Logout --}}
    <div class="border-t border-slate-800 p-4">

        <div class="mb-3 flex items-center gap-3 px-2">

            <div
                class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-pink-500 to-purple-600 text-xs font-bold text-white"
            >
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div class="min-w-0">

                <p class="truncate text-sm font-medium text-white">
                    {{ auth()->user()->name }}
                </p>

                <p class="truncate text-xs text-slate-500">
                    {{ auth()->user()->email }}
                </p>

            </div>

        </div>


        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-400 transition hover:bg-slate-900 hover:text-white"
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"
                    />
                </svg>

                Logout

            </button>

        </form>

    </div>

</aside>