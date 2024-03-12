<?php
include_once("getinfo.php");
include_once("functions.php");
include_once("db_connect.php");

header('Content-Type: application/json; charset=utf-8');

if(!isset($_GET["token"])){
    http_response_code(403);
    die('Forbidden');
}
if(!check_token($_GET["token"], $connection)){
    http_response_code(401);
    die('Неверно указан токен');
}


if(!isset($_GET['from'])) handle_error("Вы не указали GET параметр from!");

$query = "UPDATE `API_keys` SET `Today_calls`= `Today_calls` + 1 WHERE `Token`='".$_GET["token"]."'";
$res_query = mysqli_query($connection, $query);
if(!$res_query) handle_error("Ошибка в запросе!");

$query = "SELECT `Today_calls` FROM `API_keys` WHERE `Token`='".$_GET["token"]."'";
$res_query = mysqli_query($connection, $query);
if(!$res_query) handle_error("Ошибка в запросе!");

$row = mysqli_fetch_assoc($res_query);

if($row["Today_calls"] > 2000){
    http_response_code(401);
    die('Превышен дневной лимит запросов');
}

if(isset($_GET["location"])) $loaction = get_coords($_GET["location"]);
else $loaction = get_coords();

switch (strtolower($_GET['from'])) {
    case 'yandex':
        exit(json_encode(get_from_DB($connection, $loaction, "yandex")));

    case 'openweathermap':
        exit(json_encode(get_from_DB($connection, $loaction, "openweathermap")));

    case 'weatherapi':
        exit(json_encode(get_from_DB($connection, $loaction, "weatherapi")));

    case 'all':
        exit(json_encode(
            array(
                array(
                    "from" => "yandex",
                    "full" => "Яндекс.Погода",
                    "data" => get_yandex_wether($loaction)
                ),
                array(
                    "from" => "openweathermap",
                    "full" => "Open Weater Map",
                    "data" => get_openweathermap_wether($loaction)
                ),
                array(
                    "from" => "weatherapi",
                    "full" => "Weather API",
                    "data" => get_wetherapi_wether($loaction)
                )
            )
        ));
        break;

    case 'allfromdb':
        $serv = isset($_GET["service"]) ? $_GET["service"] : null;
        exit(json_encode(get_from_DB($connection, $loaction, $serv)));
        break;

    case 'avg':
        exit(json_encode(avg_temp($connection, $loaction)));

    default:
        handle_error("Неизвестный источник данных.");
}