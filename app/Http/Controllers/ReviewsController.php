<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewsController extends Controller
{
    public function index(Request $request): View
    {
        $query = Review::query()
            ->with([
                'property',
                'insights',
            ])
            ->orderByDesc('review_date')
            ->orderByDesc('id');

        /*
        |--------------------------------------------------------------------------
        | Property
        |--------------------------------------------------------------------------
        */
        if ($request->filled('property_id')) {
            $query->where(
                'property_id',
                $request->integer('property_id')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Start date
        |--------------------------------------------------------------------------
        */
        if ($request->filled('start_date')) {
            $query->whereDate(
                'review_date',
                '>=',
                $request->input('start_date')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | End date
        |--------------------------------------------------------------------------
        */
        if ($request->filled('end_date')) {
            $query->whereDate(
                'review_date',
                '<=',
                $request->input('end_date')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Rating
        |--------------------------------------------------------------------------
        */
        if ($request->filled('rating')) {
            $query->where(
                'rating',
                $request->integer('rating')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sentiment
        |--------------------------------------------------------------------------
        */
        if ($request->input('sentiment') === 'positive') {
            $query->where('rating', '>=', 7);
        }

        if ($request->input('sentiment') === 'negative') {
            $query->where('rating', '<', 7);
        }

        /*
        |--------------------------------------------------------------------------
        | Topic
        |--------------------------------------------------------------------------
        */
        if ($request->filled('topic')) {
            $query->whereHas('insights', function ($insightQuery) use ($request) {
                $insightQuery->where(
                    'topic',
                    $request->input('topic')
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Paginate
        |--------------------------------------------------------------------------
        */
        $reviews = $query
            ->paginate(15)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Properties
        |--------------------------------------------------------------------------
        */
        $properties = Property::query()
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */
        $filters = [
            'property_id' => $request->input('property_id', ''),
            'start_date' => $request->input('start_date', ''),
            'end_date' => $request->input('end_date', ''),
            'rating' => $request->input('rating', ''),
            'sentiment' => $request->input('sentiment', ''),
            'topic' => $request->input('topic', ''),
        ];

        return view('reviews.index', compact(
            'reviews',
            'properties',
            'filters'
        ));
    }
}
