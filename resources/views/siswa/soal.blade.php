@extends('siswa.layouts.main')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endsection

@section('judul')
    {{ $judul }}
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="50" class="text-center">No</th>
                        @if (!Request::is('siswa/soal/ukk'))
                            <th>Type</th>
                        @endif
                        <th>Mata Pelajaran</th>
                        <th>Capaian Pembelajaran</th>
                        <th width="30">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($dataSoal as $soal)
                        <tr class="text-capitalize">
                            <td class="text-center">{{ $no }}</td>
                            @if (!Request::is('siswa/soal/ukk'))
                                <td>{{ $soal->type }}</td>
                            @endif
                            <td>{{ $soal->mapel }}</td>
                            <td>{{ $soal->capaian }}</td>
                            <td>
                                @if (!Request::is('siswa/soal/ukk'))
                                    @if (Request::is('siswa/soal/asesmen'))
                                        <button class="btn btn-warning {{ $dataScore->where('id_soal', $soal->id)->count() > 0 ? ($dataScore->where('id_soal', $soal->id)->first()->score >= $soal->kkm ? 'disabled' : '') : '' }}" data-toggle="modal"
                                            data-target="#kerjakan{{ $soal->id }}" {{ $dataScore->where('id_soal', $soal->id)->count() > 0 ? ($dataScore->where('id_soal', $soal->id)->first()->score >= $soal->kkm ? 'disabled' : '') : '' }}>
                                            <i class="fas fa-pen text-white"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-warning {{ $dataScore->where('id_soal', $soal->id)->count() > 0 ? 'disabled' : '' }}" data-toggle="modal" data-target="#kerjakan{{ $soal->id }}"
                                            {{ $dataScore->where('id_soal', $soal->id)->count() > 0 ? 'disabled' : '' }}>
                                            <i class="fas fa-pen text-white"></i>
                                        </button>
                                    @endif
                                @else
                                    <a href="/siswa/soal/ukk/{{ $soal->id }}" class="btn btn-warning">
                                        <i class="fas fa-pen text-white"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @php
                            $no++;
                        @endphp

                        @if (!Request::is('siswa/soal/ukk'))
                            <!-- Modal -->
                            <div class="modal fade" id="kerjakan{{ $soal->id }}" tabindex="-1" role="dialog" aria-labelledby="kerjakan{{ $soal->id }}Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark">
                                            <h5 class="modal-title" id="kerjakan{{ $soal->id }}Label">Kerjakan Soal</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" class="text-white">&times;</span>
                                            </button>
                                        </div>
                                        <form action="/siswa/token/submit/{{ $soal->id }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Mata Pelajaran</label>
                                                    <input type="text" class="form-control text-capitalize" value="{{ $soal->mapel }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Capaian Pembelajaran</label>
                                                    <input type="text" class="form-control text-capitalize" value="{{ $soal->capaian }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Type Soal</label>
                                                    <input type="text" class="form-control text-capitalize" value="{{ $soal->type }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Token</label>
                                                    <input type="text" class="form-control" name="token" required>
                                                </div>
                                                <div class="form-group">
                                                    <h6>(*) Masukkan token untuk dapat mengerjakan soal</h6>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Kerjakan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <!-- Data Tables -->
    <script src="/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script>
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
        })
    </script>
@endsection
