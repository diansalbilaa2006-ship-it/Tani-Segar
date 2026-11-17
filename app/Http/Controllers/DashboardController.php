<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Farmer;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Data awal
        $stats = [];

        // Dashboard Admin
        if ($user->role === 'admin') {
            $stats = [
                'total_pengguna' => User::count(),
                'calon_petani' => Farmer::where('status_verifikasi', 'menunggu')->count(),
                'total_produk' => Product::count(),
                'total_pesanan' => Order::count(),
            ];
        }

        // Dashboard Petani
        elseif ($user->role === 'petani') {
            $farmer = $user->farmer;

            $stats = [
                'total_produk' => $farmer
                    ? Product::where('farmer_id', $farmer->id)->count()
                    : 0,

                'total_pesanan' => $farmer
                    ? Order::where('farmer_id', $farmer->id)->count()
                    : 0,

                'produk_habis' => $farmer
                    ? Product::where('farmer_id', $farmer->id)
                        ->where('status', 'habis')->count()
                    : 0,
            ];
        }

        // Dashboard Pembeli
        elseif ($user->role === 'pembeli') {
            $stats = [
                'total_pesanan' => $user->orders()->count(),
                'jumlah_keranjang' => $user->cart
                    ? $user->cart->items()->sum('jumlah')
                    : 0,
            ];
        }

        // Dashboard Calon Petani
        elseif ($user->role === 'calon_petani') {
            $farmer = $user->farmer;

            $stats = [
                'status_verifikasi' => $farmer
                    ? $farmer->status_verifikasi
                    : 'belum_mendaftar',

                'alasan_penolakan' => $farmer
                    ? $farmer->alasan_penolakan
                    : null,
            ];
        }

              // Menampilkan dashboard sesuai role pengguna
        if ($user->role === 'admin') {
            return view('dashboard.admin', compact('user', 'stats'));
        }

        if ($user->role === 'petani') {
            return view('dashboard.petani', compact('user', 'stats'));
        }

        if ($user->role === 'pembeli') {
            return view('dashboard.pembeli', compact('user', 'stats'));
        }

        if ($user->role === 'calon_petani') {
            return view('dashboard.calon-petani', compact('user', 'stats'));
        }

        abort(403, 'Role tidak dikenali.');
}
}