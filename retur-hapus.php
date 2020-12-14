<?php
include "include/config.php";

$rKODE = $_GET['rKODE'];
$hapus = mysqli_query($connection, "SELECT * FROM returpenjualan WHERE returpenjualanKODE = '$rKODE'");
$rowhapus = mysqli_fetch_array($hapus);
 

mysqli_query($connection, "DELETE FROM returpenjualan WHERE returpenjualanKODE = '$rKODE'");

echo '<script> alert("Data Berhasil dihapus!"); window.location="retur.php" </script>';
?>