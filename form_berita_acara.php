<?php 
    include "connection.php";
    $halaman = "alat";
    include 'header_admin.php';
    include 'tgl_indo.php';

    $id_check = $tgl_checklist = $kondisi = $id_alat = $keterangan = $id_user = $petugas = $dipinjam = $peminjaman = $id_detail_masuk = $foto_alat = $id_peminjaman_masuk =  $edit  = $id_detail = $disAlatPinjam = $nama_user= $disIdAlat = "";
    $id_check_last = $tgl_checklist_last = $status = $deskripsi = $id_alat_last = $status_peminjaman =  $kondisi_last = $id_checklist_group_item= $keterangan_last = $capture_true = $foto_alat_check_last = $nama_user_last = $dipinjam_last = $id_peminjaman_masuk_last = $tgl_terbaru_last = $id_checklist_group = "";
    $res3= $judul = $action = $kronologi = $act = "";

    $tgl_hari_ini= date("Y-m-d");
    $bulan_ini = date("m");
    $tahun_ini = date("Y");

    function bulan_romawi($bulan){
        $romawi = "";
        switch ($bulan) {
            case 1:
                $romawi = "I";
                break;
            case 2:
                $romawi = "II";
                break;
            case 3:
                $romawi = "III";
                break;
            case 4:
                $romawi = "IV";
                break;
            case 5:
                $romawi = "V";
                break;
            case 6:
                $romawi = "VI";
                break;
            case 7:
                $romawi = "VII";
                break;
            case 8:
                $romawi = "VIII";
                break;
            case 9:
                $romawi = "IX";
                break;
            case 10:
                $romawi = "X";
                break;
            case 11:
                $romawi = "XI";
                break;
            case 12:
                $romawi = "XII";
                break;
                    
            default:
                $romawi = "";
                break;
        }
        return $romawi;
    }

    if(isset($_GET['id_alat'])){
        $id_alat = $_GET['id_alat'];
    }else if(isset($_POST['id_alat'])){
        $id_alat = $_POST['id_alat'];
    }



    if($id_alat != ""){
        $result=mysqli_query($conn, "SELECT a.*, k.`nama_jenis_alat` FROM alat A, jenis_alat K WHERE id_alat = '$id_alat' AND k.`id_jenis_alat` = a.`id_jenis_alat`;");
        while ($row1=mysqli_fetch_array($result)){
            $type           =   $row1["type"];
            $merk           =   $row1["merk"];
            $id_jenis_alat         =   $row1["id_jenis_alat"];
            $checklist_masuk      =   $row1["checklist_masuk"];
            $checklist_keluar     =   $row1["checklist_keluar"];
            $nama_jenis_alat       =   $row1["nama_jenis_alat"];
            $foto_alat      =   $row1["foto_alat"];
            $deskripsi      =   $row1["deskripsi"];
        }

        $res=mysqli_query($conn, "SELECT * FROM `checklist_record` WHERE `id_check` IN (SELECT MAX(`id_check`) FROM `checklist_record` WHERE `id_alat` = '$id_alat');");
        while ($row1=mysqli_fetch_array($res)){
            $id_check_last  = $row1["id_check"];
            $tgl_checklist_last = $row1["tgl_checklist"];
            $id_alat_last = $row1["id_alat"];
            $kondisi_last = $row1["kondisi"];
            $keterangan_last = $row1["keterangan"];
            $dipinjam_last = $row1["status_peminjaman"];
            $id_peminjaman_masuk_last = $row1["id_peminjaman_masuk"];
            $foto_alat_check_last = $row1["foto_alat_check"];
            $nama_user_last = $row1["petugas"];
        }
    }

    if(isset($_GET['action'])){
        $action = $_GET['action'];
    }else if(isset($_POST['action'])){
        $action = $_POST['action'];
    }

    if($action != ""){
        if($action == "baru"){
            $judul = "Alat Ditambahkan Hari Ini";
            $act = "seluruh";
            $res3=mysqli_query($conn, "SELECT a.*, k.nama_jenis_alat, i.nama_kat FROM alat A, jenis_alat K, kategori I, `checklist_record` C where k.id_jenis_alat = a.id_jenis_alat and k.id_kat = i.id_kat and a.`checklist_masuk` = c.`id_check` AND c.`tgl_checklist` = '$tgl_hari_ini' order by a.id_alat desc;");
        }else if($action == "diputihkan"){
            $judul = "Alat Diputihkan Hari Ini";
            $act = "seluruh";
            $res3=mysqli_query($conn, "SELECT a.*, k.nama_jenis_alat, i.nama_kat FROM alat A, jenis_alat K, kategori I, `checklist_record` C WHERE k.id_jenis_alat = a.id_jenis_alat AND k.id_kat = i.id_kat AND a.`id_alat` = c.`id_alat` AND c.`kondisi` = 'diputihkan' AND c.`tgl_checklist` = '$tgl_hari_ini' ORDER BY a.id_alat DESC;");
        }
    }
    
    if(isset($_POST['kronologi'])){
        $kronologi = $_POST['kronologi'];
    }
