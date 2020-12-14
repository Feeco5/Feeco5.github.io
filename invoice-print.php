<!DOCTYPE html>
<html lang="en">
<?php 
function integerToRoman($integer){
  // Convert the integer into an integer (just to make sure)
  $integer = intval($integer);
  $result = '';
  
  // Create a lookup array that contains all of the Roman numerals.
  $lookup = array('M' => 1000,
  'CM' => 900,
  'D' => 500,
  'CD' => 400,
  'C' => 100,
  'XC' => 90,
  'L' => 50,
  'XL' => 40,
  'X' => 10,
  'IX' => 9,
  'V' => 5,
  'IV' => 4,
  'I' => 1);
  
  foreach($lookup as $roman => $value){
   // Determine the number of matches
   $matches = intval($integer/$value);
  
   // Add the same number of characters to the string
   $result .= str_repeat($roman,$matches);
  
   // Set the integer to be the remainder of the integer and the value
   $integer = $integer % $value;
  }
  
  // The Roman numeral should be built, return it
  return $result;
 }
    include "include/config.php";
    $oKODE = $_GET['oKODE'];
    $tgl = $_GET['tanggal'];
    $normalquery = mysqli_query($connection, "SELECT  b.barangKODE as kode_barang, p.paymentdue as paymentdue, b.barangNAMA as nama_barang , d.karton as karton , k.karyawanNAMA as nama_karyawan, pr.partnerNAME as nama_partner, pr.partnerADDRESS as alamat_partner , pr.partnerPHONE as partner_phone , pr.partnerEMAIL as partner_email , p.tanggalORDER as tanggal_pesanan , b.isi as isi , b.barangKODE as nama_barang, b.harga as harga_barang , d.totalprice as totalprice , p.grandtotal as grandtotal from detailorder d join pesanan p on d.id = p.id and d.tanggal = p.tanggal join barang b on b.barangKODE = d.barangKODE join karyawan k on k.karyawanKODE = p.karyawanKODE join partner pr on p.customerKODE = pr.partnerKODE where p.id = '$oKODE' and p.tanggal = '$tgl' " );
    $row = mysqli_fetch_array($normalquery);

    $var = 123; 
    $format =  sprintf('%03d', $var); 
    $id =  sprintf('%03d', $oKODE);
    $month = substr($tgl, -2);
    $year = substr($tgl, 0,2);

    $nofaktur = $id . "/BKC/". integerToRoman($month) . "/". $year
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Invoice Print</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <center>
          <h2 class="page-header">
            Invoice
        </h2>
        </center>
        
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        Kepada YTH.
        <address>
          <strong><?php echo $row['nama_partner']; ?></strong><br>
          <?php echo $row['alamat_partner']; ?><br>
          Phone: <?php echo $row['partner_phone']; ?><br>
          Email: <?php echo $row['partner_email']; ?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>No Faktur</b> <?php echo $nofaktur; ?><br>
        <br>
        <b>Tanggal</b> <?php echo $row['tanggal_pesanan']; ?><br>
        <b>Sales :</b> <?php echo $row['nama_karyawan']; ?><br>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <br><br>

    <!-- Table row -->
    <div class="row">
      
      <div class="col-12 table-responsive">
        <i> Payment Due : <?php echo $row['paymentdue']; ?> Days</i>
        <table class="table table-bordered table-striped">
          <thead>
          <tr class="info">
            <th style="width: 1%">No</th>
            <th style="width: 1%">Ctn</th>
            <th style="width: 1%">Isi</th>
            <th style="text-align: center; width: 3%">Qty</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga (Rp)</th>
            <th style="width:1%">%</th>
            <th>Total (Rp)</th>
          </tr>
          </thead>
          <tbody>
                    <?php
                    $normalquery = mysqli_query($connection, "SELECT  b.barangKODE as kode_barang, p.paymentdue as paymentdue, b.barangNAMA as nama_barang , d.karton as karton , k.karyawanNAMA as nama_karyawan, pr.partnerNAME as nama_partner, pr.partnerADDRESS as alamat_partner , pr.partnerPHONE as partner_phone , pr.partnerEMAIL as partner_email , p.tanggalORDER as tanggal_pesanan , b.isi as isi , b.barangKODE as nama_barang, b.harga as harga_barang , d.totalprice as totalprice , p.grandtotal as grandtotal from detailorder d join pesanan p on d.id = p.id and d.tanggal = p.tanggal join barang b on b.barangKODE = d.barangKODE join karyawan k on k.karyawanKODE = p.karyawanKODE join partner pr on p.customerKODE = pr.partnerKODE where p.id = '$oKODE' and p.tanggal = '$tgl' " );
      /** Memeriksa apakah data yang dipanggil tersebut tersedia atau tidak **/
      if(mysqli_num_rows($normalquery)>0) 
    {?>
      
      <?php while ($row = mysqli_fetch_array($normalquery)) 
        { ?>
          <tr class="info">
            <td></td>
            <td><?php echo $row['karton']; ?> </td>
            <td><?php echo $row['isi']; ?> </td>
            <td><?php echo $row['karton'] *  $row['isi'];  ?> </td>
            <td><?php echo $row['kode_barang']; ?> </td>
            <td><?php echo $row['nama_barang']; ?> </td>
            <td><?php echo number_format($row['harga_barang']); ?> </td>
            <td>Diskon </td>
            <td><?php echo number_format($row['totalprice']); ?> </td>       
            
          </tr>
           
        <?php  } ?>
    <?php  } ?>
                  </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <br><br>
      <div class="col-6">
        <center>
          Hormat Kami,
          <br><br><br><br>
          (BKC)
        </center>
        
      </div>
      <?php 
      $normalquery = mysqli_query($connection, "SELECT  b.barangKODE as kode_barang, p.paymentdue as paymentdue, b.barangNAMA as nama_barang , d.karton as karton , k.karyawanNAMA as nama_karyawan, pr.partnerNAME as nama_partner, pr.partnerADDRESS as alamat_partner , pr.partnerPHONE as partner_phone , pr.partnerEMAIL as partner_email , p.tanggalORDER as tanggal_pesanan , b.isi as isi , b.barangKODE as nama_barang, b.harga as harga_barang , d.totalprice as totalprice , p.grandtotal as grandtotal from detailorder d join pesanan p on d.id = p.id and d.tanggal = p.tanggal join barang b on b.barangKODE = d.barangKODE join karyawan k on k.karyawanKODE = p.karyawanKODE join partner pr on p.customerKODE = pr.partnerKODE where p.id = '$oKODE' and p.tanggal = '$tgl' " );
    $row = mysqli_fetch_array($normalquery); 
    ?>


      <!-- /.col -->

      <div class="col-6">

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Subtotal:</th>
              <td><?php echo number_format($row['grandtotal']) ?></td>
            </tr>
            <tr>
              <th>Discount</th>
              <td></td>
            </tr>
            <tr>
              <th>Total:</th>
              <td><?php echo number_format($row['grandtotal']) ?></td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->

<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
