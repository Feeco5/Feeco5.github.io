<?php
include "include/config.php";
  session_start();
  $_SESSION['logged_in'] = true; //set you've logged in
  $_SESSION['last_activity'] = time(); //your last activity was now, having logged in.
  $_SESSION['expire_time'] = 30*60; //expire time in seconds: 30 mins (you must change this)

  if($_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) { //have we expired?
    //redirect to logout.php
    header('location:logout.php'); //change yoursite.com to the name of you site!!
  } 
  else { //if we haven't expired:
    $_SESSION['last_activity'] = time(); //this was the moment of last activity.
  }
  if(!isset($_SESSION["kodeuser"])) { 
    session_start();
    header('location:logout.php');
?>
<meta http-equiv="refresh" content="0;URL=login.php"/>
<?php
}
?>


<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  

  <link rel="icon" type="image/png" href="img/logo.ico"/>

    <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="plugins/ekko-lightbox/ekko-lightbox.css">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/adminlte.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script src="src/jquery.table2excel.js"></script>


<script>
function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('txt').innerHTML =
  h + ":" + m + ":" + s;
  var t = setTimeout(startTime, 500);
}
function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}

</script>

</head>
<body class="hold-transition sidebar-mini" onload="startTime()">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="home.php" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">      
     <li class="nav-item d-none d-sm-inline-block">
        <a href="logout.php" style="color: red;" > Log Out</a>          
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
   

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="img/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block" style="text-transform: capitalize;"> Hello, <?php echo $_SESSION["namauser"];?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link Inactive">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Input
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="product.php" class="nav-link ">
                  <p>Product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="bahanbaku.php" class="nav-link ">
                  <p>Bahan Baku</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="stock-history.php" class="nav-link">
                  <p>Update History</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="product-log.php" class="nav-link">
                  <p>Data Log</p>
                </a>
              </li>
              <?php 
                $level = $_SESSION['role'] == 'user1';
                $admin = $_SESSION['role'] == 'admin';
                if($level || $admin) {
              ?>
              <li class="nav-item">
                <a href="karyawan.php" class="nav-link">
                  <p>Karyawan</p>
                </a>
              </li>
            <?php } ?> 
            </ul>
          </li>

          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link Inactive">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>
                Monitoring
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="stock.php" class="nav-link">
                  <p>Product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="stock-bahanbaku.php" class="nav-link ">
                  <p>Bahan Baku</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="custom.php" class="nav-link ">
                  <p>Custom</p>
                </a>
              </li>
            </ul>
          </li>
          <?php 
                $level = $_SESSION['role'] == 'user1';
                $admin = $_SESSION['role'] == 'admin';
                if($level || $admin) {
              ?>
          <li class="nav-item">
            <a href="#" class="nav-link Inactive">
              <i class="nav-icon fa fa-shopping-cart"></i>
              <p>
                Partner
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="partner.php" class="nav-link ">
                  <p>Partner</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="jenispartner.php" class="nav-link ">
                  <p>Jenis Partner</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="History.php" class="nav-link ">
                  <p>History</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="order-log.php" class="nav-link">
                  <p>Data Log</p>
                </a>
              </li> -->
            </ul>
          </li>
           <li class="nav-item has-treeview ">
            <a href="#" class="nav-link Inactive">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>
                Transaksi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pembelian.php" class="nav-link ">
                  <p>Pembelian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="order.php" class="nav-link ">
                 
                  <p>Penjualan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="retur.php" class="nav-link ">
                  <p>Retur Penjualan</p>
                </a>
              </li>
            </ul>
          </li>  
          <?php } ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>

    <!-- /.sidebar -->
  </aside>

    <!-- Control sidebar content goes here -->
      