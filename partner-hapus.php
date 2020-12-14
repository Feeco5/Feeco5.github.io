<?php
include "include/config.php";

$prKODE = $_GET['prKODE'];
$hapus = mysqli_query($connection, "SELECT * FROM partner WHERE partnerKODE = '$prKODE'");
$rowhapus = mysqli_fetch_array($hapus);
 
mysqli_query($connection, "DELETE FROM partner WHERE partnerKODE = '$prKODE'");

echo '<script> alert("Data Berhasil dihapus!"); window.location="partner.php" </script>';
?>