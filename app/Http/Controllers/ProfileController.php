<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Hapus foto lama jika ada
        if ($user->profile_picture && Storage::disk('public')->exists('profile_pictures/' . $user->profile_picture)) {
            Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
        }

        // Simpan foto baru
        $fileName = time() . '_' . $request->profile_picture->getClientOriginalName();
        $request->profile_picture->storeAs('profile_pictures', $fileName, 'public');

        // Update data user menggunakan Query Builder langsung
        DB::table('users')
            ->where('id', Auth::id())
            ->update(['profile_picture' => $fileName]);

        return redirect()->route('profile')->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function deleteProfilePicture(Request $request)
    {
        $user = Auth::user();

        // Hapus file dari storage jika ada
        if ($user->profile_picture && Storage::disk('public')->exists('profile_pictures/' . $user->profile_picture)) {
            Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
        }

        // Update data user, kosongkan nama file
        DB::table('users')
            ->where('id', $user->id)
            ->update(['profile_picture' => null]);

        return redirect()->route('profile')->with('success', 'Foto profil berhasil dihapus.');
    }
}
