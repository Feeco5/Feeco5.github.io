<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";

  if(isset($_POST['Simpan']))
  { 
    if (isset($_REQUEST["InputBahanBakuKode"]))
    { $bahanbakuKODE = $_REQUEST["InputBahanBakuKode"];
    } 
    if (!empty($bahanbakuKODE))
    { $bahanbakuKODE = $_POST['InputBahanBakuKode'];   
    }
    $bahanbakuNAME = $_POST['InputBahanBakuName'];
    $price = $_POST['InputPrice'];
    $Quantity = $_POST['InputQty'];

    $totalharga = $price * $Quantity;

    $adminkode = $_SESSION['kodeuser'];
    $partnerKODE = $_POST['InputPartnerKode'];  

    date_default_timezone_set('Asia/Jakarta');
    $mydate=getdate(date("U"));
    $lastUPDATE ="$mydate[year]-$mydate[mon]-$mydate[mday]  $mydate[hours]:$mydate[minutes]:$mydate[seconds] ";
    
    mysqli_query($connection, "INSERT INTO bahanbaku VALUES ('','$bahanbakuKODE','$bahanbakuNAME','$Quantity','$price','$totalharga','$lastUPDATE','$adminkode', '$partnerKODE')"); 
  }
  $adminkode = $_SESSION['kodeuser'];
   
  $normalquery = mysqli_query($connection, "select * from bahanbaku join partner on bahanbaku.partnerKODE = partner.partnerKODE where bahanbaku.adminKODE = '$adminkode' ");
  $query = mysqli_query($connection, "SELECT * from partner JOIN jenispartner on partner.jenispartnerKODE = jenispartner.jenispartnerKODE where jenispartnerNAME = 'Supplier' ");
?>

<link rel="stylesheet" href="css/jquery.dataTables.css">
<link rel="stylesheet" href="css/buttons.dataTables.css">

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
<title>Bahan Baku</title>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Bahan Baku</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Bahan Baku</li>
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
                <h3 class="card-title">Input Bahan Baku</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group row">
                    <label for="bahanbakuKODE" class="col-12">Kode Bahan Baku</label>
                    <input class="form-control" type="text" id="bahanbakuKODE" name="InputBahanBakuKode" placeholder="Enter Kode Bahan Baku" maxlength="6" required="">
                  </div>

                  <div class="form-group row">
                    <label for="bahanbakuNAME" class="col-12">Nama Bahan Baku</label>
                    <input type="text" class="form-control" name="InputBahanBakuName" id="bahanbakuNAME" placeholder="Enter Nama Bahan Baku" required="">
                  </div>

                  <div class="form-group row">
                    <label for="qty" class="col-12">Qty</label>
                    <input type="text" class="form-control" name="InputQty" id="qty" placeholder="Enter Qty" required="">
                  </div>

                  <div class="form-group row">
                    <label for="price" class="col-12">Price</label>
                    <input type="text" class="form-control" name="InputPrice" id="price" placeholder="Enter Price" required="">
                  </div>

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
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" name="Simpan" value="Simpan" class="btn btn-primary">
                  <input type="reset" class="btn btn-success" value="Batal" name="Batal">
                </div>
              </form>
            </div>

            <div class="card card-primary ">
              <div class="card-header">
                <h3 class="card-title">Stock</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table-datatables" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th  style="width: auto;">Kode Bahan Baku</th>
                    <th ">Nama Bahan Baku</th>
                    <th >Stock</th>
                    <th >Price</th>
                    <th >Total Price</th>
                    <th >Last Updated</th>
                    <th>Supplier</th>
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
            
            <td><?php echo $row['bahanbakuKODE']; ?> </td>
            <td><?php echo $row['bahanbakuNAMA']; ?> </td>
            <td><?php echo $row['qty']; ?></td>
            <td>Rp <?php echo number_format($row['price'])  ?> </td>
            <td>Rp <?php echo number_format($row['totalprice'])  ?> </td>
            <td><?php echo $row['lastUPDATE']; ?></td>
            <td><?php echo $row['partnerNAME']; ?></td> 
            <td>
              <a href="bahanbaku-edit.php?bbKODE=<?php echo $row["id"]?> ">
                <button type="button" class="btn  btn-info">
                  <i class="fas fa-pencil-alt"></i>
                </button>
              </a>
              <a href="bahanbaku-hapus.php?bbKODE=<?php echo $row["id"]?> ">
                <button type="button" class="btn  btn-danger">
                  <i class="fa fa-trash"></i>
                </button>
              </a>
              <a href="bahanbaku-tambah.php?bbKODE=<?php echo $row["id"]?> ">
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

<?php include ("include/footer.php");
;
     ?>
<script type="text/javascript"> 
    $(document).ready(function () {
        $('#table-datatables').DataTable({
            dom: 'Bfrtip',
            buttons: [
      {
                extend: 'excel',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6]
                }
            },
      {
                extend: 'pdf',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6]
                }
            },
          {
                extend: 'print',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6]
                }
            }
        ]
        });
    });
</script>
</body>
</html>
