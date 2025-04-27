<?php

session_start();
if(isset($_SESSION["au"])){
   $_SESSION["au"] = "";
   session_destroy();
   echo ("success");
}

?>