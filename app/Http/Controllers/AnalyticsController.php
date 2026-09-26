<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Services\ReviewAnalyticsService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function rating(
        Request $request,
        ReviewAnalyticsService $analytics
    ): View {
        $filters = $this->filters($request);

        $properties = Property::query()
            ->orderBy('name')
            ->get();

        $ratingTrend = $analytics->getRatingTrend($filters);

        return view('analytics.rating-trends', [
            'ratingTrend' => $ratingTrend,
            'properties' => $properties,
            'filters' => $filters,
        ]);
    }

    public function sentiment(
        Request $request,
        ReviewAnalyticsService $analytics
    ): View {
        $filters = $this->filters($request);

        $properties = Property::query()
            ->orderBy('name')
            ->get();

        $sentimentTrend = $analytics->getSentimentTrend($filters);

        return view('analytics.sentiment', [
            'sentimentTrend' => $sentimentTrend,
            'properties' => $properties,
            'filters' => $filters,
        ]);
    }

    public function operational(
        Request $request,
        ReviewAnalyticsService $analytics
    ): View {
        $filters = $this->filters($request);

        $properties = Property::query()
            ->orderBy('name')
            ->get();

        $operationalInsights = $analytics->getOperationalInsights($filters);

        return view('analytics.operational-insights', [
            'operationalInsights' => $operationalInsights,
            'properties' => $properties,
            'filters' => $filters,
        ]);
    }

    private function filters(Request $request): array
    {
        return [
            'property_id' => $request->input('property_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'rating' => $request->input('rating'),
            'sentiment' => $request->input('sentiment'),
            'topic' => $request->input('topic'),
        ];
    }
}