?>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Form Berita Acara</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Data Alat</li>
                            <li class="active">Form Berita Acara</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">

        <!-- data alat banyak  -->
        <?php if($action != ""){?>
        <div class="row" <?php if(isset($_POST['submit'])){echo "hidden";}?>>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title"><?php echo $judul;?></strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-border-0">
                            <thead>
                                <tr>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 0;
                                    while ($row1=mysqli_fetch_array($res3)){
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
                                    <td>
                                        <div class="card mb-12">
                                            <div class="row no-gutters">
                                                <div class="col-md-2">
                                                    <img src="images/<?php if($row1["foto_alat"] != "" || !empty($row1["foto_alat"]) || $row1["foto_alat"] != null ){echo $row1["foto_alat"];}else{echo "no_image.png";}?>"
                                                        class="card-img" alt="..."
                                                        style="max-height: 20rem; float:none;">
                                                </div>
                                                <div class="col-md-10 ">
                                                    <div class="card-body">
                                                        <div class="float-md-left border-left">
                                                            <div class="container">
                                                                <a class="text-dark"
                                                                    href="tampil_alat.php?id_alat=<?php echo $row1["id_alat"];?>">
                                                                    <h6><?php echo $row1["id_alat"]; ?></h6>
                                                                    <h5> <?php echo $row1["merk"]." ".$row1["type"]; ?>
                                                                    </h5>
                                                                </a>
                                                                <small
                                                                    class="text-secondary"><?php echo $row1["nama_jenis_alat"]." | ".$row1["nama_kat"]; ?></small>
                                                            </div>
                                                        </div>
                                                        <div class="float-md-left border-left">
                                                            <div class="container">
                                                                <b>Deskripsi : </b><br />
                                                                <?php echo $row1["deskripsi"]; ?><br />
                                                                <b>Kondisi : </b><br />
                                                                <?php if($status_peminjaman != ""){echo "Alat ini ".$status_peminjaman." pada nomor peminjaman <a class='text-dark' href='tampil_peminjaman.php?id_peminjaman_masuk=".$id_peminjaman_masuk."'> ".$id_peminjaman_masuk."</a>. ";} if($kondisi != ""){echo "Alat ini memiliki kondisi ".$kondisi.", ".$keterangan.". <br/><small class='text-secondary'>(".tgl_indo($tgl_checklist).", ".$nama_petugas.") </small>";} ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                        } }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <!-- data alat satuan -->
        <?php if($id_alat != ""){?>
        <div class="row" <?php if(isset($_POST['submit'])){echo "hidden";}?>>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Data Alat</strong>
                    </div>
                    <div class="card-body card-block">
                        <div class="container">
                            <div class="row">
                                <div class="col ">
                                    <div class="float-md-left">
                                        <div class="container">
                                            <div class="row form-group">
                                                <div class="col col-md-12">
                                                    <img src="images/<?php if($foto_alat != "" || !empty($foto_alat) || $foto_alat != null ){echo $foto_alat;}else{echo "no_image.png";}?>"
                                                        class="rounded mx-auto d-block" alt="..."
                                                        style="max-height: 20rem;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="float-md-left ">
                                        <div class="container">
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Nomor Inventaris</label></div>
                                                <div class="col-12 col-md-9"><?php echo ": "; echo $id_alat; ?></div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Kategori</label></div>
                                                <div class="col-12 col-md-9"><?php echo ": "; echo $nama_jenis_alat; ?>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Merk</label></div>
                                                <div class="col-12 col-md-9"><?php echo ": "; echo $merk; ?></div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Tipe</label></div>
                                                <div class="col-12 col-md-9"><?php echo ": "; echo $type; ?></div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Deskripsi</label></div>
                                                <div class="col-12 col-md-9"><?php echo ": "; echo $deskripsi; ?></div>
                                            </div>
                                            <div class="row form-group">
                                                <?php 
                                                    if($checklist_masuk != ""){ 
                                                        $result1=mysqli_query($conn,"SELECT c.*, u.`nama_user` FROM `checklist_record` C, `user` U WHERE c.`id_check` = '$checklist_masuk' and c.`petugas` = u.`nia`;") ;
                                                        while ($row3=mysqli_fetch_array($result1)){
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <small
                                                                    class="text-secondary float-right"><?php echo tgl_indo($row3["tgl_checklist"]);?></small>
                                                                <h5 class="card-title">Pengecekan Awal</h5>
                                                                <?php 
                                                            if($row3["status_peminjaman"] != ""){
                                                                echo "Alat ini ".$row3["status_peminjaman"]." pada nomor peminjaman <a class='text-dark' href='tampil_peminjaman.php?id_peminjaman_masuk=".$row3["id_peminjaman_masuk"]."'> ".$row3["id_peminjaman_masuk"]."</a>. ";
                                                            } 
                                                            if($row3["kondisi"] != ""){
                                                                echo "Alat ini memiliki kondisi ".$row3["kondisi"].", ".$row3["keterangan"].". <br/><small class='text-secondary'>(".$row3["nama_user"].", NIA.".$row3["petugas"]."-GG ) </small>";
                                                            } 
                                                        ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php 
                                                        } 
                                                    }
                                                
                                                    if($checklist_keluar != ""){ 
                                                        $result1=mysqli_query($conn,"SELECT c.*, u.`nama_user` FROM `checklist_record` C, `user` U WHERE c.`id_check` = '$checklist_keluar' and c.`petugas` = u.`nia`;") ;
                                                        while ($row3=mysqli_fetch_array($result1)){
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <small
                                                                    class="text-secondary float-right"><?php echo tgl_indo($row3["tgl_checklist"]);?></small>
                                                                <h5 class="card-title">Pengecekan Pemutihan</h5>
                                                                <?php 
                                                            if($row3["status_peminjaman"] != ""){
                                                                echo "Alat ini ".$row3["status_peminjaman"]." pada nomor peminjaman <a class='text-dark' href='tampil_peminjaman.php?id_peminjaman_masuk=".$row3["id_peminjaman_masuk"]."'> ".$row3["id_peminjaman_masuk"]."</a>. ";
                                                            } 
                                                            if($row3["kondisi"] != ""){
                                                                echo "Alat ini memiliki kondisi ".$row3["kondisi"].", ".$row3["keterangan"].". <br/><small class='text-secondary'>(".$row3["nama_user"].", NIA.".$row3["petugas"]."-GG ) </small>";
                                                            } 
                                                        ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php $jumlah = mysqli_num_rows($res); if($jumlah != 0 || $id_check == ""){?>
                            <div class="row">
                                <div class="col">
                                    <h4>Checklist Terbaru</h4>
                                    <hr />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="float-md-left ">
                                        <div class="container">
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Tanggal</label></div>
                                                <div class="col-12 col-md-9">
                                                    <?php echo ": "; echo tgl_indo($tgl_checklist_last); ?></div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Kondisi</label></div>
                                                <div class="col-12 col-md-9"><?php echo ": "; echo $kondisi_last ?>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Keterangan</label></div>
                                                <div class="col-12 col-md-9"><?php echo ": "; echo $keterangan_last ?>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Petugas</label></div>
                                                <div class="col-12 col-md-9"><?php echo ": "; 
                                                    $res2=mysqli_query($conn,"SELECT * FROM USER WHERE nia = '$nama_user_last';");
                                                    while ($row1=mysqli_fetch_array($res2)){
                                                        echo $row1["nama_user"];
                                                    }
                                                    echo " <small class='text-secondary'>NIA.".$nama_user_last."-GG</small>";
                                                ?></div>
                                            </div>
                                            <div class="row form-group"
                                                <?php if($dipinjam_last == ""){echo "hidden";}?>>
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Status Peminjaman</label></div>
                                                <div class="col-12 col-md-9">
                                                    <?php echo ": "; if($dipinjam_last != ""){echo "$dipinjam_last";}else{echo "-";} ?>
                                                </div>
                                            </div>
                                            <div class="row form-group"
                                                <?php if($id_peminjaman_masuk_last == ""){echo "hidden";}?>>
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Nomor Peminjaman</label></div>
                                                <div class="col-12 col-md-9">
                                                    <?php echo ": "; if($id_peminjaman_masuk_last != ""){echo "$id_peminjaman_masuk_last";}else{echo "-";}?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="float-md-right ">
                                        <div class="container">
                                            <div class="row form-group">
                                                <div class="col col-md-12">
                                                    <img src="images/<?php if($foto_alat_check_last != "" || !empty($foto_alat_check_last) || $foto_alat_check_last != null ){echo $foto_alat_check_last;}else{echo "no_image.png";}?>"
                                                        class="rounded mx-auto d-block" alt="..."
                                                        style="max-height:20rem;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <!-- form kronologi  -->
        <div class="row" <?php if(isset($_POST['submit'])){echo "hidden";}?>>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Isikan Data Kronologi</strong>
                    </div>
                    <form action="form_berita_acara.php" method="post" name="frm" enctype="multipart/form-data"
                        class="form-horizontal">
                        <div class="card-body card-block">
                            <div class="container">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Keterangan /
                                            Kronologi</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <textarea type="text" id="text-input" name="kronologi" placeholder="Kronologi"
                                            class="form-control" value="<?php echo $nama_kat; ?>" rows="6"></textarea>
                                        <small class="form-text text-muted">Masukkan kronologi / keterangan berita acara
                                            secara lengkap dan detail.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="id_alat" value="<?php echo $id_alat; ?>">
                            <input type="hidden" name="action" value="<?php echo $action; ?>">
                            <button type="submit" class="btn btn-primary btn-sm" name="submit">
                                <i class="fa fa-dot-circle-o"></i> Submit
                            </button>
                            <button type="reset" class="btn btn-danger btn-sm" name="reset" onclick="reset()">
                                <i class="fa fa-ban"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Tampil print  -->
        <div class="row" <?php if(!isset($_POST['submit'])){echo "hidden";}?>>
            <div class="col-lg-12" id="div1">
                <div class="card" style="border: 0;">
                    <img src="images/KERTASKOPGG.png" class="card-img-top"
                        style="height: 100%; width: 100%; margin-left: auto; margin-right: auto;" alt="Kop Surat">
                    <div class="card-body card-block" style="padding-left: 80px; padding-right: 80px;">
                        <div class="row">
                            <div class="col-md-12">
                                <center>
                                    <h3><u>Berita Acara</u> </h3>
                                    <b>Nomor :
                                        B<small>2</small>....../D-RT/OPA-GG/<?php echo bulan_romawi($bulan_ini)."/".$tahun_ini;?></b>
                                </center>
                                <br />
                                <br />
                                <p class="text-dark">
                                    <t />Sehubungan dengan berita acara ini kami selaku
                                    <?php if($action != ""){echo "Dept. Rumah Tangga ";}else if($id_alat != ""){echo "penerima pengembalian peminjaman alat ";}?>
                                    memberitahukan adanya
                                    <?php if($action == "baru"){ echo "penambahan alat dibawah ini :";}else if($action == "diputihkan"){ echo "penghapusan list alat dibawah ini :";}else if($id_alat != ""){echo "alat yang ".$kondisi." dengan nomor inventaris ".$id_alat.".";}?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-10">
                                <p class="text-dark"><br /><?php echo $keterangan; ?></p>
                                <?php if($id_alat != ""){?>
                                <div class="container">
                                    <div class="row">
                                        <div class="col col-md-12">
                                            <h4>Data Alat</h4>
                                            <hr />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-6">
                                            <div class="row form-group">
                                                <div class="col col-md-12">
                                                    <img src="images/<?php if($foto_alat != "" || !empty($foto_alat) || $foto_alat != null ){echo $foto_alat;}else{echo "no_image.png";}?>"
                                                        class="rounded mx-auto d-block" alt="..."
                                                        style="max-height: 20rem;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-md-6">
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Nomor Inventaris</label>
                                                </div>
                                                <div class="col-12 col-md-9"><?php echo ": "; echo $id_alat; ?>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Kategori</label></div>
                                                <div class="col-12 col-md-9">
                                                    <?php echo ": "; echo $nama_jenis_alat; ?>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Merk</label></div>
                                                <div class="col-12 col-md-9"><?php echo ": "; echo $merk; ?>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Tipe</label></div>
                                                <div class="col-12 col-md-9"><?php echo ": "; echo $type; ?>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Deskripsi</label></div>
                                                <div class="col-12 col-md-9">
                                                    <?php echo ": "; echo $deskripsi; ?></div>
                                            </div>
                                            <div class="row form-group">
                                                <?php 
                                                    if($checklist_masuk != ""){ 
                                                        $result1=mysqli_query($conn,"SELECT c.*, u.`nama_user` FROM `checklist_record` C, `user` U WHERE c.`id_check` = '$checklist_masuk' and c.`petugas` = u.`nia`;") ;
                                                        while ($row3=mysqli_fetch_array($result1)){
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <small
                                                                    class="text-secondary float-right"><?php echo tgl_indo($row3["tgl_checklist"]);?></small>
                                                                <h5 class="card-title">Pengecekan Awal</h5>
                                                                <?php 
                                                                    if($row3["status_peminjaman"] != ""){
                                                                        echo "Alat ini ".$row3["status_peminjaman"]." pada nomor peminjaman <a class='text-dark' href='tampil_peminjaman.php?id_peminjaman_masuk=".$row3["id_peminjaman_masuk"]."'> ".$row3["id_peminjaman_masuk"]."</a>. ";
                                                                    } 
                                                                    if($row3["kondisi"] != ""){
                                                                        echo "Alat ini memiliki kondisi ".$row3["kondisi"].", ".$row3["keterangan"].". <br/><small class='text-secondary'>(".$row3["nama_user"].", NIA.".$row3["petugas"]."-GG ) </small>";
                                                                    } 
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php 
                                                        } 
                                                    }
                                                
                                                    if($checklist_keluar != ""){ 
                                                        $result1=mysqli_query($conn,"SELECT c.*, u.`nama_user` FROM `checklist_record` C, `user` U WHERE c.`id_check` = '$checklist_keluar' and c.`petugas` = u.`nia`;") ;
                                                        while ($row3=mysqli_fetch_array($result1)){
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <small
                                                                    class="text-secondary float-right"><?php echo tgl_indo($row3["tgl_checklist"]);?></small>
                                                                <h5 class="card-title">Pengecekan Pemutihan</h5>
                                                                <?php 
                                                                    if($row3["status_peminjaman"] != ""){
                                                                        echo "Alat ini ".$row3["status_peminjaman"]." pada nomor peminjaman <a class='text-dark' href='tampil_peminjaman.php?id_peminjaman_masuk=".$row3["id_peminjaman_masuk"]."'> ".$row3["id_peminjaman_masuk"]."</a>. ";
                                                                    } 
                                                                    if($row3["kondisi"] != ""){
                                                                        echo "Alat ini memiliki kondisi ".$row3["kondisi"].", ".$row3["keterangan"].". <br/><small class='text-secondary'>(".$row3["nama_user"].", NIA.".$row3["petugas"]."-GG ) </small>";
                                                                    } 
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } }?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php $jumlah = mysqli_num_rows($res); if($jumlah != 0 || $id_check == ""){?>
                                    <div class="row">
                                        <div class="col col-md-12">
                                            <h4>Checklist Terbaru</h4>
                                            <hr />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-6">
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Tanggal</label></div>
                                                <div class="col-12 col-md-9">
                                                    <?php echo ": "; echo tgl_indo($tgl_checklist_last); ?>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Kondisi</label></div>
                                                <div class="col-12 col-md-9">
                                                    <?php echo ": "; echo $kondisi_last ?>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Keterangan</label></div>
                                                <div class="col-12 col-md-9">
                                                    <?php echo ": "; echo $keterangan_last ?>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Petugas</label></div>
                                                <div class="col-12 col-md-9"><?php echo ": "; 
                                                        $res2=mysqli_query($conn,"SELECT * FROM USER WHERE nia = '$nama_user_last';");
                                                        while ($row1=mysqli_fetch_array($res2)){
                                                            echo $row1["nama_user"];
                                                        }
                                                        echo " <small class='text-secondary'>NIA.".$nama_user_last."-GG</small>";
                                                    ?></div>
                                            </div>
                                            <div class="row form-group"
                                                <?php if($dipinjam_last == ""){echo "hidden";}?>>
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Status
                                                        Peminjaman</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <?php echo ": "; if($dipinjam_last != ""){echo "$dipinjam_last";}else{echo "-";} ?>
                                                </div>
                                            </div>
                                            <div class="row form-group"
                                                <?php if($id_peminjaman_masuk_last == ""){echo "hidden";}?>>
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Nomor Peminjaman</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <?php echo ": "; if($id_peminjaman_masuk_last != ""){echo "$id_peminjaman_masuk_last";}else{echo "-";}?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-md-6">
                                            <div class="row form-group">
                                                <div class="col col-md-12">
                                                    <img src="images/<?php if($foto_alat_check_last != "" || !empty($foto_alat_check_last) || $foto_alat_check_last != null ){echo $foto_alat_check_last;}else{echo "no_image.png";}?>"
                                                        class="rounded mx-auto d-block" alt="..."
                                                        style="max-height:20rem;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <?php }  if($action != ""){ ?>
                                <?php
                                    $i = 0;
                                    while ($row1=mysqli_fetch_array($res3)){
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card mb-12">
                                            <div class="row no-gutters">
                                                <div class="col-md-2">
                                                    <img src="images/<?php if($row1["foto_alat"] != "" || !empty($row1["foto_alat"]) || $row1["foto_alat"] != null ){echo $row1["foto_alat"];}else{echo "no_image.png";}?>"
                                                        class="card-img" alt="..."
                                                        style="max-height: 20rem; float:none;">
                                                </div>
                                                <div class="col-md-10 ">
                                                    <div class="card-body">
                                                        <div class="float-md-left border-left">
                                                            <div class="container">
                                                                <a class="text-dark"
                                                                    href="tampil_alat.php?id_alat=<?php echo $row1["id_alat"];?>">
                                                                    <h6><?php echo $row1["id_alat"]; ?></h6>
                                                                    <h5> <?php echo $row1["merk"]." ".$row1["type"]; ?>
                                                                    </h5>
                                                                </a>
                                                                <small
                                                                    class="text-secondary"><?php echo $row1["nama_jenis_alat"]." | ".$row1["nama_kat"]; ?></small>
                                                            </div>
                                                        </div>
                                                        <div class="float-md-left border-left">
                                                            <div class="container">
                                                                <b>Deskripsi : </b><br />
                                                                <?php echo $row1["deskripsi"]; ?><br />
                                                                <b>Kondisi : </b><br />
                                                                <?php if($status_peminjaman != ""){echo "Alat ini ".$status_peminjaman." pada nomor peminjaman <a class='text-dark' href='tampil_peminjaman.php?id_peminjaman_masuk=".$id_peminjaman_masuk."'> ".$id_peminjaman_masuk."</a>. ";} if($kondisi != ""){echo "Alat ini memiliki kondisi ".$kondisi.", ".$keterangan.". <br/><small class='text-secondary'>(".tgl_indo($tgl_checklist).", ".$nama_petugas.") </small>";} ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                        } }
                                    ?>
                                <?php } ?>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-dark">Dengan alasan, <?php echo $kronologi.". ";?></p>
                                <p class="text-dark">Demikian berita acara ini kami buat dengan sebenar-benarnya dan
                                    dapat dipergunakan sebagaimana mestinya. Atas perhatiannya, saya ucapkan terima
                                    kasih</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                            </div>
                            <div class="col col-md-4">
                                <br />
                                <p class="text-dark">.................., <?php echo tgl_indo($tgl_hari_ini);?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <?php 
                                    $que="SELECT * FROM user where status_anggota = 'Ketua Umum';";
                                    $res=mysqli_query($conn,$que);
                                    while ($row1=mysqli_fetch_array($res)){
                                ?>
                                <p class="text-dark">
                                    Ketua Umum<br />
                                    OPA Ganendra Giri
                                    <br />
                                    <br />
                                    <br />
                                    <b><?php echo $row1["nama_user"]; ?></b><br />
                                    NIA. <?php echo $row1["nia"]; ?>-GG
                                </p>
                                <?php }
                                ?>
                            </div>
                            <div class="col-md-4">
                                <?php
                                    if($action != ""){
                                    $que="SELECT * FROM user where nia = '$nia';";
                                    $res=mysqli_query($conn,$que);
                                    while ($row1=mysqli_fetch_array($res)){
                                ?>
                                <p class="text-dark">
                                    <?php if($row1["status_anggota"] == "Departemen Rumah Tangga"){echo "Dept. Rumah Tangga";}else{echo "a.n Dept. Rumah Tangga";} ?><br />
                                    OPA Ganendra Giri
                                    <br />
                                    <br />
                                    <br />
                                    <?php echo $row1["nama_user"]; ?><br />
                                    NIA. <?php echo $row1["nia"]; ?>-GG
                                </p>
                                <?php break; }}else if($id_alat != ""){
                                    $que="SELECT * FROM user where status_anggota = 'Departemen Rumah Tangga';";
                                    $res=mysqli_query($conn,$que);
                                    while ($row1=mysqli_fetch_array($res)){
                                ?>
                                <p class="text-dark">
                                    Dept. Rumah Tangga<br />
                                    OPA Ganendra Giri
                                    <br />
                                    <br />
                                    <br />
                                    <b><?php echo $row1["nama_user"]; ?></b><br />
                                    NIA. <?php echo $row1["nia"]; ?>-GG
                                </p>
                                <?php break;} }?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-8">
                                <?php
                                    if($id_alat != ""){
                                    $que="SELECT * FROM user where nia = '$nia';";
                                    $res=mysqli_query($conn,$que);
                                    while ($row1=mysqli_fetch_array($res)){
                                ?>
                                <p class="text-dark">
                                    Penerima Pengembalian Alat<br />
                                    <br />
                                    <br />
                                    <br />
                                    <b><?php echo $row1["nama_user"]; ?></b><br />
                                    NIA. <?php echo $row1["nia"]; ?>-GG
                                </p>
                                <?php }}?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" <?php if(!isset($_POST['submit'])){echo "hidden";}?>>
            <div class="col-lg-12" id="div1">
                <button class="btn btn-outline-primary " onclick="printContent('div1')">
                    <i class="fas fa-print fa-1x"></i></button>
            </div>
        </div>


    </div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>
<?php include 'footer_admin.php'; ?>
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