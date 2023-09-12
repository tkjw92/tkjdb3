<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    // ===============================================================================================
    // zone view
    // ===============================================================================================

    public function index()
    {
        return redirect('/siswa/soal/asesmen');
    }

    public function viewSoal($jenis)
    {
        $judul = 'soal ' . $jenis;

        if ($jenis == 'ukk') {
        } else {
            // mengambil semua soal dengan type yang diminta dan dengan status published
            $dataSoal = DB::table('tb_soal')->where('jenis', $jenis)->where('status', 'published')->get();

            return view('siswa.soal', compact('judul', 'dataSoal'));
        }
    }

    public function viewKerjakan($jenis, $id)
    {
        return view('siswa.kerjakan');
    }

    // ===============================================================================================
    // ===============================================================================================












    // ===============================================================================================
    // zone view
    // ===============================================================================================

    // ===============================================================================================
    // ===============================================================================================
}
