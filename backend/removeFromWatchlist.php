<?php
session_start();
require "connection.php";

$json = $_POST["json"];

$php_ob = json_decode($json);

$id = $php_ob->id;

$php_ob2 = new stdClass();

Database::search("DELETE FROM `watchlist` WHERE `user_email`='".$_SESSION["u"]["email"]."' AND `product_id`='".$id."'");

$php_ob2->msg = "success";
$json2 = json_encode($php_ob2);
echo($json2);
?>