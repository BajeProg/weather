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


if(!isset($_GET['from'])){
    echo ajax_echo(
        "Ошибка!",
        "Вы не указали GET параметр from!",
        "ERROR",
        null
    );
    exit;
}

$query = "UPDATE `API_keys` SET `Today_calls`= `Today_calls` + 1 WHERE `Token`='".$_GET["token"]."'";
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

$query = "SELECT `Today_calls` FROM `API_keys` WHERE `Token`='".$_GET["token"]."'";
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
$row = mysqli_fetch_assoc($res_query);

if($row["Today_calls"] > 2000){
    http_response_code(401);
    die('Превышен дневной лимит запросов');
}

if(preg_match_all("/^yandex$/ui", $_GET['from'])){
    exit(json_encode(get_yandex_wether()));
}

if(preg_match_all("/^openweathermap$/ui", $_GET['from'])){
    exit(json_encode(get_openweathermap_wether()));
}

if(preg_match_all("/^wetherapi$/ui", $_GET['from'])){
    exit(json_encode(get_wetherapi_wether()));
}

if(preg_match_all("/^all$/ui", $_GET['from'])){
    $geo = get_coords("Пермь");
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
}

if(preg_match_all("/^allfromdb$/ui", $_GET['from'])){
    $loc = isset($_GET["location"]) ? $_GET["location"] : null;
    $serv = isset($_GET["service"]) ? $_GET["service"] : null;
    exit(json_encode(get_from_DB($connection, $loc, $serv)));
}