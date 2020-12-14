<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";
  $doKODE = $_GET['doKODE'];
  
  $jumlahtampil = 5;

  $halaman = @$_GET['page'];
  if (empty($halaman)) {
    $nomorpage = 0;
    $halaman = 1;
  }
  else {
    $nomorpage = ($halaman - 1) * $jumlahtampil;
  }
    
  $normalquery = mysqli_query($connection, "SELECT * FROM detailorder WHERE detailorderKODE = '$doKODE'");

  if(isset($_POST['Simpan']))
  { 
    $dblama = mysqli_query($connection, "SELECT * from detailorder WHERE detailorderKODE = '$doKODE'");
    $lama = mysqli_fetch_array($dblama);
    $productKODE = $lama['barangKODE'];

    $barang = mysqli_query($connection, "SELECT * from barang where barangKODE = '$productKODE'");
    $rowb = mysqli_fetch_array($barang);


    $karton = $_POST['InputKarton'];
    $kartonbaru = $karton + $lama['karton'];
    $harga = $rowb['harga'];
    $totalprice = $kartonbaru * $harga;

    date_default_timezone_set('Asia/Jakarta');
    $mydate=getdate(date("U"));
    $lastUPDATE ="$mydate[year]-$mydate[mon]-$mydate[mday]  $mydate[hours]:$mydate[minutes]:$mydate[seconds] ";
    
      $result = mysqli_query($connection, "UPDATE detailorder SET 
      karton = '$kartonbaru',
      totalprice = '$totalprice'
      WHERE detailorderKODE = '$doKODE'");
      
      if($result) {
        echo '<script> alert("Barang Berhasil ditambah!"); window.location="order.php" </script>';
      }
      else {
        echo '<script> alert("FAILED ERROR! Check the error");</script>';
      }
    }
  
  $rowedit = mysqli_fetch_array($normalquery);

?>

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
            <h1 class="m-0 text-dark">Detail Order</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Detail Order</li>
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
                <h3 class="card-title">Tambah Karton <?php echo $rowedit['barangKODE'] ?></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">

                   <div class="form-group ">
                    <label for="karton" class="col-12">Karton</label>
                    <input type="text" class="form-control" name="InputKarton" id="karton" placeholder="Enter Karton" required="">
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
