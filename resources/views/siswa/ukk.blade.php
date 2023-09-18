@extends('siswa.layouts.main')

@section('judul')
    Uji Kompetensi Keahlian
@endsection

@section('content')
    <h6 class="text-danger">(*) Jawaban hanya dapat di submit 1 kali :)</h6>
    <div class="card">
        <div class="card-header">
            <h5>Upload Jawaban Dalam Bentuk PDF</h5>
        </div>
        <div class="card-body">
            @if ($status == 'belum')
                <form action="" method="post" class="row" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-md-11">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" accept="application/pdf" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file" required>
                                <label class="custom-file-label" for="inputGroupFile01" id="nameFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-1">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            @else
                <h5>Terimakasi telah melakukan submit</h5>
            @endif
        </div>
    </div>

    <div class="card rounded p-5">
        <div class="container">
            <object class="w-100" height="800" data="/storage/{{ $soal->url }}"></object>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const label = document.getElementById('nameFile');
        const input = document.getElementById('inputGroupFile01');

        input.addEventListener('change', () => {
            label.innerText = input.files[0].name;
        });
    </script>
@endsection
