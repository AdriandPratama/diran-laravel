<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Robot;
use App\Models\IpMapping;
use App\Models\RfidMapping;
use App\Models\DataLog;
use Illuminate\Support\Facades\Log;

class RFIDController extends Controller
{
public function apiStore(Request $request)
{
    Log::info('📥 RFIDController menerima data:', $request->all());
    Log::info('📥 Data request:', $request->all());


   $request->validate([
    'ip' => 'required|ip',
    'location' => 'required|string',
    'tag' => 'nullable|string',
    'name' => 'nullable|string|max:255',
]);


    try {
        // Mapping dari tabel ip_mappings & rfid_mappings
        $ipMapping = IpMapping::where('ip', $request->ip)->first();
       $name = $ipMapping && $ipMapping->name ? $ipMapping->name : 'Unknown Robot';


        $rfidMapping = RfidMapping::where('tag', $request->tag)->first();
      $location = $rfidMapping && $rfidMapping->location ? $rfidMapping->location : ($request->location ?? 'Unknown Location');

        // ✅ Update or Create status di tabel robots
        Robot::updateOrCreate(
            ['ip' => $request->ip],
            [
                'name' => $request->name ?? 'Unknown Robot',

                'location' => $location,
                'tag' => $request->tag,
            ]
        );

        // ✅ Simpan histori ke tabel datalogs
        DataLog::create([
            'name' => $name,
            'ip' => $request->ip,
            'location' => $location,
            'tag' => $request->tag,
        ]);

        Log::info('🧾 Final Data:', [
    'name' => $name,
    'ip' => $request->ip,
    'location' => $location,
    'tag' => $request->tag
]);


        return response()->json(['message' => '✅ Data robot & histori berhasil disimpan'], 200);
    } catch (\Exception $e) {
        Log::error('❌ Gagal menyimpan data lokasi: ' . $e->getMessage());
        return response()->json(['error' => 'Gagal menyimpan data'], 500);
    }
}
}
