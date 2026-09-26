@extends('layouts.dashboard')

@section('title', 'Dashboard | Azzurro Hotels')
@section('page-title', 'Dashboard')
@section('page-description', 'Overview of guest review performance')

@section('content')

@php
    $currentAverage = $kpis['current_average'] ?? 0;
    $previousAverage = $kpis['previous_average'] ?? 0;
    $ratingChange = $kpis['rating_change'] ?? 0;

    $currentReviewCount = $kpis['current_review_count'] ?? 0;
    $previousReviewCount = $kpis['previous_review_count'] ?? 0;

    $positivePercentage = $kpis['positive_percentage'] ?? 0;
    $negativePercentage = $kpis['negative_percentage'] ?? 0;

    $ratingChangePositive = $ratingChange >= 0;
    $reviewChange = $currentReviewCount - $previousReviewCount;
    $reviewChangePositive = $reviewChange >= 0;

    $currentWeekStart = $kpis['current_week_start'] ?? null;
    $currentWeekEnd = $kpis['current_week_end'] ?? null;

    $ratingTrendCollection = collect($ratingTrend ?? []);
    $sentimentTrendCollection = collect($sentimentTrend ?? []);
    $propertyPerformanceCollection = collect($propertyPerformance ?? []);
    $operationalInsightsCollection = collect($operationalInsights ?? []);

    $totalPositive =
        $sentimentTrendCollection->sum('positive');

    $totalNegative =
        $sentimentTrendCollection->sum('negative');

    $totalSentimentReviews =
        $totalPositive + $totalNegative;
@endphp


{{-- =========================================================
     HERO / DASHBOARD HEADER
     ========================================================= --}}
<div class="mb-8">

    <div
        class="relative overflow-hidden rounded-3xl
               bg-slate-950 px-6 py-7 text-white shadow-sm
               lg:px-8"
    >

        {{-- Decorative background --}}
        <div
            class="pointer-events-none absolute -right-20 -top-24
                   h-64 w-64 rounded-full bg-pink-500/10 blur-3xl"
        ></div>

        <div
            class="pointer-events-none absolute -bottom-32 left-1/3
                   h-64 w-64 rounded-full bg-violet-500/10 blur-3xl"
        ></div>


        <div class="relative flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">

            <div>

                <div class="mb-3 flex items-center gap-2">

                    <div
                        class="flex h-9 w-9 items-center justify-center
                               rounded-xl bg-white/10 text-pink-400"
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
                    </div>

                    <span class="text-sm font-medium text-slate-300">
                        Guest Review Intelligence
                    </span>

                </div>


                <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">
                    Review Performance Overview
                </h2>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-400">
                    Monitor guest satisfaction, review volume, sentiment,
                    and operational themes across your hotel properties.
                </p>

            </div>


            {{-- Current period --}}
            @if ($currentWeekStart && $currentWeekEnd)

                <div
                    class="shrink-0 rounded-2xl border border-white/10
                           bg-white/5 px-4 py-3 backdrop-blur"
                >

                    <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">
                        Current Period
                    </p>

                    <p class="mt-1 text-sm font-semibold text-white">
                        {{ \Carbon\Carbon::parse($currentWeekStart)->format('d M') }}
                        –
                        {{ \Carbon\Carbon::parse($currentWeekEnd)->format('d M Y') }}
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>


{{-- =========================================================
     KPI CARDS
     ========================================================= --}}
