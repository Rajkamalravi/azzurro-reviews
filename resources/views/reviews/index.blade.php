@extends('layouts.dashboard')

@section('title', 'Reviews | Azzurro Hotels')

@section('page-title', 'Reviews')

@section('page-description', 'Browse and analyze guest reviews')

@section('content')

@php
$reviewCollection = $reviews instanceof \Illuminate\Pagination\AbstractPaginator
? collect($reviews->items())
: collect($reviews);

$totalReviews = $reviews instanceof \Illuminate\Pagination\AbstractPaginator
    ? $reviews->total()
    : $reviewCollection->count();

$averageRating = $reviewCollection->count() > 0
    ? round($reviewCollection->avg('rating'), 2)
    : 0;

$positiveReviews = $reviewCollection->where('rating', '>=', 7)->count();

$negativeReviews = $reviewCollection->where('rating', '<', 7)->count();

$positivePercentage = $reviewCollection->count() > 0
    ? round(($positiveReviews / $reviewCollection->count()) * 100, 1)
    : 0;

$negativePercentage = $reviewCollection->count() > 0
    ? round(($negativeReviews / $reviewCollection->count()) * 100, 1)
    : 0;


@endphp

{{-- =========================================================
PAGE HEADER
========================================================= --}}

<div class="mb-8 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">


<div>

    <div class="mb-2 flex items-center gap-2">

        <div
            class="flex h-9 w-9 items-center justify-center rounded-xl
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

        <span class="text-sm font-medium text-slate-500">
            Guest Feedback
        </span>

    </div>

    <h2 class="text-2xl font-bold tracking-tight text-slate-900">
        Guest Reviews
    </h2>

    <p class="mt-1 max-w-2xl text-sm text-slate-500">
        Review guest feedback, ratings, and sentiment across your properties.
    </p>

</div>

{{-- Review count --}}
<div
    class="inline-flex items-center gap-2 self-start rounded-full
           border border-slate-200 bg-white px-4 py-2
           text-sm font-medium text-slate-600 shadow-sm lg:self-auto"
>
    <span class="flex h-2 w-2 rounded-full bg-violet-500"></span>

    {{ number_format($totalReviews) }}

    {{ \Illuminate\Support\Str::plural('Review', $totalReviews) }}
</div>


</div>

{{-- =========================================================
SUMMARY CARDS
========================================================= --}}

<div class="mb-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">


{{-- Total --}}
<div
    class="rounded-2xl border border-slate-200 bg-white p-5
           shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
