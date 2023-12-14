
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать BrAccount</title>
</head>
<body>

    <form method="POST" action="{{ route('createaccount') }}">
    @csrf

    <label for="balance">Баланс:</label>
        <input type="number" id="balance" name="balance" required>
        <button type="submit">Создать BrAccount</button>
    </form>
</form>
</body>
</html>