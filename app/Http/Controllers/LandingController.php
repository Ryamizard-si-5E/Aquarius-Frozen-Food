<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class LandingController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('index', compact('barangs'));
    }
    public function awal()
    {
        // Ambil hanya 4 barang untuk ditampilkan di home
        $barangs = Barang::take(4)->get();
        return view('awal', compact('barangs'));
    }
    public function awal2()
    {
        // Ambil hanya 4 barang untuk ditampilkan di home
        $barangs = Barang::take(4)->get();
        return view('awal2', compact('barangs'));
    }
    public function dashboard()
    {
        $barangs = Barang::all();
        return view('dashboard', compact('barangs'));
    }
    public function admin()
    {
        $barangs = Barang::all();
        return view('admin', compact('barangs'));
    }
    
}

