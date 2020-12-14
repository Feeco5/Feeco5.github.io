<!DOCTYPE html>
<html lang="en">
<?php 
  include "include/header.php";

  function integerToRoman($integer){
     // Convert the integer into an integer (just to make sure)
     $integer = intval($integer);
     $result = '';
     
     // Create a lookup array that contains all of the Roman numerals.
     $lookup = array('M' => 1000,
     'CM' => 900,
     'D' => 500,
     'CD' => 400,
     'C' => 100,
     'XC' => 90,
     'L' => 50,
     'XL' => 40,
     'X' => 10,
     'IX' => 9,
     'V' => 5,
     'IV' => 4,
     'I' => 1);
     
     foreach($lookup as $roman => $value){
      // Determine the number of matches
      $matches = intval($integer/$value);
     
      // Add the same number of characters to the string
      $result .= str_repeat($roman,$matches);
     
      // Set the integer to be the remainder of the integer and the value
      $integer = $integer % $value;
     }
     
     // The Roman numeral should be built, return it
     return $result;
    }

  if(isset($_POST['Simpan']))
  { 
    if (isset($_REQUEST["InputCustomerKode"]))
    { $customerKODE = $_REQUEST["InputCustomerKode"];
    } 
    if (!empty($customerKODE))
    { $customerKODE = $_POST['InputCustomerKode'];  
    }
    $productKODE = $_POST['InputProductKode'];
    $paymentdue = $_POST['InputDuePayment'];

    $var = $_POST['InputTanggal'];
    $tanggalORDER = date('Y-m-d', strtotime($var));

    $month = date("m",strtotime($tanggalORDER));
    $year = date('y',strtotime($tanggalORDER));
    $tanggal = $year."-".$month;

    date_default_timezone_set('Asia/Jakarta');
    $mydate=getdate(date("U"));
    $lastUPDATE ="$mydate[year]-$mydate[mon]-$mydate[mday]  $mydate[hours]:$mydate[minutes]:$mydate[seconds] ";

    $karyawanKODE = $_POST['InputKaryawanKode'];
    
    $adminkode = $_SESSION['kodeuser'];

    mysqli_query($connection, "INSERT INTO pesanan VALUES ('$tanggal','','','$tanggalORDER', '$paymentdue','$karyawanKODE','$customerKODE' ,'$adminkode', '$lastUPDATE')"); 
  }
   
  $adminkode = $_SESSION['kodeuser'];
  $normalquery = mysqli_query($connection, "SELECT * from pesanan left join partner on pesanan.customerKODE = partner.partnerKODE  left join karyawan on pesanan.karyawanKODE = karyawan.karyawanKODE where pesanan.adminKODE = '$adminkode' ");
    $query = mysqli_query($connection, "SELECT * from partner JOIN jenispartner on partner.jenispartnerKODE = jenispartner.jenispartnerKODE where jenispartnerNAME = 'Customer' ");
    $karyawan = mysqli_query($connection, "SELECT * from karyawan where adminKODE = '$adminkode' ")

?>

<title>Order</title>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Order</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Order</li>
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

                  <div class="form-group ">
                    <label  for="customerKODE">Nama Customer</label>
                        <select name="InputCustomerKode" class="form-control" id="customerKODE" placeholder="Nama Customer">
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

                <div class="form-group ">
                    <label for="duePayment" class="col-12">Due Payment</label>
                    <input type="text" class="form-control" name="InputDuePayment" id="duePayment" placeholder="Enter Due Payment" required="">
                  </div>

                <div class="form-group ">
                    <label  for="karyawanKODE">Nama Karyawan</label>
                        <select name="InputKaryawanKode" class="form-control" id="karyawanKODE" placeholder="Nama Karyawan">
                        <?php if (mysqli_num_rows($karyawan) > 0) {?>
                        <?php while($krow=mysqli_fetch_array($karyawan))
                        {?>
                        <option value="<?php echo $krow["karyawanKODE"]?>">
                        <?php echo $krow["karyawanNAMA"]?>
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

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Order</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Kode Order</th>
                    <th>Nama Customer</th>
                    <th>Tanggal Order</th>
                    <th>Grand Total</th>
                    <th>Due Payment</th>
                    <th>Karyawan</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
      /** Memeriksa apakah data yang dipanggil tersebut tersedia atau tidak **/
      if(mysqli_num_rows($normalquery)>0) 
    {?>
      
      <?php while ($row = mysqli_fetch_array($normalquery)) 
        { 
         
          $id =  sprintf('%03d', $row['id']);
          $month = date("m",strtotime($row['tanggalORDER']));
          $year = date('y',strtotime($row['tanggalORDER']));

          $nofaktur = $id . "/BKC/". integerToRoman($month) . "/". $year


          ?>
          <tr class="info">
            
            <td> <a href="invoice-print.php?oKODE=<?php echo $row["id"]?>&tanggal=<?php echo $row["tanggal"]?>" target="_blank"> <?php echo $nofaktur; ?></a> </td>
            <td><?php echo $row['partnerNAME']; ?> </td>
            <td><?php echo $row['tanggalORDER']; ?> </td>
            <td>Rp <?php echo number_format($row['grandTOTAL'])  ?> </td>
            <td><?php echo $row['paymentdue']; ?> </td>
            <td><?php echo $row['karyawanNAMA']; ?> </td>         
            <td>
              <a href="order-edit.php?oKODE=<?php echo $row["id"]?>&tanggal=<?php echo $row["tanggal"]?>">
                <button type="button" class="btn  btn-info">
                  <i class="fas fa-pencil-alt"></i>
                </button>
              </a>
              <a href="order-hapus.php?oKODE=<?php echo $row["id"]?>&tanggal=<?php echo $row["tanggal"]?>">
                <button type="button" class="btn  btn-danger">
                  <i class="fa fa-trash"></i>
                </button>
              </a>
              <a href="detailorder.php?oKODE=<?php echo $row["id"]?>&tanggal=<?php echo $row["tanggal"]?>">
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

