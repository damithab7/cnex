<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$php_ob = json_decode($json);

$op = $php_ob->op;
$np = $php_ob->np;

$php_ob2 = new stdClass();

$u_rs = Database::search("SELECT * FROM `user` WHERE `email`='".$_SESSION["u"]["email"]."'");
$u_num = $u_rs->num_rows;

if($u_num == 1){
    $u_data = $u_rs->fetch_assoc();
    if(empty($op)){
        $php_ob2->msgo = "Fill old password";
        $json2 = json_encode($php_ob2);
        echo($json2);
    }else if(empty($np)){
        $php_ob2->msgn = "Fill new password";
        $json2 = json_encode($php_ob2);
        echo($json2);
    }else if($op != $u_data["password"]){
        $php_ob2->msgo = "Old password does not match.";
        $json2 = json_encode($php_ob2);
        echo($json2);
    }else if(strlen($np) < 5 || strlen($np) > 20){
        $php_ob2->msgn = "Password requirements does not match(characters must be between 5-20).";
        $json2 = json_encode($php_ob2);
        echo($json2);
    }else{
        Database::iud("UPDATE `user` SET `password`='".$np."' WHERE `email`='".$_SESSION["u"]["email"]."'");
        $php_ob2->msg = "success";
        $json2 = json_encode($php_ob2);
        echo($json2);
    }
}else{
    $php_ob2->error = "Invalid user";
    $json2 = json_encode($php_ob2);
    echo($json2);
}

?>