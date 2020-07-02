<?php
    include "connection.php";

    $id_detail=$_GET["id_detail"];
    
    if($id_detail != null){
        $query="DELETE FROM detail_peminjaman where id_detail = $id_detail;";
        $delete=mysqli_query($conn,$query);
        echo "<script>alert('Data Berhasil Dihapus')
            location.replace('tabel_detailPeminjaman.php')</script>";
    }else{
        echo "<script>alert('Data Gagal Dihapus')
        location.replace('tabel_detailPeminjaman.php')</script>";
    }
?>