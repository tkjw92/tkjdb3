@extends('guru.layouts.main')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endsection

@section('judul')
    Data Kelas
@endsection

@section('content')
    <div class="card">
        @if (session('akun')['role'] == 'admin')
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus pr-1"></i>Add</button>
                    </div>
                </div>
            </div>
        @endif
        <!-- /.card-header -->
        <div class="card-body">
            <table id="kelas" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th>Kelas</th>
                        <th>Jumlah Siswa</th>
                        @if (session('akun')['role'] == 'admin')
                            <th width="30">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($dataKelas as $kelas)
                        @php
                            $jumlahSiswa = $dataSiswa->where('kelas', $kelas->kelas)->count();
                        @endphp
                        <tr>
                            <td class="text-center">{{ $no }}</td>
                            <td class="text-uppercase">{{ $kelas->kelas }}</td>
                            <td>{{ $jumlahSiswa }}</td>
                            @if (session('akun')['role'] == 'admin')
                                <td>
                                    <button data-toggle="modal" data-target="#delete{{ $kelas->id }}" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            @endif
                        </tr>
                        @php
                            $no++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <input type="text" class="form-control text-uppercase" id="kelas" name="kelas" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($dataKelas as $kelas)
        <!-- Modal Delete -->
        <div class="modal fade" id="delete{{ $kelas->id }}" tabindex="-1" role="dialog" aria-labelledby="delete{{ $kelas->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="delete{{ $kelas->id }}Label">Delete Kelas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-white">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" class="form-control text-uppercase" name="kelas" value="{{ $kelas->kelas }}" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a href="/guru/data/data-kelas/delete/{{ $kelas->id }}" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('script')
    <script src="/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script>
        $("#kelas").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
        })
    </script>
@endsection
