<?php
    include "connection.php";

    $id_jenis_alat=$_GET["id_jenis_alat"];

    $result=mysqli_query($conn, "SELECT * FROM jenis_alat WHERE id_jenis_alat = $id_jenis_alat");
    while ($row1=mysqli_fetch_array($result)){
        $foto      =   $row1["foto_jenis_alat"];
    }

    if ($foto  != ""){
        $target = "images/" .$foto;
        if(file_exists($target)){
            unlink($target);
        }
    }
    
    if($id_jenis_alat != null){
        $query="DELETE FROM kategori where id_jenis_alat = $id_jenis_alat;";
        $delete=mysqli_query($conn,$query);
        echo "<script>alert('Data Berhasil Dihapus')
            location.replace('tabel_kategori.php')</script>";
    }else{
        echo "<script>alert('Data Gagal Dihapus')
        location.replace('tabel_kategori.php')</script>";
    }
?>