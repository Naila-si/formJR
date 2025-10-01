<?php

namespace App\Http\Controllers;

use App\Models\Manifest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManifestController extends Controller
{
    // ==========================
    // FRONTEND - FORM SUBMIT
    // ==========================
    public function index()
    {
        // Halaman form manifest frontend
        return view('manifest.index');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // Handle multiple file upload
        if($request->hasFile('foto_manifest')){
            $files = [];
            foreach($request->file('foto_manifest') as $file){
                $filename = time().'_'.$file->getClientOriginalName();
                $file->storeAs('public/manifest', $filename);
                $files[] = $filename;
            }
            $data['foto_manifest'] = $files;
        }

        Manifest::create($data);

        return redirect()->back()->with('success', 'Data manifest berhasil disimpan!');
    }

    // ==========================
    // ADMIN
    // ==========================
    public function adminIndex()
    {
        $manifests = Manifest::latest()->get();
        return view('admin1.manifest.index', compact('manifests'));
    }

    public function destroy($id)
    {
        $manifest = Manifest::findOrFail($id);

        // Hapus file foto manifest dari storage jika ada
        if($manifest->foto_manifest){
            foreach($manifest->foto_manifest as $file){
                Storage::delete('public/manifest/'.$file);
            }
        }

        $manifest->delete();

        return redirect()->route('admin1.manifest.index')
                         ->with('success', 'Data manifest berhasil dihapus');
    }

    // Optional: detail manifest di admin
    public function show($id)
    {
        $manifest = Manifest::findOrFail($id);
        return view('admin.manifest.show', compact('manifest'));
    }
}
