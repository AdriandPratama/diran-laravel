<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Robot;
use App\Models\Battery;
use App\Models\User;
use App\Notifications\BatteryLowNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DataLogController extends Controller
{
    // API: Menyimpan data dari ESP32
    public function apiStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ip' => 'required|ip',
            'location' => 'required|string|max:255',
            'tag' => 'nullable|string|max:32',
            'battery' => 'required|numeric',
        ]);

        try {
            // Simpan ke tabel robots
         Robot::create([
    'name' => $request->name,
    'ip' => $request->ip,
    'location' => $request->location,
    'tag' => $request->tag,
    'created_at' => now(),
    'updated_at' => now(),
]);


            // Simpan ke tabel battery
            $battery = Battery::create([
                'name' => $request->name,
                'ip' => $request->ip,
                'battery' => $request->battery,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Kirim notifikasi jika baterai rendah
            if ($battery->battery < 20) {
                $users = User::all();
                foreach ($users as $user) {
                    $user->notify(new BatteryLowNotification($battery));
                }
            }

            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menyimpan data'], 500);
        }
    }

    // Web: Tampilkan DataLog Gabungan (1 baris per IP)
public function index()
{
    $dataLogs = DB::table('robots as r')
        ->join(DB::raw('(SELECT ip, MAX(updated_at) as latest_robot FROM robots GROUP BY ip) as latest_r'), function ($join) {
            $join->on('r.ip', '=', 'latest_r.ip')
                 ->on('r.updated_at', '=', 'latest_r.latest_robot');
        })
        ->leftJoin(DB::raw('(SELECT ip, battery, updated_at as latest_battery FROM battery WHERE (ip, updated_at) IN (
            SELECT ip, MAX(updated_at) FROM battery GROUP BY ip
        )) as b'), function ($join) {
            $join->on('r.ip', '=', 'b.ip');
        })
        ->leftJoin('rfid_mappings as map', 'r.tag', '=', 'map.tag') // ✅ tambahkan ini
        ->select(
            'r.id as robot_id',
            'r.name',
            'r.ip',
            'map.location_label as location', // ✅ ganti ini jadi dari mapping
            'r.tag',
            'r.created_at as robot_created',
            'r.updated_at as robot_updated',
            'b.battery',
            'b.latest_battery as battery_updated'
        )
        ->get();

    return view('dashboard.datalog', compact('dataLogs'));
}




    // Web: Tambah data manual dari form
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ip' => 'required|ip',
            'location' => 'nullable|string|max:255',
            'tag' => 'nullable|string|max:32',
            'battery' => 'nullable|numeric',
        ]);

        try {
         Robot::create([
    'name' => $request->name,
    'ip' => $request->ip,
    'location' => $request->location,
    'tag' => $request->tag,
    'created_at' => now(),
    'updated_at' => now(),
]);


            if ($request->filled('battery')) {
                $battery = Battery::create([
                    'name' => $request->name,
                    'ip' => $request->ip,
                    'battery' => $request->battery,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if ($battery->battery < 20) {
                    $users = User::all();
                    foreach ($users as $user) {
                        $user->notify(new BatteryLowNotification($battery));
                    }
                }
            }

            return redirect()->route('datalog')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan data: ' . $e->getMessage());
            return redirect()->route('datalog')->with('error', 'Gagal menambahkan data.');
        }
    }

    // Web: Update data berdasarkan sumber (robot/battery)
    public function update(Request $request, $id, $source)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ip' => 'required|ip',
            'location' => 'nullable|string|max:255',
            'tag' => 'nullable|string|max:32',
            'battery' => 'nullable|numeric',
        ]);

        try {
            if ($source === 'robot') {
                $robot = Robot::findOrFail($id);
                $robot->update([
                    'name' => $request->name,
                    'ip' => $request->ip,
                    'location' => $request->location,
                    'tag' => $request->tag,
                ]);
            } else {
                $battery = Battery::findOrFail($id);
                $battery->update([
                    'name' => $request->name,
                    'ip' => $request->ip,
                    'battery' => $request->battery,
                ]);

                if ($battery->battery < 20) {
                    $users = User::all();
                    foreach ($users as $user) {
                        $user->notify(new BatteryLowNotification($battery));
                    }
                }
            }

            return redirect()->route('datalog')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data: ' . $e->getMessage());
            return redirect()->route('datalog')->with('error', 'Gagal memperbarui data.');
        }
    }

    // Web: Hapus data
    public function destroy($id, $source)
    {
        try {
            if ($source === 'robot') {
                $robot = Robot::findOrFail($id);
                $robot->delete();
            } else {
                $battery = Battery::findOrFail($id);
                $battery->delete();
            }

            return redirect()->route('datalog')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data: ' . $e->getMessage());
            return redirect()->route('datalog')->with('error', 'Gagal menghapus data.');
        }
    }
}
