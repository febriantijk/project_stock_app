<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class pegawaicontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = user::where('name', 'LIKE', '%' . $search . '%')
        ->orwhere('name', 'LIKE', '%' . $search . '%')
        ->paginate();

        // $data = User::paginate();
        // dd($data);
        return view('pegawai.pegawai', compact(
            'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'level' => 'required',

        ]);

        $save = new User();
        $save->name = $request->name;
        $save->email = $request->email;
        $save->password = Hash::make($request->password);
        $save->level = $request->level;
        $save->save();

        // dd($save);

        return redirect()->back()->with(
            'message',
            'data pegawai berhasil ditambahkan',
        );


    }

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
        $getdata = user::find($id);
        return view('pegawai.edit-pegawai', compact(
            'getdata',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' =>'required',
            'email' => 'nullable|email',
            'password' => 'nullable|min:6',
            'level' => 'nullable',

        ]);

        $updateuser = user::find($id);
        $updateuser->name = $request->name;

        if ($request->filled('email') && $request -> email != $updateuser->email) {
            $request->validate([
                'emaiil' => 'unique:users,email',
            ], [
                'email.unique' => 'email sudah terdaftar'
            ]);

            $updateuser->email = $request->email;
        }
        if ($request->filled('password')) {
            $updateuser->password = Hash::make($request->password);
        }
        if ($request->filled('level')) {
         $updateuser->level = $request->level;
        }
        $updateuser->save();
        return redirect('/pegawai')->with(
            'message',
          'data pegawai berhasil diperbaharui'
        );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $getdata =user::find($id);
        $getdata->delete();

        return redirect()->back()->with(
            'message',
            'data pegawai berhasil dihapus'
        );
    }
}
