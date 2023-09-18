@extends('guru.layouts.main')

@section('judul')
    Koreksi Soal Uraian
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-body">
                <div class="accordion" id="accordionLayer0">
                    @foreach ($jeniss as $jenis)
                        <div class="card">
                            <div class="card-header">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left text-uppercase d-flex justify-content-between" type="button" data-toggle="collapse" data-target="#collapse{{ $jenis }}" aria-expanded="true" aria-controls="collapse{{ $jenis }}">
                                        <span>{{ $jenis }}</span>
                                    </button>
                                </h2>
                            </div>

                            <div id="collapse{{ $jenis }}" class="collapse" data-parent="#accordionLayer0">
                                <div class="card-body">

                                    <div class="accordion" id="accordionLayer1">
                                        @foreach ($kelass as $kelas)
                                            <div class="card">
                                                <div class="card-header">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left text-uppercase d-flex justify-content-between" type="button" data-toggle="collapse" data-target="#kelas{{ $kelas->id }}{{ $jenis }}" aria-expanded="true"
                                                            aria-controls="kelas{{ $kelas->id }}{{ $jenis }}">
                                                            <span>{{ $kelas->kelas }}</span>
                                                            <span>{{ DB::table('tb_siswa')->where('kelas', $kelas->kelas)->count() }} siswa</span>
                                                        </button>
                                                    </h2>
                                                </div>

                                                <div id="kelas{{ $kelas->id }}{{ $jenis }}" class="collapse" data-parent="#accordionLayer1">
                                                    <div class="card-body">

                                                        <div class="accordion" id="accordionLayer2">
                                                            @foreach ($siswas as $siswa)
                                                                @if ($siswa->kelas == $kelas->kelas)
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h2 class="mb-0">
                                                                                <button class="btn btn-link btn-block text-left text-capitalize d-flex justify-content-between" type="button" data-toggle="collapse"
                                                                                    data-target="#siswa{{ $siswa->nis }}{{ $kelas->id }}{{ $jenis }}" aria-expanded="true" aria-controls="siswa{{ $siswa->nis }}{{ $kelas->id }}{{ $jenis }}">
                                                                                    <span>{{ $siswa->nama }}</span>
                                                                                </button>
                                                                            </h2>
                                                                        </div>

                                                                        <div id="siswa{{ $siswa->nis }}{{ $kelas->id }}{{ $jenis }}" class="collapse" data-parent="#accordionLayer2">
                                                                            <div class="card-body">
                                                                                @foreach ($soals as $soal)
                                                                                    @if ($koreksis->where('id_soal', $soal->id)->where('nis', $siswa->nis)->count() > 0 && $soal->jenis == $jenis)
                                                                                        <div class="row mb-2">
                                                                                            <span class="text-capitalize col-10">{{ $soal->capaian }}</span>
                                                                                            <div class="col-2 text-right">
                                                                                                <a href="/guru/soal/list/koreksi/{{ $siswa->nis }}/{{ $soal->id }}" class="btn btn-warning">
                                                                                                    <i class="fas fa-edit text-white"></i>
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection
