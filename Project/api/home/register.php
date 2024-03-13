<?php
include_once("../db_connect.php");
include_once("../functions.php");
session_start();

if($_POST["reg-password"] != $_POST["confirm-password"]) header('Location: login.php?message=Пароли не совпадают');

//проверка существования пользователя
$query = "SELECT ID FROM `Users` WHERE `Username` = '".$_POST["reg-login"]."'";
$res_query = mysqli_query($connection, $query);
if(!$res_query) handle_error("Ошибка в запросе!");
if(mysqli_num_rows($res_query) > 0) header('Location: login.php?message=Пользователь с таким логином уже зарегистрирован');

//регистрация
$query = "INSERT INTO `Users`(`Username`, `Password_hash`) VALUES ('".$_POST["reg-login"]."', '".hash("sha256", $_POST["reg-password"])."')";
$res_query = mysqli_query($connection, $query);
if(!$res_query) handle_error("Ошибка в запросе!");

session_regenerate_id(true);

$query = "SELECT ID FROM `Users` WHERE `Username` = '".$_POST["reg-login"]."' AND `Password_hash` = '".hash("sha256", $_POST["reg-password"])."'";
$res_query = mysqli_query($connection, $query);
if(!$res_query) handle_error("Ошибка в запросе!");

$row = mysqli_fetch_assoc($res_query);
$_SESSION["userID"] = $row["ID"];


$currentDateTime = new DateTime();
$currentDateTime->modify('+1 hour');

$query = "INSERT INTO `Sessions`(`User_ID`, `Token`, `Date_end`) VALUES (".$row["ID"].", '".session_id()."', '".$currentDateTime->format('Y-m-d H:i:s')."')";
$res_query = mysqli_query($connection, $query);
if(!$res_query) handle_error("Ошибка в запросе!");

header('Location: index.php');