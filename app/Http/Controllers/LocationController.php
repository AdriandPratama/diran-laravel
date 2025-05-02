<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Robot;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    // API: Menyimpan atau memperbarui data lokasi dari ESP32
    public function apiStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ip' => 'required|ip',
            'location' => 'required|string|max:255',
            'tag' => 'nullable|string|max:32',
        ]);

        try {
            Robot::updateOrCreate(
                ['ip' => $request->ip],
                [
                    'name' => $request->name,
                    'location' => $request->location,
                    'tag' => $request->tag
                ]
            );

            return response()->json(['message' => 'Data lokasi berhasil disimpan'], 200);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data lokasi: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menyimpan data lokasi'], 500);
        }
    }

    // Web: Menampilkan semua data robot (lokasi)
    public function index()
    {
        $robots = Robot::all();
        return view('dashboard.location', compact('robots'));
    }

    // Web: Menyimpan data robot baru dari form
    public function store(Request $request)
    {
        Log::info('Store (Web) called', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'ip' => 'required|ip',
            'location' => 'required|string|max:255',
            'tag' => 'nullable|string|max:32',
        ]);

        try {
            Robot::create([
                'name' => $request->name,
                'ip' => $request->ip,
                'location' => $request->location,
                'tag' => $request->tag,
            ]);

            return redirect()->route('location')->with('success', 'Data robot berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan data robot: ' . $e->getMessage());
            return redirect()->route('location')->with('error', 'Gagal menambahkan data robot: ' . $e->getMessage());
        }
    }

    // Web: Mengupdate data robot dari form
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ip' => 'required|ip',
            'location' => 'required|string|max:255',
            'tag' => 'nullable|string|max:32',
        ]);

        $robot = Robot::findOrFail($id);
        $robot->update([
            'name' => $request->name,
            'ip' => $request->ip,
            'location' => $request->location,
            'tag' => $request->tag,
        ]);

        return redirect()->route('location')->with('success', 'Data robot berhasil diperbarui.');
    }

    // Web: Menghapus data robot
    public function destroy($id)
    {
        $robot = Robot::findOrFail($id);
        $robot->delete();

        return redirect()->route('location')->with('success', 'Data robot berhasil dihapus.');
    }
}
