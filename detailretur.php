<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";
  $rKODE = $_GET['rKODE'];
  
  $jumlahtampil = 5;

  $halaman = @$_GET['page'];
  if (empty($halaman)) {
    $nomorpage = 0;
    $halaman = 1;
  }
  else {
    $nomorpage = ($halaman - 1) * $jumlahtampil;
  }
    
  $normalquery = mysqli_query($connection, "SELECT * FROM detailreturpenj WHERE returpenjualanKODE = '$rKODE'");
  $hasilkueri = mysqli_query($connection, "select * from detailreturpenj WHERE returpenjualanKODE = '$rKODE' ORDER BY returpenjualanKODE ASC LIMIT $nomorpage, $jumlahtampil");

  if(isset($_POST['Simpan']))
  { 
    if (isset($_REQUEST["InputProductKode"]))
    { $productKODE = $_REQUEST["InputProductKode"];
    } 
    if (!empty($productKODE))
    { $productKODE = $_POST['InputProductKode'];  
    }

    $keterangan = $_POST['InputKeterangan'];

    $barang = mysqli_query($connection, "SELECT * from barang where barangKODE = '$productKODE'");
    $rowb = mysqli_fetch_array($barang);

    $karton = $_POST['InputKarton'];
    $harga = $rowb['harga'];
    $totalprice = $karton * $harga;

    date_default_timezone_set('Asia/Jakarta');
    $mydate=getdate(date("U"));
    $lastUPDATE ="$mydate[year]-$mydate[mon]-$mydate[mday]  $mydate[hours]:$mydate[minutes]:$mydate[seconds] ";
    //insert data
    mysqli_query($connection, "INSERT INTO detailreturpenj VALUES ('','$karton', '$totalprice','$rKODE','$productKODE', '$keterangan')");
    //insert data end

    //update grand total
    $grandtotal = mysqli_query($connection, "SELECT sum(drpTOTALHARGA) FROM detailreturpenj group by returpenjualanKODE having returpenjualanKODE = '$rKODE'");

    $gt =  mysqli_fetch_array($grandtotal);

    $totalharga = $gt['sum(drpTOTALHARGA)'];

    mysqli_query($connection, "UPDATE returpenjualan SET 
      returTOTALHARGA = '$totalharga'
      WHERE returpenjualanKODE = '$rKODE'");
    //update grand total end
  }

//update grand total
  if(isset($_POST['Refresh'])){
    $grandtotal = mysqli_query($connection, "SELECT sum(drpTOTALHARGA) FROM detailreturpenj group by returpenjualanKODE having returpenjualanKODE = '$rKODE'");
    $gt =  mysqli_fetch_array($grandtotal);
    $totalharga = $gt['sum(drpTOTALHARGA)'];

    mysqli_query($connection, "UPDATE returpenjualan SET 
      returTOTALHARGA = '$totalharga'
      WHERE returpenjualanKODE = '$rKODE'");
  }
//update grand total end

  $rowshow = mysqli_fetch_array($normalquery);
  $query1 = mysqli_query($connection, "SELECT * from returpenjualan  where returpenjualanKODE = '$rKODE' ");
    $rowq = mysqli_fetch_array($query1);
      $orderkode = $rowq['orderKODE'];
  $pesanan = mysqli_query($connection, "SELECT * from pesanan join detailorder on pesanan.orderKODE = detailorder.pesananKODE join barang on detailorder.barangKODE = barang.barangKODE where orderKODE = '$orderkode'"); 
?>

<title>Detail Retur</title>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Tambah Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tambah Product</li>
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
                <h3 class="card-title">Kode Retur : <?php echo $rKODE  ?></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group ">
                    <label  for="productKODE">Nama Product</label>
                        <select name="InputProductKode" class="form-control" id="productKODE" placeholder="Nama Product">
                        <?php if   (mysqli_num_rows($pesanan) > 0) {?>
                        <?php while($row=mysqli_fetch_array($pesanan))
                        {?>
                        <option value="<?php echo $row["barangKODE"]?>">
                        <?php echo $row["barangNAMA"]?> | <?php echo $row["barangKODE"]?>
                        </option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                    </div>

                  <div class="form-group ">
                    <label for="karton" class="col-12">Karton</label>
                    <input type="text" class="form-control" name="InputKarton" id="karton" placeholder="Enter Karton" required="">
                  </div>

                  <div class="form-group ">
                    <label for="keterangan" class="col-12">Keterangan Retur</label>
                    <input type="text" class="form-control" name="InputKeterangan" id="keterangan" placeholder="Contoh : Barang rusak, Salah warna  dll" required="">
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" name="Simpan" value="Simpan" class="btn btn-primary">
                  <input type="reset" class="btn btn-success" value="Batal" name="Batal">
                </div>
              </form>
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Order</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Action</th>
                    <th>Nama Barang</th>
                    <th>Keterangan</th>
                    <th>Karton</th>
                    <th>Total Harga</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $normalquery = mysqli_query($connection, "SELECT * FROM detailreturpenj join barang on detailreturpenj.barangKODE = barang.barangKODE WHERE returpenjualanKODE = '$rKODE'");
      /** Memeriksa apakah data yang dipanggil tersebut tersedia atau tidak **/
      if(mysqli_num_rows($normalquery)>0) 
    {?>
      
      <?php while ($row = mysqli_fetch_array($normalquery)) 
        { ?>
          <tr class="info">
            <td>
              <a href="detailretur-edit.php?drKODE=<?php echo $row["drpKODE"]?>">
                <button type="button" class="btn  btn-info">
                  <i class="fas fa-pencil-alt"></i>
                </button>
              </a>
              <a href="detailretur-hapus.php?drKODE=<?php echo $row["drpKODE"]?>">
                <button type="button" class="btn  btn-danger">
                  <i class="fa fa-trash"></i>
                </button>
              </a>
              <a href="detailretur-tambah.php?drKODE=<?php echo $row["drpKODE"]?>">
                <button type="button" class="btn  btn-primary">
                  <i class="fas fa-plus"></i> 
                </button>
              </a>
                             
            </td>
            <td><?php echo $row['barangNAMA']; ?> | <?php echo $row['barangKODE']; ?> </td>
            <td><?php echo $row['drpKARTON']; ?> </td>
            <td><?php echo $row['keterangan']; ?> </td>
            <td>Rp <?php echo number_format($row['drpTOTALHARGA'])  ?> </td>
            
          </tr>
           
        <?php  } ?>
    <?php  } ?>
      <tr class="info">
        <td colspan="4">Grand Total</td>
        <td>Rp <?php echo number_format($rowq['returTOTALHARGA']) ?></td>
      </tr>
                  </tbody>
                </table>
              </div>
               <form method="POST" enctype="multipart/form-data">
                <div class="card-footer">
                  <input type="submit" name="Refresh" value="Refresh" class="btn btn-primary">
              </div>
              </form><!-- /.card-body -->

              
            </div>
            <!-- /.card -->
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

