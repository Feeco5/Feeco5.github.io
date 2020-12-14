<?php
include "include/config.php";

$dpKODE = $_GET['dpKODE'];
$hapus = mysqli_query($connection, "SELECT * FROM detailpembelian WHERE detailpembelianKODE = '$dpKODE'");
$rowhapus = mysqli_fetch_array($hapus);

mysqli_query($connection, "DELETE FROM detailpembelian WHERE detailpembelianKODE = '$dpKODE'");

echo '<script> alert("Data Berhasil dihapus!"); window.history.back() </script>';

?>