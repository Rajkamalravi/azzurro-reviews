@extends('layouts.dashboard')

@section('title', 'Rating Trends | Azzurro Hotels')

@section('page-title', 'Rating Trends')

@section('page-description', 'Track guest rating performance over time')

@section('content')

    {{-- =========================================================
         PAGE HEADER
         ========================================================= --}}
    <div class="mb-8">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <div class="mb-2 flex items-center gap-2">

                    <span
                        class="flex h-9 w-9 items-center justify-center rounded-xl
                               bg-pink-500/10 text-pink-600"
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
                    </span>

                    <span class="text-xs font-semibold uppercase tracking-wider text-pink-600">
                        Analytics
                    </span>

                </div>

                <h2 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Rating Trends
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Track daily guest rating performance and identify changes over time.
                </p>

            </div>

            {{-- Current result count --}}
            <div
                class="inline-flex w-fit items-center gap-2 rounded-full
                       border border-slate-200 bg-white px-3.5 py-2
                       text-xs font-medium text-slate-600 shadow-sm"
            >
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                {{ count($ratingTrend) }} days tracked
            </div>

        </div>

    </div>


    {{-- =========================================================
         FILTERS
         ========================================================= --}}
    <div
        class="overflow-hidden rounded-2xl border border-slate-200
               bg-white shadow-sm"
    >

        {{-- Filter Header --}}
        <div
            class="flex flex-col gap-3 border-b border-slate-200
                   px-5 py-5 sm:flex-row sm:items-center sm:justify-between
                   sm:px-6"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center
                           rounded-xl bg-slate-100 text-slate-600"
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
                            d="M3 5h18M6 12h12M10 19h4"
                        />
                    </svg>
                </div>

                <div>

                    <h3 class="text-sm font-semibold text-slate-900">
                        Filter results
                    </h3>

                    <p class="mt-0.5 text-xs text-slate-500">
                        Narrow the trend by property, date range or rating.
                    </p>

                </div>

            </div>

            @if (
                !empty($filters['property_id']) ||
                !empty($filters['start_date']) ||
                !empty($filters['end_date']) ||
                !empty($filters['rating'])
            )
                <span
                    class="inline-flex w-fit items-center rounded-full
                           bg-pink-50 px-3 py-1 text-xs font-medium text-pink-700"
                >
                    Filters applied
                </span>
            @endif

        </div>


        {{-- Filter Form --}}
        <form
            method="GET"
            action="{{ route('analytics.rating') }}"
            class="p-5 sm:p-6"
        >

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4">

                {{-- Property --}}
                <div>

                    <label
                        for="property_id"
                        class="mb-2 block text-xs font-semibold uppercase
                               tracking-wide text-slate-500"
                    >
                        Property
                    </label>

                    <select
                        name="property_id"
                        id="property_id"
                        class="block w-full rounded-xl border border-slate-200
                               bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800
                               outline-none transition
                               focus:border-pink-500 focus:bg-white
                               focus:ring-2 focus:ring-pink-500/10"
                    >

                        <option value="">
                            All properties
                        </option>

                        @foreach ($properties as $property)

                            <option
                                value="{{ $property->id }}"
                                @selected(
                                    (string) ($filters['property_id'] ?? '') ===
                                    (string) $property->id
                                )
                            >
                                {{ $property->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- From --}}
                <div>

                    <label
                        for="start_date"
                        class="mb-2 block text-xs font-semibold uppercase
                               tracking-wide text-slate-500"
                    >
                        From
                    </label>

                    <input
                        type="date"
                        name="start_date"
                        id="start_date"
                        value="{{ $filters['start_date'] ?? '' }}"
                        class="block w-full rounded-xl border border-slate-200
                               bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800
                               outline-none transition
                               focus:border-pink-500 focus:bg-white
                               focus:ring-2 focus:ring-pink-500/10"
                    >

                </div>


                {{-- To --}}
                <div>

                    <label
                        for="end_date"
                        class="mb-2 block text-xs font-semibold uppercase
                               tracking-wide text-slate-500"
                    >
                        To
                    </label>

                    <input
                        type="date"
                        name="end_date"
                        id="end_date"
                        value="{{ $filters['end_date'] ?? '' }}"
                        class="block w-full rounded-xl border border-slate-200
                               bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800
                               outline-none transition
                               focus:border-pink-500 focus:bg-white
                               focus:ring-2 focus:ring-pink-500/10"
                    >

                </div>


                {{-- Rating --}}
                <div>

                    <label
                        for="rating"
                        class="mb-2 block text-xs font-semibold uppercase
                               tracking-wide text-slate-500"
                    >
                        Rating
                    </label>

                    <select
                        name="rating"
                        id="rating"
                        class="block w-full rounded-xl border border-slate-200
                               bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800
                               outline-none transition
                               focus:border-pink-500 focus:bg-white
                               focus:ring-2 focus:ring-pink-500/10"
                    >

                        <option value="">
                            All ratings
                        </option>

                        @for ($rating = 1; $rating <= 10; $rating++)

                            <option
                                value="{{ $rating }}"
                                @selected(
                                    (string) ($filters['rating'] ?? '') ===
                                    (string) $rating
                                )
                            >
                                {{ $rating }}/10
                            </option>

                        @endfor

                    </select>

                </div>

            </div>


            {{-- Form Actions --}}
            <div
                class="mt-6 flex flex-col-reverse gap-3 border-t
                       border-slate-100 pt-5 sm:flex-row sm:items-center"
            >

                <a
                    href="{{ route('analytics.rating') }}"
                    class="inline-flex items-center justify-center gap-2
                           rounded-xl border border-slate-200 bg-white
                           px-4 py-2.5 text-sm font-medium text-slate-600
                           transition hover:border-slate-300 hover:bg-slate-50
                           hover:text-slate-900"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 6l12 12M18 6L6 18"
                        />
                    </svg>

                    Clear
                </a>


                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2
                           rounded-xl bg-pink-600 px-5 py-2.5
                           text-sm font-semibold text-white
                           shadow-sm shadow-pink-600/20
                           transition hover:bg-pink-700
                           focus:outline-none focus:ring-2
                           focus:ring-pink-500 focus:ring-offset-2"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z"
                        />
                    </svg>

                    Apply Filters
                </button>

            </div>

        </form>

    </div>


    {{-- =========================================================
         CHART
         ========================================================= --}}
    <div
        class="mt-6 overflow-hidden rounded-2xl border border-slate-200
               bg-white shadow-sm"
    >

        {{-- Chart Header --}}
        <div
            class="flex flex-col gap-4 border-b border-slate-200
                   px-5 py-5 sm:flex-row sm:items-center
                   sm:justify-between sm:px-6"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center
                           rounded-xl bg-pink-50 text-pink-600"
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
                            d="M4 19V5M4 19h16M7 15l4-5 3 3 5-7"
                        />
                    </svg>
                </div>

                <div>

                    <h3 class="text-base font-semibold text-slate-900">
                        Average Rating
                    </h3>

                    <p class="mt-0.5 text-xs text-slate-500">
                        Daily rating performance for the selected period.
                    </p>

                </div>

            </div>


            {{-- Legend --}}
            <div
                class="inline-flex w-fit items-center gap-2 rounded-full
                       bg-slate-50 px-3 py-1.5 text-xs font-medium
                       text-slate-600"
            >
                <span class="h-2 w-2 rounded-full bg-pink-500"></span>

                Average rating
            </div>

        </div>


        {{-- Chart Body --}}
        <div class="p-5 sm:p-6">

            @if (collect($ratingTrend)->whereNotNull('rating')->count() > 0)

                <div class="relative h-[360px] sm:h-[420px]">

                    <canvas
                        id="ratingTrendChart"
                        data-labels='@json(collect($ratingTrend)->pluck("label")->values())'
                        data-ratings='@json(collect($ratingTrend)->pluck("rating")->values())'
                    ></canvas>

                </div>

            @else

                {{-- Empty State --}}
                <div
                    class="flex min-h-[360px] flex-col items-center
                           justify-center text-center"
                >

                    <div
                        class="mb-4 flex h-14 w-14 items-center justify-center
                               rounded-2xl bg-slate-100 text-slate-400"
                    >
                        <svg
                            class="h-7 w-7"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.6"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 3v18h18M7 16l4-5 3 3 4-6"
                            />
                        </svg>
                    </div>

                    <h4 class="text-sm font-semibold text-slate-900">
                        No rating data available
                    </h4>

                    <p class="mt-1 max-w-sm text-sm text-slate-500">
                        There are no reviews matching the selected filters.
                        Try changing the property, date range or rating.
                    </p>

                </div>

            @endif

        </div>

    </div>

@endsection
