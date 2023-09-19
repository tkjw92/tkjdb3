<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="/AdminLTE/plugins/bootstrap/css/bootstrap.min.css">
</head>

<body>

    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="/assets/images/bg.svg" class="img-fluid">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <form action="" method="POST">
                        @csrf
                        <div class="form-outline mb-4">
                            <label class="form-label" for="id">NIS / NIP</label>
                            <input type="text" id="id" class="form-control form-control-lg" name="username" required>
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" id="password" class="form-control form-control-lg" name="password" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- jQuery -->
    <script src="/AdminLTE/plugins/jquery/jquery.min.js"></script>

    <script src="/AdminLTE/plugins/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
