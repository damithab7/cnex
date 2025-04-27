<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$resOb = json_decode($json);

$new_total = $resOb->total;

unset($_SESSION["buy"]);

$_SESSION["shipping"]["total"] = $new_total;

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d");

$d_d = new DateTime();
$tz_d = new DateTimeZone("Asia/Colombo");
$d_d->setTimezone($tz_d);

$d_date =  explode("-", $date);
$d_date[2] = $d_date[2] + 7;

$new_date = $d_d->setDate($d_date[0], $d_date[1], $d_date[2]);

$new_date2 = $new_date->format("Y-F-D-d");

$_SESSION["shipping"]["date"] = $date;
$_SESSION["shipping"]["new_date"] = $new_date2;

echo "success";
