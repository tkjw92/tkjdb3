@extends('guru.layouts.main')

@section('judul')
    Rapor Siswa
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="accordion" id="accordionKelas">

                @foreach ($kelass as $kelas)
                    <div class="card">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left text-uppercase" type="button" data-toggle="collapse" data-target="#collapseKelas{{ $kelas->id }}" aria-expanded="true" aria-controls="collapseKelas{{ $kelas->id }}">
                                    {{ $kelas->kelas }}
                                </button>
                            </h2>
                        </div>

                        <div id="collapseKelas{{ $kelas->id }}" class="collapse" data-parent="#accordionKelas">
                            <div class="card-body">

                                @php
                                    $siswas = $dataSiswa->where('kelas', $kelas->kelas);
                                @endphp
                                @foreach ($siswas as $siswa)
                                    <div class="accordion" id="accordion{{ $kelas->id }}{{ $siswa->nis }}">
                                        <div class="card">
                                            <div class="card-header">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link btn-block text-left text-capitalize" type="button" data-toggle="collapse" data-target="#collapseSiswa{{ $kelas->id }}{{ $siswa->nis }}" aria-expanded="true"
                                                        aria-controls="collapseSiswa{{ $kelas->id }}{{ $siswa->nis }}">
                                                        {{ $siswa->nama }}
                                                    </button>
                                                </h2>
                                            </div>

                                            <div id="collapseSiswa{{ $kelas->id }}{{ $siswa->nis }}" class="collapse" data-parent="#accordion{{ $kelas->id }}{{ $siswa->nis }}">
                                                <div class="card-body">

                                                    <div class="card">
                                                        <div class="card-header">
                                                            <table>
                                                                <tr>
                                                                    <td>Nama</td>
                                                                    <td class="px-5">:</td>
                                                                    <td class="text-capitalize">{{ $siswa->nama }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>NIS</td>
                                                                    <td class="px-5">:</td>
                                                                    <td>{{ $siswa->nis }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Kelas</td>
                                                                    <td class="px-5">:</td>
                                                                    <td class="text-uppercase">{{ $siswa->kelas }}</td>
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

                                                                @php
                                                                    $scorestmp = $scores->where('nis', $siswa->nis);
                                                                @endphp
                                                                @foreach ($scorestmp as $score)
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

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
