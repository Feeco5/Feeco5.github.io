<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";
  $oKODE = $_GET['oKODE'];
  $tgl = $_GET['tanggal'];

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
    
  $normalquery = mysqli_query($connection, "SELECT * FROM detailorder WHERE id = '$oKODE' and tanggal = '$tgl' ");
  $hasilkueri = mysqli_query($connection, "select * from detailorder WHERE id = '$oKODE' and tanggal = '$tgl' ASC LIMIT $nomorpage, $jumlahtampil");

  if(isset($_POST['Simpan']))
  { 
    if (isset($_REQUEST["InputProductKode"]))
    { $productKODE = $_REQUEST["InputProductKode"];
    } 
    if (!empty($productKODE))
    { $productKODE = $_POST['InputProductKode'];  
    }

    // mengurangi karton barang
    $barang = mysqli_query($connection, "SELECT * from barang where barangKODE = '$productKODE' and adminKODE = '$adminkode' ");
    $rowb = mysqli_fetch_array($barang);
    $karton = $_POST['InputKarton'];
    $stock = $rowb['karton'];
    $newstock = $stock - $karton;

    if  ($newstock > 0) {
      $harga = $rowb['harga'];
      $totalprice = $karton * $harga;
      $adminkode = $_SESSION['kodeuser'];

      date_default_timezone_set('Asia/Jakarta');
      $mydate=getdate(date("U"));
      $lastUPDATE ="$mydate[year]-$mydate[mon]-$mydate[mday]  $mydate[hours]:$mydate[minutes]:$mydate[seconds] ";

      mysqli_query($connection, "INSERT INTO detailorder VALUES ('','$productKODE', '$karton','$totalprice','$tgl','$oKODE', '$adminkode')");
      
      // update stock terbaru 
      mysqli_query($connection, "UPDATE barang SET karton = '$newstock' where barangKODE = '$productKODE' and adminKODE = '$adminkode' ");

      $grandtotal = mysqli_query($connection, "SELECT sum(totalprice) FROM detailorder group by id,tanggal having id = '$oKODE' and tanggal = '$tgl'");

      $gt =  mysqli_fetch_array($grandtotal);

      $totalharga = $gt['sum(totalprice)'];

      mysqli_query($connection, "UPDATE pesanan SET 
        grandtotal = '$totalharga'
        WHERE id = '$oKODE' and tanggal = '$tgl'");
    }
    else {
      echo '<script> alert("Karton melebihi stock !"); window.history.back() </script>';
    }
  }

  if(isset($_POST['Refresh'])){
    $grandtotal = mysqli_query($connection, "SELECT sum(totalprice) FROM detailorder group by id,tanggal having id = '$oKODE' and tanggal = '$tgl'");
    $gt =  mysqli_fetch_array($grandtotal);
    $totalharga = $gt['sum(totalprice)'];

    mysqli_query($connection, "UPDATE pesanan SET 
      grandtotal = '$totalharga'
      WHERE id = '$oKODE' and tanggal = '$tgl'");
  }
  
  $rowshow = mysqli_fetch_array($normalquery);
  $product = mysqli_query($connection, "SELECT * from barang");
  $pesanan = mysqli_query($connection, "SELECT * from pesanan where id = '$oKODE' and tanggal = '$tgl'");
  $rowp = mysqli_fetch_array($pesanan);

  $id =  sprintf('%03d', $oKODE);
  $month = substr($tgl, -2);
  $year = substr($tgl, 0,2);

  $nofaktur = $id . "/BKC/". integerToRoman($month) . "/". $year

?>

<title>Detail Order | <?php echo $nofaktur  ?></title>


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
                <h3 class="card-title">Kode Order : <?php echo $nofaktur  ?></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group ">
                    <label  for="productKODE">Nama Product</label>
                        <select name="InputProductKode" class="form-control" id="productKODE" placeholder="Nama Product">
                        <?php if   (mysqli_num_rows($product) > 0) {?>
                        <?php while($row=mysqli_fetch_array($product))
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
                    <th>Karton</th>
                    <th>Total Harga</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $normalquery = mysqli_query($connection, "SELECT * FROM detailorder WHERE id = '$oKODE' and tanggal = '$tgl' ");
      /** Memeriksa apakah data yang dipanggil tersebut tersedia atau tidak **/
      if(mysqli_num_rows($normalquery)>0) 
    {?>
      
      <?php while ($row = mysqli_fetch_array($normalquery)) 
        { ?>
          <tr class="info">
            <td>
              <a href="detailorder-edit.php?doKODE=<?php echo $row["detailorderKODE"]?>">
                <button type="button" class="btn  btn-info">
                  <i class="fas fa-pencil-alt"></i>
                </button>
              </a>
              <a href="detailorder-hapus.php?doKODE=<?php echo $row["detailorderKODE"]?>">
                <button type="button" class="btn  btn-danger">
                  <i class="fa fa-trash"></i>
                </button>
              </a>
              <a href="detailorder-tambah.php?doKODE=<?php echo $row["detailorderKODE"]?>">
                <button type="button" class="btn  btn-primary">
                  <i class="fas fa-plus"></i> 
                </button>
              </a>
                             
            </td>
            <td><?php echo $row['barangKODE']; ?> </td>
            <td><?php echo $row['karton']; ?> </td>
            <td>Rp <?php echo number_format($row['totalprice'])  ?> </td>
            
          </tr>
           
        <?php  } ?>
    <?php  } ?>
      <tr class="info">
        <td colspan="3">Grand Total</td>
        <td>Rp <?php echo number_format($rowp['grandTOTAL']) ?></td>
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

