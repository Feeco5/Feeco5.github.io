<?php
include "include/config.php";

$pKODE = $_GET['pKODE'];
$hapus = mysqli_query($connection, "SELECT * FROM barang WHERE id = '$pKODE'");
$rowhapus = mysqli_fetch_array($hapus);
$namafile = $rowhapus['foto'];
	
$path_to_file="./img/product/";

$old = getcwd(); // Save the current directory
chdir($path_to_file);
unlink("$namafile");
chdir($old); // Restore the old working directory   

mysqli_query($connection, "DELETE FROM barang WHERE id = '$pKODE'");

echo '<script> alert("Data Berhasil dihapus!"); window.location="product.php" </script>';
?>
<title>Hapus Product</title>