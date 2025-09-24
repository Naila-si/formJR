<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManifestController extends Controller
{
    public function index()
    {
        // $manifests = Manifest::all();
        return view('manifest.index');
    }
}
