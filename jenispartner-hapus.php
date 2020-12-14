<?php
include "include/config.php";

$jpKODE = $_GET['jpKODE'];
$hapus = mysqli_query($connection, "SELECT * FROM jenispartner WHERE jenispartnerKODE = '$jpKODE'");
$rowhapus = mysqli_fetch_array($hapus);

mysqli_query($connection, "DELETE FROM jenispartner WHERE jenispartnerKODE = '$jpKODE'");

echo '<script> alert("Data Berhasil dihapus!"); window.location="jenispartner.php" </script>';
?>
<title>Hapus Jenis Partner</title>