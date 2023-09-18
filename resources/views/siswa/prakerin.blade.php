@extends('siswa.layouts.main')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <script src="/AdminLTE/plugins/ckeditor/ckeditor.js"></script>
@endsection

@section('judul')
    Laporan Prakerin
@endsection

@section('content')
    <div class="card">
        <div class="card-header text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus"></i> Add</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="tb">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>Tempat Prakerin</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $unapprove = $laporans->where('status', 'null');
                    @endphp
                    @foreach ($unapprove as $laporan)
                        <tr>
                            <td>{{ $laporan->tgl }}</td>
                            <td>{{ $laporan->judul }}</td>
                            <td>{{ $dudis->where('id', $laporan->id_dudi)->first()->nama }}</td>
                            <td class="text-center">
                                <button class="btn btn-warning" data-toggle="modal" data-target="#editModal{{ $laporan->id }}"><i class="fas fa-edit text-white"></i></button>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $laporan->id }}"><i class="fas fa-trash text-white"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Sudah di approve</h5>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped" id="tb2">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>Tempat Prakerin</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $approved = $laporans->where('status', '!=', 'null');
                    @endphp
                    @foreach ($approved as $laporan)
                        <tr>
                            <td>{{ $laporan->tgl }}</td>
                            <td>{{ $laporan->judul }}</td>
                            <td>{{ $dudis->where('id', $laporan->id_dudi)->first()->nama }}</td>
                            <td>{{ $laporan->status }}</td>
                            <td class="text-center">
                                <button class="btn btn-warning" data-toggle="modal" data-target="#viewModal{{ $laporan->id }}"><i class="fas fa-eye text-white"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Laporan Prakerin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post">
                    @csrf
                    <input type="hidden" name="action" value="add">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col">
                                <label for="tgl">Tanggal</label>
                                <input name="tgl" type="date" class="form-control" id="tgl" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="dudi">Tempat Prakerin</label>
                                <select name="dudi" id="dudi" class="form-control" required>
                                    <option value="">Pilih Tempat Prakerin</option>
                                    @foreach ($dudis as $dudi)
                                        <option value="{{ $dudi->id }}">{{ $dudi->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="judul">Judul Kegiatan</label>
                                <input name="judul" type="text" class="form-control" id="judul" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="detail">Detail Kegiatan</label>
                                <textarea name="detail" id="detail" cols="30" rows="10"></textarea>
                            </div>
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

    @foreach ($laporans as $laporan)
        <!-- Modal Delete -->
        <div class="modal fade" id="deleteModal{{ $laporan->id }}" tabindex="-1" aria-labelledby="deleteModal{{ $laporan->id }}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="deleteModal{{ $laporan->id }}Label">Delete Laporan Prakerin</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="post">
                        @csrf
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="{{ $laporan->id }}">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col">
                                    <label>Tanggal</label>
                                    <input value="{{ $laporan->tgl }}" type="date" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>Tempat Prakerin</label>
                                    <input type="text" class="form-control" value="{{ $dudis->where('id', $laporan->id_dudi)->first()->nama }}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>Judul Kegiatan</label>
                                    <input type="text" class="form-control" value="{{ $laporan->judul }}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>Detail Kegiatan</label>
                                    <textarea id="detailDelete{{ $laporan->id }}" cols="30" rows="10">{{ $laporan->detail }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal{{ $laporan->id }}" tabindex="-1" aria-labelledby="editModal{{ $laporan->id }}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModal{{ $laporan->id }}Label">Edit Laporan Prakerin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="post">
                        @csrf
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" value="{{ $laporan->id }}">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" name="tgl" value="{{ $laporan->tgl }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>Tempat Prakerin</label>
                                    <select name="dudi" class="form-control" required>
                                        <option value="">Pilih Tempat Prakerin</option>
                                        @foreach ($dudis as $dudi)
                                            <option {{ $dudi->id == $laporan->id_dudi ? 'selected' : '' }} value="{{ $dudi->id }}">{{ $dudi->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>Judul Kegiatan</label>
                                    <input name="judul" type="text" class="form-control" value="{{ $laporan->judul }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>Detail Kegiatan</label>
                                    <textarea name="detail" id="detail{{ $laporan->id }}" cols="30" rows="10">{{ $laporan->detail }}</textarea>
                                </div>
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

        <!-- Modal View -->
        <div class="modal fade" id="viewModal{{ $laporan->id }}" tabindex="-1" aria-labelledby="deleteModal{{ $laporan->id }}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModal{{ $laporan->id }}Label">View Laporan Prakerin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col">
                                <label>Tanggal</label>
                                <input value="{{ $laporan->tgl }}" type="date" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>Tempat Prakerin</label>
                                <input type="text" class="form-control" value="{{ $dudis->where('id', $laporan->id_dudi)->first()->nama }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>Judul Kegiatan</label>
                                <input type="text" class="form-control" value="{{ $laporan->judul }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>Detail Kegiatan</label>
                                <textarea id="detailView{{ $laporan->id }}" cols="30" rows="10">{{ $laporan->detail }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            ClassicEditor
                .create(document.getElementById('detailDelete{{ $laporan->id }}'), {
                    // Editor configuration.
                })
                .then(editor => {
                    window.editor = editor;

                    editor.enableReadOnlyMode('detailDelete{{ $laporan->id }}');
                })
                .catch(handleSampleError);

            function handleSampleError(error) {
                const message = [
                    'Oops, something went wrong!',
                    `Please, report the following error on admin@nizar.my.id with the error stack trace:`
                ].join('\n');

                console.error(message);
                console.error(error);
            }
        </script>

        <script>
            ClassicEditor
                .create(document.getElementById('detail{{ $laporan->id }}'), {
                    // Editor configuration.
                })
                .then(editor => {
                    window.editor = editor;
                })
                .catch(handleSampleError);

            function handleSampleError(error) {
                const message = [
                    'Oops, something went wrong!',
                    `Please, report the following error on admin@nizar.my.id with the error stack trace:`
                ].join('\n');

                console.error(message);
                console.error(error);
            }
        </script>

        <script>
            ClassicEditor
                .create(document.getElementById('detailView{{ $laporan->id }}'), {
                    // Editor configuration.
                })
                .then(editor => {
                    window.editor = editor;

                    editor.enableReadOnlyMode('detailView{{ $laporan->id }}');
                })
                .catch(handleSampleError);

            function handleSampleError(error) {
                const message = [
                    'Oops, something went wrong!',
                    `Please, report the following error on admin@nizar.my.id with the error stack trace:`
                ].join('\n');

                console.error(message);
                console.error(error);
            }
        </script>
    @endforeach
@endsection

@section('script')
    <!-- Data Tables -->
    <script src="/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script>
        ClassicEditor
            .create(document.getElementById('detail'), {
                // Editor configuration.
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(handleSampleError);

        function handleSampleError(error) {
            const message = [
                'Oops, something went wrong!',
                `Please, report the following error on admin@nizar.my.id with the error stack trace:`
            ].join('\n');

            console.error(message);
            console.error(error);
        }
    </script>

    <script>
        $("#tb").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "order": [0, 'desc']
        })

        $("#tb2").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "order": [0, 'desc']
        })
    </script>
@endsection
