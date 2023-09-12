@extends('guru.layouts.main')

@section('style')
    <script src="/AdminLTE/plugins/ckeditor/ckeditor.js"></script>
@endsection

@section('judul')
    Edit Soal
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="" method="POST" class="row" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-md">
                    <label for="capaian">Capaian Pembelajaran</label>
                    <input type="text" class="form-control" id="capaian" name="capaian" value="{{ $soal->capaian }}" required>
                </div>
                @if (!Request::is('guru/soal/ukk/edit*'))
                    <div class="form-group col-md">
                        <label for="token">Token</label>
                        <input type="text" class="form-control" id="token" name="token" value="{{ $soal->token }}" required>
                    </div>
                    <div class="form-group col-md">
                        <label for="kkm">Nilai Minimum</label>
                        <input type="number" class="form-control" id="kkm" name="kkm" value="{{ $soal->kkm }}" required>
                    </div>
                @else
                    <div class="form-group col-md">
                        <label for="status" class="form-label text-capitalize">Lampiran PDF</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" accept="application/pdf" name="file">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="form-group col-md">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="draft">Draft</option>
                        <option value="published" {{ $soal->status == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
                <div class="form-group col-md-1">
                    <label>&nbsp;</label>
                    <button class="btn btn-primary form-control" type="submit"><i class="fas fa-save pr-1"></i>Save</button>
                </div>
            </form>
        </div>
    </div>

    @if (!Request::is('guru/soal/ukk/edit*'))
        <div class="text-right mb-3">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus pr-1"></i>Add</button>
        </div>
    @endif

    @if (Request::is('guru/soal/ukk/edit*'))
        <div class="card rounded p-5">
            <div class="container">
                <object class="w-100" height="800" data="/storage/{{ $soal->url }}"></object>
            </div>
        </div>
    @else
        {{-- ============================================================================================ --}}
        {{-- Soal Pilihan --}}
        {{-- ============================================================================================ --}}
        @if ($type == 'pilihan')
            <div class="card rounded">
                @php
                    $no = 1;
                @endphp
                @foreach ($butirSoal as $butir)
                    <div class="row p-5 mt-2 shadow-sm ">
                        <div class="col-md-10">
                            <ul class="list-unstyled d-flex">
                                <li>{{ $no }}.&nbsp;&nbsp;</li>
                                <li>
                                    @php
                                        echo $butir->soal;
                                    @endphp
                                </li>
                            </ul>
                            <ul class="list-unstyled ml-5">
                                <li>
                                    <table>
                                        @php
                                            $pilihan = explode('%|@|%', $butir->pilihan);
                                        @endphp
                                        @for ($i = 0; $i < 4; $i++)
                                            <tr>
                                                <td><i class="far {{ $butir->correct == $i ? 'fa-dot-circle' : 'fa-circle' }} pr-3"></i></td>
                                                <td>
                                                    <span>
                                                        {{ $pilihan[$i] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endfor
                                    </table>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-2 text-center">
                            <button data-toggle="modal" data-target="#edit{{ $butir->id }}" class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></button>
                            <button data-toggle="modal" data-target="#delete{{ $butir->id }}" class="btn btn-sm btn-danger mr-3 text-white"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    @php
                        $no++;
                    @endphp
                @endforeach
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Add Butir Soal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/guru/soal/add/butir-pilihan/{{ $soal->id }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="soal">Soal</label>
                                    <textarea name="soal" id="soal" cols="30" rows="10"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Pilihan</label>
                                </div>

                                @for ($i = 0; $i < 4; $i++)
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input name="correct" type="radio" value="{{ $i }}" required>
                                                </div>
                                            </div>
                                            <input name="pilihan{{ $i }}" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @foreach ($butirSoal as $butir)
                @php
                    $pilihan = explode('%|@|%', $butir->pilihan);
                @endphp

                <!-- Modal Edit -->
                <div class="modal fade" id="edit{{ $butir->id }}" tabindex="-1" role="dialog" aria-labelledby="edit{{ $butir->id }}Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="edit{{ $butir->id }}Label">Edit Butir Soal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/guru/soal/edit/butir-pilihan/{{ $butir->id }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="soal">Soal</label>
                                        <textarea name="soal" id="editBox{{ $butir->id }}" cols="30" rows="10">
                                    {{ $butir->soal }}
                                </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Pilihan</label>
                                    </div>

                                    @for ($i = 0; $i < 4; $i++)
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <input name="correct" type="radio" name="correct" value="{{ $i }}" {{ $butir->correct == $i ? 'checked' : '' }} required>
                                                    </div>
                                                </div>
                                                <input name="pilihan{{ $i }}" type="text" value="{{ $pilihan[$i] }}" class="form-control" required>
                                            </div>
                                        </div>
                                    @endfor

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Delete -->
                <div class="modal fade" id="delete{{ $butir->id }}" tabindex="-1" role="dialog" aria-labelledby="delete{{ $butir->id }}Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h5 class="modal-title" id="delete{{ $butir->id }}Label">Delete Butir Soal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" class="text-white">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="soal">Soal</label>
                                    <textarea id="deleteBox{{ $butir->id }}">{{ $butir->soal }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Pilihan</label>
                                </div>

                                @for ($i = 0; $i < 4; $i++)
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="radio" {{ $butir->correct == $i ? 'checked' : '' }} disabled>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" value="{{ $pilihan[$i] }}" readonly>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a href="/guru/soal/edit/delete/{{ $butir->id }}" class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    ClassicEditor
                        .create(document.getElementById('deleteBox{{ $butir->id }}'), {
                            // Editor configuration.
                        })
                        .then(editor => {
                            window.editor = editor;

                            editor.enableReadOnlyMode('deleteBox{{ $butir->id }}');
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

                    ClassicEditor
                        .create(document.getElementById('editBox{{ $butir->id }}'), {
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
            @endforeach
        @else
            {{-- ============================================================================================ --}}
            {{-- Soal Uraian --}}
            {{-- ============================================================================================ --}}

            <div class="card rounded">
                @php
                    $no = 1;
                @endphp
                @foreach ($butirSoal as $butir)
                    <div class="row p-5 mt-2 shadow-sm ">
                        <div class="col-md-10">
                            <ul class="list-unstyled d-flex">
                                <li>{{ $no }}.&nbsp;&nbsp;</li>
                                <li>
                                    @php
                                        echo $butir->soal;
                                    @endphp
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-2 text-center">
                            <button data-toggle="modal" data-target="#edit{{ $butir->id }}" class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></button>
                            <button data-toggle="modal" data-target="#delete{{ $butir->id }}" class="btn btn-sm btn-danger mr-3 text-white"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    @php
                        $no++;
                    @endphp
                @endforeach
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Add Butir Soal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/guru/soal/add/butir-uraian/{{ $soal->id }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="soal">Soal</label>
                                    <textarea name="soal" id="soal" cols="30" rows="30"></textarea>
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

            @foreach ($butirSoal as $butir)
                <!-- Modal Delete -->
                <div class="modal fade" id="delete{{ $butir->id }}" tabindex="-1" role="dialog" aria-labelledby="delete{{ $butir->id }}Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h5 class="modal-title" id="delete{{ $butir->id }}Label">Delete Butir Soal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" class="text-white">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="soal">Soal</label>
                                    <textarea id="deleteBox{{ $butir->id }}" cols="30" rows="30">{{ $butir->soal }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a href="/guru/soal/edit/delete/uraian/{{ $butir->id }}" class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit -->
                <div class="modal fade" id="edit{{ $butir->id }}" tabindex="-1" role="dialog" aria-labelledby="edit{{ $butir->id }}Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="edit{{ $butir->id }}Label">Delete Butir Soal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/guru/soal/edit/butir-uraian/{{ $butir->id }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="soal">Soal</label>
                                        <textarea name="soal" id="editBox{{ $butir->id }}" cols="30" rows="30">{{ $butir->soal }}</textarea>
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

                <script>
                    ClassicEditor
                        .create(document.getElementById('deleteBox{{ $butir->id }}'), {
                            // Editor configuration.
                        })
                        .then(editor => {
                            window.editor = editor;

                            editor.enableReadOnlyMode('deleteBox{{ $butir->id }}');
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

                    ClassicEditor
                        .create(document.getElementById('editBox{{ $butir->id }}'), {
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
            @endforeach
        @endif
    @endif

@endsection

@if (!Request::is('guru/soal/ukk/edit*'))
    @section('script')
        <script>
            ClassicEditor
                .create(document.getElementById('soal'), {
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
    @endsection
@else
    @section('script')
        <script>
            document.getElementById('inputGroupFile01').addEventListener('change', () => {
                document.querySelector('.custom-file-label').innerText = document.getElementById('inputGroupFile01').files[0].name;
            })
        </script>
    @endsection
@endif
