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
        if ($jenis == 'ukk') {
        } else {
            $soal = DB::table('tb_soal')->where('id', $id)->first();

            if ($soal == null) {
                return abort(404);
            }

            if ($soal->type == 'pilihan') {
                $soal = DB::table('tb_butir_pilihan')->where('id_soal', $id)->paginate(1);

                return view('siswa.kerjakan', compact('soal'));
            } else {
            }
        }
    }

    // ===============================================================================================
    // ===============================================================================================

    // ===============================================================================================
    // zone validasi
    // ===============================================================================================
    public function submitToken($id, Request $request)
    {
        $soal = DB::table('tb_soal')->where('id', $id)->first();

        if ($soal->token === $request->token) {
            session([
                'ujian' => $id,
                'jenis' => $soal->jenis,
            ]);
        } else {
            session()->remove('ujian');
            session()->remove('jenis');
        }

        return back();
    }
    // ===============================================================================================
    // ===============================================================================================










    // ===============================================================================================
    // zone view
    // ===============================================================================================

    // ===============================================================================================
    // ===============================================================================================
}
