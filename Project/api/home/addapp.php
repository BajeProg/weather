<?php
include_once("../db_connect.php");
include_once("../functions.php");
session_start();
$currentDateTime = new DateTime();

$query = "INSERT INTO `API_keys`(`Token`, `App_name`, `User_ID`) 
    VALUES ('".hash("sha256", $_POST["appName"].session_id().$currentDateTime->format('Y-m-d H:i:s'))."', '".$_POST["appName"]."', ".$_SESSION["userID"].")";
$res_query = mysqli_query($connection, $query);
    
if(!$res_query) handle_error("Ошибка в запросе!");

header('Location: index.php');