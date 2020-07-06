<?php
    include "connection.php";

    $tgl_awal = $tgl_akhir = $jum_kat = $jumlah = $status = $jumlah_belum = $jumlah_telah = $judul = $act = "";
    $tgl_hari_ini = date('Y-m-d');

    if(isset($_GET["action"])){
        $act = $_GET["action"];
        if( $act == "valid"){
            $judul = "Valid";
        } else if( $act== "rusak"){
            $judul = "Rusak";
        }else if($act == "hilang"){
            $judul = "Hilang";
        }else if($act == "diputihkan"){
            $judul = "Diputihkan";
        }else if($act == "seluruh"){
            $judul = "Seluruh";
        }
    }
    
    $query2="SELECT a.*, j.nama_jenis_alat FROM `alat` A, `jenis_alat` J WHERE a.`id_jenis_alat` = j.`id_jenis_alat` ORDER BY a.`id_alat` DESC";
    $result2=mysqli_query($conn,$query2);
    $jumlah_telah_check = mysqli_num_rows($result2);
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Inventory Ganendra Giri</title>
    <link rel="shortcut icon" href="images/ggIcon.png">
</head>

<body>
    <?php
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=data_alat_terbaru_$tgl_hari_ini.xls");
    ?>

    <h3>Data Alat <?php echo " | ".$judul;?></h3>

    <b>Hasil Checklist:</b>
    <table style="border: 1">
        <tr>
            <th>No</th>
            <th>Jenis Alat</th>
            <th>Nomor Inventaris</th>
            <th>Merk</th>
            <th>Tipe</th>
            <th>Deskripsi</th>
            <th>Kondisi</th>
        </tr>
        <?php
            $i = 0;
            while ($row1=mysqli_fetch_array($result2)){
                $i++; 
                $kondisi = "";
                $keterangan = "";
                $petugas = "";
                $tgl_checklist = "";
                $nama_petugas = "";
                $status_peminjaman = "";
                $id_peminjaman_masuk = "";

                $id_alat = $row1["id_alat"];
                $res1=mysqli_query($conn,"SELECT * FROM `checklist_record` WHERE `id_check` IN (SELECT MAX(`id_check`) FROM `checklist_record` WHERE `id_alat` = '$id_alat');");
                while ($row2=mysqli_fetch_array($res1)){
                    $kondisi = $row2["kondisi"];
                    $keterangan = $row2["keterangan"];
                    $petugas = $row2["petugas"];
                    $tgl_checklist = $row2["tgl_checklist"];
                    $status_peminjaman = $row2["status_peminjaman"];
                    $id_peminjaman_masuk = $row2["id_peminjaman_masuk"];
                }
                $res2=mysqli_query($conn,"SELECT nama_user FROM user WHERE nia = '$petugas';");
                while ($row2=mysqli_fetch_array($res2)){
                    $nama_petugas = $row2["nama_user"];
                }
                if($kondisi == $act || $act == "seluruh"){ 
        ?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $row1["nama_jenis_alat"];?></td>
            <td><?php echo $row1["id_alat"];?></td>
            <td><?php echo $row1["merk"];?></td>
            <td><?php echo $row1["type"];?></td>
            <td><?php echo $row1["deskripsi"];?></td>
            <td>
            <?php
                if($status_peminjaman != ""){echo "Alat ini ".$status_peminjaman." pada nomor peminjaman ".$id_peminjaman_masuk.". ";} if($kondisi != ""){echo "Alat ini memiliki kondisi ".$kondisi.", ".$keterangan.". (".$tgl_checklist.", ".$nama_petugas.").";} 
            ?>
            </td>
        </tr>
        <?php } }?>
    </table>
    <br />

</body>

</html>