
<?php 
  include "include/header.php";
  $prKODE = $_GET['prKODE'];
    
  $normalquery = mysqli_query($connection, "SELECT * FROM partner join jenispartner on partner.jenispartnerKODE = jenispartner.jenispartnerKODE WHERE partnerKODE = '$prKODE'");
  if(isset($_POST['Simpan']))
  { 
    $partnerKODE = $_POST['InputBahanBakuKode']; 
    $partnerNAME = $_POST['InputBahanBakuName'];
    $price = $_POST['InputPrice'];
    $Quantity = $_POST['InputQty'];

    $totalharga = $price * $Quantity;

      $result = mysqli_query($connection, "UPDATE partner SET 
      partnerKODE = '$partnerKODE', 
      partnerNAMA = '$partnerNAME', 
      qty = '$Quantity',
      price = '$price',
      totalprice = '$totalharga'
      WHERE partnerKODE = '$prKODE'");
      
      if($result) {
        echo '<script> alert("Data Berhasil diedit!"); window.location="partner.php" </script>';
      }
      else {
        echo '<script> alert("FAILED ERROR! Check the error");</script>';
      }
  }
  
  $rowedit = mysqli_fetch_array($normalquery);
  $query = mysqli_query($connection, "select * from jenispartner");

?>

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
<title>Edit Partner</title>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Partner</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Partner</li>
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
                <h3 class="card-title">Update Partner</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">
                 
                  <div class="form-group">
                    <label for="nama">Name</label>
                    <input type="text" class="form-control" name="InputNama" id="nama" placeholder="Enter Name" required="" value="<?php echo $rowedit['partnerNAME'] ?>">
                  </div>

      
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="InputEmail" id="email" placeholder="Enter Email" required="" value="<?php echo $rowedit['partnerEMAIL'] ?>">
                  </div>

                  <div class="form-group">
                    <label for="phonenumber">Phone Number</label>
                    <input type="text" class="form-control" name="InputPhoneNumber" id="phonenumber" placeholder="Enter Phone Number" required="" value="<?php echo $rowedit['partnerPHONE'] ?>">
                  </div>

                  <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="InputAddress" id="address" placeholder="Enter Address" value="<?php echo $rowedit['partnerADDRESS'] ?>">
                  </div>

                   <div class="form-group ">
                    <label  for="jenispartner">Jenis Partner Old : <?php echo $rowedit['jenispartnerNAME'] ?> </label>
                        <select name="InputJenisPartner" class="form-control" id="jenispartner" placeholder="Nama Jenis Partner">
                        <?php if (mysqli_num_rows($query) > 0) {?>
                        <?php while($row=mysqli_fetch_array($query))
                        {?>
                        <option value="<?php echo $row["jenispartnerKODE"]?>">
                        <?php echo $row["jenispartnerNAME"]?>
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
