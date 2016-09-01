<?php
require_once("model/Curl.php");
$ch = new Curl("localhost:122/ImportantProjects/app2/index.php");

$response = $ch->getFullInfo($_POST);

if($response['content'] == 'Ok') {
  include("views/success.php");
} else {
  include("views/failed.php");
}


 ?>
