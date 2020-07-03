<?php
    include "connection.php";

    $nia_anggota = $_GET["nia"];

    $result=mysqli_query($conn, "SELECT * FROM user WHERE nia = $nia_anggota");
    while ($row1=mysqli_fetch_array($result)){
        $foto      =   $row1["foto_anggota"];
    }

    if ($foto  != ""){
        $target = "images/" .$foto;
        if(file_exists($target)){
            unlink($target);
        }
    }
    
    if($nia != null){
        $query="DELETE FROM user where nia  = $nia_anggota;";
        $delete=mysqli_query($conn,$query);
        echo "<script>location.replace('tabel_anggota.php?status=berhasildihapus')</script>";
    }else{
        echo "<script>location.replace('tabel_anggota.php?status=gagaldihapus')</script>";
    }
?>