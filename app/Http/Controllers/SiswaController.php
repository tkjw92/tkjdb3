<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $dataScore = DB::table('tb_score')->where('nis', session('akun')['nis'])->get();

        if ($jenis == 'ukk') {
            $dataSoal = DB::table('tb_soal_ukk')
                ->where('status', 'published')
                ->get();
        } else {
            // mengambil semua soal dengan type yang diminta dan dengan status published
            $dataSoal = DB::table('tb_soal')
                ->where('jenis', $jenis)
                ->where('status', 'published')
                ->get();
        }
        return view('siswa.soal', compact('judul', 'dataSoal', 'dataScore'));
    }

    public function viewKerjakan($jenis, $id)
    {
        if ($jenis == 'ukk') {
        } else {
            $soal = DB::table('tb_soal')
                ->where('id', $id)
                ->first();

            if ($soal == null) {
                return abort(404);
            }

            if ($soal->type == 'pilihan') {
                $soal = DB::table('tb_butir_pilihan')
                    ->where('id_soal', $id)
                    ->paginate(1);
                $nomors = DB::table('tb_butir_pilihan')
                    ->where('id_soal', $id)
                    ->get();
                $type = 'pilihan';
            } else {
                $soal = DB::table('tb_butir_uraian')
                    ->where('id_soal', $id)
                    ->paginate(1);
                $nomors = DB::table('tb_butir_uraian')
                    ->where('id_soal', $id)
                    ->get();
                $type = 'uraian';
            }
            return view('siswa.kerjakan', compact('soal', 'nomors', 'type'));
        }
    }

    public function viewRapor()
    {
        $scores = DB::table('tb_score')->where('nis', session('akun')['nis'])->get();
        $soals = DB::table('tb_soal')->get();

        return view('siswa.rapor', compact('scores', 'soals'));
    }

    public function viewUKK($id)
    {
        $soal = DB::table('tb_soal_ukk')->where('id', $id)->first();
        $status = DB::table('tb_jawaban_ukk')->where('id_soal', $id)->where('nis', session('akun')['nis'])->count() == 0 ? 'belum' : 'sudah';

        return view('siswa.ukk', compact('soal', 'status'));
    }

    public function viewPrakerin()
    {
        $dudis = DB::table('tb_dudi')->get();
        $laporans = DB::table('tb_prakerin')->where('nis', session('akun')['nis'])->get();

        return view('/siswa/prakerin', compact('dudis', 'laporans'));
    }

    // ===============================================================================================
    // ===============================================================================================

    // ===============================================================================================
    // zone validasi
    // ===============================================================================================
    public function submitToken($id, Request $request)
    {
        $soal = DB::table('tb_soal')
            ->where('id', $id)
            ->first();

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
    // zone store
    // ===============================================================================================
    public function storeJawabanPilihan(Request $request)
    {
        session(['jawaban' . $request->id => $request->jawaban]);
    }

    public function storeJawabanUraian(Request $request)
    {
        session(['jawaban' . $request->id => $request->jawaban]);
    }

    public function score()
    {
        // cek apakah siswa telah login
        if (session()->has('akun')) {
            // cek apakah siswa sedang dalam ujian
            if (session()->has('ujian') && session()->has('jenis')) {
                // ambil data dari tb_soal
                $soal = DB::table('tb_soal')
                    ->where('id', session('ujian'))
                    ->first();

                // jika soal bertype pilihan
                if ($soal->type == 'pilihan') {
                    // ambil data butir soal
                    $dataSoal = DB::table('tb_butir_pilihan')
                        ->where('id_soal', session('ujian'))
                        ->get();

                    // cek apakah siswa telah menjawab semua soal
                    foreach ($dataSoal as $data) {
                        if (!session()->has('jawaban' . $data->id)) {
                            // jika ada soal yang belum terjawab akan dikembalikan ke sesi ujian
                            return redirect('/siswa');
                        }
                    }

                    // hitung score
                    $score = 0;
                    foreach ($dataSoal as $data) {
                        // jika kunci jawaban dan jawaban yang diberikan siswa sama maka tambahkan score
                        if ($data->correct == session('jawaban' . $data->id)) {
                            $score++;
                        }
                    }

                    // hitung nilai rata-rata dan dibulatkan keatas
                    $score = ceil(($score * 100) / $dataSoal->count());

                    // ambil datascore dari tb_score
                    $dataScore = DB::table('tb_score')
                        ->where('nis', session('akun')['nis'])
                        ->where('id_soal', session('ujian'));

                    // cek apakah siswa telah mengerjakan soal yang sama
                    if ($dataScore->count() == 0) {
                        // jika siswa baru mengerjakan tambahkan nilai baru ke tb_score
                        DB::table('tb_score')->insert([
                            'score' => $score,
                            'nis' => session('akun')['nis'],
                            'id_soal' => session('ujian'),
                        ]);
                    } else {
                        // jika siswa sebelumnya telah mengerjakan dan mendapatkan nilai lebih tinggi update nilai yang telah ada
                        if ($score > $dataScore->first()->score) {
                            $dataScore->update([
                                'score' => $score,
                            ]);
                        }
                    }
                    // jika soal bertype uraian
                } else {
                    // cek apakah siswa telah mengerjakan semua soal
                    $dataSoal = DB::table('tb_butir_uraian')
                        ->where('id_soal', session('ujian'))
                        ->get();

                    foreach ($dataSoal as $data) {
                        if (!session()->has('jawaban' . $data->id)) {
                            // jika ada soal yang belum terjawab akan dikembalikan ke sesi ujian
                            return redirect('/siswa');
                        }
                    }

                    // jika telah terverifikasi mengerjakan semua soal, tambahkan jawban siswa ke tb_koreksi
                    foreach ($dataSoal as $data) {
                        DB::table('tb_koreksi')->insert([
                            'id_soal' => session('ujian'),
                            'id_butir' => $data->id,
                            'jawaban' => session('jawaban' . $data->id),
                            'nis' => session('akun')['nis'],
                        ]);
                    }
                }

                // simpan informasi akun
                $old = session('akun');

                // hapus semua session yang ada
                session()->flush();

                // kembalikan sesi akun
                session(['akun' => $old]);
            }
        }

        return redirect('/siswa');
    }

    public function prakerin(Request $request)
    {
        if ($request->action == 'add') {
            DB::table('tb_prakerin')->insert([
                'nis' => session('akun')['nis'],
                'id_dudi' => $request->dudi,
                'judul' => $request->judul,
                'tgl' => $request->tgl,
                'detail' => $request->detail
            ]);
        }

        if ($request->action == 'edit') {
            DB::table('tb_prakerin')->where('id', $request->id)->update([
                'id_dudi' => $request->dudi,
                'judul' => $request->judul,
                'tgl' => $request->tgl,
                'detail' => $request->detail
            ]);
        }

        if ($request->action == 'delete') {
            DB::table('tb_prakerin')->where('id', $request->id)->delete();
        }


        return redirect('/siswa/prakerin');
    }

    public function submitSoalUkk(Request $request, $id)
    {
        // cek apakah siswa pernah melakukan submit
        $data = DB::table('tb_jawaban_ukk')->where('id_soal', $id)->where('nis', session('akun')['nis']);

        if ($data->count() == 0) {
            if ($request->file('file')->getMimeType() == 'application/pdf') {
                $random = Str::random(20) . '.pdf';
                $request->file->storeAs('public', $random);

                DB::table('tb_jawaban_ukk')->insert([
                    'id_soal' => $id,
                    'nis' => session('akun')['nis'],
                    'url' => $random
                ]);
            }
        }

        return back();
    }
}
