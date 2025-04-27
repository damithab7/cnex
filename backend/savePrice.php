<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$resOb = json_decode($json);

if (isset($resOb->total)) {
    $new_total = $resOb->total;
} else {
    $new_total = 0;
}

$pid = $resOb->id;
$qty = $resOb->qty;

$p_rs = Database::search("SELECT * FROM `product` WHERE `product`.`id`='" . $pid . "'");

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

        } else {

            $_SESSION["buy"]["id"] = $pid;
            $_SESSION["buy"]["qty"] = $qty;
            $new_total = $qty * $p_price;

            $_SESSION["buy"]["total"] = $new_total;
        }
    } else {

        $_SESSION["buy"]["id"] = $pid;
        $_SESSION["buy"]["qty"] = $qty;
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
