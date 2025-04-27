<?php

session_start();

require "connection.php";

$name = $_SESSION["au"]["fname"];
$lname = $_SESSION["au"]["lname"];

$php_ob = new stdClass();

if (isset($_SESSION["au"])) {

   if (isset($_FILES["file"])) {
      $image = $_FILES["file"];

      $allowed_ex = array("image/jpg", "image/png", "image/jpeg", "image/svg+xml");

      $image_ex = $image["type"];


      if (!in_array($image_ex, $allowed_ex)) {
         echo ("Please select a valid image");
      } else {
         $new_ex;
         if ($image_ex == "image/jpg") {
            $new_ex = ".jpg";
         } else if ($image_ex == "image/png") {
            $new_ex = ".png";
         } else if ($image_ex == "image/jpeg") {
            $new_ex = ".jpeg";
         } else if ($image_ex == "image/svg+xml") {
            $new_ex = ".svg";
         }

         $new_file_name = "../style/resources/profile_images/pixiebakes" . $name . $lname . uniqid() . $image["name"] . $new_ex;

         move_uploaded_file($image["tmp_name"], $new_file_name);

         $user_image = Database::search("SELECT * FROM `admin` WHERE `user_email`='" . $_SESSION["au"]["email"] . "'");

         if ($user_image->num_rows == 0) {
            Database::iud("INSERT INTO `admin` (`path`,`user_email`) VALUES ('" . $new_file_name . "','" . $_SESSION["au"]["email"] . "')");
            $php_ob->msg = "inserted";
         } else {
            Database::iud("UPDATE `admin` SET `path`='" . $new_file_name . "' WHERE `user_email`='" . $_SESSION["au"]["email"] . "'");
            $php_ob->msg = "updated";
         }

         echo (json_encode($php_ob));
      }
   }
} else {
   header("Location:../index.php");
}
