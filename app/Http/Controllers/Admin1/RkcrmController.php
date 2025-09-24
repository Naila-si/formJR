<?php

namespace App\Http\Controllers\Admin1;

use App\Models\Admin1\Rkcrm;
use App\Http\Controllers\Controller;

class RkcrmController extends Controller
{
    public function index() {
        $rkcrms = Rkcrm::all(); // model Rkcrm harus dibuat
        return view('admin1.rkcrm.index', compact('rkcrms'));
    }

}
