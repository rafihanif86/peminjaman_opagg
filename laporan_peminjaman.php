<?php 
    include "connection.php";
    $halaman = "peminjaman";
    include 'header_admin.php';

    $act = "";
    $judul = "";
    $act = $_GET["action"];
    $filter_tgl = "";
    $tgl_awal = "";
    $tgl_akhir = "";
    $tgl_akhir_fix = "";
    $tgl_awal_fix = "";
    $keteerangan = "";
    $keterangan_tanggal = "";

    function tgl_indo($tanggal, $cetak_hari = false){
        $hari = array ( 1 =>    'Senin',
                    'Selasa',
                    'Rabu',
                    'Kamis',
                    'Jumat',
                    'Sabtu',
                    'Minggu'
                );
                
        $bulan = array (1 =>   'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );
        $split 	  = explode('-', $tanggal);
        $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
        
        if ($cetak_hari) {
            $num = date('N', strtotime($tanggal));
            return $hari[$num] . ', ' . $tgl_indo;
        }
        return $tgl_indo;
    }

    if(isset($_POST["btnTracking"]) && $_POST["tgl_awal"] !="" && $_POST["tgl_akhir"] != "" ){
        $tgl_awal=$_POST["tgl_awal"];
        $tgl_akhir=$_POST["tgl_akhir"];

        if($tgl_awal <= $tgl_akhir && $tgl_akhir >= $tgl_awal){
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
        }else{

        }
    }

    if($act != ""){
        $keterangan_judul = "";
        if( $act == "baru"){
            $judul = "Baru";
            $keterangan_judul = " baru";
            $query="SELECT * FROM peminjaman_masuk where status = 'baru' order by id_peminjaman_masuk desc;"; //query vendor
        } else if( $act== "disetujui"){
            $judul = "Telah Disetujui";
            $keterangan_judul = " telah disetujui";
            $query="SELECT * FROM peminjaman_masuk where status = 'disetujui' order by id_peminjaman_masuk desc;"; //query vendor
        }else if($act == "diambil"){
            $judul = "Telah diambil";
            $keterangan_judul = " telah diambil";
            $query="SELECT * FROM peminjaman_masuk where status = 'diambil' order by id_peminjaman_masuk desc;"; //query vendor
        }else if($act == "dikembalikan"){
            $judul = "Telah dikembalikan";
            $keterangan_judul = " telah dikembalikan";
            $query="SELECT * FROM peminjaman_masuk where status = 'dikembalikan' order by id_peminjaman_masuk desc;"; //query vendor
        }
        $keterangan = "Berikut ini adalah pelaporan Departemen Rumah Tangga berisi data peminjaman alat berstatus" .$keterangan_judul. ".";
        $keterangan .= $keterangan_tanggal;
    }else{
        $judul = "Seluruh";
        $keterangan = "Berikut ini adalah pelaporan Departemen Rumah Tangga berisi seluruh data peminjaman alat.";
        $query="SELECT * FROM peminjaman_masuk order by id_peminjaman_masuk desc;"; //query vendor
        $keterangan .= $keterangan_tanggal;
    }
    
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Pilih Rentang Waktu Data Laporan </strong>
                    </div>
                    <form action="laporan_peminjaman.php?action=<?php echo $act;?>" method="post" name="frm"
                        enctype="multipart/form-data" class="form-horizontal">
                        <div class="card-body card-block">
                            <div class="container">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">
                                            Tanggal Awal
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="date" id="text-input" name="tgl_awal" placeholder="Tanggal Awal"
                                            class="form-control" value="<?php echo $tgl_awal; ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">
                                            Tanggal Akhir
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="date" id="text-input" name="tgl_akhir" placeholder="Tanggal akhir"
                                            class="form-control" value="<?php echo $tgl_akhir; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm" name="btnTracking">
                                <i class="fa fa-dot-circle-o"></i> Submit
                            </button>
                            <button type="submit" class="btn btn-danger btn-sm" name="reset">
                                <i class="fa fa-ban"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12" id="div1">
                <div class="card" style="border: 0;">
                    <img src="images/KERTASKOPGG.png" class="card-img-top"
                        style="height: 100%; width: 100%; margin-left: auto; margin-right: auto;" alt="Kop Surat">
                    <div class="card-body card-block" style="padding-left: 50px; padding-right: 50px;">
                        <div class="row">
                            <div class="col-md-8">
                                <h3>Laporan Departemen Rumah Tangga <br />| Data Peminjaman Alat - <?php echo $judul; ?></h3>
                            </div>
                            <div class="col-md-4">
                                <br/>
                                <p class="text-dark"><?php echo tgl_indo(date('Y-m-d'), true);?> </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-dark"><br/><?php echo $keterangan; ?></p>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="5px">#</th>
                                            <th>No. Peminjaman</th>
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
                                            <td><?php echo $row1["nama_instansi"]; ?></td>
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
                                            <td><?php echo $row1["nama_instansi"]; ?></td>
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
                                    <br/>
                                    <br/>
                                    <br/>
                                    <?php echo $row1["nama_user"]; ?><br/>
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