<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";
  $jumlahtampil = 5;

  $halaman = @$_GET['page'];
  if (empty($halaman)) {
    $nomorpage = 0;
    $halaman = 1;
  }
  else {
    $nomorpage = ($halaman - 1) * $jumlahtampil;
  }

  $adminkode = $_SESSION['kodeuser'];
  
  $normalbarang = mysqli_query($connection, "select * from barang");
  $barang = mysqli_query($connection, "SELECT * FROM barang where adminKODE = '$adminkode' ORDER BY barangKODE  ASC LIMIT $nomorpage, $jumlahtampil");

  $customer = mysqli_query($connection, "SELECT * FROM partner join jenispartner on partner.jenispartnerKODE = jenispartner.jenispartnerKODE where jenispartnerNAME = 'Customer' and adminKODE= '$adminkode' ORDER BY partnerKODE ASC LIMIT 5 ");
  $supplier = mysqli_query($connection, "SELECT * FROM partner join jenispartner on partner.jenispartnerKODE = jenispartner.jenispartnerKODE where jenispartnerNAME = 'Supplier' and adminKODE= '$adminkode' ORDER BY partnerKODE ASC LIMIT 5 ");


?>
<title>Home</title>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Home</h1>
          </div><!-- /.col -->
          <!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Product</h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-bordered table-striped" >
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>Code</th>
                      <th>Name</th>
                      <th>Qty</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php
      /** Memeriksa apakah data yang dipanggil tersebut tersedia atau tidak **/
      if(mysqli_num_rows($barang)>0) 
    {?>
      <?php $no=$nomorpage+1; ?>
      <?php while ($row = mysqli_fetch_array($barang)) 
        { ?>
          <tr class="info">
            <td><?php echo $no; ?></td>
            <td><?php echo $row['barangKODE']; ?> </td>
            <td><?php echo $row['barangNAMA']; ?> </td>
            <td><?php echo $row['quantity']; ?> </td>
          </tr>
          <?php $no++; ?> 
        <?php  } ?>
    <?php  } ?>
    </table>
    
    <?php
    $jumlahrecord = mysqli_num_rows($normalbarang);
    $jumlahpage = ceil($jumlahrecord/$jumlahtampil);
    ?>
    
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <?php if($halaman == 1) { ?>
          <li class="page-item disabled"><a class="page-link" href="?page=<?php echo $halaman?>">Previous</a></li>
        <?php } ?>
        <?php if($halaman > 1) { ?>
          <li class="page-item"><a class="page-link" href="?page=<?php echo $halaman-1?>">Previous</a></li>
        <?php } ?>
        <?php for ($pagination = 1; $pagination <= $jumlahpage; $pagination++)  {
          if ($pagination != $halaman) {
          ?><li class="page-item"><a class="page-link" href="?page=<?php echo $pagination; ?>"> <?php echo $pagination;?></a></li>
          <?php } 
          else {
            ?><li class="page-item disabled"><a class="page-link" href="?page=<?php echo $pagination; ?>"> <?php echo $pagination;?></a></li>
          <?php } 
        }?>
        <?php if($halaman == $jumlahpage) { ?>
          <li class="page-item disabled"><a class="page-link" href="?page=<?php echo $halaman?>">Next</a></li>
        <?php } ?>
        <?php if($halaman < $jumlahpage) { ?>
          <li class="page-item"><a class="page-link" href="?page=<?php echo $halaman+1?>">Next</a></li>
        <?php } ?>
      </ul> 
    </nav>
                <div class="card-footer">
                  <a href="stock.php" class="btn btn-primary">See all</a>
                </div>
              </div>
              <!-- /.card-body -->
            </div>

            <div class="card card-primary card-outline">
              <div class="card-body">
                <h5 class="card-title">Card title</h5>

                <p class="card-text">
                  Some quick example text to build on the card title and make up the bulk of the card's
                  content.
                </p>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
              </div>
            </div><!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          
          <div class="col-lg-6">
            <?php
             /** Memeriksa apakah data yang dipanggil tersebut tersedia atau tidak **/
             if(mysqli_num_rows($customer)>0) 
           {?>
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Customer</h5>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped" >
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>Customer Name</th>
                      <th>Address</th>
                    </tr>
                  </thead>
                  <tbody>
                   
                  <?php $no=$nomorpage+1; ?>
                  <?php while ($row = mysqli_fetch_array($customer)) 
                    { ?>
                      <tr class="info">
                        <td><?php echo $no; ?></td>
                        <td><?php echo $row['partnerNAME']; ?> </td>
                        <td><?php echo $row['partnerADDRESS']; ?> </td>
                      </tr>
                      <?php $no++; ?> 
                    <?php  } ?>
                
                </table>
                <div class="card-footer">
                  <a href="partner.php" class="btn btn-primary">See all</a>
                </div>
              </div>
            </div>
              <?php  } ?>
             <?php
             /** Memeriksa apakah data yang dipanggil tersebut tersedia atau tidak **/
             if(mysqli_num_rows($supplier)>0) 
           {?>
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Supplier</h5>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped" >
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>Supplier Name</th>
                      <th>Address</th>
                    </tr>
                  </thead>
                  <tbody>
                   
                  <?php $no=$nomorpage+1; ?>
                  <?php while ($row = mysqli_fetch_array($supplier)) 
                    { ?>
                      <tr class="info">
                        <td><?php echo $no; ?></td>
                        <td><?php echo $row['partnerNAME']; ?> </td>
                        <td><?php echo $row['partnerADDRESS']; ?> </td>
                      </tr>
                      <?php $no++; ?> 
                    <?php  } ?>
                <?php  } ?>
                </table>
                <div class="card-footer">
                  <a href="partner.php" class="btn btn-primary">See all</a>
                </div>
              </div>
            </div>

          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  <!-- /.content-wrapper -->

  
  <!-- /.control-sidebar -->

<?php include ("include/footer.php")?>
</body>
</html>
