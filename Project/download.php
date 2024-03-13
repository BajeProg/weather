<?php
include_once("./api/functions.php");
include_once("./api/getinfo.php");

$data = get_from_DB();
download_send_headers("data_export_" . date("Y-m-d") . ".csv");
echo array2csv($data);
die();