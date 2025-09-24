<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use App\Models\Admin1\Iwkbu;
use Illuminate\Http\Request;

class FormulirController extends Controller
{
    // =======================
    // FRONTEND - Form Submit
    // =======================
    public function index()
    {
        // Ambil semua no_polisi dari tabel Iwkbu
        $nopolList = Iwkbu::distinct()->pluck('no_polisi')->toArray();

       // Kirim variabel ke view
        return view('formulir.index', compact('nopolList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_polisi' => 'required|string|max:50',
            'evidence' => 'required|array|max:5', // maksimal 5 file
            'evidence.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'tanda_tangan' => 'nullable|file|mimes:jpg,jpeg,png|max:1024',
        ]);

        $formulir = new Formulir();
        $formulir->nama = $request->nama;
        $formulir->no_polisi = $request->no_polisi;

        // Upload evidence files
        if ($request->hasFile('evidence')) {
            $files = [];
            foreach ($request->file('evidence') as $file) {
                $files[] = $file->store('evidence', 'public');
            }
            $formulir->evidence = json_encode($files);
        }

        // Upload tanda tangan
        if ($request->hasFile('tanda_tangan')) {
            $formulir->tanda_tangan = $request->file('tanda_tangan')->store('tanda_tangan', 'public');
        }

        $formulir->save();

        return redirect()->back()->with('success', 'Form berhasil disubmit!');
    }

    // Untuk autocomplete No Polisi di frontend
    public function nopolList(Request $request)
    {
        $term = $request->get('term');
        $data = Iwkbu::where('no_polisi', 'LIKE', "%{$term}%")->pluck('no_polisi');
        return response()->json($data);
    }

    // Cek outstanding IWKBU
    public function getOutstanding($nopol)
    {
        $data = Iwkbu::where('no_polisi', $nopol)->first();

        if (!$data) {
            return response()->json([
                'error' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'no_polisi' => $data->no_polisi,
            'tarif' => $data->tarif,
            'nilai_outstanding' => (float) $data->nilai_outstanding // pastikan numeric
        ]);
    }

    // =======================
    // ADMIN - Dashboard CRUD
    // =======================
    public function adminIndex()
    {
        $formulirs = Formulir::all();
        return view('admin1.formulir.index', compact('formulirs'));
    }

    public function edit($id)
    {
        $formulir = Formulir::findOrFail($id);
        return view('admin1.formulir.edit', compact('formulir'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_polisi' => 'required|string|max:50',
            // optional update file jika mau
        ]);

        $formulir = Formulir::findOrFail($id);
        $formulir->nama = $request->nama;
        $formulir->no_polisi = $request->no_polisi;
        $formulir->save();

        return redirect()->route('admin1.formulir.index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($id)
    {
        $formulir = Formulir::findOrFail($id);
        $formulir->delete();
        return redirect()->route('admin1.formulir.index')->with('success', 'Data berhasil dihapus!');
    }
}
