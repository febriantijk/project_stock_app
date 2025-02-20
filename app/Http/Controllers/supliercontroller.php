<?php

namespace App\Http\Controllers;

use App\Models\suplier;
use App\Models\User;
use Illuminate\Http\Request;

class supliercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = suplier::where('nama_suplier', 'LIKE', '%' . $search . '%')
        ->orwhere('telp', 'LIKE', '%' . $search . '%')
        ->paginate();

        return view('suplier.suplier', compact(
            'data',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suplier.addsuplier');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_suplier' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'telp' => 'required|numeric',
            'tgl_terdaftar' => 'required',
            'status' => 'required',

        ],[
            'nama_suplier.required' => 'data wajib di isi',
            'email.required' => 'Data wajib diisi',
            'alamat.required' => 'Data wajib diisi',

            'telp.required' => 'data wajib diisi',
            'telp.numeric' => 'data berupa angka',
            'tgl_terdaftar.required' => 'Data berupa angka',
            'status.required' => 'Data wajib diisi',
        ]);

        $savesuplier = new suplier();
        $savesuplier->nama_suplier = $request->nama_suplier;
        $savesuplier->email = $request->email;
        $savesuplier->alamat = $request->alamat;
        $savesuplier->telp = $request->telp;
        $savesuplier->tgl_terdaftar = $request->tgl_terdaftar;
        $savesuplier->status = $request->status;
        $savesuplier->save();


        return redirect('/suplier')->with(
            'message',
            'data' . $request->nama_suplier . 'berhasil ditambahkan'
        );
    }






    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      $getdata = suplier::find($id);
      //dd($getdata);

      return view('suplier.editsuplier',compact('getdata'
    ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_suplier' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'telp' => 'required|numeric',
            'tgl_terdaftar' => 'required',
            'status' => 'required',

        ],[
            'nama_suplier.required' => 'data wajib di isi',
            'email.required' => 'Data wajib diisi',
            'alamat.required' => 'Data wajib diisi',

            'telp.required' => 'data wajib diisi',
            'telp.numeric' => 'data berupa angka',
            'tgl_terdaftar.required' => 'Data berupa angka',
            'status.required' => 'Data wajib diisi',
        ]);

        $savesuplier = suplier::find($id);
        $savesuplier->nama_suplier = $request->nama_suplier;
        $savesuplier->email = $request->email;
        $savesuplier->alamat = $request->alamat;
        $savesuplier->telp = $request->telp;
        $savesuplier->tgl_terdaftar = $request->tgl_terdaftar;
        $savesuplier->status = $request->status;
        $savesuplier->save();


        return redirect('/suplier')->with(
            'message',
            'data' . $request->nama_suplier . 'berhasil ditambahkan'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $getdata =suplier::find($id);
       $getdata->delete();

       return redirect('/suplier')->with(
           'message',
           'data'. $getdata->nama_suplier . 'berhasil dihapus'
       );
    }
}
