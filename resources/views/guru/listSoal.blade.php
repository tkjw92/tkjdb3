@extends('guru.layouts.main')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <script src="/AdminLTE/plugins/ckeditor/ckeditor.js"></script>
@endsection

@section('judul')
    {{ $judul }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus pr-1"></i>Add</button>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="50" class="text-center">No</th>
                        @if (!Request::is('guru/soal/ukk'))
                            <th width="90">Type</th>
                        @endif
                        <th>Mata Pelajaran</th>
                        <th>Capaian Pembelajaran</th>
                        <th>Status</th>
                        @if (session('akun')['role'] == 'admin')
                            <th>Owner</th>
                        @endif
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($dataSoal as $soal)
                        <tr>
                            <td class="text-center">{{ $no }}</td>
                            @if (!Request::is('guru/soal/ukk'))
                                <td>{{ $soal->type }}</td>
                            @endif
                            <td>{{ $soal->mapel }}</td>
                            <td>{{ $soal->capaian }}</td>
                            <td>{{ $soal->status }}</td>
                            @if (session('akun')['role'] == 'admin')
                                <td>{{ $soal->owner }}</td>
                            @endif
                            <td class="text-center">
                                <a href="/guru/soal{{ Request::is('guru/soal/ukk') ? '/ukk' : '' }}/edit/{{ $soal->id }}" class="btn btn-warning text-white"><i class="fas fa-edit"></i></a>
                                <button data-toggle="modal" data-target="#delete{{ $soal->id }}" class="btn btn-danger text-white"><i class="fas fa-trash"></i></button>
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

    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ Request::is('guru/soal/ukk') ? '/guru/soal/ukk/add' : '' }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="capaian">Capaian Pembelajaran</label>
                            <input type="text" class="form-control" id="capaian" name="capaian" required>
                        </div>
                        @if (!Request::is('guru/soal/ukk'))
                            <div class="form-group">
                                <label for="kkm">Nilai Minimum</label>
                                <input type="number" class="form-control" id="kkm" name="kkm" required>
                            </div>
                            <div class="form-group">
                                <label for="type">Type Soal</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="">Pilih type soal</option>
                                    <option value="pilihan">Pilihan</option>
                                    <option value="uraian">Uraian</option>
                                </select>
                            </div>
                        @endif
                        @if (Request::is('guru/soal/ukk'))
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" accept="application/pdf" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file" required>
                                    <label class="custom-file-label" for="inputGroupFile01" id="nameFile">Choose file</label>
                                </div>
                            </div>

                            <div class="form-group mt-2">
                                <label for="template">Template Penilaian</label>
                                <textarea name="template" id="template" cols="30" rows="10"></textarea>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($dataSoal as $soal)
        <!-- Modal -->
        <div class="modal fade" id="delete{{ $soal->id }}" tabindex="-1" role="dialog" aria-labelledby="delete{{ $soal->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="delete{{ $soal->id }}Label">Delete Soal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-white">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Capaian Pembelajaran</label>
                                <input type="text" class="form-control" value="{{ $soal->capaian }}" readonly>
                            </div>
                            @if (!Request::is('guru/soal/ukk'))
                                <div class="form-group">
                                    <label>Type Soal</label>
                                    <input type="text" class="form-control" value="{{ $soal->type }}" readonly>
                                </div>
                            @else
                                <h5 class="bold text-danger">Karena tidak ada preview harap pastikan kembali sebelum menghapus data !!!</h5>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a href="/guru/soal/{{ Request::is('guru/soal/ukk') ? 'ukk/' : '' }}delete/{{ $soal->id }}" class="btn btn-danger">Delete</a>
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

    @if (Request::is('guru/soal/ukk'))
        <script>
            ClassicEditor
                .create(document.getElementById('template'), {
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
    @endif

    <script>
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
        })

        const label = document.getElementById('nameFile');
        const input = document.getElementById('inputGroupFile01');

        input.addEventListener('change', () => {
            label.innerText = input.files[0].name;
        });
    </script>
@endsection
