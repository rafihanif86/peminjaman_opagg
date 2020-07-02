<?php
    include "connection.php";

    $nik=$_GET["nik"];
    
    if($nik != null){
        $query="DELETE FROM peminjam where nik  = $nik;";
        $delete=mysqli_query($conn,$query);
        echo "<script>location.replace('tabel_peminjam.php?status=berhasildihapus')</script>";
    }else{
        echo "<script>location.replace('tabel_peminjam.php?status=gagaldihapus')</script>";
    }
?>