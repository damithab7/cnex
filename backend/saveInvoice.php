<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$php_ob = json_decode($json);

$orderId = $php_ob->orderId;
$email = $php_ob->email;
$total = $php_ob->total;

$php_ob2 = new stdClass();

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");

$cart_rs = Database::search("SELECT *,product.id AS pid,cart.qty AS cqty FROM `cart` INNER JOIN `product` ON cart.product_id=product.id WHERE cart.user_email='" . $email . "'");

$cart_num = $cart_rs->num_rows;

if (isset($_SESSION["buy"])) {

   Database::iud("INSERT INTO `checkout` (`order_id`,`total`,`date`,`status`,`user_email`)
   VALUES('" . $orderId . "','" . $total . "','" . $date . "','1','" . $email . "');");

   $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $_SESSION["buy"]["id"] . "'");

   $id = $_SESSION["buy"]["id"];
   $qty = $_SESSION["buy"]["qty"];

   $product_data = $product_rs->fetch_assoc();

   if (isset($_SESSION["buy"]["size"])) {

      Database::iud("INSERT INTO `invoice` (`total`,`qty`,`status`,`product_id`,`checkout_order_id`,`size`)
      VALUES ('" . $total . "','" . $qty . "','1','" . $id . "','" . $orderId . "','" . $_SESSION["buy"]["size"] . "');");

      $size_rs = Database::search("SELECT * FROM `product_has_size` WHERE `size_id`='" . $_SESSION["buy"]["sizeid"] . "' AND `product_id`='" . $id . "'");

      $s_data = $size_rs->fetch_assoc();

      $s_qty = $s_data["qty"];

      $sn_qty = $s_qty - $qty;

      Database::iud("UPDATE `product_has_size` SET `qty`='" . $sn_qty . "' WHERE `size_id`='" . $_SESSION["buy"]["sizeid"] . "' AND `product_id`='" . $id . "'");

   } else {
      Database::iud("INSERT INTO `invoice` (`total`,`qty`,`status`,`product_id`,`checkout_order_id`) VALUES ('" . $total . "','" . $qty . "','1','" . $id . "','" . $orderId . "');");
   }

   $new_qty = $product_data["qty"] - $qty;

} else {

   Database::iud("INSERT INTO `checkout` (`order_id`,`total`,`date`,`status`,`user_email`)
   VALUES('" . $orderId . "','" . $total . "','" . $date . "','1','" . $email . "');");

   for ($d = 0; $d < $cart_num; $d++) {

      $cart_data = $cart_rs->fetch_assoc();

      $id = $cart_data["pid"];
      $qty = $cart_data["cqty"];
      $price = $cart_data["price"];

      $item_price = $qty * $price;

      $new_qty = $cart_data["qty"] - $qty;

      Database::iud("INSERT INTO `invoice` (`total`,`qty`,`status`,`product_id`,`checkout_order_id`) VALUES ('" . $item_price . "','" . $qty . "','1','" . $id . "','" . $orderId . "');");
   }
}

if ($new_qty <= 0) {
   Database::iud("UPDATE `product` SET `qty`='" . $new_qty . "',`status_id`='6' WHERE `id`='" . $id . "'");
} else {
   Database::iud("UPDATE `product` SET `qty`='" . $new_qty . "' WHERE `id`='" . $id . "'");
}

$php_ob2->msg = "success";
$json2 = json_encode($php_ob2);
echo ($json2);
