<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Azzurro Hotels - Review Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="min-h-screen">

    <header class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-6 py-5">
            <h1 class="text-2xl font-bold text-gray-900">
                Azzurro Hotels
            </h1>

            <p class="text-gray-500">
                Guest Review Insights
            </p>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">

        {{-- Page heading --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                Review Overview
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Current week:
                {{ $kpis['current_week_start']->format('d M Y') }}
                -
                {{ $kpis['current_week_end']->format('d M Y') }}
            </p>
        </div>


        {{-- KPI Cards --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Average Rating --}}
            <div class="bg-white rounded-xl shadow-sm border p-6">

                <p class="text-sm font-medium text-gray-500">
                    Average Rating
                </p>

                <div class="mt-2 flex items-end gap-2">

                    <p class="text-3xl font-bold text-gray-900">
                        {{ number_format($kpis['current_average'], 1) }}
                    </p>

                    <span class="text-sm text-gray-500 mb-1">
                    / 10
                </span>

                </div>

                <p class="mt-2 text-sm
                {{ $kpis['rating_change'] >= 0
                    ? 'text-green-600'
                    : 'text-red-600' }}">

                    {{ $kpis['rating_change'] >= 0 ? '↑' : '↓' }}
                    {{ number_format(abs($kpis['rating_change']), 1) }}

                    vs previous week
                </p>

            </div>


            {{-- Review Count --}}
            <div class="bg-white rounded-xl shadow-sm border p-6">

                <p class="text-sm font-medium text-gray-500">
                    Reviews
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ number_format($kpis['current_review_count']) }}
                </p>

                <p class="mt-2 text-sm text-gray-500">
                    {{ number_format($kpis['previous_review_count']) }}
                    previous week
                </p>

            </div>


            {{-- Positive --}}
            <div class="bg-white rounded-xl shadow-sm border p-6">

                <p class="text-sm font-medium text-gray-500">
                    Positive Reviews
                </p>

                <p class="mt-2 text-3xl font-bold text-green-600">
                    {{ number_format($kpis['positive_percentage'], 1) }}%
                </p>

                <p class="mt-2 text-sm text-gray-500">
                    {{ $kpis['positive_count'] }} reviews
                </p>

            </div>


            {{-- Negative --}}
            <div class="bg-white rounded-xl shadow-sm border p-6">

                <p class="text-sm font-medium text-gray-500">
                    Negative Reviews
                </p>

                <p class="mt-2 text-3xl font-bold text-red-600">
                    {{ number_format($kpis['negative_percentage'], 1) }}%
                </p>

                <p class="mt-2 text-sm text-gray-500">
                    {{ $kpis['negative_count'] }} reviews
                </p>

            </div>

        </div>


        {{-- Property Performance --}}
        <div class="mt-8 bg-white rounded-xl shadow-sm border">

            <div class="px-6 py-5 border-b">
                <h2 class="text-lg font-semibold text-gray-900">
                    Property Performance
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Performance for the current week
                </p>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-gray-50">
                    <tr class="text-left text-gray-500">

                        <th class="px-6 py-3 font-medium">
                            Property
                        </th>

                        <th class="px-6 py-3 font-medium text-center">
                            Reviews
                        </th>

                        <th class="px-6 py-3 font-medium text-center">
                            Avg Rating
                        </th>

                        <th class="px-6 py-3 font-medium text-center">
                            Positive
                        </th>

                        <th class="px-6 py-3 font-medium text-center">
                            Negative
                        </th>

                    </tr>
                    </thead>

                    <tbody class="divide-y">

                    @foreach ($propertyPerformance as $property)

                        <tr class="hover:bg-gray-50">

                            {{-- Property --}}
                            <td class="px-6 py-4">

                                <div class="font-medium text-gray-900">
                                    {{ $property['name'] }}
                                </div>

                            </td>

                            {{-- Review count --}}
                            <td class="px-6 py-4 text-center text-gray-700">
                                {{ $property['review_count'] }}
                            </td>

                            {{-- Average rating --}}
                            <td class="px-6 py-4 text-center">

                            <span class="inline-flex items-center rounded-full
                                bg-blue-50 px-3 py-1 text-sm font-semibold
                                text-blue-700">

                                {{ number_format($property['average_rating'], 1) }}

                            </span>

                            </td>

                            {{-- Positive --}}
                            <td class="px-6 py-4 text-center">

                            <span class="text-green-600 font-medium">
                                {{ $property['positive_count'] }}
                            </span>

                                <span class="text-gray-400">
                                ({{ number_format($property['positive_percentage'], 1) }}%)
                            </span>

                            </td>

                            {{-- Negative --}}
                            <td class="px-6 py-4 text-center">

                            <span class="text-red-600 font-medium">
                                {{ $property['negative_count'] }}
                            </span>

                                <span class="text-gray-400">
                                ({{ number_format($property['negative_percentage'], 1) }}%)
                            </span>

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        {{-- Dashboard Filters --}}
        <div class="mt-8 bg-white rounded-xl shadow-sm border">

            <div class="px-6 py-5 border-b">

                <h2 class="text-lg font-semibold text-gray-900">
                    Review Filters
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Filter the review feed by property, date, rating and sentiment.
                </p>

            </div>

            <form
                method="GET"
                action="{{ url('/dashboard') }}"
                class="p-6"
            >

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">

                    {{-- Property --}}
                    <div>

                        <label
                            for="property_id"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Property
                        </label>

                        <select
                            name="property_id"
                            id="property_id"
                            class="mt-1 block w-full rounded-lg border-gray-300
                           shadow-sm focus:border-blue-500
                           focus:ring-blue-500"
                        >

                            <option value="">
                                All properties
                            </option>

                            @foreach ($properties as $property)

                                <option
                                    value="{{ $property->id }}"
                                    @selected(
                                    (string) $filters['property_id'] ===
                                (string) $property->id
                                )
                                >
                                {{ $property->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Start Date --}}
                    <div>

                        <label
                            for="start_date"
                            class="block text-sm font-medium text-gray-700"
                        >
                            From
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            id="start_date"
                            value="{{ $filters['start_date'] }}"
                            class="mt-1 block w-full rounded-lg border-gray-300
                           shadow-sm focus:border-blue-500
                           focus:ring-blue-500"
                        >

                    </div>


                    {{-- End Date --}}
                    <div>

                        <label
                            for="end_date"
                            class="block text-sm font-medium text-gray-700"
                        >
                            To
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            id="end_date"
                            value="{{ $filters['end_date'] }}"
                            class="mt-1 block w-full rounded-lg border-gray-300
                           shadow-sm focus:border-blue-500
                           focus:ring-blue-500"
                        >

                    </div>


                    {{-- Rating --}}
                    <div>

                        <label
                            for="rating"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Rating
                        </label>

                        <select
                            name="rating"
                            id="rating"
                            class="mt-1 block w-full rounded-lg border-gray-300
                           shadow-sm focus:border-blue-500
                           focus:ring-blue-500"
                        >

                            <option value="">
                                All ratings
                            </option>

                            @for ($rating = 1; $rating <= 10; $rating++)

                                <option
                                    value="{{ $rating }}"
                                    @selected(
                                    (string) $filters['rating'] ===
                                (string) $rating
                                )
                                >
                                {{ $rating }}/10
                                </option>

                            @endfor

                        </select>

                    </div>


                    {{-- Sentiment --}}
                    <div>

                        <label
                            for="sentiment"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Sentiment
                        </label>

                        <select
                            name="sentiment"
                            id="sentiment"
                            class="mt-1 block w-full rounded-lg border-gray-300
                           shadow-sm focus:border-blue-500
                           focus:ring-blue-500"
                        >

                            <option value="">
                                All sentiment
                            </option>

                            <option
                                value="positive"
                                @selected($filters['sentiment'] === 'positive')
                            >
                            Positive
                            </option>

                            <option
                                value="negative"
                                @selected($filters['sentiment'] === 'negative')
                            >
                            Negative
                            </option>

                        </select>

                    </div>


                    {{-- Topic --}}
                    <div>

                        <label
                            for="topic"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Topic
                        </label>

                        <select
                            name="topic"
                            id="topic"
                            class="mt-1 block w-full rounded-lg border-gray-300
                           shadow-sm focus:border-blue-500
                           focus:ring-blue-500"
                        >

                            <option value="">
                                All topics
                            </option>

                            <option
                                value="cleanliness"
                                @selected($filters['topic'] === 'cleanliness')
                            >
                            Cleanliness
                            </option>

                            <option
                                value="check_in"
                                @selected($filters['topic'] === 'check_in')
                            >
                            Check-in
                            </option>

                            <option
                                value="staff"
                                @selected($filters['topic'] === 'staff')
                            >
                            Staff
                            </option>

                            <option
                                value="noise"
                                @selected($filters['topic'] === 'noise')
                            >
                            Noise
                            </option>

                            <option
                                value="facilities"
                                @selected($filters['topic'] === 'facilities')
                            >
                            Facilities
                            </option>

                            <option
                                value="location"
                                @selected($filters['topic'] === 'location')
                            >
                            Location
                            </option>

                            <option
                                value="room_condition"
                                @selected($filters['topic'] === 'room_condition')
                            >
                            Room Condition
                            </option>

                            <option
                                value="value"
                                @selected($filters['topic'] === 'value')
                            >
                            Value for Money
                            </option>

                        </select>

                    </div>

                </div>


                {{-- Buttons --}}
                <div class="mt-6 flex flex-wrap gap-3">

                    <button
                        type="submit"
                        class="rounded-lg bg-blue-600 px-5 py-2.5
                       text-sm font-medium text-white
                       hover:bg-blue-700"
                    >
                        Apply Filters
                    </button>

                    <a
                        href="{{ url('/dashboard') }}"
                        class="rounded-lg border border-gray-300
                       bg-white px-5 py-2.5
                       text-sm font-medium text-gray-700
                       hover:bg-gray-50"
                    >
                        Clear
                    </a>

                </div>

            </form>

        </div>

        {{-- Rating Trend --}}
        <div class="mt-8 bg-white rounded-xl shadow-sm border">

            <div class="px-6 py-5 border-b">
                <h2 class="text-lg font-semibold text-gray-900">
                    Rating Trend
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Daily average rating for the current week
                </p>
            </div>

            <div class="p-6">

                <div class="h-80">

                    <canvas
                        id="ratingTrendChart"
                        data-labels='@json(collect($ratingTrend)->pluck("label")->values())'
                        data-ratings='@json(collect($ratingTrend)->pluck("rating")->values())'
                    ></canvas>

                </div>

            </div>

        </div>

        {{-- Sentiment Trend --}}
        <div class="mt-8 bg-white rounded-xl shadow-sm border">

            <div class="px-6 py-5 border-b">
                <h2 class="text-lg font-semibold text-gray-900">
                    Positive & Negative Reviews
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Daily review sentiment for the current week
                </p>
            </div>

            <div class="p-6">

                <div class="h-80">

                    <canvas
                        id="sentimentTrendChart"
                        data-labels='@json(collect($sentimentTrend)->pluck("label")->values())'
                        data-positive='@json(collect($sentimentTrend)->pluck("positive")->values())'
                        data-negative='@json(collect($sentimentTrend)->pluck("negative")->values())'
                    ></canvas>

                </div>

            </div>

        </div>

        {{-- Operational Insights --}}
        <div class="mt-8 bg-white rounded-xl shadow-sm border">

            <div class="px-6 py-5 border-b">

                <h2 class="text-lg font-semibold text-gray-900">
                    Operational Insights
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Topics mentioned in negative reviews
                </p>

            </div>


            @if (count($operationalInsights) > 0)

                <div class="p-6 space-y-5">

                    @foreach ($operationalInsights as $insight)

                        <div>

                            <div class="flex items-center justify-between mb-2">

                                <div class="flex items-center gap-3">

                            <span class="font-medium text-gray-900">
                                {{ \Illuminate\Support\Str::headline($insight['topic']) }}
                            </span>

                                    <span class="text-sm text-gray-500">
                                {{ $insight['review_count'] }}
                                        {{ Str::plural('review', $insight['review_count']) }}
                            </span>

                                </div>

                                <span class="text-sm font-semibold text-gray-700">
                            {{ number_format($insight['percentage'], 1) }}%
                        </span>

                            </div>


                            <div class="w-full bg-gray-100 rounded-full h-3">

                                <div
                                    class="bg-red-500 h-3 rounded-full transition-all"
                                    style="width: {{ min($insight['percentage'], 100) }}%"
                                ></div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="p-6 text-sm text-gray-500">
                    No negative operational issues were identified this week.
                </div>

            @endif

        </div>

        {{-- Recent Reviews --}}
        <div class="mt-8 bg-white rounded-xl shadow-sm border">

            <div class="px-6 py-5 border-b">

                <div class="flex items-center justify-between">

                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">
                            Recent Reviews
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Latest guest feedback
                        </p>
                    </div>

                </div>

            </div>


            <div class="divide-y">

                @forelse ($recentReviews as $review)

                    <div class="p-6">

                        {{-- Header --}}
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                            <div>

                                <div class="flex items-center gap-3">

                                    {{-- Rating --}}
                                    <span class="inline-flex items-center rounded-full
                                bg-blue-50 px-3 py-1 text-sm font-semibold
                                text-blue-700">

                                {{ number_format($review->rating, 1) }}/10

                            </span>

                                    {{-- Property --}}
                                    <span class="font-medium text-gray-900">

                                {{ $review->property->name }}

                            </span>

                                </div>

                                <p class="mt-1 text-xs text-gray-500">

                                    {{ $review->review_date?->format('d M Y') }}

                                    @if ($review->reviewer_name)
                                        · {{ $review->reviewer_name }}
                                    @endif

                                </p>

                            </div>


                            {{-- Sentiment --}}
                            @if ($review->rating >= 7)

                                <span class="inline-flex w-fit items-center rounded-full
                            bg-green-50 px-3 py-1 text-xs font-medium
                            text-green-700">

                            Positive

                        </span>

                            @else

                                <span class="inline-flex w-fit items-center rounded-full
                            bg-red-50 px-3 py-1 text-xs font-medium
                            text-red-700">

                            Negative

                        </span>

                            @endif

                        </div>


                        {{-- Review content --}}
                        <div class="mt-5 space-y-3">

                            @if ($review->positive_text)

                                <div>

                                    <p class="text-xs font-semibold uppercase
                                tracking-wide text-green-600">

                                        Positive

                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-gray-700">

                                        {{ $review->positive_text }}

                                    </p>

                                </div>

                            @endif


                            @if ($review->negative_text)

                                <div>

                                    <p class="text-xs font-semibold uppercase
                                tracking-wide text-red-600">

                                        Negative

                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-gray-700">

                                        {{ $review->negative_text }}

                                    </p>

                                </div>

                            @endif

                        </div>


                        {{-- Topics --}}
                        @if ($review->insights->count())

                            <div class="mt-4 flex flex-wrap gap-2">

                                @foreach ($review->insights as $insight)

                                    <span
                                        class="inline-flex items-center rounded-full
                                px-2.5 py-1 text-xs font-medium
                                {{ $insight->sentiment === 'negative'
                                    ? 'bg-red-50 text-red-700'
                                    : 'bg-green-50 text-green-700' }}"
                                    >

                                {{ \Illuminate\Support\Str::headline($insight->topic) }}

                                <span class="ml-1 opacity-60">
                                    {{ $insight->sentiment }}
                                </span>

                            </span>

                                @endforeach

                            </div>

                        @endif

                    </div>

                @empty

                    <div class="p-6 text-sm text-gray-500">

                        No reviews available.

                    </div>

                @endforelse

            </div>

        </div>

    </main>

</div>

</body>
</html>
