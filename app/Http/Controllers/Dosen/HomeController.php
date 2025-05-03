<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $mahasiswa = Dosen::with('user')->get();
        return view('dosen.home', compact('dosen'));
    }
}
