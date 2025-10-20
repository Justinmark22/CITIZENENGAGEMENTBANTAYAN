<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaterDashboardController extends Controller
{
    public function santafe()
    {
        return view('dashboard.water-santafe');
    }

    public function bantayan()
    {
        return view('dashboard.water-bantayan');
    }

    public function madridejos()
    {
        return view('dashboard.water-madridejos');
    }
}
