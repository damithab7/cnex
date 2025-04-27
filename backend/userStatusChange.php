<?php

require "../backend/connection.php";

$json = $_POST["json"];

$resOb = json_decode($json);

$email = $resOb->email;

$user_rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."'");

if($user_rs->num_rows == 1){

   $user_data = $user_rs->fetch_assoc();

   if($user_data["status"] == 1){
      Database::iud("UPDATE `user` SET `status`='0' WHERE `email`='".$email."'");
      echo ("success0");
   }else{
      Database::iud("UPDATE `user` SET `status`='1' WHERE `email`='".$email."'");
      echo ("success1");
   }

}else{

}

?>