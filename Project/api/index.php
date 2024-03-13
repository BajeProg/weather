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

database_query("UPDATE `API_keys` SET `Today_calls`= `Today_calls` + 1 WHERE `Token`='".$_GET["token"]."'");

$row = mysqli_fetch_assoc(database_query("SELECT `Today_calls` FROM `API_keys` WHERE `Token`='".$_GET["token"]."'"));
if($row["Today_calls"] > 2000){
    http_response_code(401);
    die('Превышен дневной лимит запросов');
}

$loaction = get_coords();

if(isset($_GET['from'])){
switch (strtolower($_GET['from'])) {
    case 'yandex':
        exit(json_encode(get_from_DB($loaction, "yandex")));

    case 'openweathermap':
        exit(json_encode(get_from_DB($loaction, "openweathermap")));

    case 'weatherapi':
        exit(json_encode(get_from_DB($loaction, "weatherapi")));

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
                    "full" => "Open Weather Map",
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
        exit(json_encode(get_from_DB($loaction, $serv)));
        break;

    default:
        handle_error("Неизвестный источник данных.");
}
}

else if(isset($_GET['analytics_type'])){
    switch (strtolower($_GET['analytics_type'])) {
        case 'avghour':
            exit(json_encode(avg_hour_temp($loaction)));
            
        case 'avgday':
            exit(json_encode(avg_day_temp($loaction)));
            
        case 'avgmonth':
            exit(json_encode(avg_month_temp($loaction)));
    
        default:
            handle_error("Неизвестный источник данных.");
    }
}

else handle_error("Не указан ни один параметр.");