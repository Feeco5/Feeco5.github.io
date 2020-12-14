<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";
  $drKODE = $_GET['drKODE'];
  
  $normalquery = mysqli_query($connection, "SELECT * FROM detailreturpenj WHERE drpKODE = '$drKODE'");

  if(isset($_POST['Simpan']))
  { 
    $productKODE = $_POST['InputProductKode'];
    $keterangan = $_POST['InputKeterangan'];

    $barang = mysqli_query($connection, "SELECT * from barang where barangKODE = '$productKODE'");
    $rowb = mysqli_fetch_array($barang);

    $karton = $_POST['InputKarton'];
    $harga = $rowb['harga'];
    $totalprice = $karton * $harga;

    date_default_timezone_set('Asia/Jakarta');
    $mydate=getdate(date("U"));
    $lastUPDATE ="$mydate[year]-$mydate[mon]-$mydate[mday]  $mydate[hours]:$mydate[minutes]:$mydate[seconds] ";   
    
      $result = mysqli_query($connection, "UPDATE detailreturpenj SET 
      barangKODE = '$productKODE', 
      drpKARTON = '$karton',
      drpTOTALHARGA = '$totalprice',
      keterangan = '$keterangan'
      WHERE drpKODE = '$drKODE'");
      
      if($result) {
        echo '<script> alert("Data Berhasil diedit!"); window.history.back() </script>';
      }
      else {
        echo '<script> alert("FAILED ERROR! Check the error");</script>';
      }
  }
  
  $rowedit = mysqli_fetch_array($normalquery);

  $query1 = mysqli_query($connection, "SELECT orderKODE from detailreturpenj join returpenjualan on detailreturpenj.returpenjualanKODE = returpenjualan.returpenjualanKODE where drpKODE = '$drKODE' ");
    $rowq = mysqli_fetch_array($query1);
      $orderkode = $rowq['orderKODE'];
  $pesanan = mysqli_query($connection, "SELECT * from pesanan join detailorder on pesanan.orderKODE = detailorder.pesananKODE join barang on detailorder.barangKODE = barang.barangKODE where orderKODE = '$orderkode'");

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
            <h1 class="m-0 text-dark">Update Order</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Update Order</li>
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
                <h3 class="card-title">Update Detail Order</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">

                 <div class="form-group ">
                    <label  for="productKODE">Nama Product Old: <?php echo $rowedit["barangKODE"]?></label>
                        <select name="InputProductKode" class="form-control" id="productKODE" placeholder="Nama Product">
                        <?php if   (mysqli_num_rows($pesanan) > 0) {?>
                        <?php while($rowp=mysqli_fetch_array($pesanan))
                        {?>
                        <option value="<?php echo $rowp["barangKODE"]?>">
                        <?php echo $rowp["barangNAMA"]?> | <?php echo $rowp["barangKODE"]?>
                        </option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                     
                    </div>
                    
                  <div class="form-group ">
                    <label for="karton" class="col-12">Karton</label>
                    <input type="text" class="form-control" name="InputKarton" id="karton" placeholder="Enter Karton" required="" value="<?php echo $rowedit["drpKARTON"]?>">
                  </div>

                  <div class="form-group ">
                    <label for="keterangan" class="col-12">Keterangan Retur</label>
                    <input type="text" class="form-control" name="InputKeterangan" id="keterangan" placeholder="Contoh : Barang rusak, Salah warna  dll" required="" value="<?php echo $rowedit["keterangan"]?>">
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
