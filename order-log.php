<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";   
  $normalquery = mysqli_query($connection, "select * from customer_log");
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
            <h1 class="m-0 text-dark">Order Data Log</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Order Data Log</li>
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

            <div class="card-primary">
              <div class="card-header">
                <h3 class="card-title">Customer Data Log</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Action</th>
                    <th>Action Time</th>
                    <th>Nama Customer</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
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
            
            <td><?php echo $row['action']; ?> </td>
            <td><?php echo $row['action_time']; ?> </td>
            <td><?php echo $row['customerNAME']; ?> </td>
            <td><?php echo $row['email']; ?> </td>
            <td><?php echo $row['phoneNUMBER1']; ?> | <?php if($row['phoneNUMBER2'] != '0' ){echo $row['phoneNUMBER2'];} ;?> </td>
            <td ><?php echo $row['address']; ?> </td>      
          </tr>
           
        <?php  } ?>
    <?php  } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- card -->
            <div class="card-primary">
              <div class="card-header">
                <h3 class="card-title">Order Data Log</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Action</th>
                    <th>Action Time</th>
                    <th>Kode Order</th>
                    <th>Customer Name</th>
                    <th></th>
                    <th>Address</th>
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
            
            <td><?php echo $row['action']; ?> </td>
            <td><?php echo $row['action_time']; ?> </td>
            <td><?php echo $row['customerNAME']; ?> </td>
            <td><?php echo $row['email']; ?> </td>
            <td><?php echo $row['phoneNUMBER1']; ?> | <?php if($row['phoneNUMBER2'] != '0' ){echo $row['phoneNUMBER2'];} ;?> </td>
            <td ><?php echo $row['address']; ?> </td>      
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
