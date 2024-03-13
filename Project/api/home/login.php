<?php
include_once("../functions.php");
session_start();

$currentDateTime = new DateTime();
$query = "SELECT `ID` FROM `Sessions` WHERE `Token` = '".session_id()."' AND `Date_end` > '".$currentDateTime->format('Y-m-d H:i:s')."'";
if(mysqli_num_rows(database_query($query)) > 0) header('Location: index.php');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница входа</title>
    <style>
        .login-form, .register-form {
            display: none;
        }
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background-color: #f4f4f4;
}

#welcome-message {
    text-align: center;
    margin-bottom: 20px;
}

button {
    padding: 10px;
    font-size: 16px;
    margin: 5px;
    cursor: pointer;
    width: 200px;
}

p{
    color: #c88;
}

form {
    width: 300px;
    padding: 20px;
    border: 1px solid #ccc;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
}

label {
    margin-top: 10px;
}

input {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

button[type="submit"] {
    background-color: #4caf50;
    color: #fff;
    border: none;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #45a049;
}

    </style>
</head>
<body>

    <div id="welcome-message">
        <h1>Добро пожаловать!</h1>
        <?if(isset($_GET["message"])) echo "<p>".$_GET["message"]."</p>";?>
        <button onclick="showLoginForm()">Войти</button>
        <button onclick="showRegisterForm()">Зарегистрироваться</button>
    </div>

    <form id="login-form" class="login-form" action="signin.php" method="post">
        <h2>Форма входа</h2>
        <label for="login">Логин:</label>
        <input type="text" id="login" name="login" required>
        <br>
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Войти</button>
        <button onclick="goBack()">Назад</button>
    </form>

    <form id="register-form" class="register-form" action="register.php" method="post">
        <h2>Форма регистрации</h2>
        <label for="reg-login">Логин:</label>
        <input type="text" id="reg-login" name="reg-login" required>
        <br>
        <label for="reg-password">Пароль:</label>
        <input type="password" id="reg-password" name="reg-password" required>
        <br>
        <label for="confirm-password">Повторите пароль:</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
        <br>
        <button type="submit">Зарегистрироваться</button>
        <button onclick="goBack()">Назад</button>
    </form>

    <script>
        function showLoginForm() {
            document.getElementById('welcome-message').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
            document.getElementById('register-form').style.display = 'none';
        }

        function showRegisterForm() {
            document.getElementById('welcome-message').style.display = 'none';
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'block';
        }

        function goBack() {
            document.getElementById('welcome-message').style.display = 'block';
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'none';
        }
    </script>

</body>
</html>
