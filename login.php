<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin || Login</title>

  <link rel="icon" type="image/png" href="img/logo.ico"/>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/adminlte.min.css">
</head>

<?PHP 
include "include/config.php";
ob_start();
session_start();
if(isset($_SESSION['username']))
    header("location:home.php");

// ini proses login
if(isset($_POST["submitlogin"])) {
    $namauser = $_POST["username"];
    $passuser = MD5($_POST["password"]); //MD5 untuk membuka enkripsi password
  if (empty($_POST["username"])) {
    echo '<script> alert("Mohon untuk mengisi username!"); window.location="login.php" </script>';
    return;
  }
  if (empty($_POST["password"])) {
    echo '<script> alert("Mohon untuk mengisi password!"); window.location="login.php" </script>';
    return;
  }
  $check_user = mysqli_query($connection, "SELECT * from admin2 
                                where NAMAadmin = '$namauser'");
  
    if(mysqli_num_rows($check_user)>0) {
    $sql_login = mysqli_query($connection, "SELECT * from admin2 
               where NAMAadmin = '$namauser' and PASSWORDadmin = '$passuser' ");
  
    
    if(mysqli_num_rows($sql_login)>0) {
      $row_admin = mysqli_fetch_array($sql_login);
      $_SESSION['kodeuser'] = $row_admin['IDadmin'];
      $_SESSION['namauser'] = $row_admin['NAMAadmin'];
      $_SESSION['role'] = $row_admin['role'];
      header("location:home.php");
    }
    else {
      echo '<script> alert("Username dan Password tidak Valid!"); window.location="login.php" </script>';
      return;
    }
    }
  else {
    echo '<script> alert("Username tidak terdaftar!"); window.location="login.php" </script>';
    return;
  }
}
?>

<body class="hold-transition login-page" style="background-image: linear-gradient( rgb(173,216,230), white);">
<div class="login-box">
  <div class="login-logo">
      <img src="img/logo.png" style="width: 50%">
    <a href="#"><b>BintangKelindo</b>Cemerlang</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Please sign in</p>

      <form action="login.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
            <button type="submit" value="login" name="submitlogin" class="btn btn-primary btn-block">Sign In</button>
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
