<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SoalController extends Controller
{
    // ===============================================================================================
    // zone view
    // ===============================================================================================

    public function viewSoal($jenis)
    {

        // deklarasi judul page
        $judul = 'soal ' . $jenis;

        if ($jenis == 'ukk') {
            // mengambil data dari tb_soal_ukk
            if (session('akun')['role'] == 'admin') {
                $dataSoal = DB::table('tb_soal_ukk')->get();
            } else {
                $dataSoal = DB::table('tb_soal_ukk')->where('owner', session('akun')['nip'])->get();
            }

            return view('guru.listSoal', compact('judul', 'dataSoal'));
        } else {
            // mengambil data dari tb_soal
            if (session('akun')['role'] == 'admin') {
                $dataSoal = DB::table('tb_soal')->where('jenis', $jenis)->get();
            } else {
                $dataSoal = DB::table('tb_soal')->where('jenis', $jenis)->where('owner', session('akun')['nip'])->get();
            }

            return view('guru.listSoal', compact('judul', 'dataSoal'));
        }
    }

    public function viewEditSoal($id)
    {
        // mengambil data owner soal
        $soal = DB::table('tb_soal')->where('id', $id);

        if ($soal->count() == 0) {
            return abort(404);
        }

        // verifikasi apakah soal tersebut benar meilik guru bersangkutan
        if (session('akun')['nip'] == $soal->first()->owner || session('akun')['role'] == 'admin') {
            $soal = $soal->first();
            $type = $soal->type;

            if ($soal->type == 'pilihan') {
                $butirSoal = DB::table('tb_butir_pilihan')->where('id_soal', $soal->id)->get();
                return view('guru.editSoal', compact('soal', 'butirSoal', 'type'));
            } else {
                $butirSoal = DB::table('tb_butir_uraian')->where('id_soal', $soal->id)->get();
                return view('guru.editSoal', compact('soal', 'type', 'butirSoal'));
            }
        } else {
            return abort(403);
        }
    }

    public function viewEditSoalUkk($id)
    {
        // mengambil data soal
        $soal = DB::table('tb_soal_ukk')->where('id', $id);

        if ($soal->count() == 0) {
            return abort(404);
        }

        // verifikasi apakah soal tersebut benar miliki guru bersangkutan
        if ($soal->first()->owner == session('akun')['nip'] || session('akun')['role'] == 'admin') {
            $soal = $soal->first();

            return view('guru.editSoal', compact('soal'));
        } else {
            return abort(403);
        }
    }

    // ===============================================================================================
    // ===============================================================================================


    // ===============================================================================================
    // zone add
    // ===============================================================================================

    public function addSoal($jenis, Request $request)
    {
        // guru mapel
        $mapel = DB::table('tb_guru')->where('nip', session('akun')['nip'])->first()->mapel;

        // menambahkan soal ke tb_soal
        DB::table('tb_soal')->insert([
            'jenis' => $jenis,
            'type' => $request->type,
            'mapel' => $mapel,
            'capaian' => $request->capaian,
            'status' => 'draft',
            'owner' => session('akun')['nip'],
            'token' => substr(md5(rand()), 0, 7),
            'kkm' => $request->kkm
        ]);

        return redirect('/guru/soal/' . $jenis);
    }

    public function addButirPilihan($id, Request $request)
    {
        $delimitter = "%|@|%";

        // mengambil data pilihan
        $pilihan = $request->pilihan0 . $delimitter . $request->pilihan1 . $delimitter . $request->pilihan2 . $delimitter . $request->pilihan3;

        // menambahkan data ke tb_butir_pilihan
        DB::table('tb_butir_pilihan')->insert([
            'id_soal' => $id,
            'soal' => $request->soal,
            'pilihan' => $pilihan,
            'correct' => $request->correct
        ]);

        return back();
    }

    public function addButirUraian($id, Request $request)
    {
        DB::table('tb_butir_uraian')->insert([
            'id_soal' => $id,
            'soal' => $request->soal
        ]);

        return back();
    }

    public function addSoalUkk(Request $request)
    {
        // mangambil data guru yang bersangkutan
        $guru = DB::table('tb_guru')->where('nip', session('akun')['nip'])->first();

        if ($request->file('file')->getMimeType() == 'application/pdf') {
            $random = Str::random(20) . '.pdf';
            $request->file->storeAs('public', $random);

            DB::table('tb_soal_ukk')->insert([
                'status' => 'draft',
                'mapel' => $guru->mapel,
                'url' => $random,
                'capaian' => $request->capaian,
                'owner' => session('akun')['nip']
            ]);

            return back();
        }
    }

    // ===============================================================================================
    // ===============================================================================================


    // ===============================================================================================
    // zone delete
    // ===============================================================================================

    public function deleteSoal($id)
    {
        // mengambil data soal dari tb_soal
        $soal = DB::table('tb_soal')->where('id', $id);

        // cek apakah soal tersebut memang milik guru bersangkutan
        $owner = $soal->first()->owner == session('akun')['nip'] ? true : false;

        // delete jika pengecekan berhasil / jika yang mengeksekusi admin
        if ($owner || session('akun')['role'] == 'admin') {
            $soal->delete();
            DB::table('tb_butir_pilihan')->where('id_soal', $id)->delete();
            return back();
        } else {
            return abort(403);
        }
    }

    public function deleteButirPilihan($id)
    {
        // mengambil data butir soal
        $butir = DB::table('tb_butir_pilihan')->where('id', $id);

        // mengambil data soal
        $soal = DB::table('tb_soal')->where('id', $butir->first()->id_soal)->first()->owner == session('akun')['nip'] ? true : false;

        if ($soal || session('akun')['role'] == 'admin') {
            $butir->delete();
        } else {
            abort(403);
        }

        return back();
    }

    public function deleteButirUraian($id)
    {
        // mengambil data butir soal
        $butir = DB::table('tb_butir_uraian')->where('id', $id);

        // mengambil data soal
        $soal = DB::table('tb_soal')->where('id', $butir->first()->id_soal)->first()->owner == session('akun')['nip'] ? true : false;

        if ($soal || session('akun')['role'] == 'admin') {
            $butir->delete();
        } else {
            abort(403);
        }

        return back();
    }

    public function deleteSoalUkk($id)
    {
        if (DB::table('tb_soal_ukk')->where('id', $id)->where('owner', session('akun')['nip'])->count() == 0) {
            return abort(404);
        }

        unlink('storage/' . DB::table('tb_soal_ukk')->where('id', $id)->first()->url);
        DB::table('tb_soal_ukk')->where('id', $id)->delete();

        return back();
    }

    // ===============================================================================================
    // ===============================================================================================


    // ===============================================================================================
    // zone edit
    // ===============================================================================================
    public function editSoal($id, Request $request)
    {
        // cek apakah soal tersebut benar milik owner
        $soal = DB::table('tb_soal')->where('id', $id)->first()->owner == session('akun')['nip'] ? true : false;

        // jika memang benar milik owner maka lakukan edit
        if ($soal) {
            DB::table('tb_soal')->where('id', $id)->update([
                'capaian' => $request->capaian,
                'token' => $request->token,
                'kkm' => $request->kkm,
                'status' => $request->status
            ]);

            return back();
        } else {
            return abort(403);
        }
    }

    public function editButirPilihan($id, Request $request)
    {
        $delimitter = "%|@|%";

        // mengambil data pilihan
        $pilihan = $request->pilihan0 . $delimitter . $request->pilihan1 . $delimitter . $request->pilihan2 . $delimitter . $request->pilihan3;

        DB::table('tb_butir_pilihan')->where('id', $id)->update([
            'soal' => $request->soal,
            'pilihan' => $pilihan,
            'correct' => $request->correct
        ]);

        return back();
    }

    public function editButirUraian($id, Request $request)
    {
        DB::table('tb_butir_uraian')->where('id', $id)->update([
            'soal' => $request->soal
        ]);

        return back();
    }

    public function editSoalUkk($id, Request $request)
    {
        if (isset($request->file)) {
            $request->file->storeAs('public', DB::table('tb_soal_ukk')->where('id', $id)->first()->url);
        }

        DB::table('tb_soal_ukk')->where('id', $id)->update([
            'capaian' => $request->capaian,
            'status' => $request->status
        ]);

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
