<?php
    include "connection.php";

    $id_check=$_GET["id_check"];
    
    if($id_check != null){
        $delete=mysqli_query("DELETE FROM checklist_record where id_check = $id_check;",$conn);
        echo "<script>alert('Data Berhasil Dihapus')
            location.replace('tabel_checklist.php')</script>";
    }else{
        echo "<script>alert('Data Gagal Dihapus')
        location.replace('tabel_checklist.php')</script>";
    }
?>