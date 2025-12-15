<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pelanggan;


class AdminController extends Controller
{
   

    public function destroy($id_pelanggan)
    {
        $pelanggan = Pelanggan::findOrFail($id_pelanggan);
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }

    public function User()
    {
        $pelanggan = Pelanggan::where('status', 'active')->get();

        return view('hapususer', compact('pelanggan'));
    }
    
    // Simpan produk baru
    public function simpanProduk(Request $request)
    {
        $request->validate([
            'nama_barang'  => 'required|string|max:30',
            'harga'        => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
            'satuan'       => 'required|string|max:30',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'nama_barang' => $request->nama_barang,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'satuan'      => $request->satuan,
        ];

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $filename = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images'), $filename);
            $data['gambar'] = $filename;
        }

        DB::table('barang')->insert($data);

        return redirect()->route('admin.dashboard')->with('success', 'Produk berhasil ditambahkan');
    }

    // Update stok produk
    public function updateStok(Request $request, $id_barang)
    {
        $request->validate([
            'stok' => 'required|integer|min:0'
        ]);

        DB::table('barang')
            ->where('id_barang', $id_barang)
            ->update(['stok' => $request->stok]);

        return redirect()->route('admin.dashboard')->with('success', 'Stok berhasil diperbarui');
    }

    // Hapus produk
    public function hapusProduk($id_barang)
    {
        DB::table('barang')->where('id_barang', $id_barang)->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Produk berhasil dihapus');
    }
    public function showLoginForm() {
        return view('auth.login');
    }
    

    public function login(Request $request){
    $admin = Admin::where('username', $request->username)
                  ->where('password', $request->password) // langsung cocokkan plaintext
                  ->first();

    if ($admin) {
        Auth::guard('admin')->login($admin);
        return redirect()->route('admin.dashboard');
    }
    
    

    return back()->withErrors([
        'username' => 'Username atau password salah',
    ]);
}

}
