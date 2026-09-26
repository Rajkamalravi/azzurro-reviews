@extends('layouts.dashboard')

@section('title', 'Properties | Azzurro Hotels')
@section('page-title', 'Properties')
@section('page-description', 'Manage hotel properties and review coverage')

@section('content')

{{-- =========================================================
     PAGE HEADER
     ========================================================= --}}
<div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

    <div>
        <div class="mb-2 flex items-center gap-2">

            <div
                class="flex h-9 w-9 items-center justify-center rounded-xl
                       bg-pink-500/10 text-pink-500"
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
                        d="M3 21h18M5 21V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v16M15 21V9a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v12M9 7h2M9 11h2M9 15h2"
                    />
                </svg>
            </div>

            <span class="text-sm font-medium text-slate-500">
                Property Management
            </span>

        </div>

        <h2 class="text-2xl font-bold tracking-tight text-slate-900">
            Hotel Properties
        </h2>

        <p class="mt-1 max-w-2xl text-sm text-slate-500">
            View and manage properties connected to your guest review analytics.
        </p>
    </div>

    {{-- Property count --}}
    <div
        class="inline-flex items-center gap-2 self-start rounded-full
               border border-slate-200 bg-white px-4 py-2
               text-sm font-medium text-slate-600 shadow-sm sm:self-auto"
    >
        <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>

        {{ $properties->count() }}
        {{ \Illuminate\Support\Str::plural('Property', $properties->count()) }}
    </div>

</div>


{{-- =========================================================
     SUMMARY CARDS
     ========================================================= --}}
@php
    $propertyCount = $properties->count();

    $totalReviews = $properties->sum(function ($property) {
        return $property->reviews_count ?? 0;
    });

    $averageRating = $properties->avg(function ($property) {
        return $property->reviews_avg_rating ?? 0;
    });

    $averageRating = round($averageRating ?? 0, 2);
@endphp

