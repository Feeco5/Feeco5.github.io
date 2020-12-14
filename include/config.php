<?php
	/** ini koneksi ke basis data **/
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "bintangkelindocemerlang";
	
	$connection = mysqli_connect($servername, $username, $password, $dbname);
	if (!$connection)
	{
		die("koneksi gagal:".mysqli_connect_error());
	}
?>