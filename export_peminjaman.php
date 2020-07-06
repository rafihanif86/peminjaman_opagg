<?php
    include "connection.php";

    $tgl_awal = $tgl_akhir = $jum_kat = $jumlah = $status = $jumlah_belum = $jumlah_telah = "";
    $tgl_hari_ini = date('Y-m-d');

    $act = "";
    $judul = "";
    $filter_tgl = "";
    $tgl_awal = "";
    $tgl_akhir = "";
    $tgl_akhir_fix = "";
    $tgl_awal_fix = "";
    $keterangan = "";
    $keterangan_tanggal = "";
    $query = "";


    if(isset($_GET["tgl_awal"]) and isset($_GET["tgl_akhir"]) and isset($_GET["action"])){
        $tgl_awal=$_GET["tgl_awal"];
        $tgl_akhir=$_GET["tgl_akhir"];
        $act = $_GET["action"];

        if(($tgl_awal and $tgl_akhir) != ""){
            $filter_tgl = "filter";
            $tgl_awal_tahun = substr($tgl_awal,0,4);
            $tgl_awal_bulan = substr($tgl_awal,5,2);
            $tgl_awal_tanggal = substr($tgl_awal,8,2);
            $tgl_awal_fix = $tgl_awal_tahun.$tgl_awal_bulan.$tgl_awal_tanggal;
    
            $tgl_akhir_tahun = substr($tgl_akhir,0,4);
            $tgl_akhir_bulan = substr($tgl_akhir,5,2);
            $tgl_akhir_tanggal = substr($tgl_akhir,8,2);
            $tgl_akhir_fix = $tgl_akhir_tahun.$tgl_akhir_bulan.$tgl_akhir_tanggal;
    
        }
    }

    if($act != ""){
        $keterangan_judul = "";
        if( $act == "baru"){
            $judul = "Pending";
            $keterangan_judul = " baru";
            $query2="SELECT m.*, p.`nama`, p.`instansi` FROM peminjaman_masuk M, `peminjam` P WHERE m.`nik` = p.`nik` AND m.status = '$act' ORDER BY m.id_peminjaman_masuk DESC;"; //query vendor
            $keterangan = "Berikut ini adalah pelaporan Departemen Rumah Tangga berisi data peminjaman alat berstatus" .$keterangan_judul. ".";
        } else if( $act== "disetujui"){
            $judul = "Telah Disetujui";
            $keterangan_judul = " telah disetujui";
            $query2="SELECT m.*, p.`nama`, p.`instansi` FROM peminjaman_masuk M, `peminjam` P WHERE m.`nik` = p.`nik` AND m.status = '$act' ORDER BY m.id_peminjaman_masuk DESC;"; //query vendor
            $keterangan = "Berikut ini adalah pelaporan Departemen Rumah Tangga berisi data peminjaman alat berstatus" .$keterangan_judul. ".";
        }else if($act == "diambil"){
            $judul = "Telah diambil";
            $keterangan_judul = " telah diambil";
            $query2="SELECT m.*, p.`nama`, p.`instansi` FROM peminjaman_masuk M, `peminjam` P WHERE m.`nik` = p.`nik` AND m.status = '$act' ORDER BY m.id_peminjaman_masuk DESC;"; //query vendor
            $keterangan = "Berikut ini adalah pelaporan Departemen Rumah Tangga berisi data peminjaman alat berstatus" .$keterangan_judul. ".";
        }else if($act == "dikembalikan"){
            $judul = "Telah dikembalikan";
            $keterangan_judul = " telah dikembalikan";
            $query2="SELECT m.*, p.`nama`, p.`instansi` FROM peminjaman_masuk M, `peminjam` P WHERE m.`nik` = p.`nik` AND m.status = '$act' ORDER BY m.id_peminjaman_masuk DESC;"; //query vendor
            $keterangan = "Berikut ini adalah pelaporan Departemen Rumah Tangga berisi data peminjaman alat berstatus" .$keterangan_judul. ".";
        }else if($act == "seluruh"){
            $judul = "Seluruh";
            $keterangan = "Berikut ini adalah pelaporan Departemen Rumah Tangga berisi seluruh data peminjaman alat.";
            $query2="SELECT m.*, p.`nama`, p.`instansi` FROM peminjaman_masuk M, `peminjam` P WHERE m.`nik` = p.`nik` ORDER BY m.id_peminjaman_masuk DESC;"; //query vendor
        }
    }

    $keterangan .= $keterangan_tanggal;
    $result2=mysqli_query($conn,$query2);

    function nama_admin($nia){
        include "connection.php";
        $nama = "";
        $sql=mysqli_query($conn,"SELECT `nama_user` FROM  `user` WHERE `nia` = '$nia'");
        while ($row=mysqli_fetch_array($sql)) {
            $nama = $row['nama_user'];
        }
        return $nama;
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
        header("Content-Disposition: attachment; filename=data_peminjam_$tgl_hari_ini.xls");
    ?>

    <h3>Data Peminjaman Peralatan <?php echo " | ".$judul; if(($tgl_awal and $tgl_akhir) != ""){echo "Tanggal : ".$tgl_awal." s/d ".$tgl_akhir;}?></h3>

    <b>Data peminjaman:</b>
    <table style="border: 1">
        <tr>
            <th>No</th>
            <th>No Peminjaman</th>
            <th>Nama Peminjam</th>
            <th>Instansi</th>
            <th>Nama Kegiatan</th>
            <th>Pengambilan</th>
            <th>Pengembalian</th>
            <th>Status</th>
            <th>Menyetujui</th>
            <th>Pengambilan</th>
            <th>Pengembalian</th>
            <th>Keterangan Alat</th>
        </tr>
        <?php
            $i = 0;
            while ($row1=mysqli_fetch_array($result2)){
                $i++;
        ?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $row1["id_peminjaman_masuk"];?></td>
            <td><?php echo $row1["nama"]." NIK: ".$row1["nik"];?></td>
            <td><?php echo $row1["instansi"];?></td>
            <td><?php echo $row1["nama_kegiatan"];?></td>
            <td><?php echo $row1["tgl_ambil"];?></td>
            <td><?php echo $row1["tgl_kembali"];?></td>
            <td><?php echo $row1["status"];?></td>
            <td><?php echo nama_admin($row1["petugas_menyetujui"]);?></td>
            <td><?php echo nama_admin($row1["petugas_menyetujui"]);?></td>
            <td><?php echo nama_admin($row1["petugas_pengembalian"]);?></td>
            <td>
                <?php 
                    $id = $row1["id_peminjaman_masuk"];
                    $que11 = "SELECT d.*, k.`nama_jenis_alat` FROM `detail_peminjaman_masuk` D, `jenis_alat` K WHERE d.`id_jenis_alat` = k.`id_jenis_alat` AND d.`id_peminjaman_masuk` ='$id';";
                    $res11=mysqli_query($conn,$que11) ;
                    $a = 0;
                    while ($row2=mysqli_fetch_array($res11)){
                        $a++;                        
                        $id_detail_masuk = $row2["id_detail_masuk"];
                        $jum_kel="";
                        $queryKel="SELECT COUNT(*) AS jum_keluar FROM detail_peminjaman_diterima WHERE id_detail_masuk = '$id_detail_masuk'; ";
                        $resultKel=mysqli_query($conn,$queryKel) ;
                        while ($row6=mysqli_fetch_array($resultKel)){
                            $jum_kel = $row6["jum_keluar"];
                        }
                        echo $a.". ".$row2['nama_jenis_alat']." (permintaan: ".$row2['jumlah'].". disetujui: ".$row2['jumlah_dikeluarkan'].". diserahkan: ".$jum_kel.".) ";
                    }
                ?>
            </td>
        </tr>
        <?php } ?>
    </table>
    <br />

</body>

</html>