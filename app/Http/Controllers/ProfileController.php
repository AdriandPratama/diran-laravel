<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return view('profile'); // Ensure you have a profile.blade.php view
    }
}
