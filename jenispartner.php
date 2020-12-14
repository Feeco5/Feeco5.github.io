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
    
    
    mysqli_query($connection, "INSERT INTO jenispartner VALUES ('','$nama')"); 
  }
   
  $normalquery = mysqli_query($connection, "select * from jenispartner");
?>

<title>Jenis Partner</title>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Jenis Partner</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Jenis Partner</li>
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
                <h3 class="card-title">Form Jenis Partner</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group">
                    <label for="nama">Name</label>
                    <input type="text" class="form-control" name="InputNama" id="nama" placeholder="Enter Name" required="">
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
                <h3 class="card-title">Jenis Partner</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example"  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
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
            <td><?php echo $row['jenispartnerNAME']; ?> </td>          
            <td>
              <a href="jenispartner-edit.php?jpKODE=<?php echo $row["jenispartnerKODE"]?> ">
                <button type="button" class="btn  btn-info">
                  <i class="fas fa-pencil-alt"></i>
                </button>
              </a>
              <a href="jenispartner-hapus.php?jpKODE=<?php echo $row["jenispartnerKODE"]?> ">
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
