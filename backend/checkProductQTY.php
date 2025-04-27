<?php
$json = $_POST["json"];

$reqOb = json_decode($json);

$qty = $reqOb->qty;

$resOb = new stdClass();

if($qty <= 0){
   $resOb->msg = "Invalid QTY";
}

echo (json_encode($resOb));

?>