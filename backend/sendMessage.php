<?php

require "connection.php";

session_start();

$json = $_POST["json"];

$reqOb = json_decode($json);

$msg = $reqOb->msg;
$rmail = $reqOb->rmail;

$from = $_SESSION["au"]["email"];

$resOb = new stdClass();

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");

if(strlen($msg) > 5000){
   $resOb->msg = "Too long.";
}else if(empty($msg)){
   $resOb->MSG = "Empty Message!";
}else{
   Database::iud("INSERT INTO `chat` (`from`,`to`,`status`,`content`,`date_time`)
   VALUES ('".$from."','".$rmail."','0','".$msg."','".$date."');");
   $resOb->msg = "success";
}

echo (json_encode($resOb));

?>