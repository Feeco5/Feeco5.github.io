<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";

  if(isset($_POST['Simpan']))
  { 
    if (isset($_REQUEST["InputPartnerKode"]))
    { $partnerKODE = $_REQUEST["InputPartnerKode"];
    } 
    if (!empty($partnerKODE))
    { $partnerKODE = $_POST['InputPartnerKode'];  
    }

    $var = $_POST['InputTanggal'];
    $date = str_replace('/', '-', $var);
    $tanggalORDER = date('Y-m-d', strtotime($date));
    $adminkode = $_SESSION['kodeuser'];
    
    mysqli_query($connection, "INSERT INTO pembelian VALUES ('','$partnerKODE','$tanggalORDER', '', '$adminkode')"); 
  }
   
  $adminkode = $_SESSION['kodeuser'];
  $normalquery = mysqli_query($connection, "SELECT * from pembelian join partner on pembelian.partnerKODE = partner.partnerKODE where pembelian.adminKODE = '$adminkode' ");
  $query = mysqli_query($connection, "SELECT * from partner JOIN jenispartner on partner.jenispartnerKODE = jenispartner.jenispartnerKODE where name = 'Supplier' ");
?>

<title>Pembelian</title>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Pembelian</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Pembelian</li>
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
                <h3 class="card-title">Form Pembelian</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group ">
                    <label  for="partnerKODE">Nama Supplier</label>
                        <select name="InputPartnerKode" class="form-control" id="partnerKODE" placeholder="Nama Supplier">
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
                  <label>Tanggal Order</label>
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
                <h3 class="card-title">Pembelian</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Kode Pembelian</th>
                    <th>Nama Supplier</th>
                    <th>Tanggal Order</th>
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
            
            <td> <a href="invoice-print.php?pKODE=<?php echo $row["pembelianKODE"]?>" target="_blank"> <?php echo $row['pembelianKODE']; ?></a> </td>
            <td><?php echo $row['partnerNAME']; ?> </td>
            <td><?php echo $row['tanggalORDER']; ?> </td>
            <td>Rp <?php echo number_format($row['grandtotal'])  ?> </td>        
            <td>
              <a href="pembelian-edit.php?pKODE=<?php echo $row["pembelianKODE"]?>">
                <button type="button" class="btn  btn-info">
                  <i class="fas fa-pencil-alt"></i>
                </button>
              </a>
              <a href="pembelian-hapus.php?pKODE=<?php echo $row["pembelianKODE"]?>">
                <button type="button" class="btn  btn-danger">
                  <i class="fa fa-trash"></i>
                </button>
              </a>
              <a href="detailpembelian.php?pKODE=<?php echo $row["pembelianKODE"]?>">
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

