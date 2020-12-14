<?php
include "include/config.php";

$pKODE = $_GET['bbKODE'];
$hapus = mysqli_query($connection, "SELECT * FROM bahanbaku WHERE id = '$bbKODE'");
$rowhapus = mysqli_fetch_array($hapus);
$namafile = $rowhapus['foto'];
	
$path_to_file="./img/product/";

$old = getcwd(); // Save the current directory
chdir($path_to_file);
unlink("$namafile");
chdir($old); // Restore the old working directory   

mysqli_query($connection, "DELETE FROM bahanbaku WHERE id = '$bbKODE'");

echo '<script> alert("Data Berhasil dihapus!"); window.location="bahanbaku.php" </script>';
?>
<title>Hapus Bahan Baku</title>