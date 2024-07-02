<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use Illuminate\Http\Request;
use App\Models\Tahun;
use Illuminate\Support\Facades\Storage;

class KelurahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index($id)
    {
        $tahun = Tahun::findOrFail($id); // Mengambil data tahun berdasarkan tahun_id
        $paginate = Kelurahan::where('tahun_id', $id)->orderBy('id', 'asc')->paginate(20);

        return view('admin.admin_crud.kelurahan.index', [
            'paginate' => $paginate,
            'tahun_id' => $id,
            'tahun' => $tahun // Mengirimkan data tahun ke view
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $title = "Tambah Data Kelurahan";
        $kelurahans = Kelurahan::all();
        $tahun_id = $request->input('tahun_id');
        return view('admin.admin_crud.kelurahan.tambah', compact('title', 'kelurahans', 'tahun_id'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            'tahun_id' => 'required|exists:tahuns,id'
        ]);

        // Check if the kelurahan with the same name already exists for the given tahun_id
        $existingKelurahan = Kelurahan::where('nama_kelurahan', $request->nama_kelurahan)
            ->where('tahun_id', $request->tahun_id)
            ->exists();

        if ($existingKelurahan) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nama_kelurahan' => 'Nama Kelurahan sudah ada untuk Tahun ID ini.']);
        }

        // Create new kelurahan if validation passes
        $kelurahan = new Kelurahan();
        $kelurahan->nama_kelurahan = $request->nama_kelurahan;
        $kelurahan->tahun_id = $request->tahun_id;
        $kelurahan->save();

        return redirect()->route('kelurahan.index', ['tahun_id' => $request->tahun_id])
            ->with('success', 'Data Kelurahan Berhasil Ditambahkan');
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paginate = Kelurahan::where('tahun_id', $id)
            ->orderBy('id', 'asc')
            ->paginate(20);

        return view('admin.admin_crud.kelurahan.index', [
            'paginate' => $paginate,
            'tahun_id' => $id
        ]);
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

        // Find the kelurahan to update
        $kelurahan = Kelurahan::findOrFail($id);

        // Check if the new name conflicts with an existing name for different tahun_id
        if ($kelurahan->nama_kelurahan !== $request->nama_kelurahan || $kelurahan->tahun_id !== $request->tahun_id) {
            $existingKelurahan = Kelurahan::where('nama_kelurahan', $request->nama_kelurahan)
                ->where('tahun_id', $request->tahun_id)
                ->exists();

            if ($existingKelurahan) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['nama_kelurahan' => 'Nama Kelurahan sudah ada untuk Tahun ID ini.']);
            }
        }

        // Update the kelurahan if validation passes
        $kelurahan->nama_kelurahan = $request->nama_kelurahan;
        $kelurahan->save();

        return redirect()->route('kelurahan.index', ['tahun_id' => $kelurahan->tahun_id])
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
        $kelurahan = Kelurahan::find($id);
        $kelurahan->delete();
        return redirect()->route('kelurahan.index', ['tahun_id' => $kelurahan->tahun_id])
            ->with('success', 'Data Kelurahan Berhasil Dihapus');
    }
}
