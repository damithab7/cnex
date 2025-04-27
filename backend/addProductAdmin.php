<?php

session_start();

require "../backend/connection.php";

$json = $_POST["json"];

$php_ob = json_decode($json);

$collection = $php_ob->collection;
$title = $php_ob->title;
$qty = $php_ob->qty;
$price = $php_ob->price;
$dca = $php_ob->dca;
$dcoa = $php_ob->dcoa;
$description = $php_ob->description;
$status = $php_ob->status;

$email;
if (isset($_SESSION["u"])) {
   $email = $_SESSION["u"]["email"];
} else {
   $email = $_SESSION["au"]["email"];
}

$resOb = new stdClass();

if (empty($collection)) {
   $resOb->collection = "Please select a item";
} else if (empty($title)) {
   $resOb->title = "Add a title";
} else if (strlen($title) > 45) {
   $resOb->title = "Long Title";
} else if (strlen($qty) == 0) {
   $resOb->qty = "Invalid QTY";
} else if ($status == 0) {
   $resOb->msg = "Please select a status";
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

   if (isset($_FILES["mainImage"])) {

      $d = new DateTime();
      $tz = new DateTimeZone("Asia/Colombo");
      $d->setTimezone($tz);
      $date = $d->format("Y-m-d H:i:s");


      $db_time = strtotime($date);
      $new_date = date("YmdHis", $db_time);

      if ($dca == 0) {
         $dca = "Free";
      }

      if ($dcoa == 0) {
         $dcoa = "Free";
      }

      Database::iud("INSERT INTO `product` (`collection_id`,`price`,`qty`,`description`,`title`,`datetime_added`,`delivery_fee_badulla`,`delivery_fee_other`,`status_id`,`user_email`)
      VALUES ('" . $collection . "','" . $price . "','" . $qty . "','" . $description . "','" . $title . "','" . $date . "','" . $dca . "','" . $dcoa . "','" . $status . "','" . $email . "')");

      $product_id = Database::$connection->insert_id;

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

         $u_id = uniqid();

         $new_file_name = "../style/resources/product_images/" . $title . $product_id . $new_date . $u_id . $new_file_ex;

         $new_file_path = "style/resources/product_images/" . $title . $product_id . $new_date . $u_id . $new_file_ex;

         move_uploaded_file($file["tmp_name"], $new_file_name);

         Database::iud("INSERT INTO `product_image` (`path`,`product_id`) VALUES ('" . $new_file_path . "','" . $product_id . "')");

         $resOb->msg1 = $product_id;

         if (isset($_SESSION["qty"])) {
            unset($_SESSION["qty"]);
         }

      } else {
         $resOb->msg = "Invalid Image type";
      }

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

                  $uni_id = uniqid();

                  $new_image_name = "../style/resources/product_images/" . $new_date . $title . $product_id . $uni_id . $i . $new_file_ex;

                  $new_image_path = "style/resources/product_images/" . $new_date . $title . $product_id . $uni_id . $i . $new_file_ex;

                  move_uploaded_file($img_file["tmp_name"], $new_image_name);

                  Database::iud("INSERT INTO `images` (`image_path`,`product_id`) VALUES ('" . $new_image_path . "','" . $product_id . "')");

                  $resOb->msg1 = $product_id;

                  if (isset($_SESSION["qty"])) {
                     unset($_SESSION["qty"]);
                  }
               } else {
                  $resOb->msg = "Invalid Image type";
               }
            }
         }
      } else {
         $resOb->msg = "Invalid Image Count";
      }
   } else {
      $resOb->msg = "Select cover photo";
   }
}

echo (json_encode($resOb));
