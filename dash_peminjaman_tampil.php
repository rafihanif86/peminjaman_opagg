<?php
    include "connection.php";
    include 'tgl_indo.php';

    $title_header = "Peminjaman | Inventory OPA Ganendra Giri";
    $home_active = "";
    $peminjaman_active = "";
    $about_active = "";
    $tracking_active = "active";
    include 'header_dashboard.php';

    $id_peminjaman_masuk = $nik = $nama = $nama_kegiatan = $email_peminjam = $tgl_ambil = $tgl_kembali =  $no_wa = $lampiran_surat = $status = "";
    $jumlah_data = 0;
    $hidden_alert = "hidden";
    $action_button_peminjaman = "";
    $disabled_no_peminjaman = "";
    $hidden_data_peminjaman = "hidden";
    $hidden_disetujui = "hidden";
    $hidden_dikeluarkan = "hidden";
    $hidden_foto = "hidden";
    $status_print = "";
    $progress = '5%';

    if(isset($_POST['id_peminjaman_masuk'])){
        $id_peminjaman_masuk = $_POST['id_peminjaman_masuk'];
    }else if(isset($_GET['id_peminjaman_masuk'])){
        $id_peminjaman_masuk = $_GET['id_peminjaman_masuk'];
    }

    if($id_peminjaman_masuk != ""){

        $query1 = "SELECT * FROM peminjaman_masuk WHERE id_peminjaman_masuk = '$id_peminjaman_masuk';";
        $result1 = mysqli_query($conn, "SELECT count(id_peminjaman_masuk) as jumlah FROM peminjaman_masuk WHERE id_peminjaman_masuk = '$id_peminjaman_masuk';");
        while ($row1 = mysqli_fetch_array($result1)) {
            $jumlah_data = $row1["jumlah"];
        }

        if($jumlah_data > 0){
            $query1 = "SELECT * FROM peminjaman_masuk WHERE id_peminjaman_masuk = '$id_peminjaman_masuk';";
            $result1 = mysqli_query($conn, $query1);
            while ($row1 = mysqli_fetch_array($result1)) {
                $nik = $row1["nik"];
                $nama_kegiatan = $row1["nama_kegiatan"];
                $tgl_ambil = $row1["tgl_ambil"];
                $tgl_kembali = $row1["tgl_kembali"];
                $status = $row1["status"];
                $lampiran_surat = $row1["lampiran_surat"];
            }

            $que2 = "SELECT * FROM peminjam WHERE nik = '$nik';";
            $res2 = mysqli_query($conn, $que2);
            while ($row1 = mysqli_fetch_array($res2)) {
                $nama = $row1["nama"];
                $email_peminjam = $row1["email"];
                $no_wa = $row1["no_telepon"];
                $nama_instansi = $row1["instansi"];
            }
            $hidden_data_peminjaman = "";
            $disabled_no_peminjaman = "disabled";
            $action_button_peminjaman = "hidden";

            if ($status == 'baru') {
                $status_print = 'Pending';
                $progress = '40%';
            } else if ($status == 'disetujui') {
                $status_print = 'Telah disetujui';
                $progress = '60%';
                $hidden_disetujui = "";
            } else if ($status == 'diambil') {
                $status_print = 'Alat Telah Diambil';
                $hidden_dikeluarkan = "";
                $progress = '80%';
            } else if ($status == 'dikembalikan') {
                $status_print = 'Alat Telah Dikembalikan';
                $progress = '100%';
                $hidden_dikeluarkan = "";
                $hidden_disetujui = "";
            } 

        }else{
            $hidden_alert = "";
        }
        
    }



    $query = "SELECT D.*, k.name_kat FROM detail_peminjaman_masuk D, kategori K WHERE d.id_peminjaman_masuk = '$id_peminjaman_masuk' and k.id_kat = d.id_kat;";
    $result = mysqli_query($conn, $query);

    $query2 = "SELECT k.`name_kat`, a.`merk`, a.`type` FROM detail_peminjaman_masuk M,detail_peminjaman_diterima D, alat A, kategori k WHERE m.`id_detail_masuk` = 'id_peminjaman_masuk' AND d.`id_detail_masuk` = m.`id_detail_masuk` AND d.`id_alat` = a.`id_alat` AND m.`id_kat` = k.`id_kat`;";
    $result2 = mysqli_query($conn, $query2);


?>

