@extends('guru.layouts.main')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('judul')
    Data Dudi
@endsection

@section('content')
    <div class="card">
        @if (session('akun')['role'] == 'admin')
            <div class="card-header text-right">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus pr-1"></i>Add</button>
            </div>
        @endif
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th>Nama Dudi</th>
                        <th>Bidang</th>
                        <th>Alamat</th>
                        @if (session('akun')['role'] == 'admin')
                            <th width="100">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($dataDudi as $dudi)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="text-capitalize">{{ $dudi->nama }}</td>
                            <td class="text-capitalize">{{ $dudi->bidang }}</td>
                            <td>{{ $dudi->alamat }}</td>
                            @if (session('akun')['role'] == 'admin')
                                <td class="text-center">
                                    <button data-toggle="modal" data-target="#edit{{ $dudi->id }}" class="btn btn-warning text-white"><i class="fas fa-edit"></i></button>
                                    <button data-toggle="modal" data-target="#delete{{ $dudi->id }}" class="btn btn-danger text-white"><i class="fas fa-trash"></i></button>
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
                    <h5 class="modal-title" id="addModalLabel">Add Dudi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Dudi</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="bidang">Bidang</label>
                            <input type="text" class="form-control" id="bidang" name="bidang" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="10" required></textarea>
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

    @foreach ($dataDudi as $dudi)
        <!-- Modal delete-->
        <div class="modal fade" id="delete{{ $dudi->id }}" tabindex="-1" role="dialog" aria-labelledby="delete{{ $dudi->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="delete{{ $dudi->id }}Label">Delete Dudi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-white">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Dudi</label>
                            <input type="text" class="form-control" value="{{ $dudi->nama }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Bidang</label>
                            <input type="text" class="form-control" value="{{ $dudi->bidang }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" cols="30" rows="10" readonly>{{ $dudi->alamat }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a href="/guru/data/data-dudi/delete/{{ $dudi->id }}" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal edit-->
        <div class="modal fade" id="edit{{ $dudi->id }}" tabindex="-1" role="dialog" aria-labelledby="edit{{ $dudi->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit{{ $dudi->id }}Label">Add Dudi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/guru/data/data-dudi/edit/{{ $dudi->id }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Dudi</label>
                                <input type="text" class="form-control" name="nama" value="{{ $dudi->nama }}" required>
                            </div>
                            <div class="form-group">
                                <label>Bidang</label>
                                <input type="text" class="form-control" name="bidang" value="{{ $dudi->bidang }}" required>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" name="alamat" cols="30" rows="10" required>{{ $dudi->alamat }}</textarea>
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
                    title: 'Data Dudi',
                    exportOptions: {
                        columns: [1, 2, 3]
                    }
                },
                {
                    extend: 'excel',
                    title: 'Data Dudi',
                    exportOptions: {
                        columns: [1, 2, 3]
                    }
                },
                {
                    extend: 'print',
                    title: 'Data Dudi',
                    exportOptions: {
                        columns: [1, 2, 3]
                    }
                }
            ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    </script>
@endsection
