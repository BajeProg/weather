<?php
include_once("db_connect.php");
include_once("functions.php");

$data = json_decode(file_get_contents("https://otakuclique.ru/api/?from=all&token=eeb9a0ca6dfc7c20c89ece32178fb221e7c93723f4dd3ce10a60cc80333bc1bf&location=Пермь"));

$query = "";
foreach($data as $value){
    $query = $query."INSERT INTO `Weather`(`Location`, `Temperature`, `Service`, `ServiceFullName`, `Condition`, `Image`) 
    VALUES ('".$value->data->geo."', ".$value->data->temp.", '".$value->from."', '".$value->full."', '".$value->data->condition."', '".$value->data->img."');";
}

$result = mysqli_multi_query($connection, $query);

if(!$result) handle_error("Ошибка в запросе!");

$res = mysqli_fetch_assoc($result);
    if($res["RESULT"] == "0") handle_error("Не удалось добавить запись!");

    echo ajax_echo(
        "Успех!", 
        "Данные загружены",
        false,
        "SUCCESS"
    );
    exit();