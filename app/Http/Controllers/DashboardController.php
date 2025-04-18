<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Robot;
use App\Models\Battery;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $robots = Robot::all();      // Data lokasi
            $batteries = Battery::all(); // Data baterai

            return view('dashboard.dashboard', compact('robots', 'batteries'));
        } catch (\Exception $e) {
            Log::error('Error fetching dashboard data: ' . $e->getMessage());
            return view('dashboard.dashboard')->with('error', 'Gagal memuat data dashboard.');
        }
    }
}
