<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";
  $pKODE = $_GET['pKODE'];
  
  $jumlahtampil = 5;

  $halaman = @$_GET['page'];
  if (empty($halaman)) {
    $nomorpage = 0;
    $halaman = 1;
  }
  else {
    $nomorpage = ($halaman - 1) * $jumlahtampil;
  }
    
  $normalquery = mysqli_query($connection, "SELECT * FROM detailpembelian WHERE pembelianKODE = '$pKODE' ");
  $hasilkueri = mysqli_query($connection, "select * from detailpembelian WHERE pesananKODE = '$pKODE' ORDER BY pesananKODE ASC LIMIT $nomorpage, $jumlahtampil");

  if(isset($_POST['Simpan']))
  { 
    if (isset($_REQUEST["InputBahanBakuKode"]))
    { $bahanbakuKODE = $_REQUEST["InputBahanBakuKode"];
    } 
    if (!empty($bahanbakuKODE))
    { $bahanbakuKODE = $_POST['InputBahanBakuKode'];  
    }

    $bahanbaku = mysqli_query($connection, "SELECT * from bahanbaku where bahanbakuKODE = '$bahanbakuKODE'");
    $rowb = mysqli_fetch_array($bahanbaku);

    $qty = $_POST['InputQty'];

    $harga = $rowb['price'];
    $totalprice = $qty * $harga;

    $adminkode = $_SESSION['kodeuser'];

    date_default_timezone_set('Asia/Jakarta');
    $mydate=getdate(date("U"));
    $lastUPDATE ="$mydate[year]-$mydate[mon]-$mydate[mday]  $mydate[hours]:$mydate[minutes]:$mydate[seconds] ";

    mysqli_query($connection, "INSERT INTO detailpembelian VALUES ('','$bahanbakuKODE', '$qty','$totalprice','$pKODE', '$adminkode' )");
    $grandtotal = mysqli_query($connection, "SELECT sum(totalprice) FROM detailpembelian group by pembelianKODE having pembelianKODE = '$pKODE'");
    $gt =  mysqli_fetch_array($grandtotal);
    $totalharga = $gt['sum(totalprice)'];

    mysqli_query($connection, "UPDATE pembelian SET 
      grandtotal = '$totalharga'
      WHERE pembelianKODE = '$pKODE'");
  }

  if(isset($_POST['Refresh'])){
    $grandtotal = mysqli_query($connection, "SELECT sum(totalprice) FROM detailpembelian group by pembelianKODE having pembelianKODE = '$pKODE'");
    $gt =  mysqli_fetch_array($grandtotal);
    $totalharga = $gt['sum(totalprice)'];

    mysqli_query($connection, "UPDATE pembelian SET 
      grandtotal = '$totalharga'
      WHERE pembelianKODE = '$pKODE'");
  }
  
  $rowshow = mysqli_fetch_array($normalquery);
  $bahanbaku = mysqli_query($connection, "SELECT * from bahanbaku");
  $pembelian = mysqli_query($connection, "SELECT * from pembelian where pembelianKODE = '$pKODE'");
  $rowp = mysqli_fetch_array($pembelian);

?>


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
                <h3 class="card-title">Kode Order : <?php echo $pKODE  ?></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group ">
                    <label  for="bahanbakuKODE">Nama Product</label>
                        <select name="InputBahanBakuKode" class="form-control" id="bahanbakuKODE" placeholder="Nama Product">
                        <?php if   (mysqli_num_rows($bahanbaku) > 0) {?>
                        <?php while($row=mysqli_fetch_array($bahanbaku))
                        {?>
                        <option value="<?php echo $row["bahanbakuKODE"]?>">
                        <?php echo $row["bahanbakuNAMA"]?> | <?php echo $row["bahanbakuKODE"]?>
                        </option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                     
                    </div>
                  <div class="form-group ">
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

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Pembelian</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Action</th>
                    <th>Nama Barang</th>
                    <th>Quantity</th>
                    <th>Total Harga</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php  
                    $normalquery = mysqli_query($connection, "SELECT * FROM detailpembelian WHERE pembelianKODE = '$pKODE' ");
      /** Memeriksa apakah data yang dipanggil tersebut tersedia atau tidak **/
      if(mysqli_num_rows($normalquery)>0) 
    {?>
      
      <?php while ($row = mysqli_fetch_array($normalquery)) 
        { ?>
          <tr class="info">
            <td>
              <a href="detailpembelian-edit.php?dpKODE=<?php echo $row["detailpembelianKODE"]?>">
                <button type="button" class="btn  btn-info">
                  <i class="fas fa-pencil-alt"></i>
                </button>
              </a>
              <a href="detailpembelian-hapus.php?dpKODE=<?php echo $row["detailpembelianKODE"]?>">
                <button type="button" class="btn  btn-danger">
                  <i class="fa fa-trash"></i>
                </button>
              </a>
              <a href="detailpembelian-tambah.php?dpKODE=<?php echo $row["detailpembelianKODE"]?>">
                <button type="button" class="btn  btn-primary">
                  <i class="fas fa-plus"></i> 
                </button>
              </a>
                             
            </td>
            <td><?php echo $row['bahanbakuKODE']; ?> </td>
            <td><?php echo $row['qty']; ?> </td>
            <td>Rp <?php echo number_format($row['totalprice'])  ?> </td>
            
          </tr>
           
        <?php  } ?>
    <?php  } ?>
      <tr class="info">
        <td colspan="3">Grand Total</td>
        <td>Rp <?php echo number_format($rowp['grandtotal']) ?></td>
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

