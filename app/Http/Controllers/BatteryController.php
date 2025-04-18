<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Battery;
use Illuminate\Support\Facades\Log;

class BatteryController extends Controller
{
    // Menampilkan semua data robot
    public function index()
    {
        $batteries = Battery::all(); // Ambil semua data robot
        return view('dashboard.battery', compact('batteries')); // Kirim ke view
    }

    // Menyimpan data robot baru
    public function store(Request $request)
    {
        // Log untuk debugging
        Log::info('Store method called', $request->all());

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
        } catch (\Exception $e) {
            // Log error jika gagal menyimpan ke database
            Log::error('Error saving robot data: ' . $e->getMessage());
            return redirect()->route('battery')->with('error', 'Gagal menambahkan data robot: ' . $e->getMessage());
        }

        return redirect()->route('battery')->with('success', 'Data robot berhasil ditambahkan.');
    }

    // Menghapus data robot
    public function destroy($id)
    {
        $battery = Battery::findOrFail($id);
        $battery->delete();

        return redirect()->route('battery')->with('success', 'Data robot berhasil dihapus.');
    }

    // Mengupdate data robot
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
}
