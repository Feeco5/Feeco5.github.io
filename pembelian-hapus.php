<?php
include "include/config.php";

$pKODE = $_GET['pKODE'];
$hapus = mysqli_query($connection, "SELECT * FROM pembelian WHERE pembelianKODE = '$pKODE'");
$rowhapus = mysqli_fetch_array($hapus);
 
mysqli_query($connection, "DELETE FROM pembelian WHERE pembelianKODE = '$pKODE'");

echo '<script> alert("Data Berhasil dihapus!"); window.location="pembelian.php" </script>';
?>