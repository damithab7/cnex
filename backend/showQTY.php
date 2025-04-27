<?php

require "connection.php";

$json = $_POST["json"];

$phpOb = json_decode($json);

$pid = $phpOb->pid;
$sizeid = $phpOb->sizeid;

$resOb = new stdClass();

$size_rs = Database::search("SELECT * FROM `product_has_size` WHERE `size_id`='".$sizeid."' AND `product_id`='".$pid."'");

if($size_rs->num_rows == 1){
   $size_data = $size_rs->fetch_assoc();
   $resOb->qty = $size_data["qty"];
}

echo (json_encode($resOb));

?>