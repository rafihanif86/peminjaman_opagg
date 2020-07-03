<?php
    include "connection.php";

    $id_detail=$_GET["id_detail"];
    $id_peminjaman_masuk=$_GET["id_peminjaman_masuk"];
    
    if($id_detail != null){
        $id_check_keluar = "";
        
        $resultKel=mysqli_query($conn,"SELECT * FROM detail_peminjaman_diterima WHERE id_detail = '$id_detail'; ") ;
        while ($row6=mysqli_fetch_array($resultKel)){
            $id_check_keluar = $row6["id_check_keluar"];
        }

        $query1="DELETE FROM checklist_record where id_check = $id_id_check_keluar;";
        $delete1=mysqli_query($conn,$query1);
        
        $delete = false;
        if($delete1){
            $query="DELETE FROM detail_peminjaman_diterima where id_detail = $id_detail;";
            $delete=mysqli_query($conn,$query);
        }

        if($delete){
            echo "<script> location.replace('form_peminjaman_pengambilan.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=berhasildihapus')</script>";
        }else{
            echo "<script> location.replace('form_peminjaman_pengambilan.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=gagaldihapus')</script>";
        }
        
        
    }else{
        echo "<script> location.replace('form_peminjaman_pengambilan.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=gagaldihapus')</script>";
    }
?>