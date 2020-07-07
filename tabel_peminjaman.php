<?php 
    include 'connection.php';
    $halaman = "peminjaman";
    include 'header_admin.php';

    $act = "";
    $judul = "";
    $tgl_hari_ini = date('Y-m-d');

    if(isset($_POST["tgl_awal"]) and isset($_POST["tgl_akhir"])){
        $tgl_awal = $_POST["tgl_awal"];
        $tgl_akhir = $_POST["tgl_akhir"];
        $act = $_POST["action"];
        if(isset($_POST["cetakxls"])){
            echo "<script> window.open('export_peminjaman.php?action=$act&tgl_awal=$tgl_awal&tgl_akhir=$tgl_akhir', '_blank');</script>";
        }
        if(isset($_POST["print"])){
            echo "<script> var win = window.open('laporan_peminjaman.php?action=$act&tgl_awal=$tgl_awal&tgl_akhir=$tgl_akhir', '_blank'); win.focus();</script>";
        }
    }

    if(isset($_GET["action"])){
        $act = $_GET["action"];
    }

    if($act != ""){
        if( $act == "baru"){
            $judul = "Baru";
            $query="SELECT * FROM peminjaman_masuk WHERE status = 'baru' order by id_peminjaman_masuk desc;"; //query vendor
        } else if( $act== "disetujui"){
            $judul = "Telah disetujui";
            $query="SELECT * FROM peminjaman_masuk WHERE status = 'disetujui' and tgl_kembali >= '$tgl_hari_ini'  order by id_peminjaman_masuk desc;"; //query vendor
        }else if($act == "diambil"){
            $judul = "Telah diambil";
            $query="SELECT * FROM peminjaman_masuk WHERE status = 'diambil' order by id_peminjaman_masuk desc;"; //query vendor
        }else if($act == "dikembalikan"){
            $judul = "Telah dikembalikan";
            $query="SELECT * FROM peminjaman_masuk WHERE  status = 'dikembalikan' order by id_peminjaman_masuk desc;"; //query vendor
        }else if($act == "seluruh"){
            $judul = "Seluruh Data";
            $query="SELECT * FROM peminjaman_masuk order by id_peminjaman_masuk desc;"; //query vendor
        }else if($act == "tidakdiambil"){
            $judul = "Tidak Diambil";
            $query="SELECT * FROM peminjaman_masuk WHERE status = 'disetujui' and tgl_kembali <= '$tgl_hari_ini'  order by id_peminjaman_masuk desc;"; //query vendor
        }
    }

    if(isset($_GET['nik'])){
        $nik_send = $_GET['nik'];
        $act = "seluruh";
        $judul = "Seluruh Data";
        $query="SELECT * FROM peminjaman_masuk where nik = '$nik_send' order by id_peminjaman_masuk desc;"; //query vendor
    }

    $result=mysqli_query($conn,$query);
   