>
    <div class="flex items-start justify-between">

        <div>

            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                Total Reviews
            </p>

            <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                {{ number_format($totalReviews) }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                Reviews in this result
            </p>

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
                    {{ number_format($averageRating, 2) }}
                </span>

                <span class="text-sm text-slate-400">
                    / 10
                </span>

            </div>

            <p class="mt-1 text-xs text-slate-500">
                Average guest rating
            </p>

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


{{-- Positive --}}
<div
    class="rounded-2xl border border-slate-200 bg-white p-5
           shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
>
    <div class="flex items-start justify-between">

        <div>

            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                Positive
            </p>

            <p class="mt-3 text-3xl font-bold tracking-tight text-emerald-600">
                {{ $positivePercentage }}%
            </p>

            <p class="mt-1 text-xs text-slate-500">
                Rating 7 and above
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
                Negative
            </p>

            <p class="mt-3 text-3xl font-bold tracking-tight text-rose-600">
                {{ $negativePercentage }}%
            </p>

            <p class="mt-1 text-xs text-slate-500">
                Rating below 7
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
    class="mb-6 rounded-2xl border border-slate-200
           bg-white shadow-sm"
>

<div class="border-b border-slate-100 px-6 py-5">

    <div class="flex items-center gap-3">

        <div
            class="flex h-9 w-9 items-center justify-center rounded-xl
                   bg-slate-100 text-slate-600"
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
                    d="M3 6h18M6 12h12M10 18h4"
                />
            </svg>
        </div>

        <div>

            <h3 class="text-sm font-semibold text-slate-900">
                Filter Reviews
            </h3>

            <p class="text-xs text-slate-500">
                Narrow reviews by property, rating, sentiment, topic, or date.
            </p>

        </div>

    </div>

</div>


<form
    method="GET"
    action="{{ route('reviews') }}"
    class="p-6"
>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Property --}}
        <div>

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

                <option value="">
                    All properties
                </option>

                @foreach (($properties ?? []) as $property)

                    <option
                        value="{{ $property->id }}"
                        @selected(
                            (string) request('property_id') ===
                            (string) $property->id
                        )
                    >
                        {{ $property->name }}
                    </option>

                @endforeach

            </select>

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

                <option value="">
                    All ratings
                </option>

                @for ($rating = 10; $rating >= 1; $rating--)

                    <option
                        value="{{ $rating }}"
                        @selected(
                            (string) request('rating') ===
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

                <option value="">
                    All sentiments
                </option>

                <option
                    value="positive"
                    @selected(request('sentiment') === 'positive')
                >
                    Positive
                </option>

                <option
                    value="negative"
                    @selected(request('sentiment') === 'negative')
                >
                    Negative
                </option>

            </select>

        </div>


        {{-- Topic --}}
        <div>

            <label
                for="topic"
                class="mb-2 block text-xs font-semibold text-slate-600"
            >
                Topic
            </label>

            <input
                id="topic"
                type="text"
                name="topic"
                value="{{ request('topic') }}"
                placeholder="e.g. cleanliness"
                class="w-full rounded-xl border border-slate-200
                       bg-white px-3.5 py-2.5 text-sm text-slate-700
                       placeholder:text-slate-400 outline-none transition
                       focus:border-pink-400 focus:ring-2
                       focus:ring-pink-500/10"
            />

        </div>

    </div>


    <div class="mt-4 grid gap-4 sm:grid-cols-2">

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
                value="{{ request('start_date') }}"
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
                value="{{ request('end_date') }}"
                class="w-full rounded-xl border border-slate-200
                       bg-white px-3.5 py-2.5 text-sm text-slate-700
                       outline-none transition
                       focus:border-pink-400 focus:ring-2
                       focus:ring-pink-500/10"
            />

        </div>

    </div>


    {{-- Actions --}}
    <div class="mt-5 flex flex-wrap items-center gap-3">

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
            request()->filled('property_id') ||
            request()->filled('rating') ||
            request()->filled('sentiment') ||
            request()->filled('topic') ||
            request()->filled('start_date') ||
            request()->filled('end_date')
        )

            <a
                href="{{ route('reviews') }}"
                class="inline-flex items-center gap-2 rounded-xl
                       border border-slate-200 bg-white px-4 py-2.5
                       text-sm font-medium text-slate-600 transition
                       hover:border-slate-300 hover:bg-slate-50"
            >
                Clear Filters
            </a>

        @endif

    </div>

</form>


</div>

{{-- =========================================================
REVIEWS
========================================================= --}}

<div
    class="overflow-hidden rounded-2xl border border-slate-200
           bg-white shadow-sm"
>


{{-- Header --}}
<div
    class="flex flex-col gap-3 border-b border-slate-200
           px-6 py-5 sm:flex-row sm:items-center
           sm:justify-between"
>

    <div>

        <h3 class="text-base font-semibold text-slate-900">
            Review Feed
        </h3>

        <p class="mt-1 text-xs text-slate-500">
            Latest guest feedback matching your filters
        </p>

    </div>


    @if ($reviews instanceof \Illuminate\Pagination\AbstractPaginator)

        <div class="text-xs font-medium text-slate-400">

            Showing

            <span class="text-slate-600">
                {{ $reviews->firstItem() ?? 0 }}
            </span>

            –

            <span class="text-slate-600">
                {{ $reviews->lastItem() ?? 0 }}
            </span>

            of

            <span class="text-slate-600">
                {{ $reviews->total() }}
            </span>

        </div>

    @endif

</div>


