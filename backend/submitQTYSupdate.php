<?php

session_start();

require "connection.php";

$size_json = $_POST["qtysize"];

$phpob2 = json_decode($size_json);

$pid = $phpob2->pid;
$sid = $phpob2->sid;
$qty = $phpob2->qty;

$phpob = new stdClass();

$phs_rs = Database::search("SELECT * FROM `product_has_size` WHERE `product_id`='".$pid."' AND `size_id`='".$sid."'");
$phs_num = $phs_rs->num_rows;

if(isset($_SESSION["qty"])){
   $_SESSION["qty"];
}else{
   $_SESSION["qty"] = 0;
}

$_SESSION["qty"] = $_SESSION["qty"] + $qty;

Database::iud("UPDATE `product` SET `qty`='".$_SESSION["qty"]."' WHERE `id`='".$pid."'");

if($phs_num == 1){

   Database::iud("UPDATE `product_has_size` SET `qty`='".$qty."' WHERE `size_id`='".$sid."' AND `product_id`='".$pid."' ");
   $phpob->msg = "success";

}else{

   Database::iud("INSERT INTO `product_has_size` (`product_id`,`size_id`,`qty`)
   VALUES ('" . $pid . "','" . $sid . "','" . $qty . "');");
   $phpob->msg = "success";

}

echo (json_encode($phpob));

?>
