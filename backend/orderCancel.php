<?php

require "../backend/connection.php";

$json = $_POST["json"];

$reqOb = json_decode($json);

$id = $reqOb->id;

Database::iud("UPDATE `orders` SET `status`='0' WHERE `id`='".$id."'");

echo("success");

?>