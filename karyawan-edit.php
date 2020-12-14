
<?php 
  include "include/header.php";
  $kKODE = $_GET['kKODE'];
  
  $jumlahtampil = 5;

  $halaman = @$_GET['page'];
  if (empty($halaman)) {
    $nomorpage = 0;
    $halaman = 1;
  }
  else {
    $nomorpage = ($halaman - 1) * $jumlahtampil;
  }
    
  $normalquery = mysqli_query($connection, "SELECT * FROM karyawan WHERE karyawanKODE = '$kKODE'");
  $hasilkueri = mysqli_query($connection, "select * from karyawan WHERE karyawanKODE = '$kKODE' ORDER BY karyawanKODE ASC LIMIT $nomorpage, $jumlahtampil");

  if(isset($_POST['Simpan']))
  { 
    $karyawanNAME = $_POST['InputNama'];
    $phonenumber1 = $_POST['InputPhoneNumber1'];
    $phonenumber2 = $_POST['InputPhoneNumber2'];
    $address = $_POST['InputAddress'];
    $role = $_POST['InputRole'];
    $email = $_POST['InputEmail'];
    
      $result = mysqli_query($connection, "UPDATE karyawan SET 
      nama = '$karyawanNAME', 
      phoneNUMBER1 = '$phonenumber1',
      phoneNUMBER2 = '$phonenumber2',
      address = '$address',
      role = '$role',
      email = '$email'
      WHERE karyawanKODE = '$kKODE'");
      
      if($result) {
        echo '<script> alert("Data Berhasil diedit!"); window.location="karyawan.php" </script>';
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
<title>Edit Karyawan</title>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Karyawan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Karyawan</li>
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
                <h3 class="card-title">Update Karyawan</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group" >
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" class="form-control" name="InputNama" id="nama" placeholder="Enter Name" required="" value="<?php echo $rowedit['nama'] ?>">
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="InputEmail" id="email" placeholder="Enter Email" required="" value="<?php echo $rowedit['email'] ?>">
                  </div>

                  <div class="form-group">
                    <label for="phonenumber1">Phone Number 1</label>
                    <input type="text" class="form-control" name="InputPhoneNumber1" id="phonenumber1" placeholder="Enter Phone Number" required="" value="<?php echo $rowedit['phoneNUMBER1']; ?>">
                  </div>

                  <div class="form-group">
                    <label for="phonenumber2">Phone Number 2</label>
                    <input type="text" class="form-control" name="InputPhoneNumber2" id="phonenumber2" placeholder="Enter Phone Number" value="<?php echo $rowedit['phoneNUMBER2']; ?>">
                  </div>

                  <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="InputAddress" id="address" placeholder="Enter Address" value="<?php echo $rowedit['address']; ?>">
                  </div>

                  <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" class="form-control" name="InputRole" id="role" placeholder="Enter Role" value="<?php echo $rowedit['role']; ?>">
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
