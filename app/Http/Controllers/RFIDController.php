<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RFIDData;

class RFIDController extends Controller
{
    public function store(Request $request)
    {
        // Validasi jika diperlukan
        $request->validate([
            'rfid_tag' => 'required|string',
            'timestamp' => 'required|date',
        ]);

        // Simpan data ke database
        $rfidData = new RFIDData();
        $rfidData->tag = $request->input('rfid_tag');
        $rfidData->timestamp = $request->input('timestamp');
        $rfidData->save();

        return response()->json(['message' => 'Data RFID berhasil disimpan']);
    }
}
