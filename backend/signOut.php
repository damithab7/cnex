<?php

session_start();

$_SESSION["u"] = "";

session_destroy();

echo ("success");

?>