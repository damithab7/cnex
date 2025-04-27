<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$php_ob = json_decode($json);

$email = $php_ob->email;
$password = $php_ob->password;

$php_ob2 = new stdClass();

$user_rs = Database::search("SELECT * FROM `user` WHERE (`email`='".$email."' AND `password`='".$password."' ) AND `user_type_id`='1'; ");

$user_num = $user_rs->num_rows;

if(empty($email)){
   $php_ob2->email = "This field cannot be empty";
   echo(json_encode($php_ob2));
}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
   $php_ob2->email = "Invalid Email";
   echo(json_encode($php_ob2));
}else if(strlen($email) > 100){
   $php_ob2->email = "Invalid Email";
   echo(json_encode($php_ob2));
}else if(empty($password)){
   $php_ob2->password = "This field cannot be empty";
   echo(json_encode($php_ob2));
}else if(strlen($password) < 5 || strlen($password) > 20){
   $php_ob2->password = "Invalid password";
   echo(json_encode($php_ob2));
}else{

   if($user_num == 1){
      $user_data = $user_rs->fetch_assoc();
      $_SESSION["au"] = $user_data;

      $php_ob2->msg = "success";
      echo(json_encode($php_ob2));
   }else{
      $php_ob2->double = "Invalid email or password";
      echo(json_encode($php_ob2));
   }

}

?>