<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$php_ob = json_decode($json);

$resOb = new stdClass();

$id = $php_ob->id;
$qty = $php_ob->qty;
$email = $php_ob->email;
$mobile = $php_ob->mobile;
$fname = $php_ob->fname;
$lname = $php_ob->lname;

if(empty($fname)){
   $resOb->fname = "Empty First Name";
}else if(strlen($fname) > 45){
   $resOb->fname = "Weird Name";
}else if(empty($lname)){
   $resOb->lname = "Empty Last Name";
}else if(strlen($lname) > 45){
   $resOb->lname = "Weird Name";
}else if(empty($email)){
   $resOb->email = "Empty Email";
}else if(strlen($email) > 100){
   $resOb->email = "Invalid Email";
}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
   $resOb->email = "Invalid Email";
}else if(empty($qty)){
   $resOb->qty = "Empty QTY";
}else if($qty < 1){
   $resOb->qty = "Invalid QTY";
}else if(empty($mobile)){
   $resOb->mobile = "Empty Mobile";
}else if(strlen($mobile) != 10){
   $resOb->mobile = "Invalid Mobile";
}else if(!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/",$mobile)){
   $resOb->mobile = "Invalid Mobile";
}else{

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");

Database::iud("INSERT INTO `orders` (`date`,`qty`,`product_id`,`order_email`,`status`,`mobile`,`fname`,`lname`)
VALUES ('".$date."','".$qty."','".$id."','".$email."','1','".$mobile."','".$fname."','".$lname."')");

$resOb->msg = "Success! You will be informed!";

}

echo(json_encode($resOb));

?>