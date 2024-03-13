<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <form action="{{ route('/api/signIn') }}" method="post">
            @csrf
            <h2>Login</h2>
            <label for="id">Id:</label>
            <input type="id" name="id" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>