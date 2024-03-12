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

$loaction = null;
if(isset($_GET["location"])) $loaction = get_coords($_GET["location"]);

switch (strtolower($_GET['from'])) {
    case 'yandex':
        exit(json_encode(get_yandex_wether($loaction)));

    case 'openweathermap':
        exit(json_encode(get_openweathermap_wether($loaction)));

    case 'weatherapi':
        exit(json_encode(get_wetherapi_wether($loaction)));

    case 'all':
        if($loaction == null) $geo = get_coords("Пермь");
        else $geo = $loaction;
        exit(json_encode(
            array(
                array(
                    "from" => "yandex",
                    "full" => "Яндекс.Погода",
                    "data" => get_yandex_wether($geo)
                ),
                array(
                    "from" => "openweathermap",
                    "full" => "Open Weater Map",
                    "data" => get_openweathermap_wether($geo)
                ),
                array(
                    "from" => "weatherapi",
                    "full" => "Weather API",
                    "data" => get_wetherapi_wether($geo)
                )
            )
        ));
        break;

    case 'allfromdb':
        $loc = isset($_GET["location"]) ? $_GET["location"] : null;
        $serv = isset($_GET["service"]) ? $_GET["service"] : null;
        exit(json_encode(get_from_DB($connection, $loc, $serv)));
        break;

    default:
        handle_error("Неизвестный источник данных.");
}