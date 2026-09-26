```blade
@extends('layouts.dashboard')

@section('title', 'Operational Insights | Azzurro Hotels')

@section('page-title', 'Operational Insights')

@section('page-description', 'Identify recurring operational issues from guest feedback')

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
                               bg-amber-500/10 text-amber-600"
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
                                d="M12 9v4m0 4h.01M10.3 3.7L2.9 17a2 2 0 001.75 3h14.7a2 2 0 001.75-3L13.7 3.7a2 2 0 00-3.4 0z"
                            />
                        </svg>
                    </span>

                    <span class="text-xs font-semibold uppercase tracking-wider text-amber-600">
                        Analytics
                    </span>

                </div>

                <h2 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Operational Insights
                </h2>

                <p class="mt-1 max-w-2xl text-sm text-slate-500">
                    Identify recurring operational issues and understand which
                    areas are generating negative guest feedback.
                </p>

            </div>

            {{-- Insight count --}}
            <div
                class="inline-flex w-fit items-center gap-2 rounded-full
                       border border-slate-200 bg-white px-3.5 py-2
                       text-xs font-medium text-slate-600 shadow-sm"
            >
                <span class="h-2 w-2 rounded-full bg-amber-500"></span>

                {{ count($operationalInsights) }} issue categories
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
                        Filter insights
                    </h3>

                    <p class="mt-0.5 text-xs text-slate-500">
                        Analyze operational issues by property and date range.
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
                           bg-amber-50 px-3 py-1 text-xs font-medium
                           text-amber-700"
                >
                    Filters applied
                </span>
            @endif

        </div>


        {{-- Filter Form --}}
        <form
            method="GET"
            action="{{ route('analytics.operational') }}"
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
                               focus:border-amber-500 focus:bg-white
                               focus:ring-2 focus:ring-amber-500/10"
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
                               focus:border-amber-500 focus:bg-white
                               focus:ring-2 focus:ring-amber-500/10"
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
                               focus:border-amber-500 focus:bg-white
                               focus:ring-2 focus:ring-amber-500/10"
                    >

                </div>

            </div>


            {{-- Form Actions --}}
            <div
                class="mt-6 flex flex-col-reverse gap-3 border-t
                       border-slate-100 pt-5 sm:flex-row sm:items-center"
            >

                <a
                    href="{{ route('analytics.operational') }}"
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
                           rounded-xl bg-amber-500 px-5 py-2.5
                           text-sm font-semibold text-white
                           shadow-sm shadow-amber-500/20
                           transition hover:bg-amber-600
                           focus:outline-none focus:ring-2
                           focus:ring-amber-500 focus:ring-offset-2"
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
         OPERATIONAL INSIGHTS
         ========================================================= --}}
    <div
        class="mt-6 overflow-hidden rounded-2xl border border-slate-200
               bg-white shadow-sm"
    >

        {{-- Section Header --}}
        <div
            class="flex flex-col gap-4 border-b border-slate-200
                   px-5 py-5 sm:flex-row sm:items-center
                   sm:justify-between sm:px-6"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center
                           rounded-xl bg-amber-50 text-amber-600"
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
                </div>

                <div>

                    <h3 class="text-base font-semibold text-slate-900">
                        Operational Issues
                    </h3>

                    <p class="mt-0.5 text-xs text-slate-500">
                        Topics mentioned in negative guest feedback.
                    </p>

                </div>

            </div>


            @if (count($operationalInsights) > 0)

                <span
                    class="inline-flex w-fit items-center gap-2 rounded-full
                           bg-slate-50 px-3 py-1.5 text-xs font-medium
                           text-slate-600"
                >
                    <span class="h-2 w-2 rounded-full bg-amber-500"></span>

                    {{ count($operationalInsights) }} topics detected
                </span>

            @endif

        </div>


        {{-- =====================================================
             INSIGHT LIST
             ===================================================== --}}
        <div class="p-5 sm:p-6">

            @if (count($operationalInsights) > 0)

                <div class="space-y-4">

                    @foreach ($operationalInsights as $index => $insight)

                        @php
                            $percentage = (float) ($insight['percentage'] ?? 0);
                            $reviewCount = (int) ($insight['review_count'] ?? 0);

                            $percentage = min(100, max(0, $percentage));

                            $topic = $insight['topic'] ?? 'Other';

                            $topicLabel = ucwords(
                                str_replace(['_', '-'], ' ', $topic)
                            );

                            $isHigh = $percentage >= 30;
                            $isMedium = $percentage >= 15 && $percentage < 30;
                        @endphp

                        <div
                            class="group rounded-2xl border border-slate-200
                                   bg-slate-50/50 p-4 transition
                                   hover:border-slate-300 hover:bg-white
                                   hover:shadow-sm sm:p-5"
                        >

                            <div
                                class="flex flex-col gap-4
                                       sm:flex-row sm:items-center"
                            >

                                {{-- Topic --}}
                                <div class="flex min-w-0 flex-1 items-center gap-4">

                                    <div
                                        class="flex h-11 w-11 shrink-0
                                               items-center justify-center
                                               rounded-xl bg-white
                                               text-sm font-bold
                                               text-slate-500 shadow-sm
                                               ring-1 ring-slate-200"
                                    >
                                        {{ $index + 1 }}
                                    </div>

                                    <div class="min-w-0">

                                        <h4
                                            class="truncate text-sm font-semibold
                                                   text-slate-900"
                                        >
                                            {{ $topicLabel }}
                                        </h4>

                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ $reviewCount }}
                                            {{ $reviewCount === 1 ? 'negative review' : 'negative reviews' }}
                                        </p>

                                    </div>

                                </div>


                                {{-- Percentage --}}
                                <div
                                    class="flex items-center justify-between
                                           gap-6 sm:justify-end"
                                >

                                    <div class="text-right">

                                        <p
                                            class="text-lg font-bold tracking-tight
                                            {{ $isHigh
                                                ? 'text-red-600'
                                                : ($isMedium
                                                    ? 'text-amber-600'
                                                    : 'text-slate-700') }}"
                                        >
                                            {{ number_format($percentage, 1) }}%
                                        </p>

                                        <p class="text-[11px] text-slate-400">
                                            of negative reviews
                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- Progress --}}
                            <div class="mt-4">

                                <div
                                    class="h-2 overflow-hidden rounded-full
                                           bg-slate-200"
                                >

                                    <div
                                        class="h-full rounded-full transition-all duration-500
                                        {{ $isHigh
                                            ? 'bg-red-500'
                                            : ($isMedium
                                                ? 'bg-amber-500'
                                                : 'bg-slate-400') }}"
                                        style="width: {{ $percentage }}%;"
                                    ></div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                {{-- =================================================
                     EMPTY STATE
                     ================================================= --}}
                <div
                    class="flex min-h-[360px] flex-col items-center
                           justify-center text-center"
                >

                    <div
                        class="mb-5 flex h-16 w-16 items-center justify-center
                               rounded-2xl bg-emerald-50 text-emerald-600"
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
                                d="M9 12l2 2 4-4M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"
                            />
                        </svg>
                    </div>

                    <h4 class="text-base font-semibold text-slate-900">
                        No operational issues detected
                    </h4>

                    <p class="mt-1 max-w-md text-sm leading-6 text-slate-500">
                        No negative operational topics were found for the
                        selected filters. Try a different property or date range.
                    </p>

                    <a
                        href="{{ route('analytics.operational') }}"
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
         INTERPRETATION NOTE
         ========================================================= --}}
    @if (count($operationalInsights) > 0)

        <div
            class="mt-6 flex gap-3 rounded-2xl border border-amber-200
                   bg-amber-50/70 p-4"
        >

            <div
                class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center
                       rounded-lg bg-amber-100 text-amber-700"
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

                <p class="text-sm font-semibold text-amber-900">
                    How to read these insights
                </p>

                <p class="mt-1 text-xs leading-5 text-amber-800">
                    The percentage represents the share of negative reviews
                    associated with each operational topic. Higher percentages
                    indicate that the topic appears more frequently in the
                    selected negative feedback.
                </p>

            </div>

        </div>

    @endif

@endsection
```
