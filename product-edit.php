<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";
  $pKODE = $_GET['pKODE'];
  
  $jumlahtampil = 5;

  $halaman = @$_GET['page'];
  if (empty($halaman)) {
    $nomorpage = 0;
    $halaman = 1;
  }
  else {
    $nomorpage = ($halaman - 1) * $jumlahtampil;
  }
    
  $normalquery = mysqli_query($connection, "SELECT * FROM barang WHERE id = '$pKODE'");
  $hasilkueri = mysqli_query($connection, "select * from barang WHERE id = '$pKODE' ORDER BY barangKODE ASC LIMIT $nomorpage, $jumlahtampil");

  if(isset($_POST['Simpan']))
  { 
    $productKODE = $_POST['InputProductKode'];
    $productNAMA = $_POST['InputProductName'];
    $karton = $_POST['InputKarton'];
    $price = $_POST['InputPrice'];
    $isi = $_POST['InputIsiKarton'];

    $totalharga = $_POST['InputKarton'] * $_POST['InputPrice'] * $_POST['InputIsiKarton'];
    $Quantity = $_POST['InputKarton'] * $_POST['InputIsiKarton'];

    date_default_timezone_set('Asia/Jakarta');
    $mydate=getdate(date("U"));
    $lastUPDATE ="$mydate[year]-$mydate[mon]-$mydate[mday]  $mydate[hours]:$mydate[minutes]:$mydate[seconds] ";
    
    if ($_FILES['file']['size'] == 0 || $_FILES['file']['name'] == "")
    {
      $result = mysqli_query($connection, "UPDATE barang SET 
      barangKODE = '$productKODE', 
      barangNAMA = '$productNAMA', 
      karton = '$karton',
      isi = '$isi',
      quantity = $Quantity,
      harga = '$price',
      totalHARGA = '$totalharga',
      lastUPDATE = '$lastUPDATE'
      WHERE id = '$pKODE'");
      
      if($result) {
        echo '<script> alert("Data Berhasil diedit!"); window.location="product.php" </script>';
      }
      else {
        echo '<script> alert("FAILED ERROR! Check the error");</script>';
      }
    }
    else
    {
      $rowedit = mysqli_fetch_array($normalquery);
      $namafile = $rowedit['foto'];
      
      $path_to_file="./img/product/";

      $old = getcwd(); // Save the current directory
      chdir($path_to_file);
      unlink("$namafile");
      chdir($old); // Restore the old working directory   
    
      $nama = $_FILES['file']['name'];
      $file_tmp = $_FILES['file']['tmp_name'];
      move_uploaded_file($file_tmp, './img/product/'.$nama);
      
      /** ini memasukkan data ke tabel **/
      $result = mysqli_query($connection, "UPDATE barang SET 
      barangKODE = '$productKODE', 
      barangNAMA = '$productNAMA', 
      karton = '$karton',
      isi = '$isi',
      quantity = $Quantity,
      harga = '$price',
      totalHARGA = '$totalharga',
      foto = '$nama',
      lastUPDATE = '$lastUPDATE'
      WHERE id = '$pKODE'");
      
      if($result) {
        echo '<script> alert("Data Berhasil diedit!"); window.location="product.php" </script>';
      }
      else {
        echo '<script> alert("FAILED ERROR! Check the error");</script>';
      }
    } 
  }
  
  $rowedit = mysqli_fetch_array($normalquery);

?>
<title>Edit Product</title>

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Product</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group row">
                    <label for="productKODE" class="col-12">Kode Produk</label>
                    <input class="form-control" type="text" id="productKODE" name="InputProductKode" placeholder="Enter Kode Produk" maxlength="6" required="" value="<?php echo $rowedit['barangKODE'] ?>">
                  </div>

                  <div class="form-group row">
                    <label for="productNAME" class="col-12">Nama Produk</label>
                    <input type="text" class="form-control" name="InputProductName" id="productNAME" placeholder="Enter Nama Produk" value="<?php echo $rowedit['barangNAMA'] ?>" >
                  </div>

                   <div class="form-group row">
                    <label for="karton" class="col-12">Karton</label>
                    <input type="text" class="form-control" name="InputKarton" id="karton" placeholder="Enter Karton" value="<?php echo $rowedit['karton'] ?>"  >
                  </div>

                  <div class="form-group row">
                    <label for="isiKARTON" class="col-12">Isi Karton</label>
                    <input type="text" class="form-control" name="InputIsiKarton" id="isiKARTON" placeholder="Enter Isi Karton" value="<?php echo $rowedit['isi'] ?>" >
                  </div>

                  <div class="form-group row">
                    <label for="price" class="col-12">Price</label>
                    <input type="text" class="form-control" name="InputPrice" id="price" placeholder="Enter Price" value="<?php echo $rowedit['harga'] ?>">
                  </div>

                  <div class="form-group row">
                    <label for="exampleInputFile " class="col-12">Foto Produk Old : 
                      <img src="./img/product/<?php echo $rowedit['foto'] ?>" width = "200px">
                    </label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="file" name="file">
                        <label class="custom-file-label " for="file">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" name="Simpan" value="Simpan" class="btn btn-primary">
                  <input type="reset" class="btn btn-success" value="Batal" name="Batal">
                </div>
              </form>
            </div>

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  
  <!-- /.control-sidebar -->

<?php include ("include/footer.php")?>
</body>
</html>