<div class="mb-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

    {{-- Total Properties --}}
    <div
        class="rounded-2xl border border-slate-200 bg-white p-5
               shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
    >
        <div class="flex items-start justify-between">

            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Total Properties
                </p>

                <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                    {{ $propertyCount }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Properties in your portfolio
                </p>
            </div>

            <div
                class="flex h-11 w-11 items-center justify-center rounded-xl
                       bg-pink-500/10 text-pink-500"
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
                        d="M3 21h18M5 21V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v16M15 21V9a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v12"
                    />
                </svg>
            </div>

        </div>
    </div>


    {{-- Total Reviews --}}
    <div
        class="rounded-2xl border border-slate-200 bg-white p-5
               shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
    >
        <div class="flex items-start justify-between">

            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Reviews Covered
                </p>

                <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                    {{ number_format($totalReviews) }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Reviews across properties
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
               shadow-sm transition hover:-translate-y-0.5 hover:shadow-md
               sm:col-span-2 xl:col-span-1"
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
                    Portfolio average
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

</div>


{{-- =========================================================
     PROPERTIES TABLE
     ========================================================= --}}
<div
    class="overflow-hidden rounded-2xl border border-slate-200
           bg-white shadow-sm"
>

    {{-- Table Header --}}
    <div
        class="flex flex-col gap-3 border-b border-slate-200
               px-6 py-5 sm:flex-row sm:items-center sm:justify-between"
    >

        <div>
            <h3 class="text-base font-semibold text-slate-900">
                All Properties
            </h3>

            <p class="mt-1 text-xs text-slate-500">
                Property-level review performance
            </p>
        </div>

        <div
            class="inline-flex items-center gap-2 rounded-lg
                   bg-slate-50 px-3 py-2 text-xs font-medium text-slate-500"
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

            Review performance
        </div>

    </div>


    @if ($properties->count())

        {{-- Desktop Table --}}
        <div class="hidden overflow-x-auto md:block">

            <table class="w-full text-left">

                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/70">

                        <th
                            class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-400"
                        >
                            Property
                        </th>

                        <th
                            class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-400"
                        >
                            Reviews
                        </th>

                        <th
                            class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-400"
                        >
                            Avg. Rating
                        </th>

                        <th
                            class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-400"
                        >
                            Status
                        </th>

                        <th
                            class="px-6 py-4 text-right text-xs font-semibold
                                   uppercase tracking-wider text-slate-400"
                        >
                            Details
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @foreach ($properties as $property)

                        @php
                            $reviewsCount = $property->reviews_count ?? 0;
                            $propertyRating = $property->reviews_avg_rating ?? 0;
                            $propertyRating = round($propertyRating, 2);
                        @endphp

                        <tr class="group transition hover:bg-slate-50/70">

                            {{-- Property --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-4">

                                    <div
                                        class="flex h-11 w-11 shrink-0
                                               items-center justify-center
                                               rounded-xl bg-slate-900
                                               text-sm font-bold text-white"
                                    >
                                        {{ strtoupper(substr($property->name, 0, 1)) }}
                                    </div>

                                    <div class="min-w-0">

                                        <p
                                            class="truncate text-sm font-semibold
                                                   text-slate-900"
                                        >
                                            {{ $property->name }}
                                        </p>

                                        @if (!empty($property->location))
                                            <p class="mt-1 truncate text-xs text-slate-500">
                                                {{ $property->location }}
                                            </p>
                                        @else
                                            <p class="mt-1 text-xs text-slate-400">
                                                Hotel property
                                            </p>
                                        @endif

                                    </div>

                                </div>

                            </td>


                            {{-- Reviews --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-2">

                                    <span class="text-sm font-semibold text-slate-800">
                                        {{ number_format($reviewsCount) }}
                                    </span>

                                    <span class="text-xs text-slate-400">
                                        reviews
                                    </span>

                                </div>

                            </td>


                            {{-- Rating --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-2">

                                    <div class="flex items-center gap-1">

                                        <svg
                                            class="h-4 w-4 text-amber-400"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="m12 3 2.78 5.63 6.22.9-4.5 4.39 1.06 6.2L12 17.2l-5.56 2.92 1.06-6.2L3 9.53l6.22-.9L12 3Z"
                                            />
                                        </svg>

                                        <span class="text-sm font-semibold text-slate-800">
                                            {{ number_format($propertyRating, 2) }}
                                        </span>

                                    </div>

                                    <span class="text-xs text-slate-400">
                                        / 10
                                    </span>

                                </div>

                            </td>


                            {{-- Status --}}
                            <td class="px-6 py-5">

                                @if ($reviewsCount > 0)

                                    <span
                                        class="inline-flex items-center gap-1.5
                                               rounded-full bg-emerald-50
                                               px-2.5 py-1 text-xs font-medium
                                               text-emerald-700"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full
                                                   bg-emerald-500"
                                        ></span>

                                        Active
                                    </span>

                                @else

                                    <span
                                        class="inline-flex items-center gap-1.5
                                               rounded-full bg-slate-100
                                               px-2.5 py-1 text-xs font-medium
                                               text-slate-500"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full
                                                   bg-slate-400"
                                        ></span>

                                        No reviews
                                    </span>

                                @endif

                            </td>


                            {{-- Details --}}
                            <td class="px-6 py-5 text-right">

                                <a
                                    href="{{ route('dashboard', ['property_id' => $property->id]) }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg
                                           border border-slate-200 bg-white
                                           px-3 py-2 text-xs font-medium
                                           text-slate-600 transition
                                           hover:border-pink-200
                                           hover:bg-pink-50
                                           hover:text-pink-600"
                                >
                                    View reviews

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

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- Mobile Cards --}}
        <div class="divide-y divide-slate-100 md:hidden">

            @foreach ($properties as $property)

                @php
                    $reviewsCount = $property->reviews_count ?? 0;
                    $propertyRating = $property->reviews_avg_rating ?? 0;
                    $propertyRating = round($propertyRating, 2);
                @endphp

                <div class="p-5">

                    <div class="flex items-start gap-4">

                        <div
                            class="flex h-11 w-11 shrink-0 items-center
                                   justify-center rounded-xl bg-slate-900
                                   text-sm font-bold text-white"
                        >
                            {{ strtoupper(substr($property->name, 0, 1)) }}
                        </div>

                        <div class="min-w-0 flex-1">

                            <div class="flex items-start justify-between gap-3">

                                <div class="min-w-0">

                                    <h4
                                        class="truncate text-sm font-semibold
                                               text-slate-900"
                                    >
                                        {{ $property->name }}
                                    </h4>

                                    @if (!empty($property->location))
                                        <p class="mt-1 truncate text-xs text-slate-500">
                                            {{ $property->location }}
                                        </p>
                                    @endif

                                </div>

                                @if ($reviewsCount > 0)
                                    <span
                                        class="shrink-0 rounded-full bg-emerald-50
                                               px-2 py-1 text-[10px] font-semibold
                                               text-emerald-700"
                                    >
                                        Active
                                    </span>
                                @endif

                            </div>


                            <div class="mt-4 grid grid-cols-2 gap-3">

                                <div class="rounded-xl bg-slate-50 p-3">

                                    <p class="text-[10px] font-semibold uppercase
                                              tracking-wider text-slate-400">
                                        Reviews
                                    </p>

                                    <p class="mt-1 text-sm font-bold text-slate-800">
                                        {{ number_format($reviewsCount) }}
                                    </p>

                                </div>

                                <div class="rounded-xl bg-slate-50 p-3">

                                    <p class="text-[10px] font-semibold uppercase
                                              tracking-wider text-slate-400">
                                        Rating
                                    </p>

                                    <div class="mt-1 flex items-center gap-1">

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

                                </div>

                            </div>


                            <a
                                href="{{ route('dashboard', ['property_id' => $property->id]) }}"
                                class="mt-4 flex w-full items-center justify-center
                                       gap-2 rounded-xl border border-slate-200
                                       bg-white px-4 py-2.5 text-xs font-semibold
                                       text-slate-600 transition
                                       hover:border-pink-200
                                       hover:bg-pink-50
                                       hover:text-pink-600"
                            >
                                View property reviews

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

                    </div>

                </div>

            @endforeach

        </div>

    @else

        {{-- Empty State --}}
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
                        d="M3 21h18M5 21V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v16M15 21V9a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v12"
                    />
                </svg>
            </div>

            <h3 class="mt-5 text-base font-semibold text-slate-900">
                No properties found
            </h3>

            <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                There are currently no hotel properties available in the system.
            </p>

        </div>

    @endif

</div>

@endsection
