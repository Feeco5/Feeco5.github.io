<?php
include "include/config.php";

$cKODE = $_GET['cKODE'];
$hapus = mysqli_query($connection, "SELECT * FROM customer WHERE customerKODE = '$cKODE'");
$rowhapus = mysqli_fetch_array($hapus);

mysqli_query($connection, "DELETE FROM customer WHERE customerKODE = '$cKODE'");

echo '<script> alert("Data Berhasil dihapus!"); window.location="customer.php" </script>';
?>