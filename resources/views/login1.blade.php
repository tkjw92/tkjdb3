<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>

<body>
    <form action="" method="POST">
        @csrf
        <label>
            username
            <input type="text" name="username" required>
        </label>

        <br>

        <label>
            password
            <input type="password" name="password" required>
        </label>

        <br>

        <button type="submit">Login</button>
    </form>
</body>

</html>
