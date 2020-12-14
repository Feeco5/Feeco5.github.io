<?php

session_start();
$_SESSION["namauser"];

unset($_SESSION["namauser"]);

session_unset();
session_destroy();
header("location:login.php")
?>