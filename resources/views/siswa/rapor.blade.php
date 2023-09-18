@extends('siswa.layouts.main')

@section('judul')
    Rapor
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <table>
                <tr>
                    <td>Nama</td>
                    <td class="px-5">:</td>
                    <td class="text-capitalize">{{ session('akun')['nama'] }}</td>
                </tr>
                <tr>
                    <td>NIS</td>
                    <td class="px-5">:</td>
                    <td>{{ session('akun')['nis'] }}</td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td class="px-5">:</td>
                    <td class="text-uppercase">{{ session('akun')['kelas'] }}</td>
                </tr>
            </table>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Mata Pelajaran</th>
                    <th>Capaian Pembelajaran</th>
                    <th>Nilai</th>
                </tr>

                @foreach ($scores as $score)
                    <tr>
                        <td class="text-uppercase">{{ $soals->where('id', $score->id_soal)->first()->jenis }}</td>
                        <td class="text-capitalize">{{ $soals->where('id', $score->id_soal)->first()->mapel }}</td>
                        <td class="text-capitalize">{{ $soals->where('id', $score->id_soal)->first()->capaian }}</td>
                        <td>{{ $score->score }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
