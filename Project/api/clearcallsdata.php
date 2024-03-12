<?php
include_once("db_connect.php");
include_once("functions.php");

$query = "UPDATE `API_keys` SET `Today_calls`= 0";
$res_query = mysqli_query($connection, $query);
if(!$res_query) handle_error("Ошибка в запросе!");