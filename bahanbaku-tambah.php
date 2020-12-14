
<?php 
  include "include/header.php";
  $bbKODE = $_GET['bbKODE'];
    
  $normalquery = mysqli_query($connection, "SELECT * FROM bahanbaku WHERE id = '$bbKODE'");

  $dblama = mysqli_query($connection, "SELECT * FROM bahanbaku WHERE id = '$bbKODE'");
  $lama = mysqli_fetch_array($dblama);
  if(isset($_POST['Simpan']))
  { 
    $qtylama = $lama['qty'];
    $hargalama = $lama['price'];
    $Quantity = $_POST['InputQty'];

    $qtybaru = $qtylama + $Quantity;

    $totalpricebaru = $qtybaru * $hargalama;

      $result = mysqli_query($connection, "UPDATE bahanbaku SET 
      qty = '$qtybaru',
      totalprice = '$totalpricebaru'
      WHERE id = '$bbKODE'");
      
      if($result) {
        echo '<script> alert("Data Berhasil diedit!"); window.location="bahanbaku.php" </script>';
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

<title>Tambah Bahan Baku</title>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Bahan Baku</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Bahan Baku</li>
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
                <h3 class="card-title">Tambah Stock <?php echo $rowedit['bahanbakuNAMA']; ?></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">
              
                        <div class="form-group row">
                          <label for="qty" class="col-12">Qty</label>
                          <input type="text" class="form-control" name="InputQty" id="qty" placeholder="Enter Qty" required="">
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
