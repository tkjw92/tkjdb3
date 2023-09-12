<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    // ===============================================================================================
    // zone view
    // ===============================================================================================

    public function dashboard()
    {
        return view('guru.layouts.main');
    }

    public function viewDataGuru()
    {
        $dataGuru = DB::table('tb_guru')->orderByDesc('id')->get();

        return view('guru.dataGuru', compact('dataGuru'));
    }

    public function viewDataKelas()
    {
        $dataKelas = DB::table('tb_kelas')->orderByDesc('id')->get();
        $dataSiswa = DB::table('tb_siswa')->get();

        return view('guru.dataKelas', compact('dataKelas', 'dataSiswa'));
    }

    public function viewDataSiswa()
    {
        $dataSiswa = DB::table('tb_siswa')->orderByDesc('id')->get();
        $dataKelas = DB::table('tb_kelas')->get();

        return view('guru.dataSiswa', compact('dataSiswa', 'dataKelas'));
    }

    public function viewDataDudi()
    {
        $dataDudi = DB::table('tb_dudi')->get();

        return view('guru.dataDudi', compact('dataDudi'));
    }

    // ===============================================================================================
    // ===============================================================================================




    // ===============================================================================================
    // zone add
    // ===============================================================================================

    public function addDataGuru(Request $request)
    {
        // cek ketersediaan nip
        $available = DB::table('tb_guru')->where('nip', $request->nip)->count() > 0 ? false : true;

        // menambahkan data ke guru
        if ($available) {
            DB::table('tb_guru')->insert([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'mapel' => $request->mapel,
                'role' => $request->role,
                'password' => $request->password
            ]);
        }

        return redirect('/guru/data/data-guru');
    }

    public function addDataKelas(Request $request)
    {
        // cek ketersediaan kelas
        $available = DB::table('tb_kelas')->where('kelas', $request->kelas)->count() > 0 ? false : true;

        // menambahkan data ke kelas
        if ($available) {
            DB::table('tb_kelas')->insert([
                'kelas' => $request->kelas
            ]);
        }

        return redirect('/guru/data/data-kelas');
    }

    public function addDataSiswa(Request $request)
    {
        // cek ketersediaan nis dan nisn
        $availableNis = DB::table('tb_siswa')->where('nis', $request->nis)->count() > 0 ? false : true;
        $availableNisn = DB::table('tb_siswa')->where('nisn', $request->nisn)->count() > 0 ? false : true;

        // menambahkan data ke siswa
        if ($availableNis && $availableNisn) {
            DB::table('tb_siswa')->insert([
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'password' => $request->password
            ]);
        }

        return redirect('/guru/data/data-siswa');
    }

    public function addDataDudi(Request $request)
    {
        DB::table('tb_dudi')->insert([
            'nama' => $request->nama,
            'bidang' => $request->bidang,
            'alamat' => $request->alamat
        ]);

        return redirect('/guru/data/data-dudi');
    }

    // ===============================================================================================
    // ===============================================================================================






    // ===============================================================================================
    // zone delete
    // ===============================================================================================

    public function deleteDataGuru($id)
    {
        DB::table('tb_guru')->where('id', $id)->delete();

        return redirect('/guru/data/data-guru');
    }

    public function deleteDataKelas($id)
    {
        DB::table('tb_kelas')->where('id', $id)->delete();

        return redirect('/guru/data/data-kelas');
    }

    public function deleteDataSiswa($id)
    {
        DB::table('tb_siswa')->where('id', $id)->delete();

        return redirect('/guru/data/data-siswa');
    }

    public function deleteDataDudi($id)
    {
        DB::table('tb_dudi')->where('id', $id)->delete();

        return redirect('/guru/data/data-dudi');
    }

    // ===============================================================================================
    // ===============================================================================================






    // ===============================================================================================
    // zone edit
    // ===============================================================================================

    public function editDataGuru($id, Request $request)
    {
        // edit data pada tb_guru
        DB::table('tb_guru')->where('id', $id)->update([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'mapel' => $request->mapel,
            'password' => $request->password,
            'role' => $request->role
        ]);

        return redirect('/guru/data/data-guru');
    }

    public function editDataSiswa($id, Request $request)
    {
        // edit data pada tb_siswa
        DB::table('tb_siswa')->where('id', $id)->update([
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'password' => $request->password
        ]);

        return redirect('/guru/data/data-siswa');
    }

    public function editDataDudi($id, Request $request)
    {
        // edit data pada tb_dudi
        DB::table('tb_dudi')->where('id', $id)->update([
            'nama' => $request->nama,
            'bidang' => $request->bidang,
            'alamat' => $request->alamat
        ]);

        return redirect('/guru/data/data-dudi');
    }
}

    // ===============================================================================================
    // ===============================================================================================
