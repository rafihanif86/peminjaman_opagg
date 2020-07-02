<?php
    include "connection.php";

    $id_detail_masuk=$_GET["id_detail_masuk"];
    $id_peminjaman_masuk=$_GET["id_peminjaman_masuk"];
    
    if($id_detail_masuk != null){
        $query="DELETE FROM detail_peminjaman_masuk where id_detail_masuk = $id_detail_masuk;";
        $delete=mysqli_query($conn,$query);
        echo "<script> location.replace('dash_item_peminjaman.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=berhasildihapus')</script>";
    }else{
        echo "<script> location.replace('dash_item_peminjaman.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=gagaldihapus')</script>";
    }
?>