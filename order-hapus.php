<?php
include "include/config.php";

$oKODE = $_GET['oKODE'];
$tanggal = $_GET['tanggal'];
$hapus = mysqli_query($connection, "SELECT * FROM pesanan WHERE id = '$oKODE' and tanggal = '$tanggal'");
$rowhapus = mysqli_fetch_array($hapus);
 

mysqli_query($connection, "DELETE FROM pesanan WHERE id = '$oKODE' and tanggal = '$tanggal'");

echo '<script> alert("Data Berhasil dihapus!"); window.location="order.php" </script>';
?>