<div class="content" style="max-width: 90%; margin: auto; float:none;">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body card-block">
                    <div class="breadcrumbs bg-white">
                        <div class="breadcrumbs-inner">
                            <div class="row" style="padding: 5px;">
                                <div class="col-md-6">
                                    <div class="page-header float-left" style="padding-bottom: 0px; padding-top: 10px;">
                                        <div class="page-title">
                                            <h1>Ringkasan Peminjaman</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="page-header float-right "
                                        style="padding-bottom: 0px; padding-top: 10px;">
                                        <div class="page-title">
                                            <ol class="breadcrumb text-right">
                                                <li class="breadcrumb-item"> Peminjaman </li>
                                                <li class="breadcrumb-item">Ringkasan</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-bottom: 10px;">
                                <div class="col-md-12">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar" aria-valuenow="<?php echo $progress;?>" aria-valuemin="0"
                                            aria-valuemax="100" style="width: <?php echo $progress;?>;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" <?php echo $action_button_peminjaman?>>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Cari data peminjaman</strong>
                </div>
                <form action="dash_peminjaman_tampil.php" method="post" name="frm" enctype="multipart/form-data"
                    class="form-horizontal">
                    <div class="card-body card-block">
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Nomor
                                    Peminjaman</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="text-input" name="id_peminjaman_masuk"
                                    placeholder="Nomor peminjaman" class="form-control"
                                    value="<?php echo  $id_peminjaman_masuk; ?>" <?php echo $disabled_no_peminjaman;?>>
                                <small class="help-block form-text">Masukkan nomor peminjaman
                                    anda</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" >
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-dot-circle-o"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-danger btn-sm">
                            <i class="fa fa-ban"></i> Reset
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="alert alert-warning" role="alert" <?php echo $hidden_alert?>>
        Data peminjaman anda tidak ditemukan. Harap masukkan nomor peminjaman dengan
        benar. Hubungi admin jika anda memiliki masalah peminjaman.
    </div>

    <div class="row" <?php echo $hidden_data_peminjaman;?>>
        <div class="col-lg-12">
            <div class="card" id="div1">
                <img src="images/KERTASKOPGG.png" class="card-img-top"
                    style="height: 100%; width: 100%; margin-left: auto; margin-right: auto;" alt="Kop Surat">
                <div class="card-body card-block">
                    <h3>Data Peminjaman <?php echo $id_peminjaman_masuk; ?></h3>
                    <hr />
                    <div class="container">
                        <div class="row ">
                            <div class="col-6">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">NIK</label>
                                    </div>
                                    <div class="col-12 col-md-9">: <?php echo $nik; ?></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Nama</label>
                                    </div>
                                    <div class="col-12 col-md-9">: <?php echo $nama; ?></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="email-input" class=" form-control-label">Email</label>
                                    </div>
                                    <div class="col-12 col-md-9">: <?php echo $email_peminjam; ?></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Telepon</label>
                                    </div>
                                    <div class="col-12 col-md-9">: <?php echo $no_wa; ?></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Instansi</label>
                                    </div>
                                    <div class="col-12 col-md-9">: <?php echo $nama_instansi; ?></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Kegiatan</label>
                                    </div>
                                    <div class="col-12 col-md-9">: <?php echo $nama_kegiatan ?></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input"
                                            class=" form-control-label">Tanggal Peminjaman</label></div>
                                    <div class="col-12 col-md-9">:
                                        <?php echo tgl_indo($tgl_ambil)." s/d ".tgl_indo($tgl_kembali); ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input"
                                            class=" form-control-label">Status</label></div>
                                    <div class="col-12 col-md-9">:
                                        <?php echo $status_print; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <h4>List Permintaan</h4>
                                <hr />
                                <div class="row">
                                    <?php
                                        $query="SELECT *  FROM detail_peminjaman_masuk DP
                                        inner join jenis_alat JA on DP.id_jenis_alat = JA.id_jenis_alat
                                        inner join kategori K on JA.id_kat = K.id_kat
                                        WHERE DP.id_peminjaman_masuk = '$id_peminjaman_masuk' ORDER BY DP.id_detail_masuk";
                                        $result=mysqli_query($conn,$query) ;
                                        $i = 0;
                                        while ($row2=mysqli_fetch_array($result)){
                                            $i++;
                                    ?>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="row no-gutters">
                                                <div class="col-md-4">
                                                    <img src="images/<?php if($row2["foto_jenis_alat"] != "" || !empty($row2["foto_jenis_alat"]) || $row2["foto_jenis_alat"] != null ){echo $row2["foto_jenis_alat"];}else{echo "no_image.png";}?>"
                                                        style="max-width: 120px; max-height: 120px; margin: 15px;"
                                                        class="card-img-top" alt="...">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <div class="col col-md-12 border-left">
                                                            <div class="card-title">
                                                                <h6><?php echo $row2["nama_jenis_alat"]; ?>
                                                                </h6>
                                                            </div>
                                                            <div class="card-text text-secondary">
                                                                <small>
                                                                    <b>Permintaan :</b>
                                                                    <?php echo $row2["jumlah"]; ?><br />
                                                                    <b <?php echo $hidden_disetujui;?>>Disetujui
                                                                        :</b>
                                                                    <?php echo $row2["jumlah_dikeluarkan"]; ?><br />
                                                                    <b <?php echo  $hidden_dikeluarkan;?>>Disetujui
                                                                        :
                                                                    </b>
                                                                    <?php
                                                                        $id_detail_masuk = $row2["id_detail_masuk"];
                                                                        $jum_kel="";
                                                                        $queryKel="SELECT COUNT(*) AS jum_keluar FROM detail_peminjaman_diterima WHERE id_detail_masuk = '$id_detail_masuk'; ";
                                                                        $resultKel=mysqli_query($conn,$queryKel) ;
                                                                        while ($row6=mysqli_fetch_array($resultKel)){
                                                                            $jum_kel = $row6["jum_keluar"];
                                                                        }
                                                                        if($jum_kel > 0){echo $jum_kel;}
                                                                    ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($i==2){ $i = 0; echo '</div><div class="row">';} } ?>
                                </div>
                            </div>
                        </div>

                        <div class="row" <?php if($status != "diambil"){ echo "hidden"; }?>>
                            <div class="col">
                                <h4>List Alat Dipinjamkan</h4>
                                <hr />
                                <div class="row">
                                    <?php   
                                        $query1="SELECT d.*, a.`merk`, a.`type`, a.id_alat, a.foto_alat, a.ciri, k.`name_kat`, c.`kondisi`, c.`keterangan` FROM detail_peminjaman_diterima D, `detail_peminjaman_masuk` M, alat A, kategori K, `checklist_record` C WHERE d.`id_detail_masuk` = m.`id_detail_masuk` AND m.id_peminjaman_masuk = '$id_peminjaman_masuk' AND d.`id_check_keluar` = c.`id_check` AND d.`id_alat` = a.`id_alat` AND a.`id_kat` = k.`id_kat`;";
                                        $result1=mysqli_query($conn,$query1);
                                        $i = 0;
                                        while ($row2=mysqli_fetch_array($result1)){
                                            $i++;
                                    ?>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="row no-gutters">
                                                <div class="col-md-4">
                                                    <img src="images/<?php if($row2["foto_alat"] != "" || !empty($row2["foto_alat"]) || $row2["foto_alat"] != null ){echo $row2["foto_alat"];}else{echo "no_image.png";}?>"
                                                        class="card-img" alt="..."
                                                        style="max-width: 120px; max-height: 120px; margin:15px;">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col col-md-12 border-left">
                                                                <div class="card-title">
                                                                    <h6><?php echo $row2["id_alat"]; ?>
                                                                    </h6>
                                                                    <h5> <?php echo $row2["merk"]." ".$row2["type"]; ?>
                                                                    </h5>
                                                                    <small
                                                                        class="text-secondary"><?php echo $row2["name_kat"]; ?></small>
                                                                </div>
                                                                <div class="card-text ">
                                                                    <b>Ciri:
                                                                    </b><?php echo $row2["ciri"]; ?><br />
                                                                    <b>Kondisi: </b>
                                                                    <?php echo $row2["kondisi"].", ".$row2["keterangan"]; ?><br />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($i == 2){echo '</div><div class="row">'; $i = 0;} } ?>
                                </div>
                            </div>
                        </div>

                        <div class="row" <?php  if($status != "dikembalikan"){ echo "hidden"; } ?>>
                            <div class="col">
                                <h4>List Alat Dipinjamkan</h4>
                                <hr />
                                <?php   
                                    $query="SELECT d.*, a.`merk`, a.`type`, a.id_alat, a.foto_alat, a.ciri, k.`name_kat` FROM detail_peminjaman_diterima D, `detail_peminjaman_masuk` M, alat A, kategori K WHERE d.`id_detail_masuk` = m.`id_detail_masuk` AND m.id_peminjaman_masuk = '$id_peminjaman_masuk' AND d.`id_alat` = a.`id_alat` AND a.`id_kat` = k.`id_kat`;";
                                    $result=mysqli_query($conn,$query) ;
                                    $i = 0;
                                    while ($row2=mysqli_fetch_array($result)){
                                        $i++;
                                        if($row2["id_check_keluar"] != "" && $row2["id_check_masuk"] != "" ){
                                ?>
                                <div class="row">
                                    <div class="col">
                                        <div class="card mb-12">
                                            <div class="row no-gutters">
                                                <div class="col-md-2">
                                                    <img src="images/<?php if($row2["foto_alat"] != "" || !empty($row2["foto_alat"]) || $row2["foto_alat"] != null ){echo $row2["foto_alat"];}else{echo "no_image.png";}?>"
                                                        class="card-img" alt="..."
                                                        style="max-height: 120px; max-width: 120px; margin: 15px; float:none;">
                                                </div>
                                                <div class="col-md-10 ">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col col-md-5 border-left">
                                                                <div class="card-title">
                                                                    <h6><?php echo $row2["id_alat"]; ?>
                                                                    </h6>
                                                                    <h5> <?php echo $row2["merk"]." ".$row2["type"]; ?>
                                                                    </h5>
                                                                    <small
                                                                        class="text-secondary"><?php echo $row2["name_kat"]; ?></small>
                                                                </div>
                                                                <div class="card-text">
                                                                    <b>Ciri : </b>
                                                                    <?php echo $row2["ciri"]; ?><br />
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-7 border-left">
                                                                <div class="card-text">
                                                                    <b>Kondisi Penyerahan: </b><br />
                                                                    <?php 
                                                                        $id_detail = $row2["id_detail"];
                                                                        $res1=mysqli_query($conn,"SELECT c.`kondisi`, c.`keterangan`, c.`tgl_checklist` FROM `detail_peminjaman_diterima` D, `checklist_record` C WHERE d.`id_check_keluar` = c.`id_check` AND d.`id_detail` = '$id_detail';") ;
                                                                        while ($row1=mysqli_fetch_array($res1)){
                                                                        echo $row1["kondisi"].", ".$row1["keterangan"]." <small class='text-secondary'>(".tgl_indo($row1["tgl_checklist"]).")</small> ";
                                                                        } 
                                                                    ?>
                                                                </div>
                                                                <div class="card-text">
                                                                    <b>Kondisi Pengembalian: </b><br />
                                                                    <?php 
                                                                        $id_detail = $row2["id_detail"];
                                                                        $res1=mysqli_query($conn,"SELECT c.`kondisi`, c.`keterangan`, c.`tgl_checklist` FROM `detail_peminjaman_diterima` D, `checklist_record` C WHERE d.`id_check_masuk` = c.`id_check` AND d.`id_detail` = '$id_detail';") ;
                                                                        while ($row1=mysqli_fetch_array($res1)){
                                                                        echo $row1["kondisi"].", ".$row1["keterangan"]." <small class='text-secondary'>(".tgl_indo($row1["tgl_checklist"]).") </small>";
                                                                        } 
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php }} ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-sm" onclick="printContent('div1')" <?php echo $hidden_data_peminjaman;?>>
                <i class="fas fa-print fa-1x"></i>
            </button>
            <span class="badge badge-info">Data Peminjaman ini tidak perlu dicetak</span>
        </div>
    </div>

    <?php 
        if($lampiran_surat != ""){
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Lampiran Surat <?php echo $id_peminjaman_masuk; ?></strong>
                </div>
                <div class="card-body card-block">
                    Nama File :<a href="images/<?php echo $lampiran_surat;?>" target="blank" class="text-dark"> <?php echo $lampiran_surat;?></a>
                    <hr />
                    <!-- <object data="images/" type="application/pdf" width="100%"
                        height="100%"></object> -->
                    <embed src="images/<?php echo $lampiran_surat;?>" type="application/pdf" width="800" height="600" >

                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <?php
        if (isset($_GET['id_peminjaman_masuk'])) {
            $foto_jaminan = "";
            $result = mysqli_query($conn, "SELECT foto_jaminan FROM peminjaman_masuk WHERE  id_peminjaman_masuk = '$id_peminjaman_masuk';");
            while ($row1 = mysqli_fetch_array($result)) {
                $foto_jaminan      =   $row1["foto_jaminan"];
            }
            $hidden_foto = "hidden";
            if ($foto_jaminan != "" || $foto_jaminan != null || !empty($foto_jaminan)) {
                $hidden_foto = "";
            }
    ?>
    <div class="row" <?php echo $hidden_foto; ?>>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Lampiran Foto Jaminan Peminjam <?php echo $id_peminjaman_masuk ?></strong>
                </div>
                <div class="card-body card-block">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <img src="images/<?php echo $foto_jaminan; ?>" class="d-block w-100"
                                                    alt="">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <p>File name : <?php echo $foto_jaminan; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div><!-- .content -->


<div class="clearfix"></div>
<?php
    include 'footer_dashboard.php'
?>
<script>
function printContent(el) {
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    window.print();
    document.body.innerHTML = restorepage;
}
</script>