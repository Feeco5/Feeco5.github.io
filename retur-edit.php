<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";
  $rKODE = $_GET['rKODE'];
  
  $normalquery = mysqli_query($connection, "SELECT * from returpenjualan where returpenjualanKODE = '$rKODE'"); 

  if(isset($_POST['Simpan']))
  { 
    $faktur = $POST["InputFaktur"];

    $var = $_POST['InputTanggal'];
    $date = str_replace('/', '-', $var);
    $tanggalORDER = date('Y-m-d', strtotime($date));
    $status = $_POST['InputStatus'];
    
    
      $result = mysqli_query($connection, "UPDATE returpenjualan SET 
      orderKODE = '$faktur', 
      tanggalORDER = '$tanggalORDER',
      WHERE returpenjualanKODE = '$rKODE'");
      
      if($result) {
        echo '<script> alert("Data Berhasil diedit!"); window.location="order.php" </script>';
      }
      else {
        echo '<script> alert("FAILED ERROR! Check the error");</script>';
      }
  }
  $adminkode = $_SESSION['kodeuser'];
  $rowedit = mysqli_fetch_array($normalquery);
  $pesanan = mysqli_query($connection, "SELECT * from pesanan left join partner on pesanan.customerKODE = partner.partnerKODE  left join karyawan on pesanan.karyawanKODE = karyawan.karyawanKODE where pesanan.adminKODE = '$adminkode'  ");

?>
<title>Edit Retur Penjualan</title>

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
            <h1 class="m-0 text-dark">Update Retur Penjualan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Update Retur Penjualan</li>
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
                <h3 class="card-title">Update Retur Penjualan</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">

                   <div class="form-group ">
                    <label  for="faktur">No Faktur Old : <?php echo $rowedit['orderKODE']; ?></label>
                        <select name="InputFaktur" class="form-control" id="faktur" placeholder="Nomor faktur">
                        <?php if (mysqli_num_rows($pesanan) > 0) {?>
                        <?php while($row=mysqli_fetch_array($pesanan))
                        {?>
                        <option>
                        <?php echo $row["orderKODE"]?>
                        </option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
  
                  <div class="form-group">
                  <label>Tanggal Retur Penjualan Old :  <?php echo $rowedit["returDATE"]?></label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" name="InputTanggal" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
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
