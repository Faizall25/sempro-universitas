<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $mahasiswa = Mahasiswa::with('user')->get();
        return view('mahasiswa.home', compact('mahasiswa'));
    }
}
