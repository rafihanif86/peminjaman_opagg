<?php
    include "connection.php";

    $id_kat=$_GET["id_kat"];
    
    if($id_kat != null){
        $query="DELETE FROM checklist_record where id_kat = $id_kat;";
        $delete=mysqli_query($conn,$query);
        echo "<script>alert('Data Berhasil Dihapus')
            location.replace('tabel_kategori.php')</script>";
    }else{
        echo "<script>alert('Data Gagal Dihapus')
        location.replace('tabel_kategori.php')</script>";
    }
?>