<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$phpObj = json_decode($json);

$fname = $phpObj->fname;
$lname = $phpObj->lname;
$email = $phpObj->email;
$password = $phpObj->password;
$rpassword = $phpObj->rpassword;
$vcode = $phpObj->vcode;
$mobile = $phpObj->mobile;

$phpObj2 = new stdClass;

$user_rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."'");

if (empty($fname) && empty($lname) && empty($email) && empty($password) && empty($rpassword) && empty($vcode) && empty($mobile)) {

   $phpObj2->fnameText = "Please enter your First name";
   $phpObj2->lnameText = "Enter your Last name";
   $phpObj2->emailText = "Email cannot be empty";
   $phpObj2->passwordText = "Please enter your password";
   $phpObj2->vcodeText = "Please enter your verification code";
   $phpObj2->mobile = "Please enter your mobile number";
} else if (empty($fname)) {

   $phpObj2->fnameText = "Please enter your First name";
} else if (strlen($fname) > 50) {

   $phpObj2->fnameText = "First name must have less that 50 characters";
} else if (empty($lname)) {

   $phpObj2->lnameText = "Enter your Last name";
} else if (strlen($lname) > 50) {

   $phpObj2->lnameText = "Last name must have less than 50 characters";
}else if($user_rs->num_rows == 1) {

   $phpObj2->emailText = "This User already Registered";
}else if(empty($email)){

   $phpObj2->emailText = "Email cannot be empty";
}else if (strlen($email) >= 100) {

   $phpObj2->emailText = "Email does not have 100 characters.";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

   $phpObj2->emailText = "Invalid email";
} else if (empty($password)) {

   $phpObj2->passwordText = "Please enter your password";
} else if (strlen($password) < 5 || strlen($password) > 20) {

   $phpObj2->passwordText = "Your password must be between 5 - 20 characters";
} else if (empty($rpassword)) {

   $phpObj2->repasswordText = "Re-enter your password";
} else if ($password != $rpassword) {

   $phpObj2->allpasswordText = "Your password does not match";
} else if (empty($vcode)) {

   $phpObj2->vcodeText = "Please enter your verification code";
} else if ($vcode != $_SESSION["su"]["verification_code"]) {

   $phpObj2->vcodeText = "Invalid verification code";
} else if (empty($mobile)) {

   $phpObj2->mobile = "Please enter your mobile number";
} else if (strlen($mobile) != 10) {

   $phpObj2->mobile = "Mobile number have 10 characters";
} else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {

   $phpObj2->mobile = "Invalid mobile number";
} else {

   $d = new DateTime();
   $tz = new DateTimeZone("Asia/Colombo");
   $d->setTimezone($tz);
   $date = $d->format("Y-m-d H:i:s");

   Database::iud("INSERT INTO `user` (`email`,`fname`,`lname`,`mobile`,`password`,`registered_date`,`status`,`user_type_id`)
      VALUES ('" . $email . "','" . $fname . "','" . $lname . "','" . $mobile . "','" . $password . "','" . $date . "','1','3');");

   $phpObj2->sText = "User Registration Successfull!";
}

echo(json_encode($phpObj2));

?>
