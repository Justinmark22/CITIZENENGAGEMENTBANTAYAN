<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class LocationReportController extends Controller
{
    public function viewBantayan()
    {
        // Get the total users in Bantayan
        $totalUsers = User::where('location', 'Bantayan')->count();

        // Get the total reports in Bantayan
        $totalReports = Report::where('location', 'Bantayan')->count();

        // Get the total pending reports in Bantayan
        $pendingReports = Report::where('location', 'Bantayan')->where('status', 'pending')->count();

        // Return the view with the data
        return view('viewbanatayan', compact('totalUsers', 'totalReports', 'pendingReports'));
    }

    public function viewSantaFe()
    {
        // Get the total users in Santa.Fe
        $totalUsers = User::where('location', 'Santa.Fe')->count();

        // Get the total reports in Santa.Fe
        $totalReports = Report::where('location', 'Santa.Fe')->count();

        // Get the total pending reports in Santa.Fe
        $pendingReports = Report::where('location', 'Santa.Fe')->where('status', 'pending')->count();

        // Return the view with the data
        return view('viewsantafe', compact('totalUsers', 'totalReports', 'pendingReports'));
    }public function viewMadridejos()
    {
        // Get the total users in Santa.Fe
        $totalUsers = User::where('location', 'Madridejos')->count();

        // Get the total reports in Santa.Fe
        $totalReports = Report::where('location', 'Madridejos')->count();

        // Get the total pending reports in Santa.Fe
        $pendingReports = Report::where('location', 'Madridejos')->where('status', 'pending')->count();

        // Return the view with the data
        return view('viewmadridejos', compact('totalUsers', 'totalReports', 'pendingReports'));
    }
}

