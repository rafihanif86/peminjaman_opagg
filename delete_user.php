<?php
    include "connection.php";

    $id_user=$_GET["id_user"];
    
    if($id_user != null){
        $query="DELETE FROM checklist_record where id_user = $id_user;";
        $delete=mysqli_query($conn,$query);
        echo "<script>alert('Data Berhasil Dihapus')
            location.replace('tabel_user.php')</script>";
    }else{
        echo "<script>alert('Data Gagal Dihapus')
        location.replace('tabel_user.php')</script>";
    }
?>