?>
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Data Peminjaman Alat | <?php echo $judul; ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li>Data Peminjaman Alat</li>
                            <li class="active"><?php echo $judul; ?></li>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">List Data Peminjaman Alat</strong>
                        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                            data-target="#exampleModalCenter"><i class="fas fa-print fa-1x"></i> Laporan </button>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table tabel-border-0">
                            <thead>
                                <tr>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 0;
                                    while ($row1=mysqli_fetch_array($result)){
                                        $i++;
                                        $status = $row1["status"];
                                ?>
                                <tr>
                                    <td>
                                        <div class="card">
                                            <div class="card-body card-block">
                                                <div class="float-md-left">
                                                    <div class="container">
                                                        <small
                                                            class="text-secondary"><?php echo $row1["tgl_ambil"]." s/d ".$row1["tgl_kembali"]; ?></small>

                                                        <div class="btn-group float-right">
                                                            <button type="button"
                                                                class="btn btn-outline-danger btn-sm dropdown-toggle dropdown-toggle-split"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <?php if($status == "baru" || $status == "disetujui"){?>
                                                                <a class="dropdown-item"
                                                                    href="delete_peminjaman.php?id_peminjaman_masuk=<?php echo $row1["id_peminjaman_masuk"];?>"
                                                                    onClick="return confirm('Hapus peminjaman ini?')">
                                                                    <i class='fa fa-trash-o fa-1x'> </i>
                                                                    Hapus</a>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <a class="text-dark"
                                                            href="tampil_peminjaman.php?id_peminjaman_masuk=<?php echo $row1["id_peminjaman_masuk"];?>">
                                                            <h5><?php echo $row1["id_peminjaman_masuk"]; ?>
                                                            </h5>

                                                            <?php
                                                            $nama_instansi      =   "";
                                                            $nama_peminjam      =   "";
                                                            $nik_potong = substr($row1["nik"],0,3);
                                                            $nik = $row1["nik"];
                                                            if($nik_potong == "910"){
                                                                $result2=mysqli_query($conn,"SELECT * FROM user  WHERE nia = '$nik';");
                                                                while ($row2=mysqli_fetch_array($result2)){
                                                                    $nama_instansi      =   "OPA Ganendra Giri";
                                                                    $nama_peminjam      =   $row2["nama_user"];
                                                                }
                                                            }else{
                                                                $result2=mysqli_query($conn,"SELECT * FROM peminjam  WHERE nik = '$nik';");
                                                                while ($row2=mysqli_fetch_array($result2)){
                                                                    $nama_instansi      =   $row2["instansi"];
                                                                    $nama_peminjam      =   $row2["nama"];
                                                                }
                                                            }
                                                        ?>
                                                            <h3> <?php echo $nama_peminjam; ?> <small
                                                                    class="text-secondary">(<?php echo $nama_instansi;?>)</small>
                                                            </h3>
                                                        </a>
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Kegiatan</td>
                                                                    <td>: <?php echo $row1["nama_kegiatan"];?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td> Status</td>
                                                                    <td>:
                                                                        <?php
                                                                        $query2 = ""; 
                                                                        if($status == "baru"){
                                                                            echo '<i class="fa fa-spinner"></i>';
                                                                            $query2="";
                                                                        }else if($status == "disetujui"){
                                                                            echo '<i class="fa fa-check"></i>';
                                                                            $query2="SELECT * FROM user U WHERE U.`nia` =  ". $row1["petugas_menyetujui"];
                                                                        }else if($status == "diambil"){
                                                                            echo '<i class="fa fa-people-carry"></i>';
                                                                            $query2="SELECT * FROM user U WHERE U.`nia` =  ". $row1["petugas_pengambilan"];
                                                                        }else if($status == "dikembalikan"){
                                                                            echo '<i class="fa fa-warehouse"></i>';
                                                                            $query2="SELECT * FROM user U WHERE U.`nia` =  ". $row1["petugas_pengambilan"];
                                                                        }
                                                                        
                                                                        if($query2 != ""){
                                                                            $result2=mysqli_query($conn,$query2);
                                                                            while ($row2=mysqli_fetch_array($result2)){
                                                                                echo " | ".$row2["nama_user"];
                                                                            }
                                                                        }
                                                                    ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="float-md-left border-left">
                                                    <div class="container">
                                                        <h5>List Alat : </h5><br />
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" width="55%">Jenis
                                                                        Alat
                                                                    </th>
                                                                    <th scope="col" width="15%">
                                                                        Permintaan
                                                                    </th>
                                                                    <th scope="col" width="15%"
                                                                        <?php if($status == "baru"){echo "hidden";}?>>
                                                                        Disetujui</th>
                                                                    <th scope="col" width="15%"
                                                                        <?php if($status == "baru" || $status == "disetujui"){echo "hidden";}?>>
                                                                        Dikeluarkan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                    $id = $row1["id_peminjaman_masuk"];
                                                                    $que11 = "SELECT d.*, k.`nama_jenis_alat` FROM `detail_peminjaman_masuk` D, `jenis_alat` K WHERE d.`id_jenis_alat` = k.`id_jenis_alat` AND d.`id_peminjaman_masuk` ='$id';";
                                                                    $res11=mysqli_query($conn,$que11) ;
                                                                    $i = 0;
                                                                    while ($row1=mysqli_fetch_array($res11)){
                                                                        $i++;
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $row1["nama_jenis_alat"]; ?>
                                                                    </td>
                                                                    <td><?php echo $row1["jumlah"]; ?>
                                                                    </td>
                                                                    <td <?php if($status == "baru"){echo "hidden";}?>>
                                                                        <?php echo $row1["jumlah_dikeluarkan"]; ?>
                                                                    </td>
                                                                    <td
                                                                        <?php if($status == "baru" || $status == "disetujui"){echo "hidden";}?>>
                                                                        <?php
                                                                        $id_detail_masuk = $row1["id_detail_masuk"];
                                                                        $jum_kel="";
                                                                        $queryKel="SELECT COUNT(*) AS jum_keluar FROM detail_peminjaman_diterima WHERE id_detail_masuk = '$id_detail_masuk'; ";
                                                                        $resultKel=mysqli_query($conn,$queryKel) ;
                                                                        while ($row6=mysqli_fetch_array($resultKel)){
                                                                            $jum_kel = $row6["jum_keluar"];
                                                                        }
                                                                        if($jum_kel != "0" || $hidden_dikeluarkan != "hidden"){echo $jum_kel;}
                                                                    ?>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                                <?php
                                        }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <i class="fa fa-spinner"></i> Pending | <i class="fa fa-check"></i> Telah Disetujui | <i
                            class="fa fa-people-carry"></i> Telah Diambil | <i class="fa fa-warehouse"></i> Telah
                        Dikembalikan
                    </div>
                </div>
            </div>
        </div>

    </div><!-- .animated -->
</div><!-- .content -->

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Atur Rentang Tanggal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="tabel_peminjaman.php" method="post" name="frm" enctype="multipart/form-data"
                class="form-horizontal">
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Tanggal Awal</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="date" id="tgl_awal" name="tgl_awal" placeholder="Tanggal Awal"
                                class="form-control" value="" max="<?php echo $tgl_hari_ini;?>"
                                onchange="change_kembali()">
                            <small class="help-block form-text">Maksimal hari ini</small>
                        </div>
                    </div>
                    <div class="row form-group" id="kembali">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Tanggal Akhir</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="date" id="tgl_kembali" name="tgl_akhir" placeholder="Tanggal Akhir"
                                class="form-control" value="" max="<?php echo $tgl_hari_ini;?>">
                            <!-- <small class="help-block form-text">Masukkan Tanggal Kembali</small> -->
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-12">
                            Kosongkan jika akan mencetak seluruh data.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="<?php echo $act;?>">
                    <button type="submit" class="btn btn-success" name="cetakxls"><i
                            class='fa fa-file-download fa-1x'></i> Download file.xls</button>
                    <button type="submit" class="btn btn-primary" name="print"><i
                            class='fa fa-print fa-1x'></i> Print</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="clearfix"></div>
<?php
    include 'footer_admin.php'
?>
<script>
if (document.getElementById("tgl_awal").value == '') {
    document.getElementById('kembali').style.display = 'none';
} else {
    document.getElementById('kembali').style.display = '';
}

function change_kembali() {
    document.getElementById('kembali').style.display = '';
    var tgl_ambil = document.getElementById("tgl_awal").value;
    document.getElementById("tgl_kembali").min = tgl_ambil;
}
</script>