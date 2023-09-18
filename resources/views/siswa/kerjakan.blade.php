<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="/AdminLTE/plugins/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="/AdminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
</head>

<body>

    <div class="container py-5">

        <p class="text-danger">(*) Sebelum menekan tombol submit pastikan kamu telah memastikan semua soal sudah terjawab !!!</p>
        <div class="card">
            <div class="card-header">
                <h4>Soal ke {{ $soal->currentPage() }}</h4>
            </div>

            <div class="card-body">
                <h5>
                    @php
                        echo $soal->items()[0]->soal;
                    @endphp
                </h5>

                @if ($type == 'pilihan')
                    <hr>
                    <table>
                        @php
                            $pilihan = explode('%|@|%', $soal->items()[0]->pilihan);
                        @endphp
                        @for ($i = 0; $i < 4; $i++)
                            <tr>
                                <td class="pe-3"><input type="radio" name="correct" value="{{ $i }}" {{ session()->has('jawaban' . $soal->items()[0]->id) ? (session('jawaban' . $soal->items()[0]->id) == $i ? 'checked' : '') : '' }} id="correct{{ $i }}">
                                </td>
                                <td><label for="correct{{ $i }}">{{ $pilihan[$i] }}</label></td>
                            </tr>
                        @endfor
                    </table>
                @else
                    <div class="form-group mt-5">
                        <label for="jawaban">Jawaban:</label>
                        <textarea id="jawaban" cols="30" rows="10" class="form-control">{{ session()->has('jawaban' . $soal->items()[0]->id) ? session('jawaban' . $soal->items()[0]->id) : '' }}</textarea>
                    </div>
                @endif
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ $soal->previousPageUrl() }}" class="btn btn-primary {{ $soal->onFirstPage() ? 'disabled' : '' }}"><i class="fas fa-arrow-left"></i> Back</a>
                    </div>
                    <div class="col-6 text-end">
                        @if ($soal->currentPage() == $soal->total())
                            @if ($type == 'pilihan')
                                <button data-bs-toggle="modal" data-bs-target="#submitModal" class="btn btn-primary"><i class="fas fa-arrow-right"></i> Submit Jawaban</button>
                            @else
                                <button onclick="submitUraian(true)" class="btn btn-primary"><i class="fas fa-arrow-right"></i> Submit Jawaban</button>
                            @endif
                        @else
                            @if ($type == 'pilihan')
                                <a href="{{ $soal->nextPageUrl() }}" class="btn btn-primary {{ $soal->currentPage() == $soal->total() ? 'disabled' : '' }}"><i class="fas fa-arrow-right"></i> Next</a>
                            @else
                                <button onclick="submitUraian()" class="btn btn-primary {{ $soal->currentPage() == $soal->total() ? 'disabled' : '' }}"><i class="fas fa-arrow-right"></i> Next</button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-5">

            <div class="card-header">
                <h5>List Nomer</h5>
            </div>

            <div class="card-body text-center">
                @php
                    $i = 1;
                @endphp
                @foreach ($nomors as $nomor)
                    @if ($i == $soal->currentPage())
                        <a href="{{ $soal->url($i) }}" class="btn border-dark btn-warning m-1" style="width: 50px">{{ $i }}</a>
                    @else
                        @if (session()->has('jawaban' . $nomor->id))
                            <a href="{{ $soal->url($i) }}" class="btn border-dark btn-secondary m-1" style="width: 50px">{{ $i }}</a>
                        @else
                            <a href="{{ $soal->url($i) }}" class="btn border-dark btn-outline-secondary m-1" style="width: 50px">{{ $i }}</a>
                        @endif
                    @endif

                    @php
                        $i++;
                    @endphp
                @endforeach
            </div>

        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="submitModal" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="submitModalLabel">Konfirmasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5><span class="text-danger">(*)</span> Dengan menekan tombol submit anda telah memastikan semua jawaban telah terjawab !!!</h5>
                    <br>
                    <h6>Good Luck 😀</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="/siswa/score" type="button" class="btn btn-success">Submit</a>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="/AdminLTE/plugins/jquery/jquery.min.js"></script>

    <script src="/AdminLTE/plugins/bootstrap/js/bootstrap5.bundle.js"></script>
    <script src="/AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const radios = document.querySelectorAll('input[type=radio]');

        for (let i = 0; i < radios.length; i++) {
            radios[i].addEventListener('change', function() {
                $.post("/siswa/kerjakan/{{ session('jenis') }}/{{ session('ujian') }}/submit", {
                        id: {{ $soal->items()[0]->id }},
                        jawaban: radios[i].value
                    },
                    function(data, status) {
                        var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });

                        Toast.fire({
                            icon: 'success',
                            title: 'Jawaban Berhasil Disimpan'
                        })
                    });
            });
        }

        function submitUraian(end = false) {
            const jawaban = document.getElementById('jawaban');

            $.post("/siswa/kerjakan/{{ session('jenis') }}/{{ session('ujian') }}/submitUraian", {
                    id: {{ $soal->items()[0]->id }},
                    jawaban: jawaban.value
                },
                function(data, status) {
                    if (end) {
                        $('#submitModal').modal('show');
                    } else {
                        location.href = '{{ $soal->nextPageUrl() }}'
                    }
                });
        }
    </script>
</body>

</html>
