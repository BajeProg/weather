<?php
include_once("../functions.php");
session_start();

if($_POST["reg-password"] != $_POST["confirm-password"]) header('Location: login.php?message=Пароли не совпадают');

//проверка существования пользователя
$res_query = database_query("SELECT ID FROM `Users` WHERE `Username` = '".$_POST["reg-login"]."'");
if(mysqli_num_rows($res_query) > 0) header('Location: login.php?message=Пользователь с таким логином уже зарегистрирован');

//регистрация
database_query("INSERT INTO `Users`(`Username`, `Password_hash`) VALUES ('".$_POST["reg-login"]."', '".hash("sha256", $_POST["reg-password"])."')");

session_regenerate_id(true);

$res_query = database_query("SELECT ID FROM `Users` WHERE `Username` = '".$_POST["reg-login"]."' AND `Password_hash` = '".hash("sha256", $_POST["reg-password"])."'");
$row = mysqli_fetch_assoc($res_query);

$_SESSION["userID"] = $row["ID"];

$currentDateTime = new DateTime();
$currentDateTime->modify('+1 hour');
database_query("INSERT INTO `Sessions`(`User_ID`, `Token`, `Date_end`) VALUES (".$row["ID"].", '".session_id()."', '".$currentDateTime->format('Y-m-d H:i:s')."')");

header('Location: index.php');