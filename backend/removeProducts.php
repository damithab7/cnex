<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$reqOb = json_decode($json);

$id = $reqOb->id;

$resOb = new stdClass();

$p_rs = Database::search("SELECT * FROM `product` WHERE `id`='".$id."' AND `user_email`='".$_SESSION["u"]["email"]."'");
$p_num = $p_rs->num_rows;

if($p_num == 1){

   $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id`='".$id."'");

   for($c = 0;$c < $cart_rs->num_rows;$c++){
      Database::iud("DELETE FROM `cart` WHERE `product_id`='".$id."'");
   }

   $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `product_id`='".$id."'");

   for($c = 0;$c < $watchlist_rs->num_rows;$c++){
      Database::iud("DELETE FROM `watchlist` WHERE `product_id`='".$id."'");
   }


   $size_rs = Database::search("SELECT * FROM `product_has_size` WHERE `product_id`='".$id."'");
   Database::iud("DELETE FROM `product_image` WHERE `product_id`='".$id."'");
   $size_num = $size_rs->num_rows;
   if($size_num == 0){

   }else{
      for($i = 0;$i < $size_num;$i++){
         Database::iud("DELETE FROM `product_has_size` WHERE `product_id`='".$id."'");
      }
   }

   $feedback_rs = Database::search("SELECT * FROM `feedback` WHERE `product_id`='".$id."'");

   for($f = 0;$f < $feedback_rs->num_rows;$f++){
      Database::iud("DELETE FROM `feedback` WHERE `product_id`='".$id."'");
   }

   $images_rs = Database::search("SELECT * FROM `images` WHERE `product_id`='".$id."'");
   $images_num = $images_rs->num_rows;

   if($images_num == 0){

   }else{
      for($m = 0;$m < $images_num;$m++){
         Database::iud("DELETE FROM `images` WHERE `product_id`='".$id."'");
      }
   }

   Database::iud("DELETE `product` FROM `product` WHERE product.id='".$id."'");

   $resOb->msg = "success";

}else{

   $resOb->msg = "Invalid product or user!";

}

echo (json_encode($resOb));

?>