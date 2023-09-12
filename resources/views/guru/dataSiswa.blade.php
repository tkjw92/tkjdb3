@extends('guru.layouts.main')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('judul')
    Data Siswa
@endsection

@section('content')
    <div class="card">
        @if (session('akun')['role'] == 'admin')
            <div class="card-header text-right">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addModal"><i class="fas fa-user-plus pr-1"></i>Add</button>
            </div>
        @endif
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th width="70">NIS</th>
                        <th width="90">NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        @if (session('akun')['role'] == 'admin')
                            <th width="100">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($dataSiswa as $siswa)
                        <tr>
                            <td class="text-center">{{ $no }}</td>
                            <td>{{ $siswa->nis }}</td>
                            <td>{{ $siswa->nisn }}</td>
                            <td class="text-capitalize">{{ $siswa->nama }}</td>
                            <td class="text-uppercase">{{ $siswa->kelas }}</td>
                            @if (session('akun')['role'] == 'admin')
                                <td class="text-center">
                                    <button data-toggle="modal" data-target="#edit{{ $siswa->id }}" class="btn btn-warning text-white"><i class="fas fa-user-edit"></i></button>
                                    <button data-toggle="modal" data-target="#delete{{ $siswa->id }}" class="btn btn-danger text-white"><i class="fas fa-user-times"></i></button>
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nis">NIS</label>
                            <input type="text" class="form-control" id="nis" name="nis" required>
                        </div>
                        <div class="form-group">
                            <label for="nisn">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <select class="form-control" id="kelas" name="kelas" required>
                                <option value="">Pilih Kelas</option>
                                @foreach ($dataKelas as $kelas)
                                    <option class="text-uppercase" value="{{ $kelas->kelas }}">{{ $kelas->kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" class="form-control" id="password" name="password" required>
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

    @foreach ($dataSiswa as $siswa)
        <!-- Modal Delete -->
        <div class="modal fade" id="delete{{ $siswa->id }}" tabindex="-1" role="dialog" aria-labelledby="delete{{ $siswa->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="delete{{ $siswa->id }}Label">Delete Siswa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-white">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="{{ $siswa->nis }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>NISN</label>
                            <input type="text" class="form-control" value="{{ $siswa->nisn }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control text-capitalize" value="{{ $siswa->nama }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" class="form-control text-uppercase" value="{{ $siswa->kelas }}" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a href="/guru/data/data-siswa/delete/{{ $siswa->id }}" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="edit{{ $siswa->id }}" tabindex="-1" role="dialog" aria-labelledby="edit{{ $siswa->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit{{ $siswa->id }}Label">Add Siswa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/guru/data/data-siswa/edit/{{ $siswa->id }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>NIS</label>
                                <input type="text" class="form-control" name="nis" value="{{ $siswa->nis }}" required>
                            </div>
                            <div class="form-group">
                                <label>NISN</label>
                                <input type="text" class="form-control" name="nisn" value="{{ $siswa->nisn }}" required>
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="nama" value="{{ $siswa->nama }}" required>
                            </div>
                            <div class="form-group">
                                <label>Kelas</label>
                                <select class="form-control" name="kelas" value="{{ $siswa->kelas }}" required>
                                    @foreach ($dataKelas as $kelas)
                                        <option class="text-uppercase" value="{{ $kelas->kelas }}" {{ $siswa->kelas == $kelas->kelas ? 'selected' : '' }}>{{ $kelas->kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" name="password" value="{{ $siswa->password }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('script')
    <!-- Data Tables -->
    <script src="/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/AdminLTE/plugins/jszip/jszip.min.js"></script>
    <script src="/AdminLTE/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/AdminLTE/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/AdminLTE/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <script>
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": [{
                    extend: 'csv',
                    title: 'Data Siswa',
                    exportOptions: {
                        columns: [1, 2, 3, 4]
                    }
                },
                {
                    extend: 'excel',
                    title: 'Data Siswa',
                    exportOptions: {
                        columns: [1, 2, 3, 4]
                    }
                },
                {
                    extend: 'print',
                    title: 'Data Siswa',
                    exportOptions: {
                        columns: [1, 2, 3, 4]
                    }
                }
            ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    </script>
@endsection
