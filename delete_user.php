<?php
    include "connection.php";

    $id_user=$_GET["id_user"];
    
    if($id_user != null){
        $delete=mysqli_query("DELETE FROM checklist_record where id_user = $id_user;",$conn);
        echo "<script>alert('Data Berhasil Dihapus')
            location.replace('tabel_user.php')</script>";
    }else{
        echo "<script>alert('Data Gagal Dihapus')
        location.replace('tabel_user.php')</script>";
    }
?>