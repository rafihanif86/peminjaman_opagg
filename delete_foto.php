<?php
    include "connection.php";

    $id_peminjaman_masuk=$_GET["id_peminjaman_masuk"];
    $id_surat=$_GET["id_surat"];
    
    if($id_peminjaman_masuk != null){
        $query="DELETE FROM foto_surat where id_surat = $id_surat;";
        $delete=mysqli_query($conn,$query);
        echo "<script>alert('Data Berhasil Dihapus')
            location.replace('form_peminjaman.php?edit=true&id_peminjaman_masuk=$id_peminjaman_masuk')</script>";
    }else{
        echo "<script>alert('Data Gagal Dihapus')
        location.replace('form_peminjaman.php?edit=true&id_peminjaman_masuk=$id_peminjaman_masuk')</script>";
    }
?>