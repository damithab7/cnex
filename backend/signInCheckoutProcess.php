<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$obj = json_decode($json);

$email = $obj->email;
$password = $obj->password;
$rememberme = $obj->rememberme;

$pid = $_SESSION["p"]["pid"];

$phpObj = new stdClass;

if(empty($email) && empty($password)){

   $phpObj->epLoginText = "Invalid email or password";
   $obj2 = json_encode($phpObj);
   echo($obj2);


}else if (empty($email)) {

   $phpObj->lemailText = "Enter your email";
   $obj2 = json_encode($phpObj);
   echo($obj2);

} else if (strlen($email) >= 100) {

   $phpObj->lemailText = "Email does not have 100 characters.";
   $obj2 = json_encode($phpObj);
   echo($obj2);

} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

   $phpObj->lemailText = "Invalid email";
   $obj2 = json_encode($phpObj);
   echo($obj2);

} else if (empty($password)) {

   $phpObj->pText = "Enter your password";
   $obj2 = json_encode($phpObj);
   echo($obj2);

}else
{

   $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "' AND `password`='" . $password . "'");

   $user_num = $user_rs->num_rows;

   if ($user_num == 1) {

      $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='".$pid."'");
      $product_data = $product_rs->fetch_assoc();

      if($product_data["qty"] <= 1){

         $phpObj->spText = $pid;
         $obj2 = json_encode($phpObj);
         echo($obj2);

      }else{

         $phpObj->sText = $pid;
         $obj2 = json_encode($phpObj);
         echo($obj2);

      }

      $user_data = $user_rs->fetch_assoc();

      $_SESSION["u"] = $user_data;

      if($rememberme == "true")
      {

         setcookie("email",$email,time() + (60*60*24*365), '/');
         setcookie("password",$password,time() + (60*60*24*365), '/');

      }else
      {

         setcookie("email","",-1);
         setcookie("password","",-1);

      }
     
   } else {

      $phpObj->epLoginText = "Invalid email or password";
      $obj2 = json_encode($phpObj);
      echo($obj2);

   }
}


