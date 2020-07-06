<?php
    include "connection.php";

    $tgl_awal = $tgl_akhir = $jum_kat = $jumlah = $status = $jumlah_belum = $jumlah_telah = $result2 ="";
    $tgl_hari_ini = date('Y-m-d');
    
    if(isset($_POST['submit_tanggal'])){
        if(($tgl_awal and $tgl_akhir) != ""){
            $tgl_awal = $_POST['tgl_awal'];
            $tgl_akhir = $_POST['tgl_akhir'];
            $query2="SELECT c.*, a.`merk`, a.`type`, a.`deskripsi`, j.`nama_jenis_alat`, u.`nama_user` FROM checklist_record c, alat a, `jenis_alat` j, USER u WHERE c.`id_alat` = a.`id_alat` AND a.`id_jenis_alat` = j.`id_jenis_alat` AND c.`petugas` = u.`nia` and tgl_checklist between '$tgl_awal' and '$tgl_akhir'  ORDER BY tgl_checklist DESC;";
        }else{
            $query2="SELECT c.*, a.`merk`, a.`type`, a.`deskripsi`, j.`nama_jenis_alat`, u.`nama_user` FROM checklist_record c, alat a, `jenis_alat` j, USER u WHERE c.`id_alat` = a.`id_alat` AND a.`id_jenis_alat` = j.`id_jenis_alat` AND c.`petugas` = u.`nia` ORDER BY tgl_checklist DESC;";
        }
    }
    
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
        header("Content-Disposition: attachment; filename=data_checklist_terbaru_$tgl_hari_ini.xls");
    ?>

    <h3>Data Checklist <?php if(($tgl_awal and $tgl_akhir) != ""){echo "Tanggal : ".$tgl_awal." s/d ".$tgl_akhir;}?></h3>

    <b>Hasil Checklist:</b>
    <table style="border: 1">
        <tr>
            <th>No</th>
            <th>Jenis Alat</th>
            <th>Nomor Inventaris</th>
            <th>Merk</th>
            <th>Tipe</th>
            <th>Deskripsi</th>
            <th>kondisi</th>
        </tr>
        <?php
            $i = 0;
            while ($row1=mysqli_fetch_array($result2)){
                $i++;
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
                if($row1["status_peminjaman"] != ""){echo "Alat ini ".$row1["status_peminjaman"]." pada nomor peminjaman ".$row1["id_peminjaman_masuk"].". ";} 
                if($row1["kondisi"] != ""){echo "Alat ini memiliki kondisi ".$row1["kondisi"].", ".$row1["keterangan"].". (".$row1['tgl_checklist'].", ".$row1["nama_user"].")";}
            ?></td>
        </tr>
        <?php } ?>
    </table>
    <br />

</body>

</html>