<?php

require "connection.php";

$json = $_POST["json"];

$php_ob = json_decode($json);

$id = $php_ob->id;

$php_ob2 = new stdClass();

$p_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $id . "'");

$p_data = $p_rs->fetch_assoc();

if ($p_data["qty"] == 0) {
   $php_ob2->msg = "noqty";
} else {
   $php_ob2->msg = "qty";
}

echo (json_encode($php_ob2));
