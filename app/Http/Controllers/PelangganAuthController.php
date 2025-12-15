<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PelangganAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.pelanggan-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('pelanggan')->attempt($credentials)) {
            $user = Auth::guard('pelanggan')->user();

            // CEK STATUS
            if ($user->status !== 'active') {
                Auth::guard('pelanggan')->logout();
                return back()->withErrors([
                    'username' => 'Akun Anda belum diverifikasi admin.',
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended('/awal2');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.pelanggan-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:pelanggan,username',
            'nama_pelanggan' => 'required|string|max:30',
            'password' => 'required|string|min:6|confirmed',
            'alamat' => 'required|string|max:30',
            'email' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
        ]);

        Pelanggan::create([
            'id_pelanggan' => (string) Str::uuid(),
            'username' => $request->username,
            'nama_pelanggan' => $request->nama_pelanggan,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'status' => 'pending', // Tambahkan status pending
        ]);
        

        return redirect()->route('pelanggan.login')->with('pending', 'Silakan tunggu admin memverifikasi akun Anda.');
    }

    public function logout(Request $request)
    {
        Auth::guard('pelanggan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('awal');
    }
    public function verifikasi($id)
{
    $pelanggan = Pelanggan::findOrFail($id);

    // Cek apakah nomor sudah dipakai pelanggan lain yang disetujui
    $nomorSudahAda = Pelanggan::where('no_hp', $pelanggan->no_hp)
        ->where('status', 'active') // hanya cek yang sudah aktif
        ->where('id_pelanggan', '!=', $pelanggan->id_pelanggan)
        ->exists();

    return view('verify-pelanggan', compact('pelanggan', 'nomorSudahAda'));
}
}
