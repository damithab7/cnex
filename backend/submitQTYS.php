<?php

session_start();

require "connection.php";

if(isset($_SESSION["qty"])){
   $_SESSION["qty"];
}else{
   $_SESSION["qty"] = 0;
}

$size_json = $_POST["qtysize"];

$phpob2 = json_decode($size_json);

$pid = $phpob2->pid;
$sid = $phpob2->sid;
$qty = $phpob2->qty;

$phpob = new stdClass();

$_SESSION["qty"] = $_SESSION["qty"] + $qty;

Database::iud("INSERT INTO `product_has_size` (`product_id`,`size_id`,`qty`)
VALUES ('" . $pid . "','" . $sid . "','" . $qty . "');");

Database::iud("UPDATE `product` SET `qty`='".$_SESSION["qty"]."' WHERE `id`='".$pid."'");

$phpob->msg = "success";
echo (json_encode($phpob));


?>
