<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$php_ob = json_decode($json);

$pid = $php_ob->id;
$qty = $php_ob->qty;
$p_price = $php_ob->price;

$php_ob2 = new stdClass();

if (isset($_SESSION["u"])) {
    Database::iud("UPDATE `cart` SET `qty`='" . $qty . "' WHERE `product_id`='" . $pid . "' AND `user_email`='" . $_SESSION["u"]["email"] . "'");

    $cart_rs = Database::search("SELECT *,cart.qty AS cqty FROM `cart` INNER JOIN `product` ON cart.product_id=product.id WHERE `cart`.`user_email`='" . $_SESSION["u"]["email"] . "'");
    $cart_num = $cart_rs->num_rows;

    $total = 0;
    $new_total = 0;

    for ($c = 0; $c < $cart_num; $c++) {

        $cart_data = $cart_rs->fetch_assoc();

        $price = $cart_data["price"];

        $new_qty = $cart_data["cqty"];

        $total = $new_qty * $price;

        $new_total = $new_total + $total;

        $_SESSION["cart"]["total"] = $new_total;
    }

} else {

    if (isset($_SESSION["cart"]["id".$pid]["id"])) {

        $total = 0;
        $new_total = 0;

        $cart_num = $_SESSION["cart"]["num"];
    
        for ($c = 0; $c < $cart_num; $c++) {

            $new_qty = $_SESSION["cart"]["id".$pid]["qty"];
    
            $total = $new_qty * $p_price;
    
            $new_total = $new_total + $total;
    
            $_SESSION["cart"]["total"] = $new_total;
        }
        
    }

    if (isset($_SESSION["buy"][$pid])) {

        $_SESSION["buy"][$pid]["qty"] = $qty;

        $new_total = $qty * $p_price;

        $_SESSION["buy"][$pid]["total"] = $new_total;

    } else {

        $_SESSION["buy"][$pid]["qty"] = $qty;
        $_SESSION["buy"][$pid]["price"] = $p_price;

        $new_total = $qty * $p_price;

        $_SESSION["buy"][$pid]["total"] = $new_total;

    }
}

$php_ob2->total = $new_total;
$json2 = json_encode($php_ob2);
echo ($json2);
