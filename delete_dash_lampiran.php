<?php
    include "connection.php";

    $id_peminjaman_masuk=$_GET["id_peminjaman_masuk"];

    $result=mysqli_query($conn, "SELECT * FROM peminjaman_masuk WHERE id_peminjaman_masuk = $id_check");
    while ($row1=mysqli_fetch_array($result)){
        $foto      =   $row1["lampiran_surat"];
    }

    if ($foto  != ""){
        $target = "images/" .$foto;
        if(file_exists($target)){
            unlink($target);
        }
    }
    
    if($id_check != null){
        $query="UPDATE peminjaman_masuk set  lampiran_surat = '' where id_peminjaman_masuk = '$id_peminjaman_masuk';";;
        $delete=mysqli_query($conn,$query);
        echo "<script>location.replace('dash_peminjaman.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=berhasildihapus')</script>";
    }else{
        echo "<script>location.replace('dash_peminjaman.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=gagaldihapus')</script>";
    }
?>