<?php

session_start();

require "connection.php";

$phpObj = new stdClass();

if(isset($_SESSION["u"])){

   $user_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='".$_SESSION["u"]["email"]."'");

   $user_num = $user_rs->num_rows;

   if($user_num == 0){

      $phpObj->fText = "user not filled address data";
      $json = json_encode($phpObj);
      echo($json);

   }else{

      $phpObj->sText = "success";
      $json = json_encode($phpObj);
      echo($json);
      
   }

}else{

}

?>