<?php
    include "connection.php";

    $id_check=$_GET["id_check"];

    $result=mysqli_query($conn, "SELECT * FROM checklist_record WHERE id_check = $id_check");
    while ($row1=mysqli_fetch_array($result)){
        $foto      =   $row1["foto_alat_check"];
    }

    if ($foto  != ""){
        $target = "images/" .$foto;
        if(file_exists($target)){
            unlink($target);
        }
    }
    
    if($id_check != null){
        $query="DELETE FROM checklist_record where id_check = $id_check;";
        $delete=mysqli_query($conn,$query);
        echo "<script>location.replace('tabel_checklist.php?status=berhasildihapus')</script>";
    }else{
        echo "<script>location.replace('tabel_checklist.php?status=gagaldihapus')</script>";
    }
?>