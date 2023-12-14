<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
</head>
<body>

<h2>Регистрация</h2>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <label for="FIO">ФИО:</label>
    <input type="text" name="FIO" required>

    <label for="lizo">Тип лица:</label>
    <select name="lizo" required>
        <option value="fiz">Физическое лицо</option>
        <option value="yr">Юридическое лицо</option>
    </select>

    <label for="Pincode">Пароль:</label>
    <input type="password" name="Pincode" required>

    <label for="Pincode_confirmation">Подтверждение пароля:</label>
    <input type="password" name="Pincode_confirmation" required>

    <label for="AllBalance">Общий баланс:</label>
    <input type="number" name="AllBalance" required>

    <label for="role">Роль:</label>
    <select name="role" required>
        <option value="admin">Администратор</option>
        <option value="user">Пользователь</option>
    </select>

    <button type="submit">Зарегистрироваться</button>
</form>

</body>
</html>