<div class="mb-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

    {{-- Average Rating --}}
    <div
        class="rounded-2xl border border-slate-200 bg-white p-5
               shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
    >

        <div class="flex items-start justify-between">

            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Average Rating
                </p>

                <div class="mt-3 flex items-baseline gap-2">

                    <span class="text-3xl font-bold tracking-tight text-slate-900">
                        {{ number_format($currentAverage, 2) }}
                    </span>

                    <span class="text-sm text-slate-400">
                        / 10
                    </span>

                </div>

                <div class="mt-2 flex items-center gap-1.5 text-xs">

                    <span
                        class="{{ $ratingChangePositive
                            ? 'text-emerald-600'
                            : 'text-rose-600' }} font-semibold"
                    >
                        {{ $ratingChangePositive ? '+' : '' }}{{ number_format($ratingChange, 2) }}
                    </span>

                    <span class="text-slate-400">
                        vs previous week
                    </span>

                </div>

            </div>


            <div
                class="flex h-11 w-11 items-center justify-center rounded-xl
                       bg-amber-500/10 text-amber-500"
            >
                <svg
                    class="h-5 w-5"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="m12 3 2.78 5.63 6.22.9-4.5 4.39 1.06 6.2L12 17.2l-5.56 2.92 1.06-6.2L3 9.53l6.22-.9L12 3Z"
                    />
                </svg>
            </div>

        </div>

    </div>


    {{-- Review Volume --}}
    <div
        class="rounded-2xl border border-slate-200 bg-white p-5
               shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
    >

        <div class="flex items-start justify-between">

            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Review Volume
                </p>

                <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                    {{ number_format($currentReviewCount) }}
                </p>

                <div class="mt-2 flex items-center gap-1.5 text-xs">

                    <span
                        class="{{ $reviewChangePositive
                            ? 'text-emerald-600'
                            : 'text-rose-600' }} font-semibold"
                    >
                        {{ $reviewChangePositive ? '+' : '' }}{{ number_format($reviewChange) }}
                    </span>

                    <span class="text-slate-400">
                        vs previous week
                    </span>

                </div>

            </div>


            <div
                class="flex h-11 w-11 items-center justify-center rounded-xl
                       bg-violet-500/10 text-violet-500"
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
                        d="M8 10h8M8 14h5M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"
                    />
                </svg>
            </div>

        </div>

    </div>


    {{-- Positive --}}
    <div
        class="rounded-2xl border border-slate-200 bg-white p-5
               shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
    >

        <div class="flex items-start justify-between">

            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Positive Reviews
                </p>

                <p class="mt-3 text-3xl font-bold tracking-tight text-emerald-600">
                    {{ number_format($positivePercentage, 1) }}%
                </p>

                <p class="mt-2 text-xs text-slate-400">
                    {{ number_format($kpis['positive_count'] ?? $totalPositive) }}
                    reviews rated 7+
                </p>

            </div>


            <div
                class="flex h-11 w-11 items-center justify-center rounded-xl
                       bg-emerald-500/10 text-emerald-500"
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
                        d="m5 12 4 4L19 6"
                    />
                </svg>
            </div>

        </div>

    </div>


    {{-- Negative --}}
    <div
        class="rounded-2xl border border-slate-200 bg-white p-5
               shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
    >

        <div class="flex items-start justify-between">

            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Negative Reviews
                </p>

                <p class="mt-3 text-3xl font-bold tracking-tight text-rose-600">
                    {{ number_format($negativePercentage, 1) }}%
                </p>

                <p class="mt-2 text-xs text-slate-400">
                    {{ number_format($kpis['negative_count'] ?? $totalNegative) }}
                    reviews rated below 7
                </p>

            </div>


            <div
                class="flex h-11 w-11 items-center justify-center rounded-xl
                       bg-rose-500/10 text-rose-500"
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
                        d="M12 9v4M12 17h.01M10.3 3.9 2.8 17a2 2 0 0 0 1.75 3h14.9a2 2 0 0 0 1.75-3l-7.5-13.1a2 2 0 0 0-3.4 0Z"
                    />
                </svg>
            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     FILTERS
     ========================================================= --}}
<div
    class="mb-8 rounded-2xl border border-slate-200
           bg-white shadow-sm"
