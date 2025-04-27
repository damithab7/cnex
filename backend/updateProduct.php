<?php

session_start();

require "../backend/connection.php";

$json = $_POST["json"];

$php_ob = json_decode($json);

$img_num = $php_ob->img_num;
$pid = $php_ob->id;
$collection = $php_ob->collection;
$title = $php_ob->title;
$qty = $php_ob->qty;
$price = $php_ob->price;
$dca = $php_ob->dca;
$dcoa = $php_ob->dcoa;
$description = $php_ob->description;

if (!isset($_SESSION["u"])) {
   header("Location:../home.php");
} else {

   $email = $_SESSION["u"]["email"];

   $resOb = new stdClass();

   if ($collection == 0) {
      $resOb->collection = "Please select a category";
   } else if (empty($title)) {
      $resOb->title = "Add a title";
   } else if (strlen($title) > 45) {
      $resOb->title = "Long Title";
   } else if (strlen($qty) == 0) {
      $resOb->qty = "Invalid QTY";
   } else if (empty($price)) {
      $resOb->price = "Empty Price";
   } else if ($price <= 0) {
      $resOb->price = "Invalid Product Value";
   } else if ($dca < 0) {
      $resOb->dca = "Invalid delivery value. If it's free insert 0";
   } else if (!is_numeric($dca)) {
      $resOb->dca = "Invalid input for delivery cost";
   } else if (!is_numeric($dcoa)) {
      $resOb->dcoa = "Invalid input for delivery cost out of Anuradhapura";
   } else if ($dcoa < 0) {
      $resOb->dcoa = "Invalid delivery value. If it's free insert 0";
   } else if (empty($description)) {
      $resOb->description = "Empty Description";
   } else {

      $image_len = sizeof($_FILES);

      $image_rs = Database::search("SELECT * FROM `product_image` WHERE `product_id`='" . $pid . "'");

      if ($dca == 0) {
         $dca = "Free";
      }

      if ($dcoa == 0) {
         $dcoa = "Free";
      }

      if (isset($_FILES["mainImage"])) {

         $d = new DateTime();
         $tz = new DateTimeZone("Asia/Colombo");
         $d->setTimezone($tz);
         $date = $d->format("Y-m-d H:i:s");

         $db_time = strtotime($date);
         $new_date = date("YmdHis", $db_time);

         $file  = $_FILES["mainImage"];
         $file_type = $file["type"];

         $allow_img_ex = array("image/jpeg", "image/png", "image/svg+xml", "image/jpg");

         if (in_array($file_type, $allow_img_ex)) {
            $new_file_ex;
            if ($file_type == "image/png") {
               $new_file_ex = ".png";
            } else if ($file_type == "image/jpg") {
               $new_file_ex = ".jpg";
            } else if ($file_type == "image/jpeg") {
               $new_file_ex = ".jpeg";
            } else if ($file_type == "image/svg+xml") {
               $new_file_ex = ".svg";
            }

            $new_file_name = "../style/resources/product_images/" . $title . $product_id . $new_date . $new_file_ex;

            $new_file_path = "style/resources/product_images/" . $title . $product_id . $new_date . $new_file_ex;

            move_uploaded_file($file["tmp_name"], $new_file_name);

            Database::iud("UPDATE `product` SET 
            `category_id`='" . $category . "',
            `price`='" . $price . "',
            `qty`='" . $qty . "',
            `description`='" . $description . "',
            `title`='" . $title . "',
            `delivery_fee_badulla`='" . $dca . "',
            `delivery_fee_other`='" . $dcoa . "',
            `updated_user`='" . $email . "' WHERE `id`='" . $pid . "'");

            Database::iud("UPDATE `product_image` SET `path`='" . $new_file_path . "' WHERE `product_id`='" . $pid . "'");

            if(isset($_SESSION["qty"])){
               unset($_SESSION["qty"]);
            }

            $resOb->msg1 = "Updated!";
            
         } else {
            $resOb->msg = "Invalid Image type";
         }

         $check_len = $image_len - 1;

         if ($check_len == $img_num) {

            if(isset($_SESSION["qty"])){
               unset($_SESSION["qty"]);
            }

            $resOb->msg1 = "Updated!";

         } else {

            if ($image_len > 0 && $image_len <= 5) {

               for ($i = 0; $i < $image_len; $i++) {

                  if (isset($_FILES["images" . $i])) {

                     $img_file = $_FILES["images" . $i];
                     $image_type = $img_file["type"];

                     if (in_array($image_type, $allow_img_ex)) {
                        $new_file_ex;
                        if ($image_type == "image/png") {
                           $new_file_ex = ".png";
                        } else if ($image_type == "image/jpg") {
                           $new_file_ex = ".jpg";
                        } else if ($image_type == "image/jpeg") {
                           $new_file_ex = ".jpeg";
                        } else if ($image_type == "image/svg+xml") {
                           $new_file_ex = ".svg";
                        }

                        $new_image_name = "../style/resources/product_images/" . $new_date . $title . $product_id . $new_file_ex;

                        $new_image_path = "style/resources/product_images/" . $new_date . $title . $product_id . $new_file_ex;

                        move_uploaded_file($img_file["tmp_name"], $new_image_name);

                        Database::iud("INSERT INTO `images` (`image_path`,`product_id`) VALUES ('" . $new_image_path . "','" . $product_id . "')");

                        if(isset($_SESSION["qty"])){
                           unset($_SESSION["qty"]);
                        }

                        $resOb->msg1 = "Updated!";

                     } else {
                        $resOb->msg = "Invalid Image type";
                     }
                  }
               }
            } else {
               $resOb->msg = "Invalid Image Count";
            }
         }
      } else if ($image_rs->num_rows == 1) {

      Database::iud("UPDATE `product` SET 
      `collection_id`='" . $collection . "',
      `price`='" . $price . "',
      `qty`='" . $qty . "',
      `description`='" . $description . "',
      `title`='" . $title . "',
      `delivery_fee_badulla`='" . $dca . "',
      `delivery_fee_other`='" . $dcoa . "',
      `updated_user`='" . $email . "' WHERE `id`='" . $pid . "'");

      if(isset($_SESSION["qty"])){
         unset($_SESSION["qty"]);
      }

         $resOb->msg1 = "Updated!";

      } else {
         $resOb->msg = "Select cover photo";
      }
   }

   echo (json_encode($resOb));
}
