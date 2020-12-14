<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";
  $dpKODE = $_GET['dpKODE'];
  
  $normalquery = mysqli_query($connection, "SELECT * FROM detailpembelian WHERE detailpembelianKODE = '$dpKODE'");

  if(isset($_POST['Simpan']))
  { 
    $bahanbakuKODE = $_POST['InputBahanBakuKode'];

    $bahanbaku = mysqli_query($connection, "SELECT * from bahanbaku where bahanbakuKODE = '$bahanbakuKODE'");
    $rowb = mysqli_fetch_array($bahanbaku);

    $qty = $_POST['InputQty'];
    $harga = $rowb['harga'];
    $totalprice = $qty * $harga;

    date_default_timezone_set('Asia/Jakarta');
    $mydate=getdate(date("U"));
    $lastUPDATE ="$mydate[year]-$mydate[mon]-$mydate[mday]  $mydate[hours]:$mydate[minutes]:$mydate[seconds] ";   
    
      $result = mysqli_query($connection, "UPDATE detailpembelian SET 
      bahanbakuKODE = '$bahanbakuKODE', 
      qty = '$qty',
      totalprice = '$totalprice'
      WHERE detailpembelianKODE = '$dpKODE'");
      
      if($result) {
        echo '<script> alert("Data Berhasil diedit!"); window.history.back() </script>';
      }
      else {
        echo '<script> alert("FAILED ERROR! Check the error");</script>';
      }
  }
  
  $rowedit = mysqli_fetch_array($normalquery);
  $bahanbaku = mysqli_query($connection, "SELECT * from bahanbaku");
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
            <h1 class="m-0 text-dark">Update Pembelian</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Update Pembelian</li>
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
                <h3 class="card-title">Update Detail Pembelian</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group ">
                    <label  for="bahanbakuKODE">Nama Product Old : <?php echo $rowedit["bahanbakuKODE"]?>|<?php echo $rowedit["bahanbakuKODE"]?> </label>
                        <select name="InputBahanBakuKode" class="form-control" id="bahanbakuKODE" placeholder="Nama Product">
                        <?php if   (mysqli_num_rows($bahanbaku) > 0) {?>
                        <?php while($row=mysqli_fetch_array($bahanbaku))
                        {?>
                        <option value="<?php echo $row["bahanbakuKODE"]?>">
                        <?php echo $row["bahanbakuNAMA"]?> | <?php echo $row["bahanbakuKODE"]?>
                        </option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                     
                    </div>
                  <div class="form-group ">
                    <label for="qty" class="col-12">Qty</label>
                    <input type="text" class="form-control" name="InputQty" id="qty" placeholder="Enter Qty" required="" value="<?php echo $row["qty"] ?>">
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
