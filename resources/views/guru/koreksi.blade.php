<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Koreksi</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="/AdminLTE/plugins/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="/AdminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
</head>

<body>

    <div class="container py-5">

        <p class="text-danger">(*) Mohon baca jawaban siswa dengan teliti, karena tidak dapat dikoreksi ulang !!!</p>
        <div class="card">
            <div class="card-header">
                <h4>Soal ke {{ $koreksi->currentPage() }}</h4>
            </div>

            <div class="card-body">
                <h5>
                    @php
                        echo DB::table('tb_butir_uraian')
                            ->where('id', $koreksi->items()[0]->id_butir)
                            ->first()->soal;
                    @endphp
                </h5>

                <div class="form-group mt-5">
                    <label for="jawaban">Jawaban:</label>
                    <textarea id="jawaban" cols="30" rows="10" class="form-control" readonly>{{ $koreksi->items()[0]->jawaban }}</textarea>
                </div>
            </div>

            <div class="card-footer">
                <div class="row">
                    @if ($koreksi->currentPage() == $koreksi->total())
                        <div class="col-6">
                            <button onclick="next('salah', true)" class="btn btn-danger"><i class="fas fa-times"></i> Salah</button>
                        </div>
                        <div class="col-6 text-end">
                            <button onclick="next('benar', true)" class="btn btn-success"><i class="fas fa-check"></i> Benar</button>
                        </div>
                    @else
                        <div class="col-6">
                            <button onclick="next('salah')" class="btn btn-danger"><i class="fas fa-times"></i> Salah</button>
                        </div>
                        <div class="col-6 text-end">
                            <button onclick="next('benar')" class="btn btn-success"><i class="fas fa-check"></i> Benar</button>
                        </div>
                    @endif
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

        function next(status, end = false) {
            $.post("/guru/soal/list/koreksi/{{ $nis }}/{{ $id }}", {
                    id: {{ $koreksi->items()[0]->id }},
                    status: status
                },
                function(data, status) {
                    if (end) {
                        $.post("/guru/soal/list/koreksi/{{ $nis }}/{{ $id }}", {
                                submitScore: 'yes',
                                nis: {{ $nis }},
                                id: {{ $id }}
                            },
                            function(data, status) {
                                location.href = '/guru/soal/list/koreksi';
                            });
                    } else {
                        location.href = '{{ $koreksi->nextPageUrl() }}';
                    }
                });
        }
    </script>

</body>

</html>
