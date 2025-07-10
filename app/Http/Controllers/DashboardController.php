<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Robot;
use App\Models\Battery;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\IpMapping;
use App\Models\RfidMapping;

class DashboardController extends Controller
{
 public function index()
{
    try {
        // Ambil data robot terakhir per IP dari tabel 'robots'
        $latestRobots = Robot::select('robots.*')
        ->join(DB::raw('(SELECT ip, MAX(updated_at) as latest FROM robots GROUP BY ip) as sub'), function($join) {
    $join->on('robots.ip', '=', 'sub.ip')
         ->on('robots.updated_at', '=', 'sub.latest');
})

            ->get();

        $mergedData = collect();
        $filteredRobots = collect(); // dikirim ke blade

        foreach ($latestRobots as $robot) {
            $robotName = IpMapping::where('ip', $robot->ip)->value('robot_name') ?? 'Unknown';
            $location = RfidMapping::where('tag', $robot->tag)->value('location_label') ?? 'Unknown';
            $battery = Battery::where('ip', $robot->ip)->orderByDesc('created_at')->value('battery') ?? '-';

            // Masukkan ke mergedData
            $mergedData->push([
                'name' => $robotName,
                'ip' => $robot->ip,
                'location' => $location,
                'battery' => $battery,
                'tag' => $robot->tag ?? '-',
                'created_at' => $robot->created_at,
            ]);

            // Masukkan ke robot list (untuk visual track)
            $robot->name = $robotName;
            $robot->location = $location;
            $filteredRobots->push($robot);
        }

        return view('dashboard.dashboard', [
            'mergedData' => $mergedData,
            'robots' => $filteredRobots,
        ]);

    } catch (\Exception $e) {
        Log::error('Error fetching dashboard data: ' . $e->getMessage());
        return view('dashboard.dashboard')->with('error', 'Gagal memuat data dashboard.');
    }
}
}
