<?php

namespace App\Http\Controllers;

use App\Models\barangkeluar;
use App\Models\pelanggan;
use App\Models\stok;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class barangkeluarcontroller extends Controller
{

    public function index()
    {
        return view('barang.barangkeluar');
    }

    public function create()
    {
        $data = barangkeluar::all();

        $lastId = barangkeluar::max('id');
        $lastId = $lastId ? $lastId : 0; //terrnary operator

        if($data->isEmpty()) {
            $nextId = $lastId + 1;
            $date = now()->format('d,m/Y');
            $kode_transaksi = 'TRK' . $nextId . '/' . $date;

            $pelanggan = pelanggan::all();

            return view('barang.addbarangkeluar', compact(
                'data',
                'kode_transaksi',
                'pelanggan',
            ));
        }

        $latestItem = barangkeluar::latest();
        $id = $latestItem->id;
        $date = $latestItem->created_at->format('d,m,Y');
        $kode_transaksi = 'TRK' . $id . '/' . $date;

        $pelanggan = pelanggan::all();

        return view('barang.addbarangkeluar', compact(
            'data',
            'kode_transaksi',
            'pelanggan',
        ));
    }

    public function store(request $request)
    {
        $request->validate([
            'kode_transaksi' =>'required',
            'tgl_faktur' => 'required',
            'tgl_jatuh_tempo' => 'required',
            'pelanggan_id' => 'required',
        ], [
            'tgl_faktur.required' => 'Data wajib di isi',
            'tgl_jatuh_tempo.required' => 'Data wajib di isi',
            'pelanggan_id.required' => 'Data wajib di isi',
            'jenis_pembayaran.required' => 'Data wajib di isi',

        ]);

        $kode_transaksi = $request->kode_transaksi;
        $tgl_faktur = $request->tgl_faktur;
        $tgl_jatuh_tempo = $request->tgl_jatuh_tempo;
        $pelanggan_id = $request->pelanggan_id;

        $getnamapelanggan = pelanggan::find($pelanggan_id);
        $namaPelanggan = $getnamapelanggan->nama_pelanggan;
        $jenis_pembayaran = $request->jenis_pembayaran;


        $getBarang = stok::all();
        // dd($getbarang);

        return view('transaksi.transaksi', compact(
            'kode_transaksi',
            'tgl_faktur',
            'tgl_jatuh_tempo',
            'pelanggan_id',
            'namaPelanggan',
            'jenis_pembayaran',
            'getBarang',

        ));

    }

    public function savebarangkeluar(Request $request)
    {
        $request->validate([
        'kode_transaksi' => 'required',
        'tgl_faktur' => 'required',
        'tgl_jatuh_tempo' => 'required',
        'pelanggan_id' => 'required',
        'jenis_pembayaran' => 'required',
        'barang_id' => 'required',
        'jumlah_beli' => 'required',
        'harga_jual' => 'required',
        ]);

        $save = new barangkeluar();
        $save->kode_transaksi = $request->kode_transaksi;
        $save->tgl_faktur = $request->tgl_faktur;
        $save->tgl_jatuh_tempo = $request->tgl_jatuh_tempo;
        $save->pelanggan_id = $request->pelanggan_id;
        $save->jenis_pembayaran =  $request->jenis_pembayaran;
        $save->barang_id = $request->barang_id;
        $save->jumlah_beli = $request->jumlah_beli;
        $save->harga_jual = $request->harga_jual;

        $getstokdata = stok::find($request->barang_id);
                $getjumlahstok = $getstokdata->stok;
        $getstokdata->stok = $getjumlahstok - $request->jumlah_beli;
        $getstokdata->save();


        $diskon = $request->diskon;
            $nilaidiskon = $diskon/100;

        if ($diskon) {
            $save->diskon = $request->diskon;
                $hitung = $request->jumlah_beli * $request->harga_jual;
                $totaldiskon = $hitung * $nilaidiskon;
                $subtotal = $hitung - $totaldiskon;
                $save->sub_total = $subtotal;
        } else {
            $hitung = $request->jumlah_beli * $request->harga_jual;
            $save->sub_total = $hitung;
        }
        $save->user_id = FacadesAuth::user()->id;
        $save->tgl_buat = $request->tgl_faktur;
        $save->save();

        return redirect('/barang-keluar')->with(
            'message',
            'barang keluar add'
        );
    }

}
