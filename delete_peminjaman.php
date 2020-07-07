<?php
    include "connection.php";

    $id_peminjaman_masuk=$_GET["id_peminjaman_masuk"];        
    
    if($id_peminjaman_masuk != null){
        $query1="DELETE FROM detail_peminjaman_masuk where id_peminjaman_masuk = $id_peminjaman_masuk;";
        $delete1=mysqli_query($conn,$query1);

        $query="DELETE FROM peminjaman_masuk where id_peminjaman_masuk = $id_peminjaman_masuk;";
        $delete=mysqli_query($conn,$query);

        if($delete || ($delete && $delete1)){
            echo "<script>alert('Data Berhasil Dihapus')
            location.replace('tabel_peminjaman.php?action=seluruh')</script>";
        }else{
            echo "<script>alert('Data Gagal Dihapus')
            location.replace('tabel_peminjaman.php?action=seluruh')</script>";
        }
        
    }else{
        echo "<script>alert('Data Gagal Dihapus')
        location.replace('tabel_peminjaman.php?action=seluruh')</script>";
    }
?>