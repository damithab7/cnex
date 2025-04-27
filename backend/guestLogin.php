<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$php_ob = json_decode($json);

$resOb = new stdClass();

$email = $php_ob->email;

$user_rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."'");

if($user_rs->num_rows == 1){
   $resOb->msg = "Invalid Email";
   echo (json_encode($resOb));
}else{
   if(empty($email)){
      $resOb->msg = "This is cannot be empty";
   }else if(strlen($email) > 100){
      $resOb->msg = "Invalid Email";
   }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      $resOb->msg = "Invalid Email";
   }else{
      $_SESSION["gu"]["email"] = $email;
      $resOb->msg = "success";
   }

   echo (json_encode($resOb));

}

?>