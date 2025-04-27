<?php

require "connection.php";

$size_json = $_POST["qtysized"];

$phpob2 = json_decode($size_json);

$pid = $phpob2->pid;
$sid = $phpob2->sid;

$phpob1 = new stdClass();

$p_rs = Database::search("SELECT * FROM `product_has_size` WHERE `product_id`='" . $pid . "' AND `size_id`='" . $sid . "'");

if ($p_rs->num_rows == 1) {

   Database::iud("DELETE FROM `product_has_size` WHERE `product_id`='" . $pid . "' AND `size_id`='" . $sid . "'");

}

$phpob1->msg = "success";

echo (json_encode($phpob1));
