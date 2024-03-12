<?php
include_once("dadata.php");
include_once("tokens.php");

function get_openweathermap_wether($geo = null){

    global $tokens;
    if($geo == null) $geo = get_coords();

    $sURL = "https://api.openweathermap.org/data/2.5/weather?lat=".$geo["lat"]."&lon=".$geo["lon"]."&appid=".$tokens["openweathermap"]."&units=metric&lang=ru";
    $data = json_decode(file_get_contents($sURL));


    return array(
        "geo" => $geo['geo'],
        "temp" => $data->main->temp,
        "condition" => $data->weather[0]->main,
        "img" => "https://openweathermap.org/img/w/".$data->weather[0]->icon.".png"
    );
}

function get_yandex_wether($geo = null){

    global $tokens;
    if($geo == null) $geo = get_coords();

    $opts = array(
        'http' => array(
        'method' => 'GET',
        'header' => 'X-Yandex-Weather-Key: ' . $tokens["yandex"]
        )
    );

    $context = stream_context_create($opts);

    $file = 
    file_get_contents('https://api.weather.yandex.ru/v2/fact?lat='.$geo["lat"].'&lon='.$geo["lon"], 
    false, $context);

    $data = json_decode($file);

    return array(
        "geo" => $geo['geo'],
        "temp" => $data->temp,
        "condition" => $data->condition,
        "img" => "https://yastatic.net/weather/i/icons/funky/light/".$data->icon.".svg"
    );

}

function get_coords($from = null){

    global $tokens;
    $token = $tokens["dadata-token"];
    $secret = $tokens["dadata-secret"];
    $dadata = new Dadata($token, $secret);
    $dadata->init();
    if($from == null) {
        $data = $dadata->iplocate($_SERVER["REMOTE_ADDR"]);
        if($data['location'] == null) exit("Не удалось определить ваше местоположение");

        $data = $data['location']['data'];
        $result = array("lat" => $data['geo_lat'], "lon" => $data['geo_lon'], "geo" => $data['city']);
    }
    else{ 
        $data = $dadata->clean("address", $from);
        $city = $data[0]['city'] == null ? $data[0]['region'] : $data[0]['city'];
        $result = array("lat" => $data[0]['geo_lat'], "lon" => $data[0]['geo_lon'], "geo" => $city);
    }
    $dadata->close();
    return $result;
}

function get_wetherapi_wether($geo = null){

    global $tokens;
    if($geo == null) $geo = get_coords();

    $sURL = "https://api.weatherapi.com/v1/current.json?key=".$tokens["wetherapi"]."&q=".$geo["lat"].",".$geo["lon"]."&lang=ru";
    $data = json_decode(file_get_contents($sURL));


    return array(
        "geo" => $geo['geo'],
        "temp" => $data->current->temp_c,
        "condition" => $data->current->condition->text,
        "img" => $data->current->condition->icon
    );
}

function get_from_DB($connection, $location = null, $service = null){

    if($location == null) $location = get_coords();

    if($service == null)
    $query = "SELECT w.*
    FROM `Weather` w
    JOIN (
        SELECT `Service`, MAX(`Date`) AS max_date
        FROM `Weather`
        WHERE `Location` = '".$location["geo"]."'
        GROUP BY `Service`
    ) t ON w.`Service` = t.`Service` AND w.`Date` = t.`max_date`
    WHERE `Location` = '".$location["geo"]."'";

    else $query = "SELECT * FROM `Weather` WHERE `Location` = '".$location["geo"]."' AND `Service` = '".$service."' ORDER BY `Date` DESC LIMIT 1";

    $res_query = mysqli_query($connection, $query);

    if(!$res_query) handle_error("Ошибка в запросе!");

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    return $arr_res;
}

function avg_temp($connection, $location = null){
    $arr = get_from_DB($connection, $location);
    $avg = 0;
    foreach($arr as $val) $avg += $val["Temperature"];

    if(count($arr) > 0) return array("Location" => $val["Location"], "AVG" => $avg / count($arr));
    else return array("Location" => $val["Location"], "AVG" => null);
}