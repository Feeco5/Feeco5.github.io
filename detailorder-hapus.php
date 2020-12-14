<?php
include "include/config.php";

$doKODE = $_GET['doKODE'];
$hapus = mysqli_query($connection, "SELECT * FROM detailorder WHERE detailorderKODE = '$doKODE'");
$rowhapus = mysqli_fetch_array($hapus);

$barangKODE = $rowhapus['barangKODE'];
$karton = $rowhapus['karton'];

$barang =  mysqli_query($connection, "SELECT * FROM barang WHERE barangKODE = '$barangKODE' ");
$rowbrg = mysqli_fetch_array($barang);


$kartonlama = $rowbrg['karton'];
$kartonbaru = $kartonlama + $karton;

$update = mysqli_query($connection, "UPDATE barang set karton = '$kartonbaru' WHERE barangKODE = '$barangKODE' ");

if (update) {
    mysqli_query($connection, "DELETE FROM detailorder WHERE detailorderKODE = '$doKODE'");
    echo '<script> alert("Data Berhasil dihapus!"); window.history.back() </script>';
}
else {
    echo '<script> alert("Data Gagal dihapus!"); window.history.back() </script>';
}



?>