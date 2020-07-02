<?php
    include "connection.php";

    $id_check=$_GET["id_check"];
    
    if($id_check != null){
        $query="DELETE FROM checklist_record where id_check = $id_check;";
        $delete=mysqli_query($conn,$query);
        echo "<script>alert('Data Berhasil Dihapus')
            location.replace('tabel_checklist.php')</script>";
    }else{
        echo "<script>alert('Data Gagal Dihapus')
        location.replace('tabel_checklist.php')</script>";
    }
?>