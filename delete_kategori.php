<?php
    include "connection.php";

    $id_kat=$_GET["id_kat"];
    
    if($id_kat != null){
        $delete=mysqli_query("DELETE FROM checklist_record where id_kat = $id_kat;",$conn);
        echo "<script>alert('Data Berhasil Dihapus')
            location.replace('tabel_kategori.php')</script>";
    }else{
        echo "<script>alert('Data Gagal Dihapus')
        location.replace('tabel_kategori.php')</script>";
    }
?>