<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";

  if(isset($_POST['Simpan']))
  { 
    if (isset($_REQUEST["InputFaktur"]))
    { $faktur = $_REQUEST["InputFaktur"];
    } 
    if (!empty($faktur))
    { $faktur = $_POST['InputFaktur'];  
    }

    $var = $_POST['InputTanggal'];
    $date = str_replace('/', '-', $var);
    $tanggalORDER = date('Y-m-d', strtotime($date));
    
    $adminkode = $_SESSION['kodeuser'];

    mysqli_query($connection, "INSERT INTO returpenjualan VALUES ('','$tanggalORDER','', '$faktur','$adminkode')"); 
  }
  $adminkode = $_SESSION['kodeuser'];

  $normalquery = mysqli_query($connection, "SELECT * from returpenjualan where adminKODE = '$adminkode' ");
  $pesanan = mysqli_query($connection, "SELECT * from pesanan where adminKODE = '$adminkode' ");
?>

<title>Retur Penjualan</title>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Retur Penjualan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Retur Penjualan</li>
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
                <h3 class="card-title">Form Retur Penjualan</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group ">
                    <label  for="faktur">No Faktur</label>
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
                  <label>Tanggal Retur Penjualan</label>
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

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Retur Penjualan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Kode Retur Penjualan</th>
                    <th>No Faktur</th>
                    <th>Tanggal Retur Penjualan</th>
                    <th>Grand Total</th>
                    <th>Action</th>
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
            
            <td><?php echo $row['returpenjualanKODE']; ?></td>
            <td><?php echo $row['orderKODE']; ?> </td>
            <td><?php echo $row['returDATE']; ?> </td>
            <td>Rp <?php echo number_format($row['returTOTALHARGA'])  ?> </td>        
            <td>
              <a href="retur-edit.php?rKODE=<?php echo $row["returpenjualanKODE"]?>">
                <button type="button" class="btn  btn-info">
                  <i class="fas fa-pencil-alt"></i>
                </button>
              </a>
              <a href="retur-hapus.php?rKODE=<?php echo $row["returpenjualanKODE"]?>">
                <button type="button" class="btn  btn-danger">
                  <i class="fa fa-trash"></i>
                </button>
              </a>
              <a href="detailretur.php?rKODE=<?php echo $row["returpenjualanKODE"]?>">
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

