<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Robot;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    // Menampilkan semua data robot
    public function index()
    {
        $robots = Robot::all(); // Ambil semua data robot
        return view('dashboard.location', compact('robots')); // Kirim ke view
    }

    // Menyimpan data robot baru
    public function store(Request $request)
    {
        // Log untuk debugging
        Log::info('Store method called', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'ip' => 'required|ip',
            'location' => 'required|string|max:255',
        ]);

        try {
            Robot::create([
                'name' => $request->name,
                'ip' => $request->ip,
                'location' => $request->location,
            ]);
        } catch (\Exception $e) {
            // Log error jika gagal menyimpan ke database
            Log::error('Error saving robot data: ' . $e->getMessage());
            return redirect()->route('location')->with('error', 'Gagal menambahkan data robot: ' . $e->getMessage());
        }

        return redirect()->route('location')->with('success', 'Data robot berhasil ditambahkan.');
    }

    // Menghapus data robot
    public function destroy($id)
    {
        $robot = Robot::findOrFail($id);
        $robot->delete();

        return redirect()->route('location')->with('success', 'Data robot berhasil dihapus.');
    }

    // Mengupdate data robot
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ip' => 'required|ip',
            'location' => 'required|string|max:255',
        ]);

        $robot = Robot::findOrFail($id);
        $robot->update([
            'name' => $request->name,
            'ip' => $request->ip,
            'location' => $request->location,
        ]);

        return redirect()->route('location')->with('success', 'Data robot berhasil diperbarui.');
    }
}
