<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Services\ReviewAnalyticsService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(
        Request $request,
        ReviewAnalyticsService $analytics
    ): View {
        $filters = [
            'property_id' => $request->input('property_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'rating' => $request->input('rating'),
            'sentiment' => $request->input('sentiment'),
            'topic' => $request->input('topic'),
        ];

        $properties = Property::orderBy('name')->get();

        $kpis = $analytics->getKpis();

        $propertyPerformance = $analytics->getPropertyPerformance();

        $ratingTrend = $analytics->getRatingTrend($filters);

        $sentimentTrend = $analytics->getSentimentTrend($filters);

        $operationalInsights = $analytics->getOperationalInsights($filters);

        $recentReviews = $analytics->getRecentReviews($filters, 5);

        return view('dashboard', [
            'kpis' => $kpis,
            'propertyPerformance' => $propertyPerformance,
            'ratingTrend' => $ratingTrend,
            'sentimentTrend' => $sentimentTrend,
            'operationalInsights' => $operationalInsights,
            'recentReviews' => $recentReviews,
            'properties' => $properties,
            'filters' => $filters,
        ]);
    }
}
