<?php
    include "connection.php";

    $tgl_awal = $tgl_akhir = $jum_kat = $jumlah = $status = $jumlah_belum = $jumlah_telah = "";
    $tgl_hari_ini = date('Y-m-d');
    
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
        header("Content-Disposition: attachment; filename=data_checklist_bulanan_seluruh_$tgl_hari_ini.xls");
        if(isset($_POST['submit_tanggal'])){
            $tgl_awal = $_POST['tgl_awal'];
            $tgl_akhir = $_POST['tgl_akhir'];
        }
    ?>

    <h3>Data Checklist Bulanan <?php if(($tgl_awal and $tgl_akhir) != ""){echo "Tanggal : ".$tgl_awal." s/d ".$tgl_akhir;}?></h3>

    <b>Hasil Checklist:</b>
    <table style="border: 1">
        <tr>
            <th>No</th>
            <th>Jenis Alat</th>
            <th>Nomor Inventaris</th>
            <th>Merk</th>
            <th>Tipe</th>
            <th>Deskripsi</th>
            <?php
                $arr_id_group = "";
                $query3= "";
                if(($tgl_awal and $tgl_akhir) != ""){
                    $query3="SELECT g.*, u.`nama_user` FROM `checklist_group` G, USER U WHERE g.`koordinator` = u.`nia` AND g.`tgl_checklist_group` between '$tgl_awal' and '$tgl_akhir'";
                }else{
                    $query3="SELECT g.*, u.`nama_user` FROM `checklist_group` G, USER U WHERE g.`koordinator` = u.`nia`";
                }
                $result3=mysqli_query($conn,$query3);
                $jumlah_checklist_bulanan = mysqli_num_rows($result3);
                $i = 0;
                while ($row1=mysqli_fetch_array($result3)){
                    $i++;
                    echo "<th>".$row1["tgl_checklist_group"].", Koordinator:".$row1["nama_user"]." NIA. ".$row1["koordinator"]."-GG. Ringkasan: ".$row1["resume"]."</tr>";
                    $arr_id_group .= $row1["id_checklist_group"]. ",";
                } 
                $arr_id_group = substr($arr_id_group,0,-1);
                $arr_id_group = explode(",", $arr_id_group);
            ?>
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
            <?php
                for($x = 0; $x < count($arr_id_group); $x++){
                    $id_alat = $row1["id_alat"];
                    $query4="SELECT c.*, u.`nama_user`, r.`kondisi`, r.`keterangan`, r.`tgl_checklist`, r.`petugas` 
                    FROM `checklist_group_item` C, `user` U, `checklist_record` R 
                    WHERE c.`id_checklist_group` = '$arr_id_group[$x]'  AND c.`id_alat` = '$id_alat' AND c.`id_check` = r.`id_check` AND c.`petugas_check` = u.`nia`;";
                    $result4=mysqli_query($conn,$query4);
                    $jumlah_checklist_bulanan = mysqli_num_rows($result4);
                    while ($row4=mysqli_fetch_array($result4)){
                        echo "<td>Kondisi : ".$row4["kondisi"].". Keterangan: ".$row4["keterangan"].". (".$row4["tgl_checklist"].", ".$row4["nama_user"]."). </td>";
                    }
                }
            ?>
        </tr>
        <?php } ?>
    </table>
    <br />

</body>

</html>