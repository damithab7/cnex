<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$reqOb = json_decode($json);

$sizeid = $reqOb->sizeid;
$pid = $reqOb->id;
$qty = $reqOb->qty;

$p_rs = Database::search("SELECT * FROM `product_has_size` INNER JOIN `product` ON `product`.`id`=`product_has_size`.`product_id` INNER JOIN `size` ON `product_has_size`.`size_id`=`size`.`id` WHERE `product_id`='" . $pid . "' AND `size_id`='" . $sizeid . "'");

if ($p_rs->num_rows == 0) {

   echo "Invalid product";

} else {

   $p_data = $p_rs->fetch_assoc();
   $p_price = $p_data["price"];

   if (isset($_SESSION["buy"]["id"])) {

      if ($_SESSION["buy"]["id"] == $pid) {

         $_SESSION["buy"]["qty"] = $qty;
         $new_total = $qty * $p_price;
         $_SESSION["buy"]["total"] = $new_total;
         $_SESSION["buy"]["sizeid"] = $sizeid;
         $_SESSION["buy"]["size"] = $p_data["name"];

      }else{

         $_SESSION["buy"]["id"] = $pid;
         $_SESSION["buy"]["qty"] = $qty;
         $_SESSION["buy"]["size"] = $p_data["name"];
         $_SESSION["buy"]["sizeid"] = $sizeid;
         $new_total = $qty * $p_price;
         $_SESSION["buy"]["total"] = $new_total;

      }
   } else {

      $_SESSION["buy"]["id"] = $pid;
      $_SESSION["buy"]["qty"] = $qty;
      $_SESSION["buy"]["size"] = $p_data["name"];
      $_SESSION["buy"]["sizeid"] = $sizeid;
      $new_total = $qty * $p_price;
      $_SESSION["buy"]["total"] = $new_total;

   }

   $new_total = $qty * $p_price;
   $_SESSION["shipping"]["total"] = $new_total;

   $d = new DateTime();
   $tz = new DateTimeZone("Asia/Colombo");
   $d->setTimezone($tz);
   $date = $d->format("Y-m-d");

   $d_d = new DateTime();
   $tz_d = new DateTimeZone("Asia/Colombo");
   $d_d->setTimezone($tz_d);
   $d_date =  explode("-", $date);

   $d_date[2] = $d_date[2] + 30;
   $new_date = $d_d->setDate($d_date[0], $d_date[1], $d_date[2]);
   $new_date2 = $new_date->format("Y-F-D-d");

   $_SESSION["shipping"]["date"] = $date;
   $_SESSION["shipping"]["new_date"] = $new_date2;
   echo "success";

}
