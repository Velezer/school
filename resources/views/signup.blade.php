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
        <form action="{{ route('/api/signUp') }}" method="post">
            @csrf
            <h2>Sign Up</h2>
            <label for="id">Id:</label>
            <input type="id" name="id" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="ADMIN">ADMIN</option>
                <option value="TEACHER">TEACHER</option>
                <option value="STUDENT">STUDENT</option>
            </select>
            <button type="submit">Sign Up</button>
        </form>
    </div>
</body>

</html>