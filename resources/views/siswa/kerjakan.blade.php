<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>

    <div class="container py-5">

        <div class="card">
            <div class="card-header">
                <h4>Soal ke 1</h4>
            </div>

            <div class="card-body">
                <h5>Ini adalah soal Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum voluptates expedita rem. Ad dolores necessitatibus accusamus reprehenderit sequi incidunt deleniti numquam nostrum fugiat quaerat, totam at eum mollitia, fuga et.</h5>
                <hr>

                <table>
                    @for ($i = 0; $i < 4; $i++)
                        <tr>
                            <td class="pe-3"><input type="radio" name="correct" id="correct{{ $i }}"></td>
                            <td><label for="correct{{ $i }}">Pilihan {{ $i }}</label></td>
                        </tr>
                    @endfor
                </table>
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-6">
                        <button class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</button>
                    </div>
                    <div class="col-6 text-end">
                        <button class="btn btn-primary"><i class="fas fa-arrow-right"></i> Next</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-5">

            <div class="card-header">
                <h5>List Nomer</h5>
            </div>

            <div class="card-body text-center">
                @for ($i = 1; $i < 41; $i++)
                    <button class="btn btn-outline-secondary m-1" style="width: 50px">{{ $i }}</button>
                @endfor
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>
