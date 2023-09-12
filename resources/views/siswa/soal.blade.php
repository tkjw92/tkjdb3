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
                                <button class="btn btn-warning">
                                    <i class="fas fa-pen text-white"></i>
                                </button>
                            </td>
                        </tr>
                        @php
                            $no++;
                        @endphp
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
