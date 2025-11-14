<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrackingLog;

class TrackingController extends Controller
{
    public function index()
    {
        $trackingLogs = TrackingLog::latest()->paginate(10); // tampilkan 10 data per halaman
        return view('dashboard.riwayat', compact('trackingLogs'));
    }
}
