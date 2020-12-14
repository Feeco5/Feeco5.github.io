<?php
include "include/config.php";

$drKODE = $_GET['drKODE'];
$hapus = mysqli_query($connection, "SELECT * FROM detailreturpenj WHERE detailreturpenjKODE = '$drKODE'");
$rowhapus = mysqli_fetch_array($hapus);

mysqli_query($connection, "DELETE FROM detailreturpenj WHERE detailreturpenjKODE = '$drKODE'");

echo '<script> alert("Data Berhasil dihapus!"); window.history.back() </script>';

?>