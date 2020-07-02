<!DOCTYPE Html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Inventory OPA Ganendra Giri</title>
    <link rel="shortcut icon" href="images/ggIcon.png">
    <?php include 'import_header.php'; ?>
    <link href="styleLogin.css" rel="stylesheet">
</head>

<body style="background:url(images/backgroundLogin.jpg);
  background-repeat:  no-repeat; 
  background-position: center fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;">

    <!-- <div class="col-md-4 col-md-offset-4 form-login justify-content-center"> -->


        <br/>
        <div class="card form-login outter-form-login " style="margin: auto; width: 40%;">
            <div class="card-body">
                <form action="check-login.php" class="inner-login" method="post">
                    <div class="form-group">
                        <h3 class="text-center title-login card-title">Login Member</h3>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username">
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-block btn-custom-green" value="Masuk" /><br/>
                        <a href="index.php" class="btn btn-primary btn-block btn-sm">Kembali</a>
                    </div>
                </form>
            </div>
        </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
<?php 
  if(isset($_GET['pesan'])){
    if($_GET['pesan'] == "gagal"){
      echo " <script type='text/javascript'> window.onload = function(){  alert('Login gagal! username dan password salah!'); } </script> ";
    }else if($_GET['pesan'] == "logout"){
      echo "<script> window.onload = function(){alert('Anda telah logout')}</script>";
    }else if($_GET['pesan'] == "belum_login"){
      echo "<script> window.onload = function(){alert('Anda harus login untuk mengakses halaman admin')}</script>";
    }
  }
?>