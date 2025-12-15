<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    // Tampilkan profil
    public function profil()
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        return view('pelangganprofil', compact('pelanggan'));
    }

    // Form e
    // Update data profil
    public function update(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        $request->validate([
            'username' => 'required|string|max:50',
            'nama_pelanggan' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'email' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
        ]);

        $pelanggan->update([
            'username' => $request->username,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui!');
    }
}
