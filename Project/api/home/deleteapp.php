<?php
include_once("../functions.php");

session_start();
database_query("DELETE FROM `API_keys` WHERE `User_ID` = ".$_SESSION["userID"]." AND `ID` = ".$_GET["id"])
header('Location: index.php');