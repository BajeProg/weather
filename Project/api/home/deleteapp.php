<?php
include_once("../db_connect.php");
include_once("../functions.php");

session_start();

$query = "DELETE FROM `API_keys` WHERE `User_ID` = ".$_SESSION["userID"]." AND `ID` = ".$_GET["id"];

$res_query = mysqli_query($connection, $query);
    
if(!$res_query){
    echo ajax_echo(
        "Ошибка!", 
        "Ошибка в запросе!",
        true,
        "ERROR",
        null
    );
    exit();
}
header('Location: index.php');