<?php

namespace App\Services;

use App\Models\Property;
use App\Models\Review;
use Carbon\Carbon;

class ReviewAnalyticsService
{
    /**
     * Get the start and end of the current week.
     */
    public function currentWeek(): array
    {
        return [
            'start' => now()->startOfWeek(),
            'end' => now()->endOfWeek(),
        ];
    }

    /**
     * Get the start and end of the previous week.
     */
    public function previousWeek(): array
    {
        return [
            'start' => now()->subWeek()->startOfWeek(),
            'end' => now()->subWeek()->endOfWeek(),
        ];
    }

    /**
     * Get dashboard KPIs.
     */
    public function getKpis(array $filters = []): array
    {
        $currentWeek = $this->currentWeek();
        $previousWeek = $this->previousWeek();

        $currentReviews = $this->reviewsBetween(
            $currentWeek['start'],
            $currentWeek['end']
        );

        $previousReviews = $this->reviewsBetween(
            $previousWeek['start'],
            $previousWeek['end']
        );

        $currentAverage = $currentReviews->avg('rating') ?? 0;
        $previousAverage = $previousReviews->avg('rating') ?? 0;

        $ratingChange = $currentAverage - $previousAverage;

        $currentCount = $currentReviews->count();
        $previousCount = $previousReviews->count();

        $positiveCount = $currentReviews
            ->where('rating', '>=', 7)
            ->count();

        $negativeCount = $currentReviews
            ->where('rating', '<', 7)
            ->count();

        $positivePercentage = $currentCount > 0
            ? ($positiveCount / $currentCount) * 100
            : 0;

        $negativePercentage = $currentCount > 0
            ? ($negativeCount / $currentCount) * 100
            : 0;

        return [
            'current_average' => round($currentAverage, 2),

            'previous_average' => round($previousAverage, 2),

            'rating_change' => round($ratingChange, 2),

            'current_review_count' => $currentCount,

            'previous_review_count' => $previousCount,

            'positive_count' => $positiveCount,

            'negative_count' => $negativeCount,

            'positive_percentage' => round($positivePercentage, 1),

            'negative_percentage' => round($negativePercentage, 1),

            'current_week_start' => $currentWeek['start'],

            'current_week_end' => $currentWeek['end'],

            'previous_week_start' => $previousWeek['start'],

            'previous_week_end' => $previousWeek['end'],
        ];
    }

    /**
     * Get reviews between two dates.
     */
    private function reviewsBetween(
        Carbon $start,
        Carbon $end
    ) {
        return Review::query()
            ->whereBetween('review_date', [
                $start->toDateString(),
                $end->toDateString(),
            ])
            ->get();
    }

    /**
     * Get property performance for the current week.
     */
    public function getPropertyPerformance(): array
    {
        $week = $this->currentWeek();

        $properties = Property::query()
            ->with([
                'reviews' => function ($query) use ($week) {
                    $query->whereBetween('review_date', [
                        $week['start']->toDateString(),
                        $week['end']->toDateString(),
                    ]);
                },
            ])
            ->get();

        return $properties->map(function ($property) {
            $reviews = $property->reviews;

            $reviewCount = $reviews->count();

            $averageRating = $reviewCount > 0
                ? $reviews->avg('rating')
                : 0;

            $positiveCount = $reviews
                ->where('rating', '>=', 7)
                ->count();

            $negativeCount = $reviews
                ->where('rating', '<', 7)
                ->count();

            return [
                'id' => $property->id,

                'name' => $property->name,

                'review_count' => $reviewCount,

                'average_rating' => round($averageRating, 2),

                'positive_count' => $positiveCount,

                'negative_count' => $negativeCount,

                'positive_percentage' => $reviewCount > 0
                    ? round(($positiveCount / $reviewCount) * 100, 1)
                    : 0,

                'negative_percentage' => $reviewCount > 0
                    ? round(($negativeCount / $reviewCount) * 100, 1)
                    : 0,
            ];
        })->toArray();
    }

