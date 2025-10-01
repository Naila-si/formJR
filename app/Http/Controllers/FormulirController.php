<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use App\Models\Admin1\Iwkbu;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\FormulirVerification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FormulirController extends Controller
{
    // =======================
    // FRONTEND - Form Submit
    // =======================
    public function index(Request $request)
    {
        $formulirs = Formulir::all();
        
        // Ambil semua no_polisi dari tabel Iwkbu
        $nopolList = Iwkbu::distinct()->pluck('no_polisi')->toArray();

        // Kirim variabel ke view
        return view('formulir.index', compact('formulirs', 'nopolList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal_waktu' => 'required|date',
            'loket' => 'required|string',
            'nama_depan' => 'required|string',
            'nama_belakang' => 'required|string',
            'nama_pt' => 'required|string',
            'jenis_angkutan' => 'required|string',
            'nama_pengelola' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|string',

            'kendaraan' => 'nullable|array',
            'hasil_kunjungan' => 'required|string',
            'janji_bayar' => 'nullable|date',

            'foto_kunjungan.*' => 'file|mimes:jpg,jpeg,png|max:2048',
            'evidence.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'profiling' => 'nullable|array',

            'ttd_petugas_data' => 'nullable|string',
            'ttd_pemilik_data' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // 🚗 Proses data kendaraan
        $kendaraanData = [];
        if ($request->has('kendaraan')) {
            foreach ($request->kendaraan['nopol'] as $i => $nopol) {
                // cek apakah nopol sudah ada di IWKBU
                $exists = Iwkbu::where('no_polisi', $nopol)->first();
                if (!$exists) {
                    Iwkbu::create([
                        'no_polisi' => $nopol,
                        'nama_perusahaan' => $request->nama_pt,
                        'nama_pemilik' => $request->nama_pengelola,
                        'no_hp' => $request->telepon,
                    ]);
                }

                $kendaraanData[] = [
                    'nopol' => $nopol,
                    'status' => $request->kendaraan['status'][$i] ?? null,
                    'jumlah_bayar' => $request->kendaraan['jumlah_bayar'][$i] ?? null,
                    'file' => $request->kendaraan['file'][$i] ?? [],
                ];
            }
        }

        // 📸 Upload file foto kunjungan
        $foto = [];
        if ($request->hasFile('foto_kunjungan')) {
            foreach ($request->file('foto_kunjungan') as $file) {
                $foto[] = $file->store('foto_kunjungan', 'public');
            }
        }

        // 📄 Upload file evidence
        $evidence = [];
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $evidence[] = $file->store('evidence', 'public');
            }
        }

        // 📝 Simpan ke tabel formulirs
        $formulir = new Formulir();
        $formulir->fill($data);
        $formulir->kendaraan = $kendaraanData;
        $formulir->foto_kunjungan = $foto;
        $formulir->evidence = $evidence;
        $formulir->save();

        return redirect()->route('formulir.index')
            ->with('success', 'Formulir berhasil disimpan!');
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
    public function adminIndex(Request $request)
    {
        $formulirs = Formulir::all();
        $query = Formulir::query();

        // Filter berdasarkan status jika ada
        if ($request->has('status') && in_array($request->status, ['pending','approved','rejected'])) {
            $query->where('verification_status', $request->status);
        }

        // Ambil data form terbaru
        $formulirs = $query->orderBy('tanggal_waktu', 'desc')->get();

        return view('admin1.formulir.index', compact('formulirs'));
    }

    public function edit($id)
    {
        $formulir = Formulir::findOrFail($id);
        $nopolList = Iwkbu::distinct()->pluck('no_polisi')->toArray();
        return view('admin1.formulir.edit', compact('formulir', 'nopolList'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'tanggal_waktu' => 'required|date',
            'loket' => 'required|string',
            'nama_depan' => 'required|string',
            'nama_belakang' => 'required|string',
            'nama_pt' => 'required|string',
            'jenis_angkutan' => 'required|string',
            'nama_pengelola' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|string',

            'kendaraan' => 'nullable|array',
            'hasil_kunjungan' => 'required|string',
            'janji_bayar' => 'nullable|date',

            'foto_kunjungan.*' => 'file|mimes:jpg,jpeg,png|max:2048',
            'evidence.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'profiling' => 'nullable|array',

            'ttd_petugas_data' => 'nullable|string',
            'ttd_pemilik_data' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $formulir = Formulir::findOrFail($id);

        // 🚗 Update data kendaraan
        $kendaraanData = [];
        if ($request->has('kendaraan')) {
            foreach ($request->kendaraan['nopol'] as $i => $nopol) {
                // cek apakah nopol sudah ada di IWKBU
                $exists = Iwkbu::where('no_polisi', $nopol)->first();
                if (!$exists) {
                    Iwkbu::create([
                        'no_polisi' => $nopol,
                        'nama_perusahaan' => $request->nama_pt,
                        'nama_pemilik' => $request->nama_pengelola,
                        'no_hp' => $request->telepon,
                    ]);
                }

                $kendaraanData[] = [
                    'nopol' => $nopol,
                    'status' => $request->kendaraan['status'][$i] ?? null,
                    'jumlah_bayar' => $request->kendaraan['jumlah_bayar'][$i] ?? null,
                    'file' => $request->kendaraan['file'][$i] ?? [],
                ];
            }
        }

        // 📸 Upload foto kunjungan baru (jika ada)
        $foto = $formulir->foto_kunjungan ?? [];
        if ($request->hasFile('foto_kunjungan')) {
            foreach ($request->file('foto_kunjungan') as $file) {
                $foto[] = $file->store('foto_kunjungan', 'public');
            }
        }

        // 📄 Upload evidence baru (jika ada)
        $evidence = $formulir->evidence ?? [];
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $evidence[] = $file->store('evidence', 'public');
            }
        }

        // 📝 Update data
        $formulir->fill($data);
        $formulir->kendaraan = $kendaraanData;
        $formulir->foto_kunjungan = $foto;
        $formulir->evidence = $evidence;
        $formulir->save();

        // Di store()
        if ($request->latitude && $request->longitude) {
            $lat = $request->latitude;
            $lng = $request->longitude;

            try {
                $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$lat}&lon={$lng}";
                $response = Http::get($url);
                if ($response->ok()) {
                    $json = $response->json();
                    $data['alamat_otomatis'] = $json['display_name'] ?? null;
                }
            } catch (\Exception $e) {
                $data['alamat_otomatis'] = null;
            }
        }

        return redirect()->route('admin1.formulir.index')
            ->with('success', 'Formulir berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $formulir = Formulir::findOrFail($id);
        $formulir->delete();
        return redirect()->route('admin1.formulir.index')->with('success', 'Data berhasil dihapus!');
    }

        // =======================
    // ADMIN - Laporan Detail & Verifikasi
    // =======================

    public function show($id)
    {
        $formulir = Formulir::findOrFail($id);
        return view('admin1.formulir.show', compact('formulir'));
    }

    public function addNotes(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string',
            'verification_status' => 'required|in:pending,approved,rejected',
        ]);

        $formulir = Formulir::findOrFail($id);
        $formulir->notes = $request->notes;
        $formulir->verification_status = $request->verification_status;
        $formulir->save();

        return redirect()->route('admin1.formulir.show', $formulir->id)
            ->with('success', 'Catatan & verifikasi berhasil disimpan!');
    }

    public function exportPdf($id)
    {
        $formulir = Formulir::with('verifications.user')->findOrFail($id);

        $pdf = Pdf::loadView('admin1.formulir.pdf', compact('formulir'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Formulir_'.$formulir->id.'.pdf');
    }

    public function storeVerification(Request $request, $id)
    {
        $formulir = Formulir::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'notes'  => 'nullable|string',
        ]);

        // cek apakah admin ini sudah pernah verifikasi
        $existing = $formulir->verifications()
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            // kalau sudah ada, update aja
            $existing->update([
                'status' => $request->status,
                'notes'  => $request->notes,
            ]);
        } else {
            // kalau belum ada, bikin baru
            $formulir->verifications()->create([
                'user_id' => auth()->id(),
                'status'  => $request->status,
                'notes'   => $request->notes,
            ]);
        }

        return redirect()->route('admin1.formulir.show', $formulir->id)
            ->with('success', 'Verifikasi berhasil disimpan!');
    }

    public function undo($id)
    {
        $formulir = Formulir::withTrashed()->findOrFail($id);
        $formulir->restore();

        return response()->json(['success' => true]);
    }
}
