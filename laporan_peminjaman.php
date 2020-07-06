<?php 
    include "connection.php";
    $halaman = "peminjaman";
    include 'header_admin.php';
    include 'tgl_indo.php';

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
    
            $keterangan_tanggal = " Dibawah ini merupakan laporan peminjaman alat dari tanggal " .tgl_indo($tgl_awal). " hingga " .tgl_indo($tgl_akhir)."." ;
        }
    }

    if($act != ""){
        $keterangan_judul = "";
        if( $act == "baru"){
            $judul = "Pending";
            $keterangan_judul = " baru";
            $query="SELECT m.*, p.`nama`, p.`instansi` FROM peminjaman_masuk M, `peminjam` P WHERE m.`nik` = p.`nik` AND m.status = '$act' ORDER BY m.id_peminjaman_masuk DESC;"; //query vendor
            $keterangan = "Berikut ini adalah pelaporan Departemen Rumah Tangga berisi data peminjaman alat berstatus" .$keterangan_judul. ".";
        } else if( $act== "disetujui"){
            $judul = "Telah Disetujui";
            $keterangan_judul = " telah disetujui";
            $query="SELECT m.*, p.`nama`, p.`instansi` FROM peminjaman_masuk M, `peminjam` P WHERE m.`nik` = p.`nik` AND m.status = '$act' ORDER BY m.id_peminjaman_masuk DESC;"; //query vendor
            $keterangan = "Berikut ini adalah pelaporan Departemen Rumah Tangga berisi data peminjaman alat berstatus" .$keterangan_judul. ".";
        }else if($act == "diambil"){
            $judul = "Telah diambil";
            $keterangan_judul = " telah diambil";
            $query="SELECT m.*, p.`nama`, p.`instansi` FROM peminjaman_masuk M, `peminjam` P WHERE m.`nik` = p.`nik` AND m.status = '$act' ORDER BY m.id_peminjaman_masuk DESC;"; //query vendor
            $keterangan = "Berikut ini adalah pelaporan Departemen Rumah Tangga berisi data peminjaman alat berstatus" .$keterangan_judul. ".";
        }else if($act == "dikembalikan"){
            $judul = "Telah dikembalikan";
            $keterangan_judul = " telah dikembalikan";
            $query="SELECT m.*, p.`nama`, p.`instansi` FROM peminjaman_masuk M, `peminjam` P WHERE m.`nik` = p.`nik` AND m.status = '$act' ORDER BY m.id_peminjaman_masuk DESC;"; //query vendor
            $keterangan = "Berikut ini adalah pelaporan Departemen Rumah Tangga berisi data peminjaman alat berstatus" .$keterangan_judul. ".";
        }else if($act == "seluruh"){
            $judul = "Seluruh";
            $keterangan = "Berikut ini adalah pelaporan Departemen Rumah Tangga berisi seluruh data peminjaman alat.";
            $query="SELECT m.*, p.`nama`, p.`instansi` FROM peminjaman_masuk M, `peminjam` P WHERE m.`nik` = p.`nik` ORDER BY m.id_peminjaman_masuk DESC;"; //query vendor
        }
    }

    $keterangan .= $keterangan_tanggal;
    $result=mysqli_query($conn,$query);

?>
<script>
function printContent(el) {
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    document.title = '<?php echo date('Y-m-d');?>_DeptRT_LaporanPeminjamanAlat_<?php echo $judul;?>';
    window.print();
    document.body.innerHTML = restorepage;
}
</script>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Laporan Peminjaman Alat</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li>Data Peminjaman Alat</li>
                            <li><a href="dashboard_admin.php?action=<?php echo $judul;?>"
                                    class="text-dark"><?php echo $judul; ?></a></li>
                            <li class="active">Laporan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">

        <div class="row">
            <div class="col-lg-12" id="div1">
                <div class="card" style="border: 0;">
                    <img src="images/KERTASKOPGG.png" class="card-img-top"
                        style="height: 100%; width: 100%; margin-left: auto; margin-right: auto;" alt="Kop Surat">
                    <div class="card-body card-block" style="padding-left: 50px; padding-right: 50px;">
                        <div class="row">
                            <div class="col-md-8">
                                <h3>Laporan Departemen Rumah Tangga <br />| Data Peminjaman Alat - <?php echo $judul; ?>
                                </h3>
                            </div>
                            <div class="col-md-4">
                                <br />
                                <p class="text-dark"><?php echo tgl_indo(date('Y-m-d'), true);?> </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-dark"><br /><?php echo $keterangan; ?></p>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="5px">#</th>
                                            <th>No. Peminjaman</th>
                                            <th>Nama</th>
                                            <th>Instansi</th>
                                            <th>Nama Kegiatan</th>
                                            <th>Tgl Ambil</th>
                                            <th>Tgl Keluar</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 0;
                                            while ($row1=mysqli_fetch_array($result)){
                                                $i++;
                                                $tgl_peminjaman = substr($row1["id_peminjaman_masuk"],2,8);
                                                if($filter_tgl == "filter" && $tgl_peminjaman >= $tgl_awal_fix && $tgl_peminjaman <= $tgl_akhir_fix){
                                        ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $row1["id_peminjaman_masuk"]; ?></td>
                                            <td><?php echo $row1["nama"]."<br/> <small class='text-secondary'>".$row1["nik"]."</small>"; ?>
                                            </td>
                                            <td><?php echo $row1["instansi"]; ?></td>
                                            <td><?php echo $row1["nama_kegiatan"]; ?></td>
                                            <td><?php echo $row1["tgl_ambil"]; ?></td>
                                            <td><?php echo $row1["tgl_kembali"]; ?></td>
                                            <td><?php echo $row1["status"]; ?></td>
                                        </tr>
                                        <?php
                                                }else if($filter_tgl == ""){
                                        ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $row1["id_peminjaman_masuk"]; ?></td>
                                            <td><?php echo $row1["nama"]."<br/> <small class='text-secondary'> NIK : ".$row1["nik"]."</small>"; ?>
                                            </td>
                                            <td><?php echo $row1["instansi"]; ?></td>
                                            <td><?php echo $row1["nama_kegiatan"]; ?></td>
                                            <td><?php echo $row1["tgl_ambil"]; ?></td>
                                            <td><?php echo $row1["tgl_kembali"]; ?></td>
                                            <td><?php echo $row1["status"]; ?></td>
                                        </tr>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-dark"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                            </div>
                            <div class="col-md-4">
                                <?php
                                    $que="SELECT * FROM user where nia = '$nia';";
                                    $res=mysqli_query($conn,$que);
                                    while ($row1=mysqli_fetch_array($res)){
                                ?>
                                <p class="text-dark">
                                    <?php echo $row1["status_anggota"]; ?>
                                    <br />
                                    <br />
                                    <br />
                                    <?php echo $row1["nama_user"]; ?><br />
                                    NIA. <?php echo $row1["nia"]; ?>
                                </p>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12" id="div1">
                <button class="btn btn-outline-primary " onclick="printContent('div1')">
                    <i class="fas fa-print fa-1x"></i></button>
            </div>
        </div>

    </div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>
<?php include 'footer_admin.php'; ?>