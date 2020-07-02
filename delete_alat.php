<?php
    include "connection.php";

    $id_alat=$_GET["id_alat"];
    
    if($id_alat != null){
        $query="DELETE FROM alat where id_alat = $id_alat;";
        $delete=mysqli_query($conn,$query);
        echo "<script>alert('Data Berhasil Dihapus')
            location.replace('tabel_alat.php')</script>";
    }else{
        echo "<script>alert('Data Gagal Dihapus')
        location.replace('tabel_alat.php')</script>";
    }
?>