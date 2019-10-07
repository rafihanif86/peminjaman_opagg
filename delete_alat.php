<?php
    include "connection.php";

    $id_alat=$_GET["id_alat"];
    
    if($id_alat != null){
        $delete=mysqli_query("DELETE FROM alat where id_alat = $id_alat;",$conn);
        echo "<script>alert('Data Berhasil Dihapus')
            location.replace('tabel_alat.php')</script>";
    }else{
        echo "<script>alert('Data Gagal Dihapus')
        location.replace('tabel_alat.php')</script>";
    }
?>