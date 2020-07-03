<?php
    include "connection.php";

    $id_kat = $_GET["id_kat"];

    $result=mysqli_query($conn, "SELECT * FROM kategori WHERE id_kat = $id_kat");
    while ($row1=mysqli_fetch_array($result)){
        $foto      =   $row1["foto_kat"];
    }

    if ($foto  != ""){
        $target = "images/" .$foto;
        if(file_exists($target)){
            unlink($target);
        }
    }
    
    if($nia != null){
        $query="DELETE FROM kategori where id_kat = $id_kat;";
        $delete=mysqli_query($conn,$query);
        echo "<script>location.replace('tabel_kategori.php?status=berhasildihapus')</script>";
    }else{
        echo "<script>location.replace('tabel_kategori.php?status=gagaldihapus')</script>";
    }
?>