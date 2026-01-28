<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DhammaVachana;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDhammaVachana = DhammaVachana::count();
        $publishedCount = DhammaVachana::where('is_published', true)->count();
        $draftCount = DhammaVachana::where('is_published', false)->count();
        $totalViews = DhammaVachana::sum('views') ?? 0;
        $recentContent = DhammaVachana::latest()->take(5)->get();
        $recentActivity = 'Hari ini';

        return view('dashboard', compact(
            'totalDhammaVachana',
            'publishedCount',
            'draftCount',
            'totalViews',
            'recentContent',
            'recentActivity'
        ));
    }
}
