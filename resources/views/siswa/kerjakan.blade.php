<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="/AdminLTE/plugins/bootstrap/css/bootstrap.min.css">
</head>

<body>

    <div class="container py-5">

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
                <hr>

                <table>
                    @php
                        $pilihan = explode('%|@|%', $soal->items()[0]->pilihan);
                    @endphp
                    @for ($i = 0; $i < 4; $i++)
                        <tr>
                            <td class="pe-3"><input type="radio" name="correct" id="correct{{ $i }}"></td>
                            <td><label for="correct{{ $i }}">{{ $pilihan[$i] }}</label></td>
                        </tr>
                    @endfor
                </table>
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ $soal->previousPageUrl() }}" class="btn btn-primary {{ $soal->onFirstPage() ? 'disabled' : '' }}"><i class="fas fa-arrow-left"></i> Back</a>
                    </div>
                    <div class="col-6 text-end">
                        <a href="{{ $soal->nextPageUrl() }}" class="btn btn-primary {{ $soal->currentPage() == $soal->total() ? 'disabled' : '' }}"><i class="fas fa-arrow-right"></i> Next</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-5">

            <div class="card-header">
                <h5>List Nomer</h5>
            </div>

            <div class="card-body text-center">
                @for ($i = 0; $i < $soal->total(); $i++)
                    <a href="{{ $soal->url($i + 1) }}" class="btn border-dark {{ $soal->currentPage() == $i + 1 ? 'btn-warning' : 'btn-outline-secondary ' }} m-1" style="width: 50px">{{ $i + 1 }}</a>
                @endfor
            </div>

        </div>

    </div>

    <script src="/AdminLTE/plugins/bootstrap/js/bootstrap5.bundle.js"></script>
</body>

</html>
