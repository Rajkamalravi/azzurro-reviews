<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard');
    }
}
