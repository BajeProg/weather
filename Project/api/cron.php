<?php
include_once("db_connect.php");
include_once("functions.php");

$data = json_decode(file_get_contents("https://otakuclique.ru/api/?from=all&token=eeb9a0ca6dfc7c20c89ece32178fb221e7c93723f4dd3ce10a60cc80333bc1bf"));

$query = "";
foreach($data as $value){
    $query = $query."INSERT INTO `Weather`(`Location`, `Temperature`, `Service`, `ServiceFullName`, `Condition`, `Image`) 
    VALUES ('".$value->data->geo."', ".$value->data->temp.", '".$value->from."', '".$value->full."', '".$value->data->condition."', '".$value->data->img."');";
}

$result = mysqli_multi_query($connection, $query);

if(!$result){
    echo ajax_echo(
        "Ошибка!", 
        "Ошибка в запросе!",
        true,
        "ERROR",
        null
    );
    exit();
}

$res = mysqli_fetch_assoc($result);
    if($res["RESULT"] == "0"){
        echo ajax_echo(
            "Ошибка!", 
            "Не удалось добавить запись!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    echo ajax_echo(
        "Успех!", 
        "Данные загружены",
        false,
        "SUCCESS"
    );
    exit();