<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormulirController extends Controller
{
    public function index()
    {
        return view('formulir.index'); // ini file resources/views/formulir.blade.php
    }

    public function store(Request $request)
    {
        // sementara tes dulu
        return back()->with('success', 'Form berhasil disubmit!');
    }
}
