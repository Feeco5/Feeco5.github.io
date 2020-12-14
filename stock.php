<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";
  $adminkode = $_SESSION['kodeuser'];
  $normalquery = mysqli_query($connection, "select * from barang where adminKODE = '$adminkode' ");
?>

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
<title>Stock</title>

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
                <h4 class="card-title">Product</h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: auto;">Kode Product</th>
                      <th style="width: auto;"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(mysqli_num_rows($normalquery)>0){?>
                      <?php while ($row = mysqli_fetch_array($normalquery)){ ?>
                        <tr class="info">
                          <td ><?php echo $row['barangKODE'] ?></td>
                          <td>
                            <a href="img/product/<?php echo $row['foto']?>" name="foto1" data-type="image" data-toggle="lightbox" data-title="<?php echo $row['barangNAMA'] ?>" data-footer="Rp <?php echo number_format($row['harga'])  ?>" data-gallery="gallery">
                              <img src="img/product/<?php echo $row['foto']?>" style="width: 500px" class="img-fluid mb-2" alt="white sample"/>
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
