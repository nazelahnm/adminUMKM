<?php

namespace App\Http\Controllers;

use App\Models\Tahun;
use Illuminate\Http\Request;

class TahunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun = Tahun::all();
        $paginate = Tahun::orderBy('id', 'asc')->paginate(5);

        return view(
            'admin.admin_crud.tahun.index',
            compact('tahun', 'paginate')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Data Tahun";
        $tahun = Tahun::all();
        return view('admin.admin_crud.tahun.tambah', compact('title', 'tahun'));
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
            'year' => 'required|unique:tahuns,year',
        ], [
            'year.unique' => 'Tahun sudah ditambahkan.',
        ]);

        $tahun = new Tahun();
        $tahun->year = $request->year;
        $tahun->save();

        return redirect()->route('tahuns.index')->with('success', 'Data Tahun Berhasil Ditambahkan');
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
        $title = "Edit Data Tahun";
        $tahun = Tahun::find($id);
        return view('admin.admin_crud.tahun.edit', compact('title', 'tahun'));
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
            'year' => 'required|unique:tahuns,year',
        ], [
            'year.unique' => 'Tahun sudah ditambahkan.',
        ]);

        $tahun = Tahun::where('id', $id)->first();
        $tahun->year = $request->get('year');
        $tahun->save();

        return redirect()->route('tahuns.index')
            ->with('success', 'Data Tahun Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tahun::where('id', $id)->delete();
        return redirect()->route('tahuns.index')->with('success', 'Data Tahun Berhasil Dihapus');
    }
}
