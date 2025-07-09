<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Menampilkan halaman registrasi
     */
    public function index()
    {
        return view('auth.register');
    }

    /**
     * Proses penyimpanan user baru
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $this->create($request->all());

        return to_route('login');
    }

    /**
     * Validasi inputan pendaftaran
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:dns', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5'],
            // Hapus validasi role karena role akan di-set otomatis
        ]);
    }

    /**
     * Simpan data user baru
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user', // Set default role di sini
        ]);
    }
}
