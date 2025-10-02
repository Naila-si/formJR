<?php

namespace App\Http\Controllers\Admin1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Shift;
use App\Models\WorkCenter;
use App\Models\DayMetric;

class RKScheduleController extends Controller
{
    public function index(Request $req)
    {
        // --- Parse filter ---
        $refParam = $req->query('ref');
        $ref = $refParam ? Carbon::parse($refParam) : now();

        $year = (int) $req->input('year', $ref->year);

        // center: treat "", null, atau "0" sebagai "All"
        $centerRaw = $req->input('center');
        $centerId  = ($centerRaw === null || $centerRaw === '' || $centerRaw === '0')
            ? null
            : (int) $centerRaw;

        // jika dropdown tahun diganti, paksa ref ke tahun tsb
        if ($year !== (int) $ref->year) {
            $ref = Carbon::create($year, $ref->month, min($ref->day, 28));
        }

        // --- Rentang tampilan 14 hari ---
        $start = $ref->copy()->startOfWeek(Carbon::MONDAY);
        $end   = $start->copy()->addDays(13);
        $days  = collect(range(0, 13))->map(fn ($i) => $start->copy()->addDays($i));

        // --- Filter pusat kerja & pegawai ---
        $centers = WorkCenter::orderBy('name')->get(['id','name']);

        $employees = Employee::when($centerId, fn ($q) => $q->where('work_center_id', $centerId))
            ->orderBy('name')
            ->get(['id','name','handle','avatar_url','work_center_id']);

        // --- Ambil shift di rentang yang terlihat ---
        $shifts = Shift::whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->when($employees->isNotEmpty(), fn ($q) => $q->whereIn('employee_id', $employees->pluck('id')))
            ->orderBy('date')
            ->get();

        // --- Metric per tanggal (untuk strip warna) ---
        $metrics = DayMetric::whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->get()
            ->keyBy(fn ($m) => Carbon::parse($m->date)->toDateString());

        // Ringkasan progress bar (akumulasi 14 hari)
        $sum = ['scheduled_ok'=>0, 'done_on_schedule'=>0, 'not_on_target'=>0];
        foreach ($metrics as $m) {
            $sum['scheduled_ok']     += (int) $m->scheduled_ok;
            $sum['done_on_schedule'] += (int) $m->done_on_schedule;
            $sum['not_on_target']    += (int) $m->not_on_target;
        }
        $total = max(1, array_sum($sum));
        $summary = [
            'total_hours_week' => 546, // placeholder
            'target_po' => [
                ['value' => round($sum['scheduled_ok']     / $total * 100), 'color' => 'bg-sky'],
                ['value' => round($sum['done_on_schedule'] / $total * 100), 'color' => 'bg-rose'],
                ['value' => round($sum['not_on_target']    / $total * 100), 'color' => 'bg-amber'],
            ],
        ];

        // --- Mapping index baris & kolom ---
        $empIndex = $employees->values()->pluck('id')->flip();                       // employee_id => rowIndex
        $dayIndex = $days->values()->mapWithKeys(fn ($d,$i) => [$d->toDateString()=>$i]); // 'Y-m-d' => colIndex

        // --- Susun blok untuk grid ---
        $blocks = [];
        foreach ($shifts as $s) {
            $row = $empIndex->get($s->employee_id);
            if ($row === null) continue;

            $dateKey = $s->date instanceof Carbon ? $s->date->toDateString() : (string) $s->date;
            $col = $dayIndex->get($dateKey);
            if ($col === null) continue;

            $startH = (int) Carbon::parse($s->start)->format('H');
            $endH   = (int) Carbon::parse($s->end)->format('H');

            $blocks[] = [
                $row, $col, $startH, $endH,
                $s->label ?: 'Shift',
                $s->color ?: 'sky',
                $s->id,
                $s->employee_id,
                Carbon::parse($s->start)->format('H:i'),
                Carbon::parse($s->end)->format('H:i'),
                $dateKey,
            ];
        }

        // --- Navigasi minggu sebelumnya / berikutnya (pertahankan filter) ---
        $base = route('admin1.rk.jadwal');
        $qs = fn (Carbon $d) => http_build_query([
            'ref'    => $d->toDateString(),
            'year'   => $year,
            'center' => $centerId ?? 0,
        ]);
        $prevUrl = $base.'?'.$qs($start->copy()->subDays(14));
        $nextUrl = $base.'?'.$qs($start->copy()->addDays(14));

        // Dropdown tahun: 3 tahun ke belakang sampai 1 tahun ke depan
        $years = collect(range($year - 3, $year + 1))->values();

        return view('admin1.rk.schedule', compact(
            'ref','start','end','days','employees','blocks','summary',
            'metrics','centers','centerId','prevUrl','nextUrl','years','year'
        ));
    }

    // ==== CRUD Shift (tetap sesuai route kamu sebelumnya) ====
    public function storeShift(Request $r) {
        $data = $r->validate([
            'employee_id'=>'required|exists:employees,id',
            'date'=>'required|date',
            'start'=>'required',
            'end'=>'required',
            'label'=>'nullable|string',
            'color'=>'nullable|string'
        ]);
        Shift::create($data);
        return back()->with('ok','Shift ditambahkan.');
    }

    public function updateShift(Request $r, Shift $shift) {
        $data = $r->validate([
            'employee_id'=>'required|exists:employees,id',
            'date'=>'required|date',
            'start'=>'required',
            'end'=>'required',
            'label'=>'nullable|string',
            'color'=>'nullable|string'
        ]);
        $shift->update($data);
        return back()->with('ok','Shift diupdate.');
    }

    public function destroyShift(Shift $shift) {
        $shift->delete();
        return back()->with('ok','Shift dihapus.');
    }

    // ==== CRUD Day Metric (keterangan per tanggal) ====
    public function storeMetric(Request $r) {
        $data = $r->validate([
            'date'=>'required|date|unique:day_metrics,date',
            'scheduled_ok'=>'required|integer|min:0|max:100',
            'done_on_schedule'=>'required|integer|min:0|max:100',
            'not_on_target'=>'required|integer|min:0|max:100',
            'notes'=>'nullable|array'
        ]);
        DayMetric::create($data);
        return back()->with('ok','Keterangan tanggal disimpan.');
    }

    public function updateMetric(Request $r, DayMetric $metric) {
        $data = $r->validate([
            'scheduled_ok'=>'required|integer|min:0|max:100',
            'done_on_schedule'=>'required|integer|min:0|max:100',
            'not_on_target'=>'required|integer|min:0|max:100',
            'notes'=>'nullable|array'
        ]);
        $metric->update($data);
        return back()->with('ok','Keterangan tanggal diperbarui.');
    }
}
