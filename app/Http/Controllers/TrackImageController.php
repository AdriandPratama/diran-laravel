<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrackImage;
use Illuminate\Support\Facades\Storage;

class TrackImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'track_image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        // Hapus gambar lama (jika ada)
        $old = TrackImage::first();
        if ($old) {
            Storage::delete('public/tracks/' . $old->filename);
            $old->delete();
        }

        // Simpan gambar baru
        $file = $request->file('track_image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/tracks', $filename);

        TrackImage::create(['filename' => $filename]);

        return redirect()->back()->with('success', 'Gambar track berhasil diupload!');
    }

    public function destroy()
    {
        $track = TrackImage::first();
        if ($track) {
            Storage::delete('public/tracks/' . $track->filename);
            $track->delete();
        }

        return redirect()->back()->with('success', 'Gambar track berhasil dihapus!');
    }
}
