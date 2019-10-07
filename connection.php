<?php 

    $conn = mysqli_connect("localhost", "root", "") or die ("koneksi database gagal");
    mysqli_select_db("inventorygg") or die ("database tidak ada");
?>