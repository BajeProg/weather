<?php
include_once("../functions.php");
session_start();

$res_query = database_query("SELECT ID FROM `Users` WHERE `Username` = '".$_POST["login"]."' AND `Password_hash` = '".hash("sha256", $_POST["password"])."'");
if(mysqli_num_rows($res_query) == 0) header('Location: login.php?message=Пользователь не найден');

session_create_id();
$row = mysqli_fetch_assoc($res_query);
$_SESSION["userID"] = $row["ID"];

$currentDateTime = new DateTime();
$currentDateTime->modify('+1 hour');
database_query("INSERT INTO `Sessions`(`User_ID`, `Token`, `Date_end`) VALUES (".$row["ID"].", '".session_id()."', '".$currentDateTime->format('Y-m-d H:i:s')."')");
header('Location: index.php');