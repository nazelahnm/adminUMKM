<?php

namespace App\Http\Controllers;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kriteria = Kriteria::all();
        $paginate = Kriteria::orderBy('id', 'asc')->paginate(5);

        return view(
            'admin.admin_crud.kriteria.index',
            compact('kriteria', 'paginate')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Data Kriteria";
        $kriteria = Kriteria::all();
        return view('admin.admin_crud.kriteria.tambah', compact('title', 'kriteria'));
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
            'kriteria' => 'required',
            'bobot' => 'required',
            'jenis' => 'required',
            'keterangan' => 'required',
        ]);

        $kriteria = new Kriteria();
        $kriteria->kriteria = $request->kriteria;
        $kriteria->bobot = $request->bobot;
        $kriteria->jenis = $request->jenis;
        $kriteria->keterangan = $request->keterangan;
        $kriteria->save();

        return redirect()->route('kriteria.index')->with('success', 'Data Kriteria Berhasil Ditambahkan');
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
        $title = "Edit Data Kriteria";
        $kriteria = Kriteria::find($id);
        return view('admin.admin_crud.kriteria.edit', compact('title', 'kriteria'));
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
            'kriteria' => 'required',
            'bobot' => 'required',
            'jenis' => 'required',
            'keterangan' => 'required',
        ]);

        $kriteria = Kriteria::where('id', $id)->first();
        $kriteria->kriteria = $request->get('kriteria');
        $kriteria->bobot = $request->get('bobot');
        $kriteria->jenis = $request->get('jenis');
        $kriteria->keterangan = $request->get('keterangan');
        $kriteria->save();

        return redirect()->route('kriteria.index')
            ->with('success', 'Data Kriteria Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Kriteria::where('id', $id)->delete();
        return redirect()->route('kriteria.index')->with('success', 'Data Kriteria Berhasil Dihapus');
    }
}