>

    <div class="border-b border-slate-100 px-6 py-5">

        <div class="flex items-center gap-3">

            <div
                class="flex h-9 w-9 items-center justify-center
                       rounded-xl bg-slate-100 text-slate-600"
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
                        d="M3 6h18M6 12h12M10 18h4"
                    />
                </svg>
            </div>

            <div>

                <h3 class="text-sm font-semibold text-slate-900">
                    Review Filters
                </h3>

                <p class="text-xs text-slate-500">
                    Filter the dashboard by property, date, rating, sentiment, or topic.
                </p>

            </div>

        </div>

    </div>


    <form
        method="GET"
        action="{{ route('dashboard') }}"
        class="p-6"
    >

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">

            {{-- Property --}}
            <div class="xl:col-span-2">

                <label
                    for="property_id"
                    class="mb-2 block text-xs font-semibold text-slate-600"
                >
                    Property
                </label>

                <select
                    id="property_id"
                    name="property_id"
                    class="w-full rounded-xl border border-slate-200
                           bg-white px-3.5 py-2.5 text-sm text-slate-700
                           outline-none transition
                           focus:border-pink-400 focus:ring-2
                           focus:ring-pink-500/10"
                >
                    <option value="">All properties</option>

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
                    class="mb-2 block text-xs font-semibold text-slate-600"
                >
                    From
                </label>

                <input
                    id="start_date"
                    type="date"
                    name="start_date"
                    value="{{ $filters['start_date'] ?? '' }}"
                    class="w-full rounded-xl border border-slate-200
                           bg-white px-3.5 py-2.5 text-sm text-slate-700
                           outline-none transition
                           focus:border-pink-400 focus:ring-2
                           focus:ring-pink-500/10"
                />

            </div>


            {{-- To --}}
            <div>

                <label
                    for="end_date"
                    class="mb-2 block text-xs font-semibold text-slate-600"
                >
                    To
                </label>

                <input
                    id="end_date"
                    type="date"
                    name="end_date"
                    value="{{ $filters['end_date'] ?? '' }}"
                    class="w-full rounded-xl border border-slate-200
                           bg-white px-3.5 py-2.5 text-sm text-slate-700
                           outline-none transition
                           focus:border-pink-400 focus:ring-2
                           focus:ring-pink-500/10"
                />

            </div>


            {{-- Rating --}}
            <div>

                <label
                    for="rating"
                    class="mb-2 block text-xs font-semibold text-slate-600"
                >
                    Rating
                </label>

                <select
                    id="rating"
                    name="rating"
                    class="w-full rounded-xl border border-slate-200
                           bg-white px-3.5 py-2.5 text-sm text-slate-700
                           outline-none transition
                           focus:border-pink-400 focus:ring-2
                           focus:ring-pink-500/10"
                >
                    <option value="">All ratings</option>

                    @for ($rating = 10; $rating >= 1; $rating--)

                        <option
                            value="{{ $rating }}"
                            @selected(
                                (string) ($filters['rating'] ?? '') ===
                                (string) $rating
                            )
                        >
                            {{ $rating }} / 10
                        </option>

                    @endfor

                </select>

            </div>


            {{-- Sentiment --}}
            <div>

                <label
                    for="sentiment"
                    class="mb-2 block text-xs font-semibold text-slate-600"
                >
                    Sentiment
                </label>

                <select
                    id="sentiment"
                    name="sentiment"
                    class="w-full rounded-xl border border-slate-200
                           bg-white px-3.5 py-2.5 text-sm text-slate-700
                           outline-none transition
                           focus:border-pink-400 focus:ring-2
                           focus:ring-pink-500/10"
                >
                    <option value="">All sentiments</option>

                    <option
                        value="positive"
                        @selected(($filters['sentiment'] ?? '') === 'positive')
                    >
                        Positive
                    </option>

                    <option
                        value="negative"
                        @selected(($filters['sentiment'] ?? '') === 'negative')
                    >
                        Negative
                    </option>

                </select>

            </div>

        </div>


        <div class="mt-4 flex flex-wrap items-center gap-3">

            <button
                type="submit"
                class="inline-flex items-center gap-2 rounded-xl
                       bg-slate-900 px-4 py-2.5 text-sm font-semibold
                       text-white shadow-sm transition
                       hover:bg-slate-800"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <circle cx="11" cy="11" r="7" />
                    <path
                        stroke-linecap="round"
                        d="m20 20-4-4"
                    />
                </svg>

                Apply Filters
            </button>


            @if (
                !empty($filters['property_id']) ||
                !empty($filters['start_date']) ||
                !empty($filters['end_date']) ||
                !empty($filters['rating']) ||
                !empty($filters['sentiment']) ||
                !empty($filters['topic'])
            )

                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 rounded-xl
                           border border-slate-200 bg-white px-4 py-2.5
                           text-sm font-medium text-slate-600 transition
                           hover:border-slate-300 hover:bg-slate-50"
                >
                    Clear Filters
                </a>

                <span
                    class="inline-flex items-center gap-2 rounded-full
                           bg-pink-50 px-3 py-1.5 text-xs font-medium
                           text-pink-600"
                >
                    Filters applied
                </span>

            @endif

        </div>

    </form>

</div>


{{-- =========================================================
     CHARTS
     ========================================================= --}}
