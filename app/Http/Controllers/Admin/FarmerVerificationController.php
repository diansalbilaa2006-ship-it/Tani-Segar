<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use Illuminate\Http\Request;

class FarmerVerificationController extends Controller
{
    // Menampilkan daftar calon petani
    public function index()
    {
        $farmers = Farmer::with('user')
            ->latest()
            ->get();

        return view('admin.farmers.index', compact('farmers'));
    }

    // Menyetujui pendaftaran petani
    public function approve($id)
    {
        $farmer = Farmer::findOrFail($id);

        if ($farmer->status_verifikasi !== 'menunggu') {
            return back()->with('error', 'Pendaftaran ini sudah diproses.');
        }

        $farmer->update([
            'status_verifikasi' => 'diterima',
            'alasan_penolakan' => null,
        ]);

        $farmer->user->update([
            'role' => 'petani',
        ]);

        return back()->with('success', 'Calon petani berhasil disetujui.');
    }

    // Menolak pendaftaran petani
    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => ['required', 'string', 'max:1000'],
        ]);

        $farmer = Farmer::findOrFail($id);

        if ($farmer->status_verifikasi !== 'menunggu') {
            return back()->with('error', 'Pendaftaran ini sudah diproses.');
        }

        $farmer->update([
            'status_verifikasi' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        return back()->with('success', 'Pendaftaran calon petani ditolak.');
    }
}
