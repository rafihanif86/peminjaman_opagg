<?php 
    include "connection.php";
    include 'header_admin.php';
    include 'tgl_indo.php';

    $id_peminjaman_masuk = $cari_alat = "";
    $search_form = "";
    $hidden_data_alat = "hidden";

    if(isset($_GET['id_peminjaman_masuk'])){
        $id_peminjaman_masuk    =   $_GET['id_peminjaman_masuk'];
    }

    if(isset($_POST['data_alat'])){
        $id_detail_masuk    =   $_POST['id_detail_masuk'];
        $hidden_data_alat = "";
    }

    if($id_peminjaman_masuk == ""){
        header('Location: dashboard_admin.php');
    }
?>
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Form Pengambilan Alat</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="dashboard_admin.php" class="text-dark">Data Peminjaman</a></li>
                            <li><a href="tampil_peminjaman.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>"
                                    class="text-dark">Ringkasan Peminjaman</a></li>
                            <li class="active text-dark">Form Pengambilan Alat</li>
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
                        <strong>List Alat telah disetujui | Peminjaman : <?php echo $id_peminjaman_masuk; ?></strong>
                        <div class="float-right"> Disetujui oleh :
                            <?php
                                $sql=mysqli_query($conn,"SELECT u.`nama_user` FROM `peminjaman_masuk` M, USER U WHERE m.`petugas_menyetujui` = u.`nia` AND m.`id_peminjaman_masuk` = '$id_peminjaman_masuk';");
                                while ($row=mysqli_fetch_array($sql)) {
                                    echo $row["nama_user"];
                                }    
                            ?>
                        </div>
                    </div>
                    <div class="card-body card-block">
                        <div class="container">
                            <div class="row">
                                <?php
                                    $query="SELECT D.*, K.nama_jenis_alat, K.foto_jenis_alat  FROM detail_peminjaman_masuk D,jenis_alat K WHERE K.id_jenis_alat = D.id_jenis_alat AND id_peminjaman_masuk = '$id_peminjaman_masuk' ORDER BY D.`id_detail_masuk`";
                                    $result=mysqli_query($conn,$query) ;
                                    $i = 0;
                                    while ($row2=mysqli_fetch_array($result)){
                                        $i++;
                                ?>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="row no-gutters">
                                            <div class="col-md-3">
                                                <img src="images/<?php if($row2["foto_jenis_alat"] != "" || !empty($row2["foto_jenis_alat"]) || $row2["foto_jenis_alat"] != null ){echo $row2["foto_jenis_alat"];}else{echo "no_image.png";}?>"
                                                    style="max-height: 20rem;" class="card-img-top" alt="...">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card-body">
                                                    <div class="float-md-left border-left">
                                                        <div class="container">
                                                            <h6><?php echo $row2["nama_jenis_alat"]; ?></h6>
                                                            <div class="text-secondary">
                                                                <small>
                                                                    <b>Permintaan : </b>
                                                                    <?php echo $row2["jumlah"]; ?><br />
                                                                    <b>Disetujui : </b>
                                                                    <?php echo $row2["jumlah_dikeluarkan"]; ?><br />
                                                                    <b>Dikeluarkan : </b>
                                                                    <?php
                                                                    $id_detail_masuk1 = $row2["id_detail_masuk"];
                                                                    $jum_kel="";
                                                                    $queryKel="SELECT COUNT(*) AS jum_keluar FROM detail_peminjaman_diterima WHERE id_detail_masuk = '$id_detail_masuk1'; ";
                                                                    $resultKel=mysqli_query($conn,$queryKel) ;
                                                                    while ($row6=mysqli_fetch_array($resultKel)){
                                                                        $jum_kel = $row6["jum_keluar"];
                                                                    }
                                                                    echo $jum_kel;
                                                                ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="float-md-right">
                                                        <div class="container">
                                                            <?php
                                                            if($row2["jumlah_dikeluarkan"] > $jum_kel){
                                                        ?>
                                                            <form
                                                                action="form_peminjaman_pengambilan.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>"
                                                                method="post" name="frm" enctype="multipart/form-data"
                                                                class="form-horizontal">
                                                                <input type="hidden" name="id_detail_masuk"
                                                                    value="<?php echo $row2["id_detail_masuk"]; ?>">
                                                                <button type="submit" class="btn btn-primary btn-sm "
                                                                    name="data_alat">
                                                                    <i class="fa fa-book-open fa-1x"></i>
                                                                </button>
                                                            </form>
                                                            <?php } ?>
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
                </div>
            </div>
        </div>

        <div class="row" <?php echo $hidden_data_alat; ?>>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>
                            <?php
                                $query="SELECT `nama_jenis_alat` FROM jenis_alat K, `detail_peminjaman_masuk` M WHERE k.`id_jenis_alat` = m.`id_jenis_alat` AND m.`id_detail_masuk` = '$id_detail_masuk';";
                                $result=mysqli_query($conn,$query) ;
                                while ($row2=mysqli_fetch_array($result)){
                                    echo $row2["nama_jenis_alat"];
                                }
                            ?> valid Yang Dapat Dipinjamkan</strong>
                    </div>
                    <div class="card-body card-block">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                                $query="SELECT a.`deskripsi`, a.`id_alat`, a.`merk`, a.`type`, a.`foto_alat`, k.`nama_jenis_alat` FROM alat A, `detail_peminjaman_masuk` M, `jenis_alat` k WHERE a.`id_jenis_alat` = k.`id_jenis_alat` and m.`id_jenis_alat` = a.`id_jenis_alat` AND m.`id_detail_masuk` = '$id_detail_masuk';";
                                                $result=mysqli_query($conn,$query) ;
                                                while ($row2=mysqli_fetch_array($result)){
                                                    $id_alat_data = $row2["id_alat"];
                                                    $status_checklist = "";
                                                    $keterangan = "";
                                                    $kondisi = "";
                                                    $tgl_checklist = "";
                                                    $que1="SELECT c.* FROM `alat` A, `checklist_record` C WHERE a.`id_alat` = c.`id_alat` AND a.`id_alat` = '$id_alat_data' ORDER BY c.`tgl_checklist` DESC;";
                                                    $res1=mysqli_query($conn,$que1) ;
                                                    while ($row1=mysqli_fetch_array($res1)){
                                                        $tgl_checklist = $row1["tgl_checklist"];
                                                        $kondisi = $row1["kondisi"];
                                                        $keterangan = $row1["keterangan"];
                                                        $status_checklist = $row1["status_peminjaman"];
                                                    }
                                                    if($status_checklist != 'diambil' and $kondisi = 'valid'){
                                                        $i++;
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="card mb-12">
                                                        <div class="row no-gutters">
                                                            <div class="col-md-3">
                                                                <img src="images/<?php if($row2["foto_alat"] != "" || !empty($row2["foto_alat"]) || $row2["foto_alat"] != null ){echo $row2["foto_alat"];}else{echo "no_image.png";}?>"
                                                                    class="card-img" alt="..."
                                                                    style="max-height: 20rem;">
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="card-body">
                                                                    <div class="float-md-left border-left">
                                                                        <div class="container">
                                                                            <a class="text-dark"
                                                                                href="tampil_alat.php?id_alat=<?php echo $row2["id_alat"];?>"
                                                                                target="blank">
                                                                                <h6><?php echo $row2["id_alat"]; ?></h6>
                                                                                <h5><?php echo $row2["merk"]." ".$row2["type"]; ?>
                                                                                </h5>
                                                                            </a>
                                                                            <small
                                                                                class="text-secondary"><?php echo $row2["nama_jenis_alat"]; ?></small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="float-md-left border-left">
                                                                        <div class="container">
                                                                            <b>Ciri : </b><br />
                                                                            <?php echo $row2["deskripsi"]; ?><br />
                                                                            <b>Kondisi : </b><br />
                                                                            <?php echo $kondisi.", ".$keterangan; if($tgl_checklist != "0000-00-00" || $tgl_checklist != "" || $tgl_checklist != null){ echo " <small class='text-secondary'>(".$tgl_checklist.") </small>";} ?><br />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="card-body">
                                                                    <a href="form_checklist.php?status_peminjaman=diambil&id_alat=<?php echo $row2["id_alat"];?>&id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>&id_detail_masuk=<?php echo $id_detail_masuk;?>"
                                                                        class="btn btn-primary btn-md"> <i
                                                                            class='fa fa-clipboard-check fa-1x'></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php } }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>List Alat Yang Diserahkan | Peminjaman : <?php echo $id_peminjaman_masuk; ?></strong>
                    </div>
                    <div class="card-body card-block">
                        <div class="container">
                            <?php
                                $query="SELECT d.*, a.`merk`, a.`type`, a.id_alat, a.foto_alat, a.deskripsi, k.`nama_jenis_alat`, c.`kondisi`, c.`keterangan`, c.`tgl_checklist` 
                                            FROM detail_peminjaman_diterima D, `detail_peminjaman_masuk` M, alat A, jenis_alat K, `checklist_record` C 
                                            WHERE d.`id_detail_masuk` = m.`id_detail_masuk` AND m.id_peminjaman_masuk = '$id_peminjaman_masuk' 
                                            AND d.`id_check_keluar` = c.`id_check` AND d.`id_alat` = a.`id_alat` AND a.`id_jenis_alat` = k.`id_jenis_alat`;";
                                $result=mysqli_query($conn,$query) ;
                                $i = 0;
                                while ($row2=mysqli_fetch_array($result)){
                                    $i++;
                            ?>
                            <div class="row">
                                <div class="col">
                                    <div class="card mb-12">
                                        <div class="row no-gutters">
                                            <div class="col-md-3">
                                                <img src="images/<?php if($row2["foto_alat"] != "" || !empty($row2["foto_alat"]) || $row2["foto_alat"] != null ){echo $row2["foto_alat"];}else{echo "no_image.png";}?>"
                                                    class="card-img" alt="..." style="max-height: 15rem;">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card-body">
                                                    <div class="float-md-left border-left">
                                                        <div class="container">
                                                            <a class="text-dark"
                                                                href="tampil_alat.php?id_alat=<?php echo $row2["id_alat"];?>" target="blank">
                                                                <h6><?php echo $row2["id_alat"]; ?></h6>
                                                                <h5><?php echo $row2["merk"]." ".$row2["type"]; ?>
                                                                </h5>
                                                            </a>
                                                            <small
                                                                class="text-secondary"><?php echo $row2["nama_jenis_alat"]; ?></small>
                                                        </div>
                                                    </div>
                                                    <div class="float-md-left border-left">
                                                        <div class="container">
                                                            <b>Ciri : </b><br />
                                                            <?php echo $row2["deskripsi"]; ?><br />
                                                            <b>Kondisi : </b><br />
                                                            <?php echo $row2["kondisi"].", ".$row2["keterangan"]." <small class='text-secondary'>(".tgl_indo($row2["tgl_checklist"]).") </small>"; ?><br />
                                                        </div>
                                                    </div>
                                                    <div class="float-md-right ">
                                                        <div class="container">
                                                            <a href="delete_item_diserahkan.php?id_detail=<?php echo $row2["id_detail"];?>&id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>"
                                                                class="btn btn-danger btn-sm "
                                                                onClick="return confirm('Hapus item ini??')">
                                                                <i class='fa fa-trash-o fa-1x'> </i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

        <div class="float-left">
            <a href="tampil_peminjaman.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>"
                class="btn btn-secondary btn-md active float-left" role="button" aria-pressed="true">
                <i class="fas fa-chevron-left "></i> Kembali
            </a>
        </div>
        <div class="float-right">
            <a href="form_peminjaman_jaminan.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>"
                class="btn btn-primary btn-md active float-right" role="button" aria-pressed="true">
                Selanjutnya <i class="fas fa-chevron-right"></i>
            </a>
        </div>

    </div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>
<?php 
    include 'footer_admin.php'; 

    if(isset($_GET['status'])){
        if($_GET['status'] == "berhasil"){
            echo "<script type='text/javascript'> window.onload = function(){ alert('Berhasil ditambahkan'); } </script>";
        }else if($_GET['status'] == "gagal"){
            echo "<script type='text/javascript'> window.onload = function(){ alert('Gagal ditambahkan'); } </script>";
        }else if($_GET['status'] == "berhasildihapus"){
            echo "<script type='text/javascript'> window.onload = function(){  alert('Lampiran berhasil dihapus'); } </script>";
        }else if($_GET['status'] == "gagaldihapus"){
            echo "<script type='text/javascript'> window.onload = function(){  alert('Lampiran gagal dihapus'); } </script>";
        }
    }
?>