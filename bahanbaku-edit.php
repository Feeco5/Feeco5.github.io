
<?php 
  include "include/header.php";
  $bbKODE = $_GET['bbKODE'];
  
  $jumlahtampil = 5;

  $halaman = @$_GET['page'];
  if (empty($halaman)) {
    $nomorpage = 0;
    $halaman = 1;
  }
  else {
    $nomorpage = ($halaman - 1) * $jumlahtampil;
  }
    
  $normalquery = mysqli_query($connection, "SELECT * FROM bahanbaku join partner on bahanbaku.partnerKODE = partner.partnerKODE WHERE id = '$bbKODE'");
  $hasilkueri = mysqli_query($connection, "select * from bahanbaku WHERE id = '$bbKODE' ORDER BY id ASC LIMIT $nomorpage, $jumlahtampil");

  if(isset($_POST['Simpan']))
  { 
    $bahanbakuKODE = $_POST['InputBahanBakuKode']; 
    $bahanbakuNAME = $_POST['InputBahanBakuName'];
    $price = $_POST['InputPrice'];
    $Quantity = $_POST['InputQty'];
    $partnerKODE = $_POST['InputPartnerKode']; 

    $totalharga = $price * $Quantity;

      $result = mysqli_query($connection, "UPDATE bahanbaku SET 
      bahanbakuKODE = '$bahanbakuKODE', 
      bahanbakuNAMA = '$bahanbakuNAME', 
      qty = '$Quantity',
      price = '$price',
      totalprice = '$totalharga',
      partnerKODE = '$partnerKODE'
      WHERE id = '$bbKODE'");
      
      if($result) {
        echo '<script> alert("Data Berhasil diedit!"); window.location="bahanbaku.php" </script>';
      }
      else {
        echo '<script> alert("FAILED ERROR! Check the error");</script>';
      }
  }
  
  $rowedit = mysqli_fetch_array($normalquery);
  $query = mysqli_query($connection, "SELECT * from partner JOIN jenispartner on partner.jenispartnerKODE = jenispartner.jenispartnerKODE where jenispartnerNAME = 'Supplier' ");

?>

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
<title>Edit Bahan Baku</title>

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
                <h3 class="card-title">Update Bahan Baku</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">
                 
                  <div class="form-group row">
                      <label for="bahanbakuKODE" class="col-12">Kode Bahan Baku</label>
                      <input class="form-control" type="text" id="bahanbakuKODE" name="InputBahanBakuKode" placeholder="Enter Kode Bahan Baku" maxlength="6" required="" value="<?php echo $rowedit['bahanbakuKODE']; ?>">
                  </div>

                  <div class="form-group row">
                    <label for="bahanbakuNAME" class="col-12">Nama Bahan Baku</label>
                    <input type="text" class="form-control" name="InputBahanBakuName" id="bahanbakuNAME" placeholder="Enter Nama Bahan Baku" required="" value="<?php echo $rowedit['bahanbakuNAMA']; ?>">
                  </div>

                         <div class="form-group row">
                          <label for="qty" class="col-12">Qty</label>
                          <input type="text" class="form-control" name="InputQty" id="qty" placeholder="Enter Qty" required="" value="<?php echo $rowedit['qty']; ?>">
                        </div>

                        <div class="form-group row">
                          <label for="price" class="col-12">Price</label>
                          <input type="text" class="form-control" name="InputPrice" id="price" placeholder="Enter Price" required="" value="<?php echo $rowedit['price']; ?>">
                        </div>

                  <div class="form-group ">
                    <label  for="partnerKODE">Nama Supplier Old : <?php echo $rowedit['partnerNAME']; ?></label>
                        <select name="InputPartnerKode" class="form-control" id="partnerKODE" placeholder="Nama Supplier">
                        <?php if (mysqli_num_rows($query) > 0) {?>
                        <?php while($row=mysqli_fetch_array($query))
                        {?>
                        <option value="<?php echo $row["partnerKODE"]?>">
                        <?php echo $row["partnerNAME"]?>
                        </option>
                        <?php } ?>
                        <?php } ?>
                      </select>
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
