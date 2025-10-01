<?php

namespace App\Http\Controllers\Admin1;

use App\Models\Rkcrm;
use App\Imports\RkcrmImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class RkcrmController extends Controller
{
    public function index()
    {
        $rkcrms = Rkcrm::all();

        // Kelompokkan per loket
        $lokets = $rkcrms->groupBy('loket_samsat');

        // Definisi kantor wilayah
        $kantor_wilayah = [
            'Kantor Wilayah Pekanbaru' => [
                'Pekanbaru Kota', 'Pekanbaru Selatan', 'Panam', 'Pekanbaru Utara',
                'Bangkinang', 'Kubang', 'Lipat Kain', 'Pasir Pangaraian',
                'Ujung Batu', 'Dalu-dalu', 'Siak', 'Perawang', 'Kandis',
                'Pelalawan', 'Taluk Kuantan', 'Rengat', 'Air Molek',
                'Pulau Kijang', 'Tembilahan'
            ],
            'Kantor Cabang Dumai' => [
                'Dumai', 'Loket Kantor Cabang Dumai', 'Duri', 'Pinggir',
                'Bagansiapiapi', 'Ujung Tanjung', 'Bagan Batu'
            ],
        ];

        // Hitung subtotal per kantor wilayah
        $subtotalsWilayah = [];
        foreach ($kantor_wilayah as $wilayah => $loketList) {
            $subtotalsWilayah[$wilayah] = [
                'os_awal' => 0,
                'os_sampai' => 0,
                'persen_os' => 0,
                'target_crm' => 0,
                'realisasi_po' => 0,
                'gap_po' => 0,
                'po_sampai_11_sept' => 0,
                'target_rupiah' => 0,
                'realisasi_os_bayar' => 0,
                'jml_kend_os_bayar' => 0,
                'nominal_os_bayar' => 0,
                'persen_os_bayar' => 0,
                'jml_kend_pemeliharaan' => 0,
                'nominal_pemeliharaan' => 0,
            ];

            foreach ($loketList as $loket) {
                if (isset($lokets[$loket])) {
                    foreach ($lokets[$loket] as $data) {
                        $subtotalsWilayah[$wilayah]['os_awal'] += $data->os_awal ?? 0;
                        $subtotalsWilayah[$wilayah]['os_sampai'] += $data->os_sampai_11_sept ?? 0;
                        $subtotalsWilayah[$wilayah]['target_crm'] += $data->target_crm ?? 0;
                        $subtotalsWilayah[$wilayah]['realisasi_po'] += $data->realisasi_po ?? 0;
                        $subtotalsWilayah[$wilayah]['gap_po'] += $data->gap_po ?? 0;
                        $subtotalsWilayah[$wilayah]['po_sampai_11_sept'] += $data->po_sampai_11_sept ?? 0;
                        $subtotalsWilayah[$wilayah]['target_rupiah'] += $data->target_rupiah ?? 0;
                        $subtotalsWilayah[$wilayah]['realisasi_os_bayar'] += $data->realisasi_os_bayar ?? 0;
                        $subtotalsWilayah[$wilayah]['jml_kend_os_bayar'] += $data->jml_kend_os_bayar ?? 0;
                        $subtotalsWilayah[$wilayah]['nominal_os_bayar'] += $data->nominal_os_bayar ?? 0;
                        $subtotalsWilayah[$wilayah]['jml_kend_pemeliharaan'] += $data->jml_kend_pemeliharaan ?? 0;
                        $subtotalsWilayah[$wilayah]['nominal_pemeliharaan'] += $data->nominal_pemeliharaan ?? 0;
                    }
                }
            }

            // Hitung %OS dan %OS Bayar
            $subtotalsWilayah[$wilayah]['persen_os'] = $subtotalsWilayah[$wilayah]['os_awal']
                ? round($subtotalsWilayah[$wilayah]['os_sampai'] / $subtotalsWilayah[$wilayah]['os_awal'] * 100, 2)
                : 0;

            $subtotalsWilayah[$wilayah]['persen_os_bayar'] = $subtotalsWilayah[$wilayah]['target_rupiah']
                ? round($subtotalsWilayah[$wilayah]['realisasi_os_bayar'] / $subtotalsWilayah[$wilayah]['target_rupiah'] * 100, 2)
                : 0;
        }

        // Total akhir semua loket (tetap sama)
        $total = [
            'os_awal' => $rkcrms->sum('os_awal'),
            'os_sampai' => $rkcrms->sum('os_sampai_11_sept'),
            'persen_os' => $rkcrms->avg('persen_os'),
            'target_crm' => $rkcrms->sum('target_crm'),
            'realisasi_po' => $rkcrms->sum('realisasi_po'),
            'gap_po' => $rkcrms->sum('gap_po'),
            'po_sampai_11_sept' => $rkcrms->sum('po_sampai_11_sept'),
            'target_rupiah' => $rkcrms->sum('target_rupiah'),
            'realisasi_os_bayar' => $rkcrms->sum('realisasi_os_bayar'),
            'jml_kend_os_bayar' => $rkcrms->sum('jml_kend_os_bayar'),
            'nominal_os_bayar' => $rkcrms->sum('nominal_os_bayar'),
            'persen_os_bayar' => $rkcrms->avg('persen_os_bayar'),
            'jml_kend_pemeliharaan' => $rkcrms->sum('jml_kend_pemeliharaan'),
            'nominal_pemeliharaan' => $rkcrms->sum('nominal_pemeliharaan'),
        ];

        return view('admin1.rkcrm.index', compact('lokets', 'subtotalsWilayah', 'total', 'kantor_wilayah'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        $file = $request->file('file');

        // Kalau pakai Laravel Excel
        Excel::import(new RkcrmImport, $file);

        return redirect()->route('admin1.rkcrm.index')->with('success', 'Data berhasil diimport!');
    }

    public function create()
    {
        // Daftar loket bisa diambil dari kantor wilayah (gabungkan semua loket)
        $kantor_wilayah = [
            'Kantor Wilayah Pekanbaru' => [
                'Pekanbaru Kota', 'Pekanbaru Selatan', 'Panam', 'Pekanbaru Utara',
                'Bangkinang', 'Kubang', 'Lipat Kain', 'Pasir Pangaraian',
                'Ujung Batu', 'Dalu-dalu', 'Siak', 'Perawang', 'Kandis',
                'Pelalawan', 'Taluk Kuantan', 'Rengat', 'Air Molek',
                'Pulau Kijang', 'Tembilahan'
            ],
            'Kantor Cabang Dumai' => [
                'Dumai', 'Loket Kantor Cabang Dumai', 'Duri', 'Pinggir',
                'Bagansiapiapi', 'Ujung Tanjung', 'Bagan Batu'
            ],
        ];

        // Gabungkan semua loket jadi satu array
        $lokets_list = [];
        foreach ($kantor_wilayah as $lokets) {
            $lokets_list = array_merge($lokets_list, $lokets);
        }

        return view('admin1.rkcrm.create', compact('lokets_list'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_pegawai' => 'required|string',
            'loket_samsat' => 'required|string',
            'os_awal' => 'required|numeric',
            'os_sampai_11_sept' => 'required|numeric',
            'persen_os' => 'required|numeric',
            'target_crm' => 'required|numeric',
            'realisasi_po' => 'required|numeric',
            'gap_po' => 'required|numeric',
            'po_sampai_11_sept' => 'nullable|numeric',
            'target_rupiah' => 'required|numeric',
            'realisasi_os_bayar' => 'required|numeric',
            'jml_kend_os_bayar' => 'required|numeric',
            'nominal_os_bayar' => 'required|numeric',
            'persen_os_bayar' => 'required|numeric',
            'jml_kend_pemeliharaan' => 'required|numeric',
            'nominal_pemeliharaan' => 'required|numeric',
        ]);

        // Simpan data ke database
        Rkcrm::create($request->all());

        // Redirect kembali ke index dengan pesan sukses
        return redirect()->route('admin1.rkcrm.index')
                        ->with('success', 'Data RK CRM berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $rkcrm = Rkcrm::findOrFail($id);

        // Loket list bisa sama seperti di create()
        $kantor_wilayah = [
            'Kantor Wilayah Pekanbaru' => [
                'Pekanbaru Kota', 'Pekanbaru Selatan', 'Panam', 'Pekanbaru Utara',
                'Bangkinang', 'Kubang', 'Lipat Kain', 'Pasir Pangaraian',
                'Ujung Batu', 'Dalu-dalu', 'Siak', 'Perawang', 'Kandis',
                'Pelalawan', 'Taluk Kuantan', 'Rengat', 'Air Molek',
                'Pulau Kijang', 'Tembilahan'
            ],
            'Kantor Cabang Dumai' => [
                'Dumai', 'Loket Kantor Cabang Dumai', 'Duri', 'Pinggir',
                'Bagansiapiapi', 'Ujung Tanjung', 'Bagan Batu'
            ],
        ];

        $lokets_list = [];
        foreach ($kantor_wilayah as $lokets) {
            $lokets_list = array_merge($lokets_list, $lokets);
        }

        return view('admin1.rkcrm.edit', compact('rkcrm', 'lokets_list'));
    }

    public function update(Request $request, $id)
    {
        $rkcrm = Rkcrm::findOrFail($id);

        $request->validate([
            'nama_pegawai' => 'required|string',
            'loket_samsat' => 'required|string',
            'os_awal' => 'required|numeric',
            'os_sampai_11_sept' => 'required|numeric',
            'persen_os' => 'required|numeric',
            'target_crm' => 'required|numeric',
            'realisasi_po' => 'required|numeric',
            'gap_po' => 'required|numeric',
            'po_sampai_11_sept' => 'nullable|numeric',
            'target_rupiah' => 'required|numeric',
            'realisasi_os_bayar' => 'required|numeric',
            'jml_kend_os_bayar' => 'required|numeric',
            'nominal_os_bayar' => 'required|numeric',
            'persen_os_bayar' => 'required|numeric',
            'jml_kend_pemeliharaan' => 'required|numeric',
            'nominal_pemeliharaan' => 'required|numeric',
        ]);

        $rkcrm->update($request->all());

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');

    }

}