<div class="mb-8 grid gap-6 xl:grid-cols-2">

    {{-- Rating Trend --}}
    <div
        class="overflow-hidden rounded-2xl border border-slate-200
               bg-white shadow-sm"
    >

        <div
            class="flex items-start justify-between border-b border-slate-100
                   px-6 py-5"
        >

            <div>

                <div class="flex items-center gap-2">

                    <div
                        class="flex h-8 w-8 items-center justify-center
                               rounded-lg bg-amber-500/10 text-amber-500"
                    >
                        <svg
                            class="h-4 w-4"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="m12 3 2.78 5.63 6.22.9-4.5 4.39 1.06 6.2L12 17.2l-5.56 2.92 1.06-6.2L3 9.53l6.22-.9L12 3Z"
                            />
                        </svg>
                    </div>

                    <h3 class="text-sm font-semibold text-slate-900">
                        Rating Trend
                    </h3>

                </div>

                <p class="mt-1 text-xs text-slate-500">
                    Average guest rating over the selected period
                </p>

            </div>

            <a
                href="{{ route('analytics.rating') }}"
                class="text-xs font-semibold text-pink-500 transition hover:text-pink-600"
            >
                View details
            </a>

        </div>


        <div class="p-6">

            @if ($ratingTrendCollection->filter(fn ($item) => $item['rating'] !== null)->count())

                <div class="h-72">
                    <canvas
                        id="ratingTrendChart"
                        data-labels='@json($ratingTrendCollection->pluck("label")->values())'
                        data-ratings='@json($ratingTrendCollection->pluck("rating")->values())'
                    ></canvas>
                </div>

            @else

                <div
                    class="flex h-72 flex-col items-center justify-center
                           text-center"
                >
                    <div
                        class="flex h-12 w-12 items-center justify-center
                               rounded-xl bg-slate-100 text-slate-400"
                    >
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 19V5M4 19h16M7 15l3-4 3 2 4-6"
                            />
                        </svg>
                    </div>

                    <p class="mt-4 text-sm font-semibold text-slate-700">
                        No rating data
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        No reviews are available for the selected period.
                    </p>
                </div>

            @endif

        </div>

    </div>


    {{-- Sentiment Trend --}}
    <div
        class="overflow-hidden rounded-2xl border border-slate-200
               bg-white shadow-sm"
    >

        <div
            class="flex items-start justify-between border-b border-slate-100
                   px-6 py-5"
        >

            <div>

                <div class="flex items-center gap-2">

                    <div
                        class="flex h-8 w-8 items-center justify-center
                               rounded-lg bg-violet-500/10 text-violet-500"
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
                                d="M7 10h10M7 14h6M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"
                            />
                        </svg>
                    </div>

                    <h3 class="text-sm font-semibold text-slate-900">
                        Sentiment Trend
                    </h3>

                </div>

                <p class="mt-1 text-xs text-slate-500">
                    Positive and negative review distribution
                </p>

            </div>

            <a
                href="{{ route('analytics.sentiment') }}"
                class="text-xs font-semibold text-pink-500 transition hover:text-pink-600"
            >
                View details
            </a>

        </div>


        <div class="p-6">

            @if ($sentimentTrendCollection->sum('total') > 0)

                <div class="h-72">
                    <canvas
                        id="sentimentTrendChart"
                        data-labels='@json($sentimentTrendCollection->pluck("label")->values())'
                        data-positive='@json($sentimentTrendCollection->pluck("positive")->values())'
                        data-negative='@json($sentimentTrendCollection->pluck("negative")->values())'
                    ></canvas>
                </div>

            @else

                <div
                    class="flex h-72 flex-col items-center justify-center
                           text-center"
                >
                    <div
                        class="flex h-12 w-12 items-center justify-center
                               rounded-xl bg-slate-100 text-slate-400"
                    >
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8 12h8M8 16h5M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"
                            />
                        </svg>
                    </div>

                    <p class="mt-4 text-sm font-semibold text-slate-700">
                        No sentiment data
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        No reviews are available for the selected period.
                    </p>
                </div>

            @endif

        </div>

    </div>

</div>


{{-- =========================================================
     PROPERTY PERFORMANCE + OPERATIONAL INSIGHTS
     ========================================================= --}}
