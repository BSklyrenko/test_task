<?php
require_once("model/model.php");
require_once("model/DbConnect.php");
$db = new DbConnect("localhost", "task", "root", "root");

date_default_timezone_set("Europe/Moscow");

$data = json_decode($_POST['request']);

$valuesList = ["id", "name", "message", "email", "date_created"];
$dataList = [getGUID(), $data->name, $data->message, $data->email, date("Y-m-d H:i:s")];
$db->insert_values("task_table", $valuesList, $dataList);

echo "Ok";
 ?>
