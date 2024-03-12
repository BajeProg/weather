<?php

function check_token($token, $connection){
    $query = "SELECT `ID` FROM `API_keys` WHERE `Token` = '".$token."'";
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

return mysqli_num_rows($res_query) > 0;
}

function ajax_echo(
    $title = '',
    $desc = '',
    $error = true,
    $type = 'ERROR',
    $other = null
){
    return json_encode(array(
        "error" => $error,
        "type" => $type,
        "title" => $title,
        "desc" => $desc,
        "other" => $other,
        "datetime" => array(
            'Y' => date('Y'),
            'm' => date('m'),
            'd' => date('d'),
            'H' => date('H'),
            'i' => date('i'),
            's' => date('s'),
            'full' => date('Y-m-d H:i:s')
        )));
};