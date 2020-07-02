<?php
    include "connection.php";

    $id_alat=$_GET["id_alat"];

    $result=mysqli_query($conn, "SELECT * FROM alat WHERE id_alat = $id_alat");
    while ($row1=mysqli_fetch_array($result)){
        $foto      =   $row1["foto_alat"];
    }

    if ($foto  != ""){
        $target = "images/" .$foto;
        if(file_exists($target)){
            unlink($target);
        }
    }
    
    if($id_alat != null){

        $res=mysqli_query($conn, "SELECT * FROM checklist_record WHERE id_alat = $id_alat");
        while ($row1=mysqli_fetch_array($res)){
            $foto_check      =   $row1["foto_alat_check"];
            if ($foto_check  != ""){
                $target = "images/" .$foto;
                if(file_exists($target)){
                    unlink($target);
                }
            }
        }

        $query1="DELETE FROM checklist_record where id_alat = $id_alat;";
        $delete1=mysqli_query($conn,$query1);

        $query2="DELETE FROM detail_peminjaman_diterima where id_alat = $id_alat;";
        $delete2=mysqli_query($conn,$query2);

        $query="DELETE FROM alat where id_alat = $id_alat;";
        $delete=mysqli_query($conn,$query);

        if($delete){
            echo "<script>location.replace('tabel_alat.php?status=berhasildihapus')</script>";
        }else{
            echo "<script>location.replace('tabel_alat.php?status=gagaldihapus')</script>";
        }
    }
?>