<div class="mb-8 grid gap-6 xl:grid-cols-5">

    {{-- Property Performance --}}
    <div
        class="overflow-hidden rounded-2xl border border-slate-200
               bg-white shadow-sm xl:col-span-3"
    >

        <div
            class="flex items-start justify-between border-b border-slate-100
                   px-6 py-5"
        >

            <div>

                <div class="flex items-center gap-2">

                    <div
                        class="flex h-8 w-8 items-center justify-center
                               rounded-lg bg-pink-500/10 text-pink-500"
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
                                d="M3 21h18M5 21V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v16M15 21V9a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v12"
                            />
                        </svg>
                    </div>

                    <h3 class="text-sm font-semibold text-slate-900">
                        Property Performance
                    </h3>

                </div>

                <p class="mt-1 text-xs text-slate-500">
                    Current-week review performance by property
                </p>

            </div>

            <a
                href="{{ route('properties') }}"
                class="text-xs font-semibold text-pink-500 transition hover:text-pink-600"
            >
                View properties
            </a>

        </div>


        @if ($propertyPerformanceCollection->count())

            <div class="divide-y divide-slate-100">

                @foreach ($propertyPerformanceCollection as $property)

                    @php
                        $propertyRating = $property['average_rating'] ?? 0;
                        $propertyPositive = $property['positive_percentage'] ?? 0;
                        $propertyReviewCount = $property['review_count'] ?? 0;
                    @endphp

                    <div class="px-6 py-5 transition hover:bg-slate-50/60">

                        <div class="flex items-center justify-between gap-4">

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="flex h-10 w-10 shrink-0 items-center
                                           justify-center rounded-xl bg-slate-900
                                           text-xs font-bold text-white"
                                >
                                    {{ strtoupper(substr($property['name'], 0, 1)) }}
                                </div>

                                <div class="min-w-0">

                                    <p class="truncate text-sm font-semibold text-slate-800">
                                        {{ $property['name'] }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-400">
                                        {{ number_format($propertyReviewCount) }}
                                        {{ \Illuminate\Support\Str::plural('review', $propertyReviewCount) }}
                                    </p>

                                </div>

                            </div>


                            <div class="shrink-0 text-right">

                                <div class="flex items-center justify-end gap-1">

                                    <svg
                                        class="h-3.5 w-3.5 text-amber-400"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="m12 3 2.78 5.63 6.22.9-4.5 4.39 1.06 6.2L12 17.2l-5.56 2.92 1.06-6.2L3 9.53l6.22-.9L12 3Z"
                                        />
                                    </svg>

                                    <span class="text-sm font-bold text-slate-800">
                                        {{ number_format($propertyRating, 2) }}
                                    </span>

                                </div>

                                <p class="mt-0.5 text-[10px] text-slate-400">
                                    / 10
                                </p>

                            </div>

                        </div>


                        <div class="mt-4">

                            <div class="mb-1.5 flex items-center justify-between">

                                <span class="text-[10px] font-medium text-slate-400">
                                    Positive reviews
                                </span>

                                <span class="text-[10px] font-semibold text-slate-600">
                                    {{ number_format($propertyPositive, 1) }}%
                                </span>

                            </div>

                            <div class="h-1.5 overflow-hidden rounded-full bg-slate-100">

                                <div
                                    class="h-full rounded-full bg-emerald-500 transition-all"
                                    style="width: {{ min(100, max(0, $propertyPositive)) }}%"
                                ></div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="px-6 py-16 text-center">

                <p class="text-sm font-semibold text-slate-700">
                    No property data
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    Property performance will appear here when reviews are available.
                </p>

            </div>

        @endif

    </div>


    {{-- Operational Insights --}}
    <div
        class="overflow-hidden rounded-2xl border border-slate-200
               bg-white shadow-sm xl:col-span-2"
    >

        <div
            class="flex items-start justify-between border-b border-slate-100
                   px-6 py-5"
        >

            <div>

                <div class="flex items-center gap-2">

                    <div
                        class="flex h-8 w-8 items-center justify-center
                               rounded-lg bg-rose-500/10 text-rose-500"
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
                                d="M12 9v4M12 17h.01M10.3 3.9 2.8 17a2 2 0 0 0 1.75 3h14.9a2 2 0 0 0 2-3l-7.5-13.1a2 2 0 0 0-3.4 0Z"
                            />
                        </svg>
                    </div>

                    <h3 class="text-sm font-semibold text-slate-900">
                        Operational Insights
                    </h3>

                </div>

                <p class="mt-1 text-xs text-slate-500">
                    Topics appearing in negative feedback
                </p>

            </div>

            <a
                href="{{ route('analytics.operational') }}"
                class="text-xs font-semibold text-pink-500 transition hover:text-pink-600"
            >
                View details
            </a>

        </div>


        @if ($operationalInsightsCollection->count())

            <div class="p-6">

                <div class="space-y-5">

                    @foreach ($operationalInsightsCollection->take(5) as $index => $insight)

                        @php
                            $percentage = min(
                                100,
                                max(0, (float) ($insight['percentage'] ?? 0))
                            );

                            $topic = ucwords(
                                str_replace(
                                    ['_', '-'],
                                    ' ',
                                    $insight['topic'] ?? 'Unknown'
                                )
                            );

                            if ($percentage >= 30) {
                                $barClass = 'bg-rose-500';
                                $badgeClass = 'bg-rose-50 text-rose-700';
                            } elseif ($percentage >= 15) {
                                $barClass = 'bg-amber-500';
                                $badgeClass = 'bg-amber-50 text-amber-700';
                            } else {
                                $barClass = 'bg-slate-400';
                                $badgeClass = 'bg-slate-100 text-slate-600';
                            }
                        @endphp

                        <div>

                            <div class="mb-2 flex items-center justify-between gap-3">

                                <div class="flex min-w-0 items-center gap-2">

                                    <span
                                        class="flex h-6 w-6 shrink-0 items-center
                                               justify-center rounded-lg
                                               bg-slate-100 text-[10px]
                                               font-bold text-slate-500"
                                    >
                                        {{ $index + 1 }}
                                    </span>

                                    <span class="truncate text-sm font-medium text-slate-700">
                                        {{ $topic }}
                                    </span>

                                </div>


                                <div class="flex shrink-0 items-center gap-2">

                                    <span
                                        class="hidden rounded-full px-2 py-1
                                               text-[10px] font-semibold sm:inline-flex
                                               {{ $badgeClass }}"
                                    >
                                        {{ number_format($percentage, 1) }}%
                                    </span>

                                    <span class="text-xs text-slate-400">
                                        {{ $insight['review_count'] ?? 0 }}
                                    </span>

                                </div>

                            </div>


                            <div class="h-2 overflow-hidden rounded-full bg-slate-100">

                                <div
                                    class="h-full rounded-full transition-all {{ $barClass }}"
                                    style="width: {{ $percentage }}%"
                                ></div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        @else

            <div class="px-6 py-16 text-center">

                <div
                    class="mx-auto flex h-12 w-12 items-center justify-center
                           rounded-xl bg-emerald-50 text-emerald-500"
                >
                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m5 12 4 4L19 6"
                        />
                    </svg>
                </div>

                <p class="mt-4 text-sm font-semibold text-slate-700">
                    No operational issues detected
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    Negative feedback topics will appear here.
                </p>

            </div>

        @endif

    </div>

</div>

{{-- =========================================================
     RECENT REVIEWS
     ========================================================= --}}
<div
    class="overflow-hidden rounded-2xl border border-slate-200
           bg-white shadow-sm"
>

    {{-- Header --}}
    <div
        class="flex flex-col gap-3 border-b border-slate-100
               px-6 py-5 sm:flex-row sm:items-center sm:justify-between"
    >

        <div>

            <div class="flex items-center gap-2">

                <div
                    class="flex h-8 w-8 items-center justify-center
                           rounded-lg bg-violet-500/10 text-violet-500"
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
                            d="M8 10h8M8 14h5M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"
                        />
                    </svg>
                </div>

                <h3 class="text-sm font-semibold text-slate-900">
                    Recent Reviews
                </h3>

            </div>

            <p class="mt-1 text-xs text-slate-500">
                Latest guest feedback from the selected view
            </p>

        </div>

        <a
            href="{{ route('reviews') }}"
            class="inline-flex items-center gap-1.5 text-xs font-semibold
                   text-pink-500 transition hover:text-pink-600"
        >
            View all reviews

            <svg
                class="h-3.5 w-3.5"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m9 18 6-6-6-6"
                />
            </svg>
        </a>

    </div>

{{-- =====================================================
     REVIEW LIST
     ===================================================== --}}

@if ($recentReviews && $recentReviews->count())

    <div class="divide-y divide-slate-100">

       @foreach ($recentReviews as $review)

            @php
                $rating = (float) ($review->rating ?? 0);

                $isPositive = $rating >= 7;

                $reviewDate = $review->review_date
                    ? \Carbon\Carbon::parse($review->review_date)
                    : null;

                $positiveText = trim(
                    (string) ($review->positive_text ?? '')
                );

                $negativeText = trim(
                    (string) ($review->negative_text ?? '')
                );

                /*
                 * Display the available review text.
                 *
                 * Positive reviews -> positive_text
                 * Negative reviews -> negative_text
                 *
                 * Fallback to the other field if needed.
                 */
                if ($isPositive) {
                    $comment = $positiveText ?: $negativeText;
                } else {
                    $comment = $negativeText ?: $positiveText;
                }

                $insights = $review->insights ?? collect();
            @endphp


            <div
                class="px-6 py-5 transition hover:bg-slate-50/60"
            >

                <div class="flex items-start gap-4">

                    {{-- =================================================
                         RATING
                         ================================================= --}}
                    <div
                        class="flex h-12 w-12 shrink-0 flex-col
                               items-center justify-center rounded-xl
                               {{ $isPositive
                                    ? 'bg-emerald-50 text-emerald-700'
                                    : 'bg-rose-50 text-rose-700' }}"
                    >

                        <span class="text-sm font-bold leading-none">
                            {{ number_format($rating, 1) }}
                        </span>

                        <span
                            class="mt-0.5 text-[8px] font-semibold"
                        >
                            / 10
                        </span>

                    </div>


                    {{-- =================================================
                         REVIEW CONTENT
                         ================================================= --}}
                    <div class="min-w-0 flex-1">

                        {{-- Property + Sentiment + Date --}}
                        <div
                            class="flex flex-col gap-2
                                   sm:flex-row sm:items-center
                                   sm:justify-between"
                        >

                            <div
                                class="flex flex-wrap items-center gap-2"
                            >

                                {{-- Property --}}
                                @if ($review->property)

                                    <span
                                        class="text-sm font-semibold text-slate-800"
                                    >
                                        {{ $review->property->name }}
                                    </span>

                                @else

                                    <span
                                        class="text-sm font-semibold text-slate-500"
                                    >
                                        Unknown Property
                                    </span>

                                @endif


                                {{-- Sentiment --}}
                                <span
                                    class="inline-flex items-center gap-1.5
                                           rounded-full px-2.5 py-1
                                           text-[10px] font-semibold
                                           {{ $isPositive
                                                ? 'bg-emerald-50 text-emerald-700'
                                                : 'bg-rose-50 text-rose-700' }}"
                                >

                                    <span
                                        class="h-1.5 w-1.5 rounded-full
                                               {{ $isPositive
                                                    ? 'bg-emerald-500'
                                                    : 'bg-rose-500' }}"
                                    ></span>

                                    {{ $isPositive ? 'Positive' : 'Negative' }}

                                </span>

                            </div>


                            {{-- Date --}}
                            @if ($reviewDate)

                                <span
                                    class="shrink-0 text-[11px] text-slate-400"
                                >
                                    {{ $reviewDate->format('d M Y') }}
                                </span>

                            @endif

                        </div>


                        {{-- =================================================
                             REVIEW TEXT
                             ================================================= --}}
                        @if ($comment)

                            <p
                                class="mt-2 line-clamp-2 text-sm leading-6
                                       text-slate-500"
                            >
                                {{ $comment }}
                            </p>

                        @else

                            <p
                                class="mt-2 text-sm italic text-slate-400"
                            >
                                No review text available.
                            </p>

                        @endif


                     {{-- Insights / Topics --}}
@if ($insights->count()) <div class="mt-4 flex flex-wrap gap-2">
@foreach ($insights->take(5) as $insight)
@if (!empty($insight->topic))
@php
$topic = ucwords(
str_replace(
['_', '-'],
' ',
$insight->topic
)
);

                $insightSentiment = strtolower(
                    trim((string) ($insight->sentiment ?? ''))
                );

                $isPositiveInsight = $insightSentiment === 'positive';
            @endphp

            <span
                class="inline-flex items-center gap-1.5 rounded-lg
                       border px-2.5 py-1 text-[11px] font-medium
                       {{ $isPositiveInsight
                           ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
                           : 'border-rose-200 bg-rose-50 text-rose-700' }}"
            >
                <span>
                    {{ $topic }}
                </span>

                <span class="opacity-50">
                    ·
                </span>

                <span class="font-semibold">
                    {{ $isPositiveInsight ? 'Positive' : 'Negative' }}
                </span>
            </span>
        @endif
    @endforeach
</div>


@endif


                    </div>

                </div>

            </div>

        @endforeach

    </div>


@else

    {{-- =====================================================
         NO REVIEWS AVAILABLE
         ===================================================== --}}

    <div class="px-6 py-16 text-center">

        <div
            class="mx-auto flex h-14 w-14 items-center justify-center
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
                    d="M8 10h8M8 14h5M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"
                />
            </svg>
        </div>

        <h4 class="mt-4 text-sm font-semibold text-slate-800">
            No reviews available
        </h4>

        <p class="mx-auto mt-1 max-w-md text-xs leading-5 text-slate-400">
            There are no guest reviews available for the selected
            property or date range.
        </p>

        @if (
            !empty($filters['property_id']) ||
            !empty($filters['start_date']) ||
            !empty($filters['end_date']) ||
            !empty($filters['rating']) ||
            !empty($filters['sentiment']) ||
            !empty($filters['topic'])
        )

            <a
                href="{{ route('dashboard') }}"
                class="mt-5 inline-flex items-center gap-2 rounded-xl
                       bg-slate-900 px-4 py-2.5 text-xs font-semibold
                       text-white transition hover:bg-slate-800"
            >
                Clear Filters
            </a>

        @endif

    </div>

@endif



</div>


{{-- =========================================================
     CHART.JS
     ========================================================= --}}
@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /*
             * Rating Trend
             */
            const ratingCanvas = document.getElementById('ratingTrendChart');

            if (ratingCanvas && typeof Chart !== 'undefined') {

                const labels = JSON.parse(
                    ratingCanvas.dataset.labels || '[]'
                );

                const ratings = JSON.parse(
                    ratingCanvas.dataset.ratings || '[]'
                );

                new Chart(ratingCanvas, {
                    type: 'line',

                    data: {
                        labels: labels,

                        datasets: [{
                            label: 'Average Rating',
                            data: ratings,
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245, 158, 11, 0.08)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2.5,
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            spanGaps: true
                        }]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },

                        plugins: {
                            legend: {
                                display: false
                            },

                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return ' Rating: ' + context.parsed.y;
                                    }
                                }
                            }
                        },

                        scales: {
                            y: {
                                min: 0,
                                max: 10,

                                ticks: {
                                    stepSize: 2,
                                    color: '#94a3b8'
                                },

                                grid: {
                                    color: '#f1f5f9'
                                }
                            },

                            x: {
                                ticks: {
                                    color: '#94a3b8'
                                },

                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }


            /*
             * Sentiment Trend
             */
            const sentimentCanvas =
                document.getElementById('sentimentTrendChart');

            if (sentimentCanvas && typeof Chart !== 'undefined') {

                const labels = JSON.parse(
                    sentimentCanvas.dataset.labels || '[]'
                );

                const positive = JSON.parse(
                    sentimentCanvas.dataset.positive || '[]'
                );

                const negative = JSON.parse(
                    sentimentCanvas.dataset.negative || '[]'
                );

                new Chart(sentimentCanvas, {
                    type: 'bar',

                    data: {
                        labels: labels,

                        datasets: [
                            {
                                label: 'Positive',
                                data: positive,
                                backgroundColor: 'rgba(16, 185, 129, 0.75)',
                                borderRadius: 6,
                                borderSkipped: false
                            },
                            {
                                label: 'Negative',
                                data: negative,
                                backgroundColor: 'rgba(244, 63, 94, 0.75)',
                                borderRadius: 6,
                                borderSkipped: false
                            }
                        ]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        plugins: {
                            legend: {
                                position: 'bottom',

                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    padding: 18,
                                    color: '#64748b',
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        },

                        scales: {
                            y: {
                                beginAtZero: true,

                                ticks: {
                                    precision: 0,
                                    color: '#94a3b8'
                                },

                                grid: {
                                    color: '#f1f5f9'
                                }
                            },

                            x: {
                                ticks: {
                                    color: '#94a3b8'
                                },

                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

        });
    </script>

@endpush

@endsection
