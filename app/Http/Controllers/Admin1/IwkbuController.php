<?php

namespace App\Http\Controllers\Admin1;

use App\Exports\IwkbuExport;
use App\Imports\IwkbuImport;
use App\Models\Admin1\Iwkbu;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class IwkbuController extends Controller
{
    public function index()
    {
        $iwkbus = Iwkbu::all();
        return view('admin1.iwkbu.index', compact('iwkbus'));
    }

    public function edit($id)
    {
        $iwkbu = Iwkbu::findOrFail($id);
        return view('admin1.iwkbu.edit', compact('iwkbu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'wilayah'             => 'required|string|max:255',
            'no_polisi'           => 'required|string|max:50',
            'tarif'               => 'nullable|numeric',
            'undefined'           => 'nullable|string',
            'nominal_iwkbu'       => 'nullable|numeric',
            'trayek'              => 'nullable|string|max:255',
            'jenis'               => 'required|string|in:' . implode(',', \App\Models\Admin1\Iwkbu::$options['jenis']),
            'tahun_pembuatan'     => 'nullable|digits:4|integer',
            'pic'                 => 'nullable|string|max:255',
            'badan_hukum'         => 'required|string|in:' . implode(',', \App\Models\Admin1\Iwkbu::$options['badan_hukum']),
            'nama_perusahaan'     => 'nullable|string|max:255',
            'alamat_lengkap'      => 'nullable|string|max:500',
            'kel'                 => 'nullable|string|max:100',
            'kec'                 => 'nullable|string|max:100',
            'kota_kab'            => 'nullable|string|max:100',
            'tanggal_transaksi'   => 'nullable|date',
            'loket_pembayaran'    => 'nullable|string|max:100',
            'masa_berlaku_iwkbu'  => 'nullable|date',
            'masa_laku_swdkllj'   => 'nullable|date',
            'status_pembayaran'    => 'required|string|in:' . implode(',', \App\Models\Admin1\Iwkbu::$options['status_pembayaran']),
            'status_kendaraan'     => 'required|string|in:' . implode(',', \App\Models\Admin1\Iwkbu::$options['status_kendaraan']),
            'nilai_outstanding'    => 'nullable|numeric',
            'hasil_konfirmasi'     => 'required|string|in:' . implode(',', \App\Models\Admin1\Iwkbu::$options['hasil_konfirmasi']),
            'no_hp'                => 'nullable|string|max:20',
            'nama_pemilik'         => 'nullable|string|max:255',
            'keterangan'           => 'nullable|string|max:500',
        ]);

        $iwkbu = Iwkbu::findOrFail($id);
        $iwkbu->update($request->all());

        return redirect()->route('admin1.iwkbu.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function show($id)
    {
        $iwkbu = Iwkbu::findOrFail($id);
        return view('admin1.iwkbu.show', compact('iwkbu'));
    }

    public function destroy($id)
    {
        $iwkbu = Iwkbu::findOrFail($id);
        $iwkbu->delete();

        return redirect()->route('admin1.iwkbu.index')->with('success', 'Data berhasil dihapus!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new IwkbuImport, $request->file('file'));

        return redirect()->route('admin1.iwkbu.index')->with('success', 'Data berhasil diimport!');
    }

    public function exportExcel()
    {
        return Excel::download(new IwkbuExport, 'data_iwkbu.xlsx');
    }

    public function exportPdf(Request $request)
    {
        ini_set('max_execution_time', 300); // 5 menit
        ini_set('memory_limit', '1024M');

        $perPage = 1000; // jumlah row per file
        $page = $request->get('page', 1);

        $iwkbus = Iwkbu::skip(($page - 1) * $perPage)
                    ->take($perPage)
                    ->get();

        $pdf = PDF::loadView('admin1.iwkbu.pdf', compact('iwkbus'))
                ->setPaper('a4', 'landscape');

        return $pdf->download("iwkbu-page-{$page}.pdf");
    }

}
