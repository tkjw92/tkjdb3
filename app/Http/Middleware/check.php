<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class check
{
    public function handle(Request $request, Closure $next, $type = null)
    {

        if ($type == 'guru') {
            if (session()->has('akun')) {
                if (session('akun')['role'] == 'guru' || session('akun')['role'] == 'admin') {
                    return $next($request);
                } else {
                    return redirect('/');
                }
            } else {
                return redirect('/');
            }
        }

        if ($type == 'siswa') {
            if (session()->has('akun')) {
                if (session()->has('ujian') && session()->has('jenis')) {
                    return redirect('/siswa/kerjakan/' . session('jenis') . '/' . session('ujian'));
                }

                if (session('akun')['role'] == 'siswa') {
                    return $next($request);
                } else {
                    return redirect('/');
                }
            } else {
                return redirect('/');
            }
        }
        if ($type == 'ujian') {
            if (session()->has('akun')) {
                if (session()->has('ujian') && session()->has('jenis')) {
                    $url = explode('/', $request->path());

                    if ($url[2] == session('jenis') && $url[3] == session('ujian')) {
                        return $next($request);
                    } else {
                        return redirect('siswa/kerjakan/' . session('jenis') . '/' . session('ujian'));
                    }
                }
            } else {
                return redirect('/');
            }
        } else {
            if (session()->has('akun')) {
                if (session('akun')['role'] == 'guru' || session('akun')['role'] == 'admin') {
                    return redirect('/guru');
                } else {
                    return redirect('/siswa');
                }
            } else {
                return $next($request);
            }
        }
    }
}
