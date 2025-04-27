<?php

session_start();

$json = $_POST["json"];

$phpObj = json_decode($json);

$phpObj2 = new stdClass();

$regNo = $phpObj->rNo;

$regN = explode("-",$regNo);

if(empty($regNo)){

   // $regNoCheck = explode("-",$regNo);

   // $text = $regNoCheck[0];
   // $number = $regNoCheck[1];

   $phpObj2->fText = "Invalid registration number" ;
   $json2 = json_encode($phpObj2);
   echo($json2);

}else if(!array_key_exists("1",$regN))
{

   $phpObj2->fText = "- no" ;
   $json2 = json_encode($phpObj2);
   echo($json2);

}else if(strlen($regNo) < 6)
{

   $phpObj2->fText = "Invalid registration number" ;
   $json2 = json_encode($phpObj2);
   echo($json2);

}else{

   if(is_numeric($regN[0])){
      $phpObj2->fText = "Invalid registration number" ;
      $json2 = json_encode($phpObj2);
      echo($json2);
   }else if(strlen($regN[0]) < 2){
      $phpObj2->fText = "Invalid registration number" ;
      $json2 = json_encode($phpObj2);
      echo($json2);
   }else if(!is_numeric($regN[1])){
      $phpObj2->fText = "Invalid registration number" ;
      $json2 = json_encode($phpObj2);
      echo($json2);
   }else{
      
      if(isset($_SESSION["u"])){
         $phpObj2->sText = "success" ;
         $json2 = json_encode($phpObj2);
         echo($json2);
         $_SESSION["car"]["rNo"] = $regNo;
      }else{
         $phpObj2->singInText = "Sign in before continue" ;
         $json2 = json_encode($phpObj2);
         echo($json2);
      }

   }

   
}

?>