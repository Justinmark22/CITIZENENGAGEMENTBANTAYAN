<?php
namespace App\Http\Controllers;
use App\Models\Feedback;
use App\Models\Announcement;
use App\Models\Alert;

use App\Models\User;
use App\Models\Report;

class LocationController extends Controller
{
    public function viewBantayan()
    {
        // Get the total users in Bantayan
        $totalUsers = User::where('location', 'Bantayan')->count();

        // Get the total reports in Bantayan
        $totalReports = Report::where('location', 'Bantayan')->count();
        $feedbacks = Feedback::where('location', 'Bantayan')->latest()->get();

        // Get the total pending reports in Bantayan
        $pendingReports = Report::where('location', 'Bantayan')->where('status', 'pending')->count();

        // Return the view with the data
        return view('viewbanatayan', compact('totalUsers', 'totalReports', 'pendingReports','feedbacks'));
    }

    public function viewSantaFe()
    {
$location = 'Santa.Fe';

$feedbacks = Feedback::where('location', 'Santa.Fe')->latest()->get();
    $reports = Report::where('location', 'Santa.Fe')->latest()->get();
    $announcements = Announcement::where('location', 'Santa.Fe')->latest()->get();
    $totalUsers = User::where('location', 'Santa.Fe')->count();
    $totalReports = $reports->count();
    $pendingReports = $reports->where('status', 'Pending')->count();
    $alerts = Alert::where('location', $location)->latest()->get(); 


    return view('viewsantafe', compact(
        'location',
        'totalUsers',
        'totalReports',
        'pendingReports',
        'announcements',
        'reports',
        'feedbacks',
        'alerts'
    ));
}
    public function viewMadridejos()
    {
        // Get the total users in Madridejos
        $totalUsers = User::where('location', 'Madridejos')->count();

        // Get the total reports in Madridejos
        $totalReports = Report::where('location', 'Madridejos')->count();

        // Get the total pending reports in Madridejos
        $pendingReports = Report::where('location', 'Madridejos')->where('status', 'pending')->count();
        $feedbacks = Feedback::where('location', 'Santa.Fe')->latest()->get();

        // Return the view with the data
        return view('viewmadridejos', compact('totalUsers', 'totalReports', 'pendingReports','feedbacks'));
    }
}
