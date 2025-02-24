<?php

namespace App\Http\Controllers;

use App\Models\barangkeluar;
use App\Models\pelanggan;
use App\Models\stok;
use App\Models\suplier;
use Illuminate\Http\Request;

class dashboardcontroller extends Controller
{
    public function index()
    {
        $getsuplier = suplier::count();
        $getpelanggan = pelanggan::count();
        $getstok = stok::count();
        $getpendapatan = barangkeluar::sum('sub_total');
        
        return view('dashboard.dashboard', compact(
            'getsuplier',
            'getpelanggan',
            'getstok',
            'getpendapatan',
        ));
    }
}
