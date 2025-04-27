<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$reqOb = json_decode($json);

$id = $reqOb->id;
$msg = $reqOb->msg;
$type = $reqOb->type;

$resOb = new stdClass();

if(isset($_SESSION["u"])){

   $email = $_SESSION["u"]["email"];

   if(empty($msg)){
      $resOb->msg = "Empty message";
   }else if(strlen($msg) > 500){
      $resOb->msg = "Too long.";
   }else{
      $feedback_rs = Database::search("SELECT * FROM `feedback` WHERE `product_id`='".$id."' AND `user_email`='".$email."'");
      $feedback_num = $feedback_rs->num_rows;

      $d = new DateTime();
      $tz = new DateTimeZone("Asia/Colombo");
      $d->setTimezone($tz);
      $date = $d->format("Y-m-d H:i:s");

      if($feedback_num == 0){
         Database::iud("INSERT INTO `feedback` (`feedback`,`type`,`product_id`,`user_email`,`date`) VALUES ('".$msg."','".$type."','".$id."','".$email."','".$date."')");
         $resOb->msg = "success";
      }else{
         Database::iud("UPDATE `feedback` SET `feedback`='".$msg."',`type`='".$type."',`date`='".$date."' WHERE `product_id`='".$id."' AND `user_email`='".$email."'");
         $resOb->msg = "success";
      }
   }

   echo (json_encode($resOb));

}else{
   header("Location:./index.php");
}
?>