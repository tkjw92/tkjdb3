<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function viewLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $dataSiswa = DB::table('tb_siswa')->get();
        $dataGuru = DB::table('tb_guru')->get();

        // cek role guru / siswa
        $roleGuru = $dataGuru->where('nip', $username)->where('password', $password);
        $roleSiswa = $dataSiswa->where('nis', $username)->where('password', $password);

        if ($roleGuru->count() > 0) {
            $nama = $dataGuru->where('nip', $username)->first()->nama;
            $role = $dataGuru->where('nip', $username)->first()->role;
            session([
                'akun' => [
                    'role' => $role,
                    'nip' => $username,
                    'nama' => $nama,
                ],
            ]);

            return redirect('/guru');
        }

        if ($roleSiswa->count() > 0) {
            $nama = $dataSiswa->where('nis', $username)->first()->nama;
            $kelas = $dataSiswa->where('nis', $username)->first()->kelas;
            $role = 'siswa';
            session([
                'akun' => [
                    'role' => $role,
                    'nis' => $username,
                    'nama' => $nama,
                    'kelas' => $kelas,
                ],
            ]);

            return redirect('/siswa');
        } else {
            session()->flush();
            return redirect('/');
        }
    }
}
