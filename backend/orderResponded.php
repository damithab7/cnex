<?php

require "../backend/connection.php";

$json = $_POST["json"];

$reqOb = json_decode($json);

$id = $reqOb->id;

$status_rs = Database::search("SELECT * FROM `orders` WHERE `id`='".$id."'");
$status_data = $status_rs->fetch_assoc();

if($status_data["status"] == 1){
   Database::iud("UPDATE `orders` SET `status`='2' WHERE `id`='".$id."'");
   echo("success2");
}else if($status_data["status"] == 2){
   Database::iud("UPDATE `orders` SET `status`='0' WHERE `id`='".$id."'");
   echo("success0");
}else{
   Database::iud("UPDATE `orders` SET `status`='1' WHERE `id`='".$id."'");
   echo("success1");
}

?>