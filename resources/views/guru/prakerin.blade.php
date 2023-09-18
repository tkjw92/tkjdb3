@extends('guru.layouts.main')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <script src="/AdminLTE/plugins/ckeditor/ckeditor.js"></script>
@endsection

@section('judul')
    Laporan Prakerin siswa
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Belum di approve</h5>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped" id="tb">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>Tempat Prakerin</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $unapprove = $laporans->where('status', 'null');
                    @endphp
                    @foreach ($unapprove as $laporan)
                        <tr>
                            <td class="text-capitalize">{{ $siswa->where('nis', $laporan->nis)->first()->nama }}</td>
                            <td class="text-uppercase">{{ $siswa->where('nis', $laporan->nis)->first()->kelas }}</td>
                            <td>{{ $laporan->tgl }}</td>
                            <td>{{ $laporan->judul }}</td>
                            <td>{{ $dudis->where('id', $laporan->id_dudi)->first()->nama }}</td>
                            <td>Belum mendapatkan approve</td>
                            <td class="text-center">
                                <button class="btn btn-warning" data-toggle="modal" data-target="#approveModal{{ $laporan->id }}"><i class="fas fa-eye text-white"></i></button>
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
                        <th>Nama</th>
                        <th>Kelas</th>
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
                            <td class="text-capitalize">{{ $siswa->where('nis', $laporan->nis)->first()->nama }}</td>
                            <td class="text-uppercase">{{ $siswa->where('nis', $laporan->nis)->first()->kelas }}</td>
                            <td>{{ $laporan->tgl }}</td>
                            <td>{{ $laporan->judul }}</td>
                            <td>{{ $dudis->where('id', $laporan->id_dudi)->first()->nama }}</td>
                            <td>{{ $laporan->status }}</td>
                            <td class="text-center">
                                <button class="btn btn-warning" data-toggle="modal" data-target="#approveModal{{ $laporan->id }}"><i class="fas fa-eye text-white"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @foreach ($laporans as $laporan)
        <!-- Modal approve -->
        <div class="modal fade" id="approveModal{{ $laporan->id }}" tabindex="-1" aria-labelledby="approveModal{{ $laporan->id }}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveModal{{ $laporan->id }}Label">Approve Laporan Prakerin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="post">
                        @csrf
                        <input type="hidden" name="action" value="approve">
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
                                    <textarea id="detailApprove{{ $laporan->id }}" cols="30" rows="10">{{ $laporan->detail }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary {{ $laporan->status != 'null' ? 'disabled' : '' }}" {{ $laporan->status != 'null' ? 'disabled' : '' }}>Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            ClassicEditor
                .create(document.getElementById('detailApprove{{ $laporan->id }}'), {
                    // Editor configuration.
                })
                .then(editor => {
                    window.editor = editor;

                    editor.enableReadOnlyMode('detailApprove{{ $laporan->id }}');
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
