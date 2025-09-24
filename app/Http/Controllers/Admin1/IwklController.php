<?php

namespace App\Http\Controllers\Admin1;

use App\Exports\IwklExport;
use App\Imports\IwklImport;
use App\Models\Admin1\Iwkl;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class IwklController extends Controller
{
    // Tampilkan Data IWKL
    public function index()
    {
        $iwkls = Iwkl::all();
        return view('admin1.iwkl.index', compact('iwkls'));
    }

    // Import Excel
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new IwklImport, $request->file('file'));
        return back()->with('success', 'Data IWKL berhasil diimport!');
    }

    // Export Excel
    public function exportExcel()
    {
        return Excel::download(new IwklExport, 'data_iwkl.xlsx');
    }

    // Export PDF
    public function exportPDF()
    {
        $iwkls = Iwkl::all();
        $pdf = PDF::loadView('admin1.iwkl.pdf', compact('iwkls'))
                  ->setPaper('a4', 'landscape');
        return $pdf->download('data_iwkl.pdf');
    }

    // Edit data IWKL
    public function edit($id)
    {
        $data = Iwkl::findOrFail($id);
        return view('admin1.iwkl.edit', compact('data'));
    }

    // Update data IWKL
    public function update(Request $request, $id)
    {
        $data = Iwkl::findOrFail($id);

        $data->update($request->all());

        return redirect()->route('admin1.iwkl.index')
                         ->with('success', 'Data IWKL berhasil diperbarui!');
    }
}
