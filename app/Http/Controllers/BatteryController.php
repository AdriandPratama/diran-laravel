<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Battery;
use Illuminate\Support\Facades\Log;

class BatteryController extends Controller
{
    // API: Menyimpan data baterai dari ESP32
    public function apiStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ip' => 'required|ip',
            'battery' => 'required|numeric',
        ]);

        try {
            Battery::create([
                'name' => $request->name,
                'ip' => $request->ip,
                'battery' => $request->battery,
            ]);

            return response()->json(['message' => 'Data baterai berhasil disimpan'], 200);
        } catch (\Exception $e) {
            Log::error('Gagal simpan data baterai: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menyimpan data baterai'], 500);
        }
    }

    // Web: Menampilkan semua data baterai
    public function index()
    {
        $batteries = Battery::all();
        return view('dashboard.battery', compact('batteries'));
    }

    // Web: Menyimpan data baterai baru (form manual)
    public function store(Request $request)
    {
        Log::info('Store (Web) called', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'ip' => 'required|ip',
            'battery' => 'required|string|max:255',
        ]);

        try {
            Battery::create([
                'name' => $request->name,
                'ip' => $request->ip,
                'battery' => $request->battery,
            ]);

            return redirect()->route('battery')->with('success', 'Data robot berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error saving robot data: ' . $e->getMessage());
            return redirect()->route('battery')->with('error', 'Gagal menambahkan data robot: ' . $e->getMessage());
        }
    }

    // Web: Mengupdate data baterai
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ip' => 'required|ip',
            'battery' => 'required|string|max:255',
        ]);

        $battery = Battery::findOrFail($id);
        $battery->update([
            'name' => $request->name,
            'ip' => $request->ip,
            'battery' => $request->battery,
        ]);

        return redirect()->route('battery')->with('success', 'Data robot berhasil diperbarui.');
    }

    // Web: Menghapus data baterai
    public function destroy($id)
    {
        $battery = Battery::findOrFail($id);
        $battery->delete();

        return redirect()->route('battery')->with('success', 'Data robot berhasil dihapus.');
    }
}
