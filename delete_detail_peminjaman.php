<?php
    include "connection.php";

    $id_detail_masuk=$_GET["id_detail_masuk"];
    $id_peminjaman_masuk=$_GET["id_peminjaman_masuk"];
    $user=$_GET["user"];
    
    if($id_detail_masuk != null){
        $query="DELETE FROM detail_peminjaman_masuk where id_detail_masuk = $id_detail_masuk;";
        $delete=mysqli_query($conn,$query);
        if($user == 'admin'){
            echo "<script>  location.replace('form_peminjaman_list.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=berhasildihapus')</script>";
        }else{
            echo "<script> location.replace('dash_item_peminjaman.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=berhasildihapus')</script>";
        }
        
    }else{
        if($user == 'admin'){
            echo "<script> location.replace('form_peminjaman_list.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=gagaldihapus')</script>";
        }else{
            echo "<script> location.replace('dash_item_peminjaman.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=gagaldihapus')</script>";
        }
    }

?>