<?php 
// mengaktifkan session
session_start();
include 'connection.php';

$nia = $_SESSION['nia'];
$query2 = "UPDATE user set login_status = 'logout' WHERE nia = '$nia'";
$result2=mysqli_query($conn,$query2);
if($result2){
    // menghapus semua session
    session_destroy();

    // mengalihkan halaman sambil mengirim pesan logout
    header("location:login.php?pesan=logout");
}else{
    echo "<script>alert('Gagal Keluar')
         location.replace('dahsboard_admin.php')</script>";
                    
}
 

?>