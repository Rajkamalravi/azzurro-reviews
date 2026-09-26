@extends('layouts.dashboard')

@section('title', 'Sentiment Analysis | Azzurro Hotels')

@section('page-title', 'Sentiment Analysis')

@section('page-description', 'Understand positive and negative guest feedback trends')

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
                               bg-violet-500/10 text-violet-600"
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
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16h6M4 5h16a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3-3-3H4a2 2 0 01-2-2V7a2 2 0 012-2z"
                            />
                        </svg>
                    </span>

                    <span class="text-xs font-semibold uppercase tracking-wider text-violet-600">
                        Analytics
                    </span>

                </div>

                <h2 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Sentiment Analysis
                </h2>

                <p class="mt-1 max-w-2xl text-sm text-slate-500">
                    Monitor positive and negative guest feedback to understand
                    changes in overall guest sentiment.
                </p>

            </div>


            {{-- Days tracked --}}
            <div
                class="inline-flex w-fit items-center gap-2 rounded-full
                       border border-slate-200 bg-white px-3.5 py-2
                       text-xs font-medium text-slate-600 shadow-sm"
            >
                <span class="h-2 w-2 rounded-full bg-violet-500"></span>

                {{ count($sentimentTrend) }} days tracked
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
                   px-5 py-5 sm:flex-row sm:items-center
                   sm:justify-between sm:px-6"
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
                        Filter sentiment
                    </h3>

                    <p class="mt-0.5 text-xs text-slate-500">
                        Compare guest sentiment by property and date range.
                    </p>

                </div>

            </div>


            @if (
                !empty($filters['property_id']) ||
                !empty($filters['start_date']) ||
                !empty($filters['end_date'])
            )

                <span
                    class="inline-flex w-fit items-center rounded-full
                           bg-violet-50 px-3 py-1 text-xs font-medium
                           text-violet-700"
                >
                    Filters applied
                </span>

            @endif

        </div>


        {{-- Filter Form --}}
        <form
            method="GET"
            action="{{ route('analytics.sentiment') }}"
            class="p-5 sm:p-6"
        >

            <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

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
                               focus:border-violet-500 focus:bg-white
                               focus:ring-2 focus:ring-violet-500/10"
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
                               focus:border-violet-500 focus:bg-white
                               focus:ring-2 focus:ring-violet-500/10"
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
                               focus:border-violet-500 focus:bg-white
                               focus:ring-2 focus:ring-violet-500/10"
                    >

                </div>

            </div>


            {{-- Form Actions --}}
            <div
                class="mt-6 flex flex-col-reverse gap-3 border-t
                       border-slate-100 pt-5 sm:flex-row sm:items-center"
            >

                <a
                    href="{{ route('analytics.sentiment') }}"
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
                           rounded-xl bg-violet-600 px-5 py-2.5
                           text-sm font-semibold text-white
                           shadow-sm shadow-violet-600/20
                           transition hover:bg-violet-700
                           focus:outline-none focus:ring-2
                           focus:ring-violet-500 focus:ring-offset-2"
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
         SENTIMENT OVERVIEW
         ========================================================= --}}
    @php
        $totalPositive = collect($sentimentTrend)->sum('positive');
        $totalNegative = collect($sentimentTrend)->sum('negative');
        $totalReviews = $totalPositive + $totalNegative;

        $positivePercentage = $totalReviews > 0
            ? round(($totalPositive / $totalReviews) * 100, 1)
            : 0;

        $negativePercentage = $totalReviews > 0
            ? round(($totalNegative / $totalReviews) * 100, 1)
            : 0;
    @endphp


    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

        {{-- Total Reviews --}}
        <div
            class="rounded-2xl border border-slate-200 bg-white
                   p-5 shadow-sm"
        >

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Total Reviews
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                        {{ number_format($totalReviews) }}
                    </p>

                </div>

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
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16h6M4 5h16a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3-3-3H4a2 2 0 01-2-2V7a2 2 0 012-2z"
                        />
                    </svg>
                </div>

            </div>

            <p class="mt-3 text-xs text-slate-400">
                Reviews in the selected period
            </p>

        </div>


        {{-- Positive --}}
        <div
            class="rounded-2xl border border-emerald-200 bg-emerald-50/60
                   p-5 shadow-sm"
        >

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">
                        Positive
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-emerald-700">
                        {{ number_format($totalPositive) }}
                    </p>

                </div>

                <div
                    class="flex h-10 w-10 items-center justify-center
                           rounded-xl bg-emerald-100 text-emerald-600"
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
                            d="M20 6L9 17l-5-5"
                        />
                    </svg>
                </div>

            </div>

            <div class="mt-3 flex items-center justify-between">

                <span class="text-xs text-emerald-700">
                    Positive sentiment
                </span>

                <span class="text-xs font-bold text-emerald-700">
                    {{ number_format($positivePercentage, 1) }}%
                </span>

            </div>

        </div>


        {{-- Negative --}}
        <div
            class="rounded-2xl border border-red-200 bg-red-50/60
                   p-5 shadow-sm"
        >

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wide text-red-700">
                        Negative
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-red-700">
                        {{ number_format($totalNegative) }}
                    </p>

                </div>

                <div
                    class="flex h-10 w-10 items-center justify-center
                           rounded-xl bg-red-100 text-red-600"
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
                            d="M6 6l12 12M18 6L6 18"
                        />
                    </svg>
                </div>

            </div>

            <div class="mt-3 flex items-center justify-between">

                <span class="text-xs text-red-700">
                    Negative sentiment
                </span>

                <span class="text-xs font-bold text-red-700">
                    {{ number_format($negativePercentage, 1) }}%
                </span>

            </div>

        </div>

    </div>


    {{-- =========================================================
         SENTIMENT CHART
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
                           rounded-xl bg-violet-50 text-violet-600"
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
                            d="M4 19V5M4 19h16M7 15l4-4 3 3 5-7"
                        />
                    </svg>
                </div>

                <div>

                    <h3 class="text-base font-semibold text-slate-900">
                        Sentiment Trend
                    </h3>

                    <p class="mt-0.5 text-xs text-slate-500">
                        Daily positive and negative guest feedback.
                    </p>

                </div>

            </div>


            {{-- Legend --}}
            <div class="flex items-center gap-4">

                <div class="flex items-center gap-2">

                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>

                    <span class="text-xs font-medium text-slate-600">
                        Positive
                    </span>

                </div>

                <div class="flex items-center gap-2">

                    <span class="h-2.5 w-2.5 rounded-full bg-red-500"></span>

                    <span class="text-xs font-medium text-slate-600">
                        Negative
                    </span>

                </div>

            </div>

        </div>


        {{-- Chart Body --}}
        <div class="p-5 sm:p-6">

            @if ($totalReviews > 0)

                <div class="relative h-[360px] sm:h-[420px]">

                    <canvas
                        id="sentimentTrendChart"
                        data-labels='@json(collect($sentimentTrend)->pluck("label")->values())'
                        data-positive='@json(collect($sentimentTrend)->pluck("positive")->values())'
                        data-negative='@json(collect($sentimentTrend)->pluck("negative")->values())'
                    ></canvas>

                </div>

            @else

                {{-- Empty State --}}
                <div
                    class="flex min-h-[360px] flex-col items-center
                           justify-center text-center"
                >

                    <div
                        class="mb-5 flex h-16 w-16 items-center justify-center
                               rounded-2xl bg-slate-100 text-slate-400"
                    >
                        <svg
                            class="h-8 w-8"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.6"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16h6M4 5h16a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3-3-3H4a2 2 0 01-2-2V7a2 2 0 012-2z"
                            />
                        </svg>
                    </div>

                    <h4 class="text-base font-semibold text-slate-900">
                        No sentiment data available
                    </h4>

                    <p class="mt-1 max-w-md text-sm leading-6 text-slate-500">
                        There are no reviews matching the selected filters.
                        Try changing the property or date range.
                    </p>

                    <a
                        href="{{ route('analytics.sentiment') }}"
                        class="mt-5 inline-flex items-center gap-2
                               rounded-xl border border-slate-200
                               bg-white px-4 py-2.5 text-sm font-medium
                               text-slate-600 shadow-sm transition
                               hover:bg-slate-50 hover:text-slate-900"
                    >
                        Clear filters

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
                                d="M5 12h14M13 6l6 6-6 6"
                            />
                        </svg>
                    </a>

                </div>

            @endif

        </div>

    </div>


    {{-- =========================================================
         SENTIMENT INTERPRETATION
         ========================================================= --}}
    @if ($totalReviews > 0)

        <div
            class="mt-6 rounded-2xl border border-violet-200
                   bg-violet-50/60 p-5"
        >

            <div class="flex gap-3">

                <div
                    class="mt-0.5 flex h-8 w-8 shrink-0 items-center
                           justify-center rounded-lg bg-violet-100
                           text-violet-700"
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
                            d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"
                        />
                    </svg>
                </div>

                <div>

                    <p class="text-sm font-semibold text-violet-900">
                        Sentiment overview
                    </p>

                    <p class="mt-1 text-xs leading-5 text-violet-800">
                        Positive feedback represents reviews with a rating of
                        7 or higher, while negative feedback represents reviews
                        below 7, based on the current analytics classification.
                    </p>

                </div>

            </div>

        </div>

    @endif

@endsection
