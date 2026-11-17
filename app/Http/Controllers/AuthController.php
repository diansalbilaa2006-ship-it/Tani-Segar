<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    // Menampilkan halaman registrasi
    public function showRegister()
    {
        return view('auth.register');
    }

    // Memproses registrasi
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['pembeli', 'calon_petani'])],

            'nama_usaha' => ['required_if:role,calon_petani', 'nullable', 'string', 'max:255'],
            'no_telepon' => ['required_if:role,calon_petani', 'nullable', 'string', 'max:20'],
            'alamat' => ['required_if:role,calon_petani', 'nullable', 'string'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => $validated['role'],
            ]);

            // Jika mendaftar sebagai calon petani,
            // simpan juga data usaha petaninya.
            if ($validated['role'] === 'calon_petani') {
                Farmer::create([
                    'user_id' => $user->id,
                    'nama_usaha' => $validated['nama_usaha'],
                    'no_telepon' => $validated['no_telepon'],
                    'alamat' => $validated['alamat'],
                    'deskripsi' => $validated['deskripsi'] ?? null,
                    'status_verifikasi' => 'menunggu',
                ]);
            }
        });

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses login
    
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        $user = Auth::user();

        // Arahkan pengguna sesuai role
        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        }

        if ($user->role === 'petani') {
            return redirect()->route('dashboard');
        }

        if ($user->role === 'calon_petani') {
            return redirect()->route('dashboard');
        }

        return redirect()->route('dashboard');
    }

    return back()
        ->withErrors([
            'email' => 'Email atau password yang kamu masukkan salah.',
        ])
        ->onlyInput('email');
}


    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Kamu berhasil logout.');
    }
}
