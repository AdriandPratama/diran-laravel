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
            ]);

            // Simpan ke tabel battery
            $battery = Battery::create([
                'name' => $request->name,
                'ip' => $request->ip,
                'battery' => $request->battery,
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
    $dataLogs = DB::table('robots')
        ->leftJoin('battery', function($join) {
            $join->on('robots.ip', '=', 'battery.ip')
                 ->whereColumn('robots.created_at', '=', 'battery.created_at'); // opsional: jika ingin 1-to-1 cocokkan per waktu
        })
        ->select(
            'robots.id as robot_id',
            'robots.name',
            'robots.ip',
            'robots.location',
            'robots.tag',
            'robots.created_at as robot_created',
            'robots.updated_at as robot_updated',
            'battery.battery',
            'battery.id as battery_id',
            'battery.created_at as battery_created',
            'battery.updated_at as battery_updated'
        )
        ->orderByDesc('robots.created_at')
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
            ]);

            if ($request->filled('battery')) {
                $battery = Battery::create([
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
