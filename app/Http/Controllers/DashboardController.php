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
            $robots = Robot::all();
            $batteries = Battery::all();

            // Gabungkan data berdasarkan IP
            $mergedData = collect();

            // Loop semua robot
            foreach ($robots as $robot) {
                // Cari semua battery dengan IP yang sama
                $relatedBatteries = $batteries->where('ip', $robot->ip);

                // Jika ada battery yang cocok, gabungkan satu per satu
                if ($relatedBatteries->isNotEmpty()) {
                    foreach ($relatedBatteries as $battery) {
                        $mergedData->push([
                            'name' => $robot->name,
                            'ip' => $robot->ip,
                            'location' => $robot->location ?? '-',
                            'battery' => $battery->battery ?? '-',
                            'tag' => $robot->tag ?? '-',
                        ]);
                    }
                } else {
                    // Kalau tidak ada battery dengan IP sama, tetap tampilkan data robot
                    $mergedData->push([
                        'name' => $robot->name,
                        'ip' => $robot->ip,
                        'location' => $robot->location ?? '-',
                        'battery' => '-',
                        'tag' => $robot->tag ?? '-',
                    ]);
                }
            }

            // Tambahkan battery yang belum dipasangkan dengan robot
            foreach ($batteries as $battery) {
                $robotWithSameIp = $robots->where('ip', $battery->ip);
                if ($robotWithSameIp->isEmpty()) {
                    $mergedData->push([
                        'name' => $battery->name ?? '-',
                        'ip' => $battery->ip,
                        'location' => '-',
                        'battery' => $battery->battery ?? '-',
                        'tag' => '-',
                    ]);
                }
            }

            return view('dashboard.dashboard', compact('robots', 'batteries', 'mergedData'));
        } catch (\Exception $e) {
            Log::error('Error fetching dashboard data: ' . $e->getMessage());
            return view('dashboard.dashboard')->with('error', 'Gagal memuat data dashboard.');
        }
    }

}
