<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        // ✅ Reports by Status
        $pendingReports   = Report::where('status', 'Pending')->count();
        $resolvedReports  = Report::where('status', 'Resolved')->count();
        $ongoingReports   = Report::where('status', 'Ongoing')->count();
        $rejectedReports  = Report::where('status', 'Rejected')->count();
        $totalReports     = Report::count();

        // ✅ Users
        $totalUsers = User::count(); // ✅ Get total users

        // ✅ Feedback
        $totalFeedbacks   = Feedback::count();
        $feedbacks        = Feedback::latest()->take(10)->get(); // ✅ Get latest 10 feedbacks

        // ✅ Reports per Municipality
        $municipalities = ['Santa Fe', 'Bantayan', 'Madridejos'];
        $reportsByMunicipality = [];
        foreach ($municipalities as $mun) {
            $reportsByMunicipality[] = Report::where('location', $mun)->count();
        }

        // ✅ Daily Reports (last 7 days)
        $dailyReports = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $count = Report::whereDate('created_at', $day)->count();
            $dailyReports[] = $count;
        }

        // ✅ User Growth (last 7 months)
        $userGrowth = [];
        for ($i = 6; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = User::whereMonth('created_at', $month->month)
                        ->whereYear('created_at', $month->year)
                        ->count();
            $userGrowth[] = $count;
        }

        return view('admin.analytics', compact(
            'pendingReports', 'resolvedReports', 'ongoingReports', 'rejectedReports',
            'totalReports', 'totalUsers', 'totalFeedbacks', 'feedbacks', 
            'municipalities', 'reportsByMunicipality', 'dailyReports', 'userGrowth'
        ));
    }
    public function getFeedbacks()
{
    $feedbacks = Feedback::latest()->take(10)->get(['id', 'user_id', 'feedback', 'rating', 'location', 'created_at']);
    return response()->json($feedbacks);
}

}

