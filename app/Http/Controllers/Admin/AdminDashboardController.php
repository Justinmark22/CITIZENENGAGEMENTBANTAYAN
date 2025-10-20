<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Report;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{public function index()
{
    $totalUsers = User::count();
    $totalReports = Report::count();
    $totalFeedbacks = Feedback::count();
    $resolvedReports = Report::where('status', 'Resolved')->count();
    $pendingReportsCount = Report::where('status', 'Pending')->count();
    

    // Group users by location
    $santaFeUsers = User::where('location', 'Santa.Fe')->count();
    $bantayanUsers = User::where('location', 'Bantayan')->count();
    $madridejosUsers = User::where('location', 'Madridejos')->count();

    // ✅ Group reports by day
    $reportsByDay = Report::select(
        DB::raw('DATE(created_at) as day'),
        DB::raw('COUNT(*) as total')
    )
    ->groupBy('day')
    ->orderBy('day', 'desc')
    ->limit(7) // Last 7 days
    ->get();

    $reportDays = $reportsByDay->pluck('day')->toArray();
    $reportCounts = $reportsByDay->pluck('total')->toArray();

    return view('dashboard.admin', compact(
        'totalUsers',
        'totalReports',
        'totalFeedbacks',
        'resolvedReports',
        'pendingReportsCount',
        'santaFeUsers',
        'bantayanUsers',
        'madridejosUsers',
        'reportDays',
        'reportCounts'
    ));
}

}
