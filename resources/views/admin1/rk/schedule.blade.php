@extends('admin1.dashboard')
@section('title','RK Jadwal & Target')

@push('styles')
<style>
:root{
  --border:#e2e8f0; --muted:#64748b; --text:#0f172a; --card:#fff;
  --sky:#0ea5e9; --rose:#ef4444; --amber:#f59e0b; --ring:#bae6fd;
}
.rk-wrap{display:flex; flex-direction:column; gap:14px}
.rk-title{font-size:28px; font-weight:700; color:var(--text)}
.rk-sub{color:#64748b}
.rk-chip{border:1px solid var(--border); padding:.5rem .75rem; border-radius:.7rem; background:#fff}
.rk-btn{background:var(--sky); color:#fff; border:none; border-radius:.7rem; padding:.55rem .9rem}
.months{display:flex; gap:8px; flex-wrap:wrap}
.month-pill{border:1px solid var(--border); padding:.35rem .7rem; border-radius:.6rem; background:#fff; font-size:.88rem}
.month-pill.is-active{background:#eaf6ff; border-color:#9bd7ff; color:#0369a1}

.card{background:#fff; border:1px solid var(--border); border-radius:14px}
.card-title{color:#64748b; font-size:.92rem}
.card-huge{font-size:32px; font-weight:700}
.progress{display:flex; height:10px; border-radius:9999px; overflow:hidden; background:#f1f5f9; border:1px solid #e2e8f0}
.progress > div{height:100%}
.bg-sky{background:#38bdf8}.bg-rose{background:#fb7185}.bg-amber{background:#fbbf24}
.legend{margin-top:8px; display:flex; gap:16px; flex-wrap:wrap; color:#475569; font-size:.88rem}
.legend .dot{display:inline-block; width:10px; height:10px; border-radius:9999px; margin-right:6px}
.legend .bg-sky{background:#38bdf8}.legend .bg-rose{background:#fb7185}.legend .bg-amber{background:#fbbf24}

.strip-wrap{position:sticky; top:64px; z-index:30; background:#fff} /* follow header layout */
.date-strip{display:flex; gap:12px; align-items:center}
.date-item{width:72px; text-align:center}
.date-dow{font-size:.8rem; color:#64748b}
.date-pill{display:inline-block; min-width:32px; padding:.32rem .6rem; border-radius:.7rem; border:1px solid #e7eef6; background:#f3f7fb; color:#334155; transition:all .15s}
.date-pill:hover{transform:translateY(-1px); box-shadow:0 8px 16px rgba(2,132,199,.15)}
.date-pill.is-today{background:#2563eb; border-color:#2563eb; color:#fff}
.date-indicator{display:flex; justify-content:center; gap:5px; margin-top:4px}
.ind-dot{width:6px; height:6px; border-radius:9999px}
.ind-sky{background:#38bdf8}.ind-rose{background:#fb7185}.ind-amber{background:#fbbf24}

/* GRID SHELL */
.shell{border:1px solid var(--border); border-radius:14px}
.headrow{display:flex; align-items:center; gap:8px; padding:12px 16px; border-bottom:1px solid var(--border)}
.filters{display:flex; gap:10px; margin-left:auto}
.select{border:1px solid var(--border); border-radius:.6rem; padding:.45rem .7rem; background:#fff}

.grid-area{display:grid; grid-template-columns: 320px 1fr; height:560px}
.left{border-right:1px solid var(--border); overflow:hidden; position:relative}
.left-head{position:sticky; top:calc(64px + 48px); background:#fff; z-index:25; padding:10px 14px; font-size:.8rem; color:#64748b; text-transform:uppercase; border-bottom:1px dashed #e5e7eb}
.left-scroll{height:100%; overflow:auto; padding-bottom:40px}
.emp{display:flex; align-items:center; gap:10px; padding:10px 14px; border-bottom:1px dashed #f1f5f9}
.emp .avatar{width:28px; height:28px; border-radius:9999px}
.emp .name{font-size:.92rem; font-weight:600}
.emp .handle{font-size:.78rem; color:#94a3b8}

/* RIGHT grid */
.right{overflow:hidden}
.right-scroll{height:100%; overflow:auto; position:relative}
.scroll-x{overflow-x:auto; overflow-y:hidden}
.col-lines{border-bottom:1px solid #e5e7eb; height:44px; display:grid; gap:0}
.col-lines > div{border-right:1px solid #e5e7eb}
.rows-lines{position:absolute; inset:44px 0 0 0}
.rows-lines .row{position:absolute; left:0; right:0; border-top:1px dashed #e5e7eb}

.block{position:absolute; border:1px solid #cbd5e1; background:rgba(148,163,184,.12); border-radius:10px; padding:.25rem .45rem; font-size:.82rem; display:flex; align-items:center; justify-content:space-between; gap:6px; backdrop-filter:saturate(120%);}
.block button.del{font-size:.72rem; padding:.1rem .35rem; border-radius:.35rem; background:#ffffffd6; border:1px solid #e5e9f2}

.palette-teal{background:rgba(13,148,136,.10); border-color:#99f6e4}
.palette-rose{background:rgba(244,63,94,.10); border-color:#fecdd3}
.palette-amber{background:rgba(245,158,11,.10); border-color:#fed7aa}
.palette-sky{background:rgba(14,165,233,.10); border-color:#bae6fd}
.palette-indigo{background:rgba(79,70,229,.10); border-color:#c7d2fe}
.palette-zinc{background:#e5e7eb; border-color:#d4d4d8}

:root{
    --left-w: 320px;              /* lebar panel kiri */
    --border:#e6edf5; --card:#fff;
    --ink:#0f172a; --muted:#64748b;
    --sky:#0284c7; --ring:#bae6fd;
  }

  /* layout grid: kiri freeze + kanan scroll */
  .rk-grid{ display:flex; }
  .rk-left{
    position: sticky; left:0; top:0;
    width:var(--left-w); background:var(--card);
    border-right:1px solid var(--border);
    z-index:30; /* di atas grid kanan */
  }
  .rk-left::after{ /* shimmer halus di sisi kanan */
    content:""; position:absolute; top:0; right:-1px; width:1px; height:100%;
    background:linear-gradient(to right, rgba(2,132,199,.14), transparent);
  }
  .rk-left-head{
    position: sticky; top:0; z-index:2;
    display:flex; align-items:center; justify-content:space-between;
    padding:10px 14px; background:#fff; font-weight:700; font-size:.82rem;
    border-bottom:1px solid var(--border);
  }
  .rk-left-count{ font-weight:600; font-size:.78rem; color:var(--muted); }

  .rk-left .inner{
    max-height: calc(100vh - 340px);  /* tinggi list; sesuaikan jika header berubah */
    overflow:auto; padding-bottom:8px;
  }
  .rk-emp-item{
    display:flex; align-items:center; gap:10px;
    padding:10px 14px; border-bottom:1px dashed #eef2f7;
    transition: background .15s ease, box-shadow .15s ease;
  }
  .rk-emp-item:hover{ background:#f8fafc; }
  .rk-emp-item.selected{
    background:#eff6ff; border-left:3px solid #38bdf8; padding-left:11px;
  }

  .rk-emp-item .chk{
    appearance:none; width:16px; height:16px; border-radius:4px;
    border:1.5px solid #cbd5e1; display:grid; place-items:center; cursor:pointer;
  }
  .rk-emp-item .chk:checked{ background:var(--sky); border-color:var(--sky); }
  .rk-emp-item .chk:checked::after{ content:"✓"; color:#fff; font-size:.68rem; line-height:1; }

  .rk-emp-item .avatar{
    width:36px; height:36px; border-radius:50%; object-fit:cover;
    box-shadow:0 2px 8px rgba(2,132,199,.08);
  }
  .rk-emp-item .meta{ min-width:0; }
  .rk-emp-item .name{
    font-weight:600; color:var(--ink); font-size:.93rem;
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
  }
  .rk-emp-item .handle{ font-size:.76rem; color:var(--muted); }

/* modal */
[x-cloak]{display:none!important}
.modal-backdrop{position:fixed; inset:0; background:rgba(0,0,0,.4); display:flex; align-items:center; justify-content:center; z-index:50}
.modal-card{width:100%; max-width:620px; background:#fff; border-radius:14px; border:1px solid var(--border); padding:16px}
.input{border:1px solid var(--border); border-radius:.6rem; padding:.55rem .7rem; width:100%}
</style>
@endpush

@section('content')
<div x-data="rkSchedule()" x-init="init()" class="rk-wrap">

  {{-- Header --}}
  <div class="flex items-center justify-between">
    <div>
      <h1 class="rk-title">Work schedule</h1>
      <p class="rk-sub">{{ $start->translatedFormat('j F Y') }} – {{ $end->translatedFormat('j F Y') }}</p>
    </div>
    <div class="flex items-center gap-2">
      <a href="{{ $prevUrl }}" class="rk-chip" title="Minggu sebelumnya">←</a>
      <a href="{{ $nextUrl }}" class="rk-chip" title="Minggu berikutnya">→</a>
      <button @click="openCreate()" class="rk-btn">Tambah Shift</button>
    </div>
  </div>

  {{-- Bulan --}}
  <div class="months">
    @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $m)
      <span class="month-pill {{ $m===\Carbon\Carbon::parse($ref)->translatedFormat('F') ? 'is-active':'' }}">{{ $m }}</span>
    @endforeach
  </div>

  {{-- Ringkasan --}}
  <div class="grid grid-cols-12 gap-4">
    <div class="col-span-7 card p-5">
      <div class="card-title">Total of working hours per week</div>
      <div class="card-huge">{{ $summary['total_hours_week'] }}h</div>
    </div>
    <div class="col-span-5 card p-5">
      <div class="card-title">Total Target PO</div>
      <div class="progress" style="margin-top:10px">
        @foreach($summary['target_po'] as $seg)
          <div class="{{ $seg['color'] }}" style="width: {{ $seg['value'] }}%"></div>
        @endforeach
      </div>
      <div class="legend">
        <span><span class="dot bg-sky"></span>Terjadwal CRM/DTD sesuai target</span>
        <span><span class="dot bg-rose"></span>Sudah dilaksanakan sesuai jadwal</span>
        <span><span class="dot bg-amber"></span>Tidak sesuai target</span>
      </div>
    </div>
  </div>

  {{-- SHELL --}}
  <div class="shell">
    {{-- bar filter atas + strip tanggal --}}
    <div class="headrow">
      <strong>Filter:</strong>
      <form id="filterForm" method="GET" action="{{ route('admin1.rk.jadwal') }}" class="filters">
        <input type="hidden" name="ref" value="{{ $ref->toDateString() }}">
        <select name="center" class="select" onchange="this.form.submit()">
          <option value="" {{ !$centerId?'selected':'' }}>Semua Loket</option>
          @foreach($centers as $c)
            <option value="{{ $c->id }}" {{ (string)$centerId===(string)$c->id?'selected':'' }}>
              {{ $c->name }}
            </option>
          @endforeach
        </select>

        <select name="year" class="select" onchange="this.form.submit()">
          @foreach($years as $y)
            <option value="{{ $y }}" {{ (int)$y===(int)$year?'selected':'' }}>{{ $y }}</option>
          @endforeach
        </select>
      </form>
    </div>

    <div class="strip-wrap">
      <div class="scroll-x" x-ref="strip">
        <div class="date-strip p-3" style="min-width:max-content">
          @foreach($days as $d)
            @php
              $m = $metrics[$d->toDateString()] ?? null;
              // warna dominan utk kapsul (opsional): ambil yg paling besar
              $dom = $m ? collect([
                'sky'   => (int)$m->scheduled_ok,
                'rose'  => (int)$m->done_on_schedule,
                'amber' => (int)$m->not_on_target,
              ])->sortDesc()->keys()->first() : null;
              $qs = http_build_query(['ref'=>$d->toDateString(), 'center'=>$centerId, 'year'=>$year]);
            @endphp
            <a href="{{ route('admin1.rk.jadwal').'?'.$qs }}" class="date-item" title="@if($m) OK {{ $m->scheduled_ok }} · OnSched {{ $m->done_on_schedule }} · NotTarget {{ $m->not_on_target }} @endif">
              <div class="date-dow">{{ $d->translatedFormat('D') }}</div>
              <div class="date-pill {{ $d->isSameDay($ref) ? 'is-today' : '' }}" style="{{ $dom==='sky'?'background:#e6f6ff;border-color:#bae6fd;':($dom==='rose'?'background:#ffe5e8;border-color:#fecdd3;':($dom==='amber'?'background:#fff3d6;border-color:#fde68a;':'')) }}">
                {{ $d->day }}
              </div>
              <div class="date-indicator">
                <span class="ind-dot ind-sky" style="opacity:{{ $m? min(1,$m->scheduled_ok/60) : .2 }}"></span>
                <span class="ind-dot ind-rose" style="opacity:{{ $m? min(1,$m->done_on_schedule/60) : .2 }}"></span>
                <span class="ind-dot ind-amber" style="opacity:{{ $m? min(1,$m->not_on_target/60) : .2 }}"></span>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    </div>

    {{-- GRID --}}
    <div class="grid-area">
      {{-- LEFT fixed / freeze --}}
      <div class="rk-left">
        <div class="rk-left-head">
            <div> NAMA PEGAWAI <span class="rk-left-count">({{ $employees->count() }})</span></div>
            <label style="display:flex;align-items:center;gap:.4rem;font-weight:500;color:#334155;font-size:.8rem">
            <input type="checkbox" x-model="checkAll" @change="toggleAll"
                    style="accent-color:#0ea5e9"> Pilih semua
            </label>
        </div>

        <div class="inner">
            @foreach($employees as $emp)
            @php
                // tandai kalau ada shift pada rentang ini (pakai blocks yang sudah kamu kirim ke view)
                $has = collect($blocks)->contains(fn($b) => $b[7] === $emp->id);
            @endphp
            <div class="rk-emp-item {{ $has ? 'selected' : '' }}">
                <input type="checkbox" class="chk" x-model="selected" value="{{ $emp->id }}">
                <img class="avatar"
                    src="{{ $emp->avatar_url ?: 'https://i.pravatar.cc/64?u='.$emp->id }}"
                    alt="{{ $emp->name }}">
                <div class="meta">
                <div class="name">{{ $emp->name }}</div>
                <div class="handle">{{ $emp->handle }}</div>
                </div>
            </div>
            @endforeach
        </div>
        </div>

      {{-- RIGHT scrollable --}}
      <div class="right">
        <div class="right-scroll" x-ref="rightY">
          @php $colWidth = 160; $rowH = 52; @endphp
          <div style="position:relative; min-width: calc({{ $days->count() }} * {{ $colWidth }}px);">

            {{-- header kolom garis atas --}}
            <div class="col-lines" style="grid-template-columns:repeat({{ $days->count() }}, {{ $colWidth }}px)"></div>

            {{-- blok --}}
            <div style="position:absolute; inset:44px 0 0 0;">
              @php
                $pal = ['teal'=>'palette-teal','rose'=>'palette-rose','amber'=>'palette-amber','emerald'=>'palette-emerald','sky'=>'palette-sky','indigo'=>'palette-indigo','zinc'=>'palette-zinc'];
              @endphp
              @foreach($blocks as [$r,$c,$sh,$eh,$label,$color,$id,$employee_id,$startTime,$endTime,$date])
                @php
                  $left = $c * $colWidth + 10;
                  $top  = $r * $rowH + 6;
                  $height = max(34, ($eh - $sh) * 12);
                @endphp
                <div class="block {{ $pal[$color] ?? 'palette-sky' }}" style="left:{{ $left }}px; top:{{ $top }}px; width:{{ $colWidth-20 }}px; height:{{ $height }}px"
                     title="{{ $label }} • {{ \Carbon\Carbon::parse($date)->format('d M') }} {{ $startTime }}–{{ $endTime }}"
                     @click="openEdit({{ $id }}, {{ $employee_id }}, '{{ $date }}', '{{ $startTime }}', '{{ $endTime }}', '{{ $label }}', '{{ $color }}')">
                  <span>{{ $label }}</span>
                  <form method="POST" action="{{ route('admin1.rk.shifts.destroy', $id) }}" onclick="event.stopPropagation();return confirm('Hapus shift ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="del">hapus</button>
                  </form>
                </div>
              @endforeach

              {{-- garis horizontal baris --}}
              <div class="rows-lines">
                @for($i=0;$i<$employees->count();$i++)
                  <div class="row" style="top:{{ ($i+1)*$rowH }}px"></div>
                @endfor
              </div>
            </div>

            {{-- spacer tinggi konten --}}
            <div style="height: {{ $employees->count()*$rowH + 80 }}px"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- MODALS --}}
  @if(session('ok'))
    <div class="card p-4" style="border-left:4px solid #10b981">Berhasil: {{ session('ok') }}</div>
  @endif

  {{-- Create --}}
  <div x-show="showCreate" x-cloak class="modal-backdrop" @keydown.escape.window="showCreate=false">
    <div class="modal-card">
      <h3 class="text-lg font-semibold mb-2">Tambah Shift</h3>
      <form method="POST" action="{{ route('admin1.rk.shifts.store') }}" class="space-y-3">
        @csrf
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="text-sm text-gray-500">Pegawai</label>
            <select name="employee_id" x-model="form.employee_id" class="input" required>
              <option value="">-- pilih --</option>
              @foreach($employees as $e)<option value="{{ $e->id }}">{{ $e->name }}</option>@endforeach
            </select>
          </div>
          <div>
            <label class="text-sm text-gray-500">Tanggal</label>
            <input type="date" name="date" class="input" x-model="form.date" required>
          </div>
        </div>
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="text-sm text-gray-500">Mulai</label>
            <input type="time" name="start" class="input" x-model="form.start" required>
          </div>
          <div>
            <label class="text-sm text-gray-500">Selesai</label>
            <input type="time" name="end" class="input" x-model="form.end" required>
          </div>
        </div>
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="text-sm text-gray-500">Label</label>
            <input type="text" name="label" class="input" x-model="form.label" placeholder="Loket Kanwil">
          </div>
          <div>
            <label class="text-sm text-gray-500">Warna</label>
            <select name="color" class="input" x-model="form.color">
              <option>teal</option><option>rose</option><option>amber</option>
              <option>emerald</option><option>sky</option><option>indigo</option><option>zinc</option>
            </select>
          </div>
        </div>
        <div class="flex justify-end gap-2">
          <button type="button" class="rk-chip" @click="showCreate=false">Batal</button>
          <button class="rk-btn">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Edit --}}
  <div x-show="showEdit" x-cloak class="modal-backdrop" @keydown.escape.window="showEdit=false">
    <div class="modal-card">
      <h3 class="text-lg font-semibold mb-2">Edit Shift</h3>
      <form method="POST" :action="editAction" class="space-y-3">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="text-sm text-gray-500">Pegawai</label>
            <select name="employee_id" class="input" x-model="form.employee_id" required>
              @foreach($employees as $e)<option value="{{ $e->id }}">{{ $e->name }}</option>@endforeach
            </select>
          </div>
          <div>
            <label class="text-sm text-gray-500">Tanggal</label>
            <input type="date" name="date" class="input" x-model="form.date" required>
          </div>
        </div>
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="text-sm text-gray-500">Mulai</label>
            <input type="time" name="start" class="input" x-model="form.start" required>
          </div>
          <div>
            <label class="text-sm text-gray-500">Selesai</label>
            <input type="time" name="end" class="input" x-model="form.end" required>
          </div>
        </div>
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="text-sm text-gray-500">Label</label>
            <input type="text" name="label" class="input" x-model="form.label">
          </div>
          <div>
            <label class="text-sm text-gray-500">Warna</label>
            <select name="color" class="input" x-model="form.color">
              <option>teal</option><option>rose</option><option>amber</option>
              <option>emerald</option><option>sky</option><option>indigo</option><option>zinc</option>
            </select>
          </div>
        </div>
        <div class="flex justify-end gap-2">
          <button type="button" class="rk-chip" @click="showEdit=false">Batal</button>
          <button class="rk-btn">Update</button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
function rkSchedule(){
  return {
    selected: [], checkAll:false,
    toggleAll(){
      this.selected = this.checkAll ? @json($employees->pluck('id')) : [];
    },
    showCreate:false, showEdit:false, editAction:'#',
    form:{ employee_id:'', date:'{{ $ref->toDateString() }}', start:'09:00', end:'12:00', label:'', color:'teal' },
    init(){
      // sync scroll horizontal antara strip dan grid kanan
      const strip = this.$refs.strip, right = this.$refs.rightY;
      if(strip && right){
        right.addEventListener('scroll', ()=>{ strip.scrollLeft = right.scrollLeft; this.$refs.leftY.scrollTop = right.scrollTop; });
        strip.addEventListener('scroll', ()=> right.scrollLeft = strip.scrollLeft);
        // sync vertikal kiri-kanan
        const left = this.$refs.leftY;
        left.addEventListener('scroll', ()=> right.scrollTop = left.scrollTop);
      }
    },
    openCreate(){
      this.form = { employee_id:'', date:'{{ $ref->toDateString() }}', start:'09:00', end:'12:00', label:'', color:'teal' };
      this.showCreate = true;
    },
    openEdit(id, employee_id, date, start, end, label, color){
      this.form = { employee_id:String(employee_id), date, start, end, label, color };
      this.editAction = "{{ route('admin1.rk.shifts.update', 0) }}".replace('/0','/'+id);
      this.showEdit = true;
    }
  }
}
</script>
@endpush
