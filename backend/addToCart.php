<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$PHP_Object = json_decode($json);
$id = $PHP_Object->id;

$Text_Alert = new stdClass();

$p_rs = Database::search("SELECT *,`id` AS pid FROM `product` WHERE `id`='" . $id . "'");
$p_data = $p_rs->fetch_assoc();

if(isset($_SESSION["cart"]["num"])){
    $_SESSION["cart"]["num"];
}else{
    $_SESSION["cart"]["num"] = 0;
}

if (!isset($_SESSION["u"])) {

    if (isset( $_SESSION["cart"]["id".$id]["id"]) &&  $_SESSION["cart"]["id".$id]["id"] == $id) {

        if ($p_data["qty"] > 1) {

            if ( $_SESSION["cart"]["id".$id]["qty"] >= $p_data["qty"]) {

                $Text_Alert->msg1 = "No qty left order it now!";
                $json2 = json_encode($Text_Alert);
                echo ($json2);
                
            } else {

                $qty =  $_SESSION["cart"]["id".$id]["qty"];
                $new_qty = $qty + 1;
                $_SESSION["cart"]["id".$id]["qty"] = $new_qty;

                $Text_Alert->msg = "success";
                $json2 = json_encode($Text_Alert);
                echo ($json2);
            }
        } else if ($p_data["qty"] == 1) {

            $Text_Alert->msg1 = "The last QTY added to your cart. Order if you want more!";
            $json2 = json_encode($Text_Alert);
            echo ($json2);

        } else {

            $Text_Alert->msg1 = "fail";
            $json2 = json_encode($Text_Alert);
            echo ($json2);
        }
    } else {

        $_SESSION["cart"]["num"] = $_SESSION["cart"]["num"] + 1;
        $_SESSION["cart"]["id".$id]["id"] = $id;
        $_SESSION["cart"]["id".$id]["qty"] = 1;
        $_SESSION["cart"]["id".$id]["price"] = $p_data["price"];

        $Text_Alert->msg = "success";
        $json2 = json_encode($Text_Alert);
        echo ($json2);
        
    }
} else {

    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $_SESSION["u"]["email"] . "' AND `product_id`='" . $id . "'");

    $cart_num = $cart_rs->num_rows;

    if ($cart_num == 1) {

        $cart_data = $cart_rs->fetch_assoc();

        if ($p_data["qty"] > 1) {

            if ($cart_data["qty"] >= $p_data["qty"]) {

                $Text_Alert->msg1 = "No qty left order it now!";
                $json2 = json_encode($Text_Alert);
                echo ($json2);
            } else {

                $qty = $cart_data["qty"];
                $new_qty = $qty + 1;
                Database::iud("UPDATE `cart` SET `qty`='" . $new_qty . "'");

                $Text_Alert->msg = "success";
                $json2 = json_encode($Text_Alert);
                echo ($json2);
            }
        } else if ($p_data["qty"] == 1) {

            $Text_Alert->msg1 = "The last QTY added to your cart. Order if you want more!";
            $json2 = json_encode($Text_Alert);
            echo ($json2);
        } else {
            $Text_Alert->msg1 = "fail";
            $json2 = json_encode($Text_Alert);
            echo ($json2);
        }
    } else {

        if ($p_data["qty"] > 0) {

            Database::iud("INSERT INTO `cart` (`qty`,`product_id`,`user_email`)
        VALUES ('1','" . $id . "','" . $_SESSION["u"]["email"] . "')");

            $Text_Alert->msg = "success";
            $json2 = json_encode($Text_Alert);
            echo ($json2);
        } else {

            $Text_Alert->msg1 = "No qty left order it now!";
            $json2 = json_encode($Text_Alert);
            echo ($json2);
        }
    }
}
