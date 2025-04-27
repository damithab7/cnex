<?php

session_start();

require "connection.php";

$amount = $_POST["amount"];

$php_ob = new stdClass();

if (isset($_SESSION["u"])) {

    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $_SESSION["u"]["email"] . "'");

    $user_data = $user_rs->fetch_assoc();

    $address_rs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `city` ON city.id=user_has_address.city_id INNER JOIN `district` ON district.id=city.district_id WHERE `user_email`='" . $user_data["email"] . "'");
    $address_num = $address_rs->num_rows;

    $array = array();

    $order_id = "69" . uniqid();
    $_SESSION["checkout"]["order_id"] = $order_id;

    $array["id"] = $order_id;
    $array["name"] = $user_data["fname"] . " " . $user_data["lname"];
    $array["email"] = $user_data["email"];
    $array["mobile"] = $user_data["mobile"];

    $currency = "LKR";
    $merchant_id = "1222852";
    $merchant_secret = "MzczMDk1ODg5NjI4ODczODcwNTMzNjc5NDIwNjQ3MzIyNTMxMDEz";

    $hash = strtoupper(
        md5(
            $merchant_id . $order_id . number_format($amount, 2, '.', '') . $currency . strtoupper(md5($merchant_secret))
        )
    );

    $array["hash"] = $hash;

    if ($address_num == 1) {
        $address_data = $address_rs->fetch_assoc();
        $array["city"] = $address_data["cname"];
        $array["district"] = $address_data["dname"];
        $array["line1"] = $address_data["line1"];
        echo json_encode($array);
    } else {
        $php_ob->msg = "Fill shipping address";
        $json = json_encode($php_ob);
        echo ($json);
    }
} else {
    if (isset($_SESSION["address"])) {

        $email = $_SESSION["address"]["email"];
        $name = $_SESSION["address"]["name"];
        $city = $_SESSION["address"]["city"];
        $postcode = $_SESSION["address"]["postcode"];
        $line1 = $_SESSION["address"]["line1"];
        $mobile = $_SESSION["address"]["mobile"];

        $address_rs = Database::search("SELECT * FROM `city` INNER JOIN `district` ON district.id=city.district_id WHERE city.id='" . $city . "'");
        $address_data = $address_rs->fetch_assoc();

        $array = array();

        $order_id = "69" . uniqid();
        $_SESSION["checkout"]["order_id"] = $order_id;

        $array["id"] = $order_id;
        $array["name"] = $name;
        $array["email"] = $email;
        $array["mobile"] = $mobile;
        $array["city"] = $address_data["cname"];
        $array["district"] = $address_data["dname"];
        $array["line1"] = $line1;

        $currency = "LKR";
        $merchant_id = "1222852";
        $merchant_secret = "MzczMDk1ODg5NjI4ODczODcwNTMzNjc5NDIwNjQ3MzIyNTMxMDEz";

        $hash = strtoupper(
            md5(
                $merchant_id . $order_id . number_format($amount, 2, '.', '') . $currency . strtoupper(md5($merchant_secret))
            )
        );

        $array["hash"] = $hash;

        echo json_encode($array);
    } else {
        $php_ob->msg = "Fill shipping address";
        $json = json_encode($php_ob);
        echo ($json);
    }
}
