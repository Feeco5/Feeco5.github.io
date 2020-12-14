<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";
  $oKODE = $_GET['oKODE'];
  $tanggal = $_GET['tanggal'];
  
  $jumlahtampil = 5;

  $halaman = @$_GET['page'];
  if (empty($halaman)) {
    $nomorpage = 0;
    $halaman = 1;
  }
  else {
    $nomorpage = ($halaman - 1) * $jumlahtampil;
  }
  
  $normalquery = mysqli_query($connection, "SELECT * from pesanan  join partner on pesanan.customerKODE = partner.partnerKODE  join karyawan on pesanan.karyawanKODE = karyawan.karyawanKODE where pesanan.id = '$oKODE' and pesanan.tanggal = '$tanggal' ");
  $hasilkueri = mysqli_query($connection, "select * from pesanan WHERE orderKODE = '$oKODE' ORDER BY orderKODE ASC LIMIT $nomorpage, $jumlahtampil");

  if(isset($_POST['Simpan']))
  { 
    $customerKODE = $_POST['InputCustomerKode'];
    $karyawanKODE = $_POST['InputKaryawanKode'];
    $paymentdue = $_POST['InputDuePayment'];

    $var = $_POST['InputTanggal'];
    $tanggalORDER = date('Y-m-d', strtotime($var));

    $month = date("m",strtotime($tanggalORDER));
    $year = date('y',strtotime($tanggalORDER));
    $tanggalbaru = $year."-".$month;    
    
      $result = mysqli_query($connection, "UPDATE pesanan SET 
      customerKODE = '$customerKODE', 
      tanggalORDER = '$tanggalORDER',
      karyawanKODE = '$karyawanKODE',
      paymentdue = '$paymentdue'
      WHERE id = '$oKODE' and
      tanggal = '$tanggal' ");
      
      if($result) {
        echo '<script> alert("Data Berhasil diedit!"); window.location="order.php" </script>';
      }
      else {
        echo '<script> alert("FAILED ERROR! Check the error");</script>';
      }
  }
  $adminkode = $_SESSION['kodeuser'];
  $rowedit = mysqli_fetch_array($normalquery);
  $query = mysqli_query($connection, "SELECT * from partner JOIN jenispartner on partner.jenispartnerKODE = jenispartner.jenispartnerKODE where jenispartnerNAME = 'Customer' and adminKODE = '$adminkode' ");
  $product = mysqli_query($connection, "SELECT * from barang");
  $karyawan = mysqli_query($connection, "SELECT * from karyawan");

?>
<title>Edit Order</title>

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
                <h3 class="card-title">Update Order</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group ">
                    <label  for="partnerKODE">Nama Customer Old : <?php echo $rowedit["partnerNAME"]?> </label>
                        <select name="InputCustomerKode" class="form-control" id="partnerKODE" placeholder="Nama Customer" value="<?php echo $rowedit["partnerNAME"]?>">
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
  
                  <div class="form-group">
                  <label>Tanggal Order Old :  <?php echo $rowedit["tanggalORDER"]?></label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" name="InputTanggal" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>

                <div class="form-group ">
                    <label for="duePayment" class="col-12">Due Payment </label>
                    <input type="text" class="form-control" name="InputDuePayment" id="duePayment" placeholder="Enter Due Payment" required="" value="<?php echo $rowedit["paymentdue"]?>">
                  </div>

                <div class="form-group ">
                    <label  for="karyawanKODE">Nama Karyawan Old :  <?php echo $rowedit["karyawanNAMA"]?></label>
                        <select name="InputKaryawanKode" class="form-control" id="karyawanKODE" placeholder="Nama Karyawan" value="<?php echo $rowedit["karyawanNAMA"]?>">
                        <?php if (mysqli_num_rows($karyawan) > 0) {?>
                        <?php while($krow=mysqli_fetch_array($karyawan))
                        {?>
                        <option value="<?php echo $krow["karyawanKODE"]?>">
                        <?php echo $krow["karyawanNAMA"]?>
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
