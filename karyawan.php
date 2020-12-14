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
    $phonenumber1 = $_POST['InputPhoneNumber1'];
    $phonenumber2 = $_POST['InputPhoneNumber2'];
    $address = $_POST['InputAddress'];
    $role = $_POST['InputRole'];

    $adminkode = $_SESSION['kodeuser'];

    
    mysqli_query($connection, "INSERT INTO karyawan VALUES ('','$nama','$email','$phonenumber1', '$phonenumber2', '$address','$role','$adminkode' )"); 
  }
   $adminkode = $_SESSION['kodeuser'];
  $normalquery = mysqli_query($connection, "select * from karyawan where adminKODE = '$adminkode'");
?>
<title>Karyawan</title>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Karyawan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Karyawan</li>
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
                <div class="card-body" style="text-transform: capitalize;">
                  <div class="form-group" >
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" class="form-control" name="InputNama" id="nama" placeholder="Enter Name" required="">
                  </div>
     
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="InputEmail" id="email" placeholder="Enter Email" required="">
                  </div>

                  <div class="form-group">
                    <label for="phonenumber1">Phone Number 1</label>
                    <input type="text" class="form-control" name="InputPhoneNumber1" id="phonenumber1" placeholder="Enter Phone Number" required="">
                  </div>

                  <div class="form-group">
                    <label for="phonenumber2">Phone Number 2</label>
                    <input type="text" class="form-control" name="InputPhoneNumber2" id="phonenumber2" placeholder="Enter Phone Number">
                  </div>

                  <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="InputAddress" id="address" placeholder="Enter Address">
                  </div>
                

                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" class="form-control" name="InputRole" id="role" placeholder="Enter Role">
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
                <h3 class="card-title">Data Karyawan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example"  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Phone Number 1</th>
                    <th>Phone Number 2</th>
                    <th>Address</th>
                    <th>Role</th>
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
            <td><?php echo $row['karyawanNAMA']; ?> </td>
            <td><?php echo $row['email']; ?> </td>
            <td><?php echo $row['phoneNUMBER1']; ?> </td>
            <td><?php if($row['phoneNUMBER2'] != '0' ){echo $row['phoneNUMBER2'];} ;?> </td>
            <td ><?php echo $row['address']; ?> </td>  
            <td ><?php echo $row['role']; ?> </td>   
            <td>
              <a href="karyawan-edit.php?kKODE=<?php echo $row["karyawanKODE"]?> ">
                <button type="button" class="btn  btn-info">
                  <i class="fas fa-pencil-alt"></i>
                </button>
              </a>
              <a href="karyawan-hapus.php?kKODE=<?php echo $row["karyawanKODE"]?> ">
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
