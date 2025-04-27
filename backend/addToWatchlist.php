<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$PHP_Object = json_decode($json);

$id = $PHP_Object->id;

$msg_ob = new stdClass();

$watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `product_id`='".$id."' AND `user_email`='".$_SESSION["u"]["email"]."';");

$watchlist_num = $watchlist_rs->num_rows;

$watchlist_data = $watchlist_rs->fetch_assoc();

if($watchlist_num == 1){
    Database::iud("DELETE FROM `watchlist` WHERE `product_id`='".$id."' AND `user_email`='".$_SESSION["u"]["email"]."';");
    $msg_ob->msg = "remove";
    $json1 = json_encode($msg_ob);
    echo($json1);
}else{
    Database::iud("INSERT INTO `watchlist` (`product_id`,`user_email`)
    VALUES ('".$id."','".$_SESSION["u"]["email"]."')");
    $msg_ob->msg = "add";
    $json1 = json_encode($msg_ob);
    echo($json1);
}

?>