<?php

session_start();

$json = $_POST["json"];

$php_ob = json_decode($json);

$id = $php_ob->id;
$php_ob2 = new stdClass();

$_SESSION["p"]["pid"] = $id;

if(isset($_SESSION["u"])){
   $php_ob2->msg = "user";
   echo (json_encode($php_ob2));
}else{
   $php_ob2->msg = "nouser";
   echo (json_encode($php_ob2));
}

?>