<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";

  if(isset($_POST['Simpan']))
  { 
    if (isset($_REQUEST["InputNama"]))
    { $nama = $_REQUEST["InputNama"];
    } 
    if (!empty($nama))
    { $nama = $_POST['InputNama'];  
    }
    $email = $_POST['InputEmail'];
    $phonenumber = $_POST['InputPhoneNumber'];
    $address = $_POST['InputAddress'];
    $adminkode = $_SESSION['kodeuser']
    
    mysqli_query($connection, "INSERT INTO partner VALUES ('','$nama','$address','$email', '$phonenumber','$adminkode')"); 
  }
   
  $normalquery = mysqli_query($connection, "select * from customer");
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Customer</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Customer</li>
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
                <h3 class="card-title">Form Order</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group">
                    <label for="nama">Partner Name</label>
                    <input type="text" class="form-control" name="InputNama" id="nama" placeholder="Enter Name" required="">
                  </div>

      
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="InputEmail" id="email" placeholder="Enter Email" required="">
                  </div>

                  <div class="form-group">
                    <label for="phonenumber">Phone Number</label>
                    <input type="text" class="form-control" name="InputPhoneNumber" id="phonenumber" placeholder="Enter Phone Number" required="">
                  </div>

                  <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="InputAddress" id="address" placeholder="Enter Address">
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
                <h3 class="card-title">Partner</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example"  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
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

            <td></td>
            <td><?php echo $row['partnerNAME']; ?> </td>
            <td><?php echo $row['partnerEMAIL']; ?> </td>
            <td><?php echo $row['partnerPHONENUMBER']; ?> </td>
            <td ><?php echo $row['partnerADDRESS']; ?> </td>          
            <td>
              <a href="partner-edit.php?prKODE=<?php echo $row["partnerKODE"]?> ">
                <button type="button" class="btn  btn-info">
                  <i class="fas fa-pencil-alt"></i>
                </button>
              </a>
              <a href="partner-hapus.php?prKODE=<?php echo $row["partnerKODE"]?> ">
                <button type="button" class="btn  btn-danger">
                  <i class="fa fa-trash"></i>
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
<script type="text/javascript">
  $(document).ready(function() {
    var t = $('#example').DataTable( {
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 1, 'asc' ]]
    } );
 
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
} );
</script>
