<?php

session_start();

require "connection.php";

$json = $_POST["json"];

$php_ob = json_decode($json);

$postcode = $php_ob->postcode;
$line1 = $php_ob->line1;
$line2 = $php_ob->line2;
$city = $php_ob->city;
$mobile = $php_ob->mobile;

$php_ob2 = new stdClass();

$user_address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='".$_SESSION["u"]["email"]."' ");
$user_address_num = $user_address_rs->num_rows;

if($user_address_num == 1){

    if($city == 0){

        $php_ob2->city = "Please select a city";
        $json2 = json_encode($php_ob2);
        echo($json2);

    }else if(empty($postcode)){

        $php_ob2->post = "Fill postal code";
        $json2 = json_encode($php_ob2);
        echo($json2);

    }else if(empty($line1)){

        $php_ob2->line1 = "Fill line1";
        $json2 = json_encode($php_ob2);
        echo($json2);

    }else if(empty($mobile)){

        $php_ob2->mobile = "Please enter your mobile number";
        $json3 = json_encode($php_ob2);
        echo($json3);
    
     }else if(strlen($mobile) != 10){
    
        $php_ob2->mobile = "Mobile number have 10 characters";
        $json3 = json_encode($php_ob2);
        echo($json3);
    
     }else if(!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/",$mobile)){
    
        $php_ob2->mobile = "Invalid mobile number";
        $json3 = json_encode($php_ob2);
        echo($json3);
    
      } else{
        Database::iud("UPDATE `user_has_address` SET `postal`='".$postcode."',`line1`='".$line1."',`line2`='".$line2."',`city_id`='".$city."'");
        Database::iud("UPDATE `user` SET `mobile`='".$mobile."'");
        $php_ob2->msg1 = "success";
        $json2 = json_encode($php_ob2);
        echo($json2);
      }

}else{
    if($city == 0){

        $php_ob2->city = "Please select a city";
        $json2 = json_encode($php_ob2);
        echo($json2);

    }else if(empty($postcode)){

        $php_ob2->post = "Fill postal code";
        $json2 = json_encode($php_ob2);
        echo($json2);

    }else if(empty($line1)){

        $php_ob2->line1 = "Fill line1";
        $json2 = json_encode($php_ob2);
        echo($json2);

    }else if(empty($mobile)){

        $php_ob2->mobile = "Please enter your mobile number";
        $json3 = json_encode($php_ob2);
        echo($json3);
    
     }else if(strlen($mobile) != 10){
    
        $php_ob2->mobile = "Mobile number have 10 characters";
        $json3 = json_encode($php_ob2);
        echo($json3);
    
     }else if(!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/",$mobile)){
    
        $php_ob2->mobile = "Invalid mobile number";
        $json3 = json_encode($php_ob2);
        echo($json3);
    
      } else {

        Database::iud("UPDATE `user` SET `mobile`='".$mobile."'");
        Database::iud("INSERT INTO `user_has_address` (`line1`,`line2`,`postal`,`city_id`,`user_email`)
        VALUES ('".$line1."','".$line2."','".$postcode."','".$city."','".$_SESSION["u"]["email"]."')");
        $php_ob2->msg1 = "success";
        $json2 = json_encode($php_ob2);
        echo($json2);
        
    }
   
}

?>
