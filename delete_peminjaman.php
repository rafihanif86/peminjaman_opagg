<?php
    include "connection.php";

    $id_peminjaman_masuk=$_GET["id_peminjaman_masuk"];
    
    if($id_peminjaman_masuk != null){
        $delete=mysqli_query("DELETE FROM checklist_record where id_peminjaman_masuk = $id_peminjaman_masuk;",$conn);
        echo "<script>alert('Data Berhasil Dihapus')
            location.replace('tabel_peminjaman.php')</script>";
    }else{
        echo "<script>alert('Data Gagal Dihapus')
        location.replace('tabel_peminjaman.php')</script>";
    }
?>