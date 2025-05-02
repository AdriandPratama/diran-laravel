<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Robot; // pastikan model Robot sudah dibuat

class RFIDController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string',
            'ip' => 'required|ip',
            'location' => 'required|string',
            'tag' => 'required|string',
        ]);

        // Simpan ke database (tabel robots)
        Robot::create([
            'name' => $request->name,
            'ip' => $request->ip,
            'location' => $request->location,
            'tag' => $request->tag,
        ]);

        return response()->json(['message' => 'Data RFID berhasil disimpan'], 201);
    }
}
