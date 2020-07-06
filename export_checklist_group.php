<?php
include "connection.php";

$id_checklist_group = $id_detail_masuk = $id_jenis_alat = $tgl_checklist_group = $dokumentasi = $resume = $nama_koordinator = $jum_kat = $jumlah = $status = $jumlah_belum = $jumlah_telah = "";
    
    if(isset($_GET['id_checklist_group'])){
        $id_checklist_group = $_GET['id_checklist_group'];
        $sql=mysqli_query($conn,"SELECT g.*, u.`nama_user` FROM `checklist_group` G, `user`U WHERE g.`koordinator` = u.`nia` and `id_checklist_group` = '$id_checklist_group';");
        while ($row=mysqli_fetch_array($sql)) {
            $id_checklist_group =  $row['id_checklist_group'];
            $status =  $row['status'];
            $koordinator =  $row['koordinator'];
            $tgl_checklist_group = $row['tgl_checklist_group'];
            $resume = $row['resume'];
            $dokumentasi = $row['dokumentasi'];
            $nama_koordinator = $row['nama_user'];
        }

        $query2="SELECT c.*, a.`merk`, a.`type`, a.`deskripsi`, j.`nama_jenis_alat`, u.`nama_user`, r.`foto_alat_check`, r.`kondisi`, r.`keterangan`, r.`tgl_checklist`, r.`petugas` 
                        FROM `checklist_group_item` C, `alat` A, `user` U, `jenis_alat` J, `checklist_record` R 
                        WHERE c.`id_checklist_group` = '$id_checklist_group' AND c.`id_check` = r.`id_check` AND a.`id_jenis_alat` = j.`id_jenis_alat` AND a.`id_alat` = c.`id_alat` AND c.`petugas_check` = u.`nia` ORDER BY c.`id_alat` DESC;";
        $result2=mysqli_query($conn,$query2);
        $jumlah_telah_check = mysqli_num_rows($result2);
        $query1="SELECT i.`petugas_check`, u.`nama_user`, u.`nia`, u.`foto_anggota` FROM `checklist_group` G, `checklist_group_item` I, `user` U WHERE i.`petugas_check` = u.`nia` AND i.`id_checklist_group` = g.`id_checklist_group` AND g.`id_checklist_group` = '$id_checklist_group' GROUP BY i.petugas_check;";
        $result1=mysqli_query($conn,$query1);
        $anggota_mengikuti = mysqli_num_rows($result1);
    }

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
        header("Content-Disposition: attachment; filename=data_checklist_$tgl_checklist_group.xls");
    ?>

    <h3>Data Checklist Bulanan</h3>
    <br />
    <table style="border: 1">
        <tr>
            <td>Tanggal</td>
            <td><?php echo ": ".$tgl_checklist_group;?></td>
        </tr>
        <tr>
            <td>Koordinator</td>
            <td><?php echo ": ".$nama_koordinator." NIA. ".$koordinator."-GG";?></td>
        </tr>
        <tr>
            <td>Alat di checklist</td>
            <td><?php echo ": ".$jumlah_telah_check;?></td>
        </tr>
        <tr>
            <td>Anggota Mengikuti</td>
            <td><?php echo ": ".$anggota_mengikuti;?></td>
        </tr>
        <tr>
            <td>Rangkuman</td>
            <td><?php echo ": ".$resume;?></td>
        </tr>
    </table>
    <br />

    <b>Hasil Checklist:</b>
    <table style="border: 1">
        <tr>
            <th>No</th>
            <th>Jenis Alat</th>
            <th>Nomor Inventaris</th>
            <th>Merk</th>
            <th>Tipe</th>
            <th>Deskripsi</th>
            <th>Tanggal Pengecekan</th>
            <th>Kondisi</th>
            <th>Keterangan</th>
            <th>Petugas </th>
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
            <td><?php echo $row1["tgl_checklist"];?></td>
            <td><?php echo $row1["kondisi"];?></td>
            <td><?php echo $row1["keterangan"];?></td>
            <td><?php echo $row1["nama_user"];?></td>
        </tr>
        <?php } ?>
    </table>
    <br />

    <b>Mengikuti Checklist:</b>
    <table>
        <tr>
            <th>Nama</th>
            <th>NIA</th>
        </tr>
        <?php
            $i = 0;
            while ($row2=mysqli_fetch_array($result1)){
        ?>
        <tr>
            <td><?php echo $row2["nama_user"]; ?></td>
            <td>NIA.<?php echo $row2["nia"]; ?>-GG </td>
        </tr>
        <?php } ?>
    </table>
</body>

</html>