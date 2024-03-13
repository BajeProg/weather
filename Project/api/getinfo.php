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

function get_coords(){
    return array("lat" => "58.010455", "lon" => "56.229443", "geo" => "Пермь");;
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

function get_from_DB($location = null, $service = null){

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

    $res_query = database_query($query);

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    return $arr_res;
}

function avg_hour_temp($location = null){
    $arr = get_from_DB($location);
    $avg = 0;
    foreach($arr as $val) $avg += $val["Temperature"];

    $currentDateTime = new DateTime();
    $nextHourDateTime = (new DateTime())->modify('+1 hour');

    if (count($arr) == 0) $avg = null;
    else $avg = $avg / count($arr);

    return array(
        "Location" => $val["Location"], 
        "AVG" => $avg, 
        "Date_from" => $currentDateTime->format('Y-m-d H').":00:00",
        "Date_to" => $nextHourDateTime->format('Y-m-d H').":00:00"
    );
}

function avg_day_temp($location = null){
    $avg = 0;

    $currentDateTime = new DateTime();
    $nextDayDateTime = (new DateTime())->modify('+1 day');

    $res_query = database_query("SELECT `Temperature` FROM `Weather` 
    WHERE `Location`='Пермь' AND `Date` >= '".$currentDateTime->format('Y-m-d')." 00:00:00' AND `Date` < '".$nextDayDateTime->format('Y-m-d')." 00:00:00'");

    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        $avg = $avg + $row["Temperature"];
    }

    if ($row == 0) $avg = null;
    else $avg = $avg / $rows;

    return array(
        "Location" => "Пермь", 
        "AVG" => $avg, 
        "Date_from" => $currentDateTime->format('Y-m-d')." 00:00:00",
        "Date_to" => $nextDayDateTime->format('Y-m-d')." 00:00:00"
    );
}


function avg_month_temp($location = null){
    $avg = 0;

    $currentDateTime = new DateTime();
    $nextMonthDateTime = (new DateTime())->modify('+1 month');

    $res_query = database_query("SELECT `Temperature` FROM `Weather` 
    WHERE `Location`='Пермь' AND `Date` >= '".$currentDateTime->format('Y-m')."-01 00:00:00' AND `Date` < '".$nextMonthDateTime->format('Y-m')."-01 00:00:00'");

    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        $avg = $avg + $row["Temperature"];
    }

    if ($row == 0) $avg = null;
    else $avg = $avg / $rows;

    return array(
        "Location" => "Пермь", 
        "AVG" => $avg, 
        "Date_from" => $currentDateTime->format('Y-m')."-01 00:00:00",
        "Date_to" => $nextMonthDateTime->format('Y-m')."-01 00:00:00"
    );
}