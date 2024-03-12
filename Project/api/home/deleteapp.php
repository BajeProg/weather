<?php
include_once("../db_connect.php");
include_once("../functions.php");

session_start();

$query = "DELETE FROM `API_keys` WHERE `User_ID` = ".$_SESSION["userID"]." AND `ID` = ".$_GET["id"];

$res_query = mysqli_query($connection, $query);
    
if(!$res_query) handle_error("Ошибка в запросе!");
header('Location: index.php');