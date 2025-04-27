<?php
session_start();

require "connection.php";

$json = $_POST["json"];

$php_ob = json_decode($json);

$fname = $php_ob->fname;
$lname = $php_ob->lname;

$php_ob2 = new stdClass();

$user_rs = Database::search("SELECT * FROM `user` WHERE `email`='".$_SESSION["u"]["email"]."'");
$user_num = $user_rs->num_rows;

if($user_num == 1){
    if(empty($fname)){
        $php_ob2->msg = "Cannot Allow empty fields.";
        $json2 = json_encode($php_ob2);
        echo($json2);
    }else if(empty($lname)){
        $php_ob2->msg1 = "Cannot Allow empty fields.";
        $json2 = json_encode($php_ob2);
        echo($json2);
    }else{
        Database::iud("UPDATE `user` SET `fname`='".$fname."',`lname`='".$lname."' WHERE `email`='".$_SESSION["u"]["email"]."'");
        $php_ob2->success = "success";
        $json2 = json_encode($php_ob2);
        echo($json2);
    }
}else{
    header("Location:home.php");
}

?>