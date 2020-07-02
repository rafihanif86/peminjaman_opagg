<?php
// mengaktifkan session php
session_start();
 
// menghubungkan dengan koneksi
include 'connection.php';
 
// menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = $_POST['password'];

$nia = "";
$status = "";
$login_status = "";

    $query1 = "SELECT * FROM user WHERE username = '$username' and password = '$password';";
    $result1=mysqli_query($conn,$query1);
    while ($row1=mysqli_fetch_array($result1)){
        $status = $row1["posisi"];
        $login_status = $row1["login_status"];
        $nia = $row1["nia"];
    }

if($status != "" && $login_status != ""){
    $query2 = "UPDATE user set login_status = 'login' WHERE nia = '$nia'";
    $result2=mysqli_query($conn,$query2);
    $_SESSION['nia'] = $nia;
    $_SESSION['status'] = $status;
    $_SESSION['last_login_timestamp'] = time();
    header("location:dashboard_admin.php");
}else{
	header("location:login.php?pesan=gagal");
}
?>