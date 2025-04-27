<?php

session_start();

require "connection.php";

$email = $_SESSION["u"]["email"];

$json = $_POST["json"];

$php_ob = json_decode($json);

$name = $php_ob->name;
$email = $php_ob->email;
$message = $php_ob->message;

$php_ob2 = new stdClass();

if (empty($name)) {

   $php_ob2->msg = "Empty Name";
} else if (strlen($name) < 6 || strlen($name) > 60) {

   $php_ob2->msg = "Name should be between 6-60 characters";
} else if (empty($email)) {

   $php_ob2->msg = "Empty Email";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

   $php_ob2->msg = "Invalid Email";
} else if (strlen($email) > 100) {

   $php_ob2->msg = "Invalid Email";
} else if (empty($message)) {

   $php_ob2->msg = "No Message?";
} else if (strlen($message) > 2000) {

   $php_ob2->msg = "You can't add more than 2000 characters";
} else {

   $d = new DateTime();
   $tz = new DateTimeZone("Asia/Colombo");
   $d->setTimezone($tz);
   $date = $d->format("Y-m-d H:i:s");

   Database::iud("INSERT INTO `contact` (`name`,`user_email`,`message`,`date`) 
   VALUES ('" . $name . "','" . $email . "','" . $message . "','" . $date . "')");

   $php_ob2->msg = "Success";
}

echo (json_encode($php_ob2));

?>