    /**
     * Get daily average rating for the current week.
     */
    public function getRatingTrend(array $filters = []): array
    {
        $query = $this->filteredReviewQuery($filters);
        $week = $this->currentWeek();

        $reviews = $query->orderBy('review_date')
            ->get([
                'review_date',
                'rating',
            ]);

        $trend = [];

        $date = $week['start']->copy();

        while ($date->lte($week['end'])) {
            $dateString = $date->toDateString();

            $dayReviews = $reviews->filter(function ($review) use ($dateString) {
                return $review->review_date->toDateString() === $dateString;
            });

            $trend[] = [
                'date' => $dateString,

                'label' => $date->format('D'),

                'rating' => $dayReviews->count() > 0
                    ? round($dayReviews->avg('rating'), 2)
                    : null,

                'review_count' => $dayReviews->count(),
            ];

            $date->addDay();
        }

        return $trend;
    }

    /**
     * Get daily positive and negative review counts
     * for the current week.
     */
    public function getSentimentTrend(array $filters = []): array
    {
        $query = $this->filteredReviewQuery($filters);
        $week = $this->currentWeek();

        $reviews = $query->orderBy('review_date')
            ->get([
                'review_date',
                'rating',
            ]);

        $trend = [];

        $date = $week['start']->copy();

        while ($date->lte($week['end'])) {
            $dateString = $date->toDateString();

            $dayReviews = $reviews->filter(function ($review) use ($dateString) {
                return $review->review_date->toDateString() === $dateString;
            });

            $positiveCount = $dayReviews
                ->where('rating', '>=', 7)
                ->count();

            $negativeCount = $dayReviews
                ->where('rating', '<', 7)
                ->count();

            $trend[] = [
                'date' => $dateString,

                'label' => $date->format('D'),

                'positive' => $positiveCount,

                'negative' => $negativeCount,

                'total' => $dayReviews->count(),
            ];

            $date->addDay();
        }

        return $trend;
    }

    /**
     * Get negative operational topics for the current week.
     */
    public function getOperationalInsights(array $filters = []): array
    {
        $query = $this->filteredReviewQuery($filters);
        $week = $this->currentWeek();

        $negativeReviews = $query->whereBetween('review_date', [
            $week['start']->toDateString(),
            $week['end']->toDateString(),
        ])->where('rating', '<', 7)
            ->with([
                'insights' => function ($query) {
                    $query->where('sentiment', 'negative');
                },
            ])->get();

        $negativeReviewCount = $negativeReviews->count();

        if ($negativeReviewCount === 0) {
            return [];
        }

        $topicCounts = [];

        foreach ($negativeReviews as $review) {
            foreach ($review->insights as $insight) {

                $topic = $insight->topic;

                if (! isset($topicCounts[$topic])) {
                    $topicCounts[$topic] = 0;
                }

                $topicCounts[$topic]++;
            }
        }

        arsort($topicCounts);

        $results = [];

        foreach ($topicCounts as $topic => $count) {
            $results[] = [
                'topic' => $topic,

                'review_count' => $count,

                'percentage' => round(
                    ($count / $negativeReviewCount) * 100,
                    1
                ),
            ];
        }

        return $results;
    }

    /**
     * Get recent reviews for the dashboard.
     */
    public function getRecentReviews(int $limit = 10)
    {
        return Review::query()
            ->with([
                'property',
                'insights',
            ])
            ->orderByDesc('review_date')
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }

    private function filteredReviewQuery(array $filters = [])
    {
        $query = Review::query();

        if (!empty($filters['property_id'])) {
            $query->where(
                'property_id',
                $filters['property_id']
            );
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate(
                'review_date',
                '>=',
                $filters['start_date']
            );
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate(
                'review_date',
                '<=',
                $filters['end_date']
            );
        }

        if (!empty($filters['rating'])) {
            $query->where(
                'rating',
                $filters['rating']
            );
        }

        if (!empty($filters['sentiment'])) {

            if ($filters['sentiment'] === 'positive') {
                $query->where('rating', '>=', 7);
            }

            if ($filters['sentiment'] === 'negative') {
                $query->where('rating', '<', 7);
            }
        }

        if (!empty($filters['topic'])) {
            $query->whereHas('insights', function ($query) use ($filters) {
                $query->where(
                    'topic',
                    $filters['topic']
                );
            });
        }

        return $query;
    }

    public function getFilteredReviews(array $filters = [])
    {
        return $this->filteredReviewQuery($filters)
            ->with([
                'property',
                'insights',
            ])
            ->orderByDesc('review_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();
    }


}
