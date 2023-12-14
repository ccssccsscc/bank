<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>

    <h2>Login</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label for="FIO">ФИО:</label>
        <input type="text" name="FIO" required>

        <label for="Pincode">Пароль:</label>
        <input type="password" name="Pincode" required>

        <button type="submit">Войти</button>
    </form>


</body>
</html>
