
<?php 
  include "include/header.php";
  $jpKODE = $_GET['jpKODE'];
  
  $normalquery = mysqli_query($connection, "SELECT * FROM jenispartner WHERE jenispartnerKODE = '$jpKODE'");

  if(isset($_POST['Simpan']))
  { 
    $name = $_POST['InputNama'];
    
      $result = mysqli_query($connection, "UPDATE jenispartner SET 
      name = '$name'
      WHERE jenispartnerKODE = '$jpKODE'");
      
      if($result) {
        echo '<script> alert("Data Berhasil diedit!"); window.location="jenispartner.php" </script>';
      }
      else {
        echo '<script> alert("FAILED ERROR! Check the error");</script>';
      }
  }
  
  $rowedit = mysqli_fetch_array($normalquery);

?>

<title>Jenis Partner Edit</title>

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
<!DOCTYPE html>
<html lang="en">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Jenis Partner</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Jenis Partner</li>
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
                <h3 class="card-title">Update Jenis Partner</h3>
              </div>
              <!-- /.card-header -->  
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">
                 <div class="form-group">
                    <label for="nama">Name</label>
                    <input type="text" class="form-control" name="InputNama" id="nama" placeholder="Enter Name" required="" value=" <?php echo $rowedit['name'] ?> " >
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
