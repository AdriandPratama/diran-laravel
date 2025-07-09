<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SettingController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('dashboard.setting', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('setting.index')->with('success', 'Role berhasil diperbarui.');
    }
}
