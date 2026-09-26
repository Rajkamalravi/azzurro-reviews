<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\View\View;

class PropertiesController extends Controller
{
    public function index(): View
    {
        $properties = Property::query()
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderBy('name')
            ->get();

        return view('properties.index', [
            'properties' => $properties,
        ]);
    }
}
