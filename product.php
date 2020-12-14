<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";

  if(isset($_POST['Simpan']))
  { 
    if (isset($_REQUEST["InputProductKode"]))
    { $productKODE = $_REQUEST["InputProductKode"];
    } 
    if (!empty($productKODE))
    { $productKODE = $_POST['InputProductKode'];  
    }
    $productNAMA = $_POST['InputProductName'];
    $karton = $_POST['InputKarton'];
    $price = $_POST['InputPrice'];
    $isi = $_POST['InputIsiKarton'];

    $totalharga = $_POST['InputKarton'] * $_POST['InputPrice'] * $_POST['InputIsiKarton'];
    $Quantity = $_POST['InputKarton'] * $_POST['InputIsiKarton'];

    $adminkode = $_SESSION['kodeuser'];

    date_default_timezone_set('Asia/Jakarta');
    $mydate=getdate(date("U"));
    $lastUPDATE ="$mydate[year]-$mydate[mon]-$mydate[mday]  $mydate[hours]:$mydate[minutes]:$mydate[seconds] ";
    
    $nama = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    move_uploaded_file($file_tmp, './img/product/'.$nama);
    
    mysqli_query($connection, "INSERT INTO barang VALUES ('','$productKODE','$productNAMA','$karton','$isi','$Quantity', '$price','$totalharga','$nama','$lastUPDATE','$adminkode')"); 
  }
  if(isset($_POST['Refresh'])){
    $adminkode = $_SESSION['kodeuser'];
    $query = mysqli_query($connection, "select * from barang where adminKODE = '$adminkode' ");
    if(mysqli_num_rows($query)>0){
      while ($row = mysqli_fetch_array($query)){
        $totalharga = $row['karton'] * $row['harga'] * $row['isi'];
        $Quantity = $row['karton'] * $row['isi'];
        $id = $row['barangKODE'];
        mysqli_query($connection, "UPDATE barang set 
        totalHARGA = '$totalharga', 
        quantity = '$Quantity'
         where barangKODE = '$id' and adminKODE = '$adminkode'");
      }
    }
    
  }
  $adminkode = $_SESSION['kodeuser'];
  $normalquery = mysqli_query($connection, "select * from barang where adminKODE = '$adminkode' ");
?>

<title>Product</title>

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
            <h1 class="m-0 text-dark">Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Product</li>
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
                <h3 class="card-title">Input Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group row">
                    <label for="productKODE" class="col-12">Kode Produk</label>
                    <input class="form-control" type="text" id="productKODE" name="InputProductKode" placeholder="Enter Kode Produk" maxlength="6" required="">
                  </div>

                  <div class="form-group row">
                    <label for="productNAME" class="col-12">Nama Produk</label>
                    <input type="text" class="form-control" name="InputProductName" id="productNAME" placeholder="Enter Nama Produk" >
                  </div>

                   <div class="form-group row">
                    <label for="karton" class="col-12">Karton</label>
                    <input type="text" class="form-control" name="InputKarton" id="karton" placeholder="Enter Karton" >
                  </div>

                  <div class="form-group row">
                    <label for="isiKARTON" class="col-12">Isi Karton</label>
                    <input type="text" class="form-control" name="InputIsiKarton" id="isiKARTON" placeholder="Enter Isi Karton" >
                  </div>

                  <div class="form-group row">
                    <label for="price" class="col-12">Price</label>
                    <input type="text" class="form-control" name="InputPrice" id="price" placeholder="Enter Price">
                  </div>

                  <div class="form-group row">
                    <label for="exampleInputFile " class="col-12">Foto Produk</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="file" name="file">
                        <label class="custom-file-label " for="file">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
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

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Stock</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th rowspan="2" style="width: auto;">Kode Produk</th>
                    <th rowspan="2">Nama Produk</th>
                    <th colspan="3">Stock</th>
                    <th rowspan="2">Price</th>
                    <th rowspan="2">Total Price</th>
                    <th rowspan="2">Foto</th>
                    <th rowspan="2">Last Updated</th>
                    <th rowspan="2">Action</th>
                  </tr>  
                  <tr>
                    <th>CTN</th>
                    <th>ISI</th>
                    <th>Qty</th>
                  </tr> 
                  </thead>
                  <tbody>
                  <?php
      /** Memeriksa apakah data yang dipanggil tersebut tersedia atau tidak **/
      if(mysqli_num_rows($normalquery)>0) 
    {?>
      
      <?php while ($row = mysqli_fetch_array($normalquery)) 
        { ?>
          <tr class="info">
            
            <td><?php echo $row['barangKODE']; ?> </td>
            <td><?php echo $row['barangNAMA']; ?> </td>
            <td><?php echo $row['karton']; ?></td>
            <td><?php echo $row['isi']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td>Rp <?php echo number_format($row['harga'])  ?> </td>
            <td>Rp <?php echo number_format($row['totalHARGA'])  ?> </td>
            <td><img src="./img/product/<?php echo $row['foto'] ?>" width = "200px"> </td>
            <td><?php echo $row['lastUPDATE']; ?></td>  
            <td>
              <a href="product-edit.php?pKODE=<?php echo $row["id"]?> ">
                <button type="button" class="btn  btn-info">
                  <i class="fas fa-pencil-alt"></i>
                </button>
              </a>
              <a href="product-hapus.php?pKODE=<?php echo $row["id"]?> ">
                <button type="button" class="btn  btn-danger">
                  <i class="fa fa-trash"></i>
                </button>
              </a>
              <a href="product-tambah.php?pKODE=<?php echo $row["id"]?> ">
                <button type="button" class="btn  btn-primary">
                  <i class="fas fa-plus"></i>
                </button>
              </a>             
            </td>
          </tr>
           
        <?php  } ?>
    <?php  } ?>
                  </tbody>
                </table>
              </div>
              <form method="POST" enctype="multipart/form-data">
                <div class="card-footer">
                  <input type="submit" name="Refresh" value="Refresh" class="btn btn-primary">
              </div>
              </form>
              <!-- /.card-body -->
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
