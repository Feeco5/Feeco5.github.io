<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";
  if(isset($_POST['Search'])){
    $customer = $_POST['InputCustomer'];
    $Barang = $_POST['InputProduct'];
    
    $Search = mysqli_query($connection, "SELECT p.partnerNAME, COUNT(d.barangKODE), b.barangNAMA, SUM(pe.grandtotal), pe.tanggalORDER from partner p join pesanan pe on p.partnerKODE = pe.customerKODE join detailorder d on d.pesananKODE = pe.orderKODE join barang b on b.barangKODE = d.barangKODE group by p.partnerNAME HAVING p.partnerKODE = "$customer" ");
  }

  $adminkode = $_SESSION['kodeuser'];
  $normalquery = mysqli_query($connection, "select * from barang where adminKODE = '$adminkode' ");
  $query = mysqli_query($connection, "SELECT * from partner join jenispartner on partner.jenispartnerKODE = jenispartner.jenispartnerKODE where jenispartnerNAME = 'Customer' and adminKODE ='$adminkode'  " );
?>

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
            <h1 class="m-0 text-dark">Custom</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Custom</li>
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
              <!-- /.card-header -->

              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Show</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group ">
                    <label  for="customer">Customer</label>
                        <select name="InputCustomer" class="form-control" id="customer" >
                        <?php if (mysqli_num_rows($query) > 0) {?>
                        <?php while($row=mysqli_fetch_array($query))
                        {?>
                        <option value="<?php echo $row["partnerKODE"]?>">
                        <?php echo $row["partnerNAME"]?>
                        </option>
                        <?php } ?>
                        <?php } ?>
                        <option></option>
                      </select>
                    </div>

                  <div class="form-group ">
                    <label  for="product">Product</label>
                        <select name="InputProduct" class="form-control" id="product">
                        <?php if (mysqli_num_rows($normalquery) > 0) {?>
                        <?php while($row=mysqli_fetch_array($normalquery))
                        {?>
                        <option value="<?php echo $row["barangKODE"]?>">
                        <?php echo $row["barangNAMA"]?>
                        </option>
                        <?php } ?>
                        <?php } ?>
                        <option></option>
                      </select>
                    </div>  

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" name="Search" value="Search" class="btn btn-primary">
                </div>
              </form>
            </div>

          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h4 class="card-title">Product</h4>
              </div>
              <div class="card-body">
                <div class="row">

                  <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: auto;">Kode Product</th>
                      <th style="width: auto;">Foto</th>
                    </tr>
                   
                  </thead>
                  <tbody>
                     <?php if(mysqli_num_rows($Search)>0) 
                        {?>
      
      <?php while ($row = mysqli_fetch_array($Search)) 
        { ?>
                    <tr class="info">
                      <td ><?php echo $row['p.partnerNAME'] ?></td>
                      <td>
                        <a href="img/product/<?php echo $row['foto']?>" name="foto1" data-type="image" data-toggle="lightbox" data-title="<?php echo $row['barangNAMA'] ?>" data-footer="Rp <?php echo number_format($row['harga'])  ?>" data-gallery="gallery">
                          <img src="img/product/<?php echo $row['foto']?>" style="width: 50%" class="img-fluid mb-2" alt="white sample"/>
                        </a>
                      </td>
                    
                    </tr>
                    <?php  } ?>
    <?php  } ?>
                  </tbody>
                </table>
                  
                </div>
              </div>
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
