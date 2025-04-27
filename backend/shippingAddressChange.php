<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$php_ob = json_decode($json);

if (isset($php_ob->email)) {
    $email = $php_ob->email;
}

$name = $php_ob->name;
$postcode = $php_ob->postcode;
$line1 = $php_ob->line1;
$city = $php_ob->city;
$mobile = $php_ob->mobile;

$php_ob2 = new stdClass();

if (isset($_SESSION["u"])) {

    $user_address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $_SESSION["u"]["email"] . "' ");

    $user_address_num = $user_address_rs->num_rows;

    if ($user_address_num == 1) {
        if (empty($name)) {

            $php_ob2->name = "Fill shipping name";
        } else if (strlen($name) < 4 || strlen($name) > 50) {

            $php_ob2->name = "Name must be between 4 - 50 characters";
        } else if ($city == 0) {

            $php_ob2->city = "Please select a city";
        } else if (empty($postcode)) {

            $php_ob2->post = "Fill postal code";
        } else if (empty($line1)) {

            $php_ob2->line1 = "Fill line1";
        } else if (empty($mobile)) {

            $php_ob2->mobile = "Please enter your mobile number";
        } else if (strlen($mobile) != 10) {

            $php_ob2->mobile = "Mobile number have 10 characters";
        } else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {

            $php_ob2->mobile = "Invalid mobile number";
        } else {
            $_SESSION["shipping"]["name"] = $name;
            Database::iud("UPDATE `user_has_address` SET `postal`='" . $postcode . "',`line1`='" . $line1 . "',`city_id`='" . $city . "'");
            Database::iud("UPDATE `user` SET `mobile`='" . $mobile . "' WHERE `email`='" . $_SESSION["u"]["email"] . "'");
            $php_ob2->msg1 = "success";
        }
    } else {
        if (empty($name)) {

            $php_ob2->name = "Fill shipping name";
        } else if (strlen($name) < 4 || strlen($name) > 50) {

            $php_ob2->name = "Name must be between 4 - 50 characters";
        } else if ($city == 0) {

            $php_ob2->city = "Please select a city";
        } else if (empty($postcode)) {

            $php_ob2->post = "Fill postal code";
        } else if (empty($line1)) {

            $php_ob2->line1 = "Fill line1";
        } else if (empty($mobile)) {

            $php_ob2->mobile = "Please enter your mobile number";
        } else if (strlen($mobile) != 10) {

            $php_ob2->mobile = "Mobile number have 10 characters";
        } else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {

            $php_ob2->mobile = "Invalid mobile number";
        } else {

            $_SESSION["shipping"]["name"] = $name;
            Database::iud("UPDATE `user` SET `mobile`='" . $mobile . "'");
            Database::iud("INSERT INTO `user_has_address` (`line1`,`postal`,`city_id`,`user_email`)
        VALUES ('" . $line1 . "','" . $postcode . "','" . $city . "','" . $_SESSION["u"]["email"] . "')");
            $php_ob2->msg1 = "success";
        }
    }
} else {
    if (isset($_SESSION["buy"])) {
        if (empty($email)) {

            $php_ob2->email = "Enter your email";
        } else if (strlen($email) >= 100) {

            $php_ob2->email = "Email does not have 100 characters.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $php_ob2->email = "Invalid email";
        } else if (empty($name)) {

            $php_ob2->name = "Fill shipping name";
        } else if (strlen($name) < 4 || strlen($name) > 50) {

            $php_ob2->name = "Name must be between 4 - 50 characters";
        } else if ($city == 0) {

            $php_ob2->city = "Please select a city";
        } else if (empty($postcode)) {

            $php_ob2->post = "Fill postal code";
        } else if (empty($line1)) {

            $php_ob2->line1 = "Fill line1";
        } else if (empty($mobile)) {

            $php_ob2->mobile = "Please enter your mobile number";
        } else if (strlen($mobile) != 10) {

            $php_ob2->mobile = "Mobile number have 10 characters";
        } else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {

            $php_ob2->mobile = "Invalid mobile number";
        } else {
            $_SESSION["address"]["email"] = $email;
            $_SESSION["address"]["name"] = $name;
            $_SESSION["address"]["city"] = $city;
            $_SESSION["address"]["postcode"] = $postcode;
            $_SESSION["address"]["line1"] = $line1;
            $_SESSION["address"]["mobile"] = $mobile;

            $php_ob2->msg1 = "success";
        }
    }
}

echo (json_encode($php_ob2));
