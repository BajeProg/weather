<?php
include_once("../functions.php");
session_start();
if(!isset($_SESSION["userID"])) header('Location: login.php');

$currentDateTime = new DateTime();
$query = "SELECT `ID` FROM `Sessions` WHERE `Token` = '".session_id()."' AND `Date_end` > '".$currentDateTime->format('Y-m-d H:i:s')."'";
if(mysqli_num_rows(database_query($query)) == 0){ 
    $message = "";
    if(isset($_SESSION["userID"])) $message = "?message=Время сессии истекло";
    session_unset();   // Remove the $_SESSION variable information.
    session_destroy(); // Remove the server-side session information.
    // Unset the cookie on the client-side.
    setcookie("PHPSESSID", "", 1); // Force the cookie to expire.
    session_start();
    session_regenerate_id(true);
    header('Location: login.php'.$message);
}

$currentDateTime->modify('+1 hour');
database_query("UPDATE `Sessions` SET `Date_end`='".$currentDateTime->format('Y-m-d H:i:s')."' WHERE `Token` = '".session_id()."'");

$res_query = database_query("SELECT * FROM `API_keys` WHERE `User_ID` = ".$_SESSION["userID"]);
$arr_res = array();
$rows = mysqli_num_rows($res_query);

for ($i=0; $i < $rows; $i++){
    $row = mysqli_fetch_assoc($res_query);
    array_push($arr_res, $row);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Прогноз погоды</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        .app-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .app-actions img {
            width: 32px;
            height: 32px;
        }

        .app-actions form {
            width: 50px;
            height: 50px;
        }

        .app-actions button {
            background-color: transparent;
            border: none;
        }

        .app-actions button :hover {
            border: 1px solid #ccc;
        }

        .app-info {
            flex: 1;
        }

        .app-info h2 {
            margin: 0;
        }

        .app-info p {
            margin: 5px 0;
        }

        form.add-form {
            display: none;
            margin-top: 20px;
        }

        form.add-form input[type="text"] {
            width: 70%;
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form.add-form button {
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        form.add-form button.cancel {
            background-color: #f44336;
        }
    </style>
</head>
<body>
<a href="logout.php">Выход</a>
<div class="container">
    <h1>Ваши API ключи</h1>

    <?foreach($arr_res as $value){?>
    <div class="app-card">
        <div class="app-info">
            <h2><?echo $value["App_name"];?></h2>
            <p>Ключ: <?echo $value["Token"];?></p>
            <p>Вызовов за сегодня: <?echo $value["Today_calls"];?>/2000</p>
        </div>
        <div class="app-actions">
            <form action="deleteapp.php" method="get">
                <input type="hidden" name="id" value="<?echo $value["ID"];?>"/>
                <button type="submit"><img src="../../icons/remove.png" alt="удалить"/></button>
            </form>
        </div>
    </div>
    <?}?>

    <button onclick="toggleForm('add-form')">Добавить</button>

    <form class="add-form" action="addapp.php" method="post" style="display: none;">
        <input type="text" name="appName" autocomplete="off" placeholder="Название вашего приложения" required/>
        <button type="submit">Добавить</button>
    </form>
</div>

<script>
    function toggleForm(formClass) {
        var form = document.querySelector('.' + formClass);
        var button = document.querySelector('button.' + formClass);

        if (form.style.display === 'none') {
            form.style.display = 'block';
            button.textContent = 'Отменить';
            button.classList.add('cancel');
        } else {
            form.style.display = 'none';
            button.textContent = 'Добавить';
            button.classList.remove('cancel');
        }
    }
</script>

</body>
</html>