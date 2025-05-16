<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;

class DosenHomeController extends Controller
{
    public function home()
    {
        $dosen = Dosen::with('user')->get();
        return view('dosen.home', compact('dosen'));
    }
}
