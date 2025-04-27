<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$obj = json_decode($json);

$email = $obj->email;
$password = $obj->password;
$rememberme = $obj->rememberme;

$phpObj = new stdClass;
if (empty($email) && empty($password)) {

   $phpObj->epLoginText = "Invalid email or password";
} else if (empty($email)) {

   $phpObj->lemailText = "Enter your email";
} else if (strlen($email) >= 100) {

   $phpObj->lemailText = "Email does not have 100 characters.";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

   $phpObj->lemailText = "Invalid email";
} else if (empty($password)) {

   $phpObj->pText = "Enter your password";
} else {

   $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "' AND `password`='" . $password . "'");

   $user_num = $user_rs->num_rows;

   if ($user_num == 1) {

      $user_data = $user_rs->fetch_assoc();

      if ($user_data["status"] == 1) {

         $phpObj->sText = "success";

         $_SESSION["u"] = $user_data;

         if ($rememberme == "true") {

            setcookie("email", $email, time() + (60 * 60 * 24 * 365), '/');
            setcookie("password", $password, time() + (60 * 60 * 24 * 365), '/');
         } else {

            setcookie("email", "", -1);
            setcookie("password", "", -1);
         }
      } else {
         $phpObj->msg = "Blocked User!";
      }
   } else {

      $phpObj->epLoginText = "Invalid email or password";
   }
}

echo (json_encode($phpObj));
