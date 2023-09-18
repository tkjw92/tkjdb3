@extends('guru.layouts.main')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <script src="/AdminLTE/plugins/ckeditor/ckeditor.js"></script>
@endsection

@section('judul')
    Penilaian UKK
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="accordion" id="accordionKelas">

                @foreach ($kelass as $kelas)
                    <div class="card">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left text-uppercase" type="button" data-toggle="collapse" data-target="#collapseKelas{{ $kelas->id }}" aria-expanded="true" aria-controls="collapseKelas{{ $kelas->id }}">
                                    {{ $kelas->kelas }}
                                </button>
                            </h2>
                        </div>

                        <div id="collapseKelas{{ $kelas->id }}" class="collapse" data-parent="#accordionKelas">
                            <div class="card-body">
                                <table class="table table-bordered table-striped" id="tb{{ $kelas->id }}">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Capaian Pembelajaran</th>
                                            <th width="100">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($soals as $soal)
                                            @if ($siswa->where('nis', $soal->nis)->first()->kelas == $kelas->kelas)
                                                <tr>
                                                    <td class="text-capitalize">{{ $siswa->where('nis', $soal->nis)->first()->nama }}</td>
                                                    <td class="text-uppercase">{{ $siswa->where('nis', $soal->nis)->first()->kelas }}</td>
                                                    <td>{{ $dataSoal->where('id', $soal->id_soal)->first()->capaian }}</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-warning" data-toggle="modal" data-target="#penilaian{{ $soal->id }}"><i class="fas fa-edit text-white"></i></button>
                                                    </td>
                                                </tr>

                                                <!-- Modal -->
                                                <div class="modal fade" id="penilaian{{ $soal->id }}" tabindex="-1" aria-labelledby="penilaian{{ $soal->id }}Label" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="penilaian{{ $soal->id }}Label">Penilaian UKK</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="" method="post">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{ $soal->id }}">
                                                                <div class="modal-body">
                                                                    <object class="w-100" height="800" data="/storage/{{ $dataSoal->where('id', $soal->id_soal)->first()->url }}"></object>
                                                                    <hr>
                                                                    <object class="w-100" height="800" data="/storage/{{ $soal->url }}"></object>
                                                                    <hr>
                                                                    <textarea name="penilaian" id="penilaianDetail{{ $soal->id }}" cols="30" rows="10">{{ $soal->penilaian == 'null' ? $dataSoal->where('id', $soal->id_soal)->first()->template : $soal->penilaian }}</textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <script>
                                                    ClassicEditor
                                                        .create(document.getElementById('penilaianDetail{{ $soal->id }}'), {
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
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Data Tables -->
    <script src="/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    @foreach ($kelass as $kelas)
        <script>
            $("#tb{{ $kelas->id }}").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "order": [0, 'desc']
            })
        </script>
    @endforeach
@endsection
