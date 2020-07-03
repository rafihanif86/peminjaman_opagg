<?php
    include "connection.php";

    $id_checklist_group_item = $_GET["id_checklist_group_item"];
    
    if($id_detail != null){
        $id_check = "";
        
        $resultKel=mysqli_query($conn,"SELECT * FROM checklist_group_item WHERE id_checklist_group_item = '$id_checklist_group_item'; ") ;
        while ($row6=mysqli_fetch_array($resultKel)){
            $id_check = $row6["id_check"];
        }

        $query1="DELETE FROM checklist_record where id_check = $id_check;";
        $delete1=mysqli_query($conn,$query1);
        
        $delete = false;
        if($delete1){
            $sql_insert1 = mysqli_query($conn,"UPDATE checklist_group_item set id_check = '' where id_checklist_group_item = '$id_checklist_group_item';");
        }

        if($sql_insert1){
            echo "<script> location.replace('form_checklist_onprocess.php?status=berhasildihapus')</script>";
        }else{
            echo "<script> location.replace('form_checklist_onprocess.php?status=gagaldihapus')</script>";
        }
        
        
    }else{
        echo "<script> location.replace('form_checklist_onprocess.php?status=gagaldihapus')</script>";
    }
?>