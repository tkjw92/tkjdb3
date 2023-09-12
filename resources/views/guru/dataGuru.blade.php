@extends('guru.layouts.main')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('judul')
    Data Guru
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
                        <th width="50">No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Mata Pelajaran</th>
                        @if (session('akun')['role'] == 'admin')
                            <th width="100">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($dataGuru as $guru)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $guru->nip }}</td>
                            <td class="text-capitalize">{{ $guru->nama }}</td>
                            <td class="text-capitalize">{{ $guru->mapel }}</td>
                            @if (session('akun')['role'] == 'admin')
                                <td class="text-center">
                                    <button data-toggle="modal" data-target="#edit{{ $guru->nip }}" class="btn btn-warning text-white"><i class="fas fa-user-edit"></i></button>
                                    <button data-toggle="modal" data-target="#delete{{ $guru->nip }}" class="btn btn-danger text-white"><i class="fas fa-user-times"></i></button>
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
                    <h5 class="modal-title" id="addModalLabel">Add Guru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nip">NIP Guru</label>
                            <input type="text" class="form-control" id="nip" name="nip" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="mapel">Mata Pelajaran</label>
                            <input type="text" class="form-control" id="mapel" name="mapel" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="guru">Guru</option>
                                <option value="admin">Admin</option>
                            </select>
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

    @foreach ($dataGuru as $guru)
        <!-- Modal Delete -->
        <div class="modal fade" id="delete{{ $guru->nip }}" tabindex="-1" role="dialog" aria-labelledby="delete{{ $guru->nip }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="delete{{ $guru->nip }}Label">Delete Guru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-white">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>NIP Guru</label>
                            <input type="text" class="form-control" value="{{ $guru->nip }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control text-capitalize" value="{{ $guru->nama }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Mata Pelajaran</label>
                            <input type="text" class="form-control text-capitalize" value="{{ $guru->mapel }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <input type="text" class="form-control text-capitalize" value="{{ $guru->role }}" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a href="/guru/data/data-guru/delete/{{ $guru->id }}" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="edit{{ $guru->nip }}" tabindex="-1" role="dialog" aria-labelledby="edit{{ $guru->nip }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit{{ $guru->nip }}Label">Edit Guru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/guru/data/data-guru/edit/{{ $guru->id }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>NIP Guru</label>
                                <input type="text" class="form-control" name="nip" value="{{ $guru->nip }}">
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control text-capitalize" name="nama" value="{{ $guru->nama }}">
                            </div>
                            <div class="form-group">
                                <label>Mata Pelajaran</label>
                                <input type="text" class="form-control text-capitalize" name="mapel" value="{{ $guru->mapel }}">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" name="password" value="{{ $guru->password }}">
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="guru">Guru</option>
                                    <option value="admin" {{ $guru->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
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
                    title: 'Data Guru',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'excel',
                    title: 'Data Guru',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'print',
                    title: 'Data Guru',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                }
            ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    </script>
@endsection
