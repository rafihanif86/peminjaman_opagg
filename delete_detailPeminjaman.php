<?php
    include "connection.php";

    $id_detail=$_GET["id_detail"];
    
    if($id_detail != null){
        $delete=mysqli_query("DELETE FROM detail_peminjaman where id_detail = $id_detail;",$conn);
        echo "<script>alert('Data Berhasil Dihapus')
            location.replace('tabel_detailPeminjaman.php')</script>";
    }else{
        echo "<script>alert('Data Gagal Dihapus')
        location.replace('tabel_detailPeminjaman.php')</script>";
    }
?>