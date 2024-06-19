<?php

namespace App\Http\Controllers;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KelurahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelurahan = Kelurahan::all();
        $paginate = Kelurahan::orderBy('id', 'asc')->paginate(5);

        return view(
            'admin.admin_crud.kelurahan.index',
            compact('kelurahan', 'paginate')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Data Kelurahan";
        $kelurahan = Kelurahan::all();
        return view('admin.admin_crud.kelurahan.tambah', compact('title', 'kelurahan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelurahan' => 'required',
        ]);

        $kelurahan = new Kelurahan();
        $kelurahan->nama_kelurahan = $request->nama_kelurahan;
        $kelurahan->save();

        return redirect()->route('kelurahan.index')->with('success', 'Data Kelurahan Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Data Kelurahan";
        $kelurahan = Kelurahan::find($id);
        return view('admin.admin_crud.kelurahan.edit', compact('title', 'kelurahan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelurahan' => 'required',
        ]);

        $kelurahan = Kelurahan::where('id', $id)->first();
        $kelurahan->nama_kelurahan = $request->get('nama_kelurahan');
        $kelurahan->save();

        return redirect()->route('kelurahan.index')
            ->with('success', 'Data Kelurahan Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Kelurahan::where('id', $id)->delete();
        return redirect()->route('kelurahan.index')->with('success', 'Data Kelurahan Berhasil Dihapus');
    }
}