@if ($reviewCollection->count())

    <div class="divide-y divide-slate-100">

        @foreach ($reviewCollection as $review)

            @php
                $rating = (float) ($review->rating ?? 0);

                $isPositive = $rating >= 7;

                $reviewDate = $review->review_date
                    ? \Carbon\Carbon::parse($review->review_date)
                    : null;

                $insights = $review->insights ?? collect();

                /*
                |--------------------------------------------------------------------------
                | Review text
                |--------------------------------------------------------------------------
                |
                | The Review model stores positive and negative text separately.
                | Display the text corresponding to the rating sentiment first.
                |
                */

                $positiveText = trim(
                    (string) ($review->positive_text ?? '')
                );

                $negativeText = trim(
                    (string) ($review->negative_text ?? '')
                );

                $comment = $isPositive
                    ? ($positiveText ?: $negativeText)
                    : ($negativeText ?: $positiveText);
            @endphp


            <article
                class="group px-6 py-6 transition hover:bg-slate-50/60"
            >

                <div class="flex flex-col gap-5 lg:flex-row">

                    {{-- Rating --}}
                    <div class="shrink-0">

                        <div
                            class="flex h-14 w-14 flex-col items-center
                                   justify-center rounded-2xl
                                   {{ $isPositive
                                       ? 'bg-emerald-50 text-emerald-700'
                                       : 'bg-rose-50 text-rose-700' }}"
                        >

                            <span class="text-lg font-bold leading-none">
                                {{ number_format($rating, 1) }}
                            </span>

                            <span class="mt-0.5 text-[9px] font-semibold uppercase">
                                / 10
                            </span>

                        </div>

                    </div>


                    {{-- Main Content --}}
                    <div class="min-w-0 flex-1">

                        {{-- Top metadata --}}
                        <div
                            class="flex flex-col gap-2
                                   sm:flex-row sm:items-center
                                   sm:justify-between"
                        >

                            <div class="flex flex-wrap items-center gap-2">

                                {{-- Property --}}
                                <span
                                    class="inline-flex items-center gap-1.5
                                           rounded-full bg-slate-100
                                           px-2.5 py-1 text-xs
                                           font-medium text-slate-600"
                                >

                                    <svg
                                        class="h-3.5 w-3.5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 21h18M5 21V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v16M15 21V9a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v12"
                                        />
                                    </svg>

                                    {{ $review->property?->name ?? 'Unknown Property' }}

                                </span>


                                {{-- Sentiment --}}
                                <span
                                    class="inline-flex items-center gap-1.5
                                           rounded-full
                                           {{ $isPositive
                                               ? 'bg-emerald-50 text-emerald-700'
                                               : 'bg-rose-50 text-rose-700' }}
                                           px-2.5 py-1 text-xs font-medium"
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

                                <div
                                    class="flex items-center gap-1.5
                                           text-xs text-slate-400"
                                >

                                    <svg
                                        class="h-3.5 w-3.5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                        viewBox="0 0 24 24"
                                    >
                                        <rect
                                            width="18"
                                            height="18"
                                            x="3"
                                            y="4"
                                            rx="2"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            d="M16 2v4M8 2v4M3 10h18"
                                        />
                                    </svg>

                                    {{ $reviewDate->format('d M Y') }}

                                </div>

                            @endif

                        </div>


                        {{-- Review text --}}
                        @if ($comment)

                            <p
                                class="mt-4 max-w-4xl text-sm leading-6
                                       text-slate-600"
                            >
                                {{ $comment }}
                            </p>

                        @else

                            <p
                                class="mt-4 text-sm italic text-slate-400"
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


                    {{-- Rating indicator --}}
                    <div class="hidden shrink-0 lg:block">

                        <div class="flex items-center gap-1">

                            @for ($star = 1; $star <= 5; $star++)

                                <svg
                                    class="h-3.5 w-3.5
                                        {{ $rating >= ($star * 2)
                                            ? 'text-amber-400'
                                            : 'text-slate-200' }}"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="m12 3 2.78 5.63 6.22.9-4.5 4.39 1.06 6.2L12 17.2l-5.56 2.92 1.06-6.2L3 9.53l6.22-.9L12 3Z"
                                    />
                                </svg>

                            @endfor

                        </div>

                    </div>

                </div>

            </article>

        @endforeach

    </div>


    {{-- =====================================================
         PAGINATION
         ===================================================== --}}

    @if ($reviews instanceof \Illuminate\Pagination\AbstractPaginator)

        @if ($reviews->hasPages())

            <div class="border-t border-slate-100 px-6 py-5">

                {{ $reviews->onEachSide(1)->links() }}

            </div>

        @endif

    @endif


@else

    {{-- =====================================================
         EMPTY STATE
         ===================================================== --}}

    <div class="px-6 py-20 text-center">

        <div
            class="mx-auto flex h-16 w-16 items-center justify-center
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
                    d="M8 10h8M8 14h5M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"
                />
            </svg>

        </div>

        <h3 class="mt-5 text-base font-semibold text-slate-900">
            No reviews found
        </h3>

        <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
            No guest reviews match the selected filters.
            Try adjusting or clearing your filters.
        </p>


        @if (
            request()->filled('property_id') ||
            request()->filled('rating') ||
            request()->filled('sentiment') ||
            request()->filled('topic') ||
            request()->filled('start_date') ||
            request()->filled('end_date')
        )

            <a
                href="{{ route('reviews') }}"
                class="mt-5 inline-flex items-center gap-2 rounded-xl
                       bg-slate-900 px-4 py-2.5 text-sm font-semibold
                       text-white transition hover:bg-slate-800"
            >
                Clear Filters
            </a>

        @endif

    </div>

@endif


</div>

@endsection
