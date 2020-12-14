<?php
include "include/config.php";

$kKODE = $_GET['kKODE'];
$hapus = mysqli_query($connection, "SELECT * FROM karyawan WHERE karyawanKODE = '$kKODE'");
$rowhapus = mysqli_fetch_array($hapus);

mysqli_query($connection, "DELETE FROM karyawan WHERE karyawanKODE = '$kKODE'");

echo '<script> alert("Data Berhasil dihapus!"); window.location="karyawan.php" </script>';
?>
<title>Hapus Karyawan</title>