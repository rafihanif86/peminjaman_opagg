<?php 
    include "connection.php";
    $halaman = "checklist bulanan";
    $reload = true;
    include 'header_admin.php';
    include 'tgl_indo.php';

    $id_checklist_group = $id_detail_masuk = $id_jenis_alat = $jum_kat = $jumlah = $jumlah2 = $status = $jumlah_belum = $jumlah_telah = "";

    $sql=mysqli_query($conn,"SELECT * FROM `checklist_group` WHERE `status` = 'waiting' || `status` = 'onprocess';");
    $jumlah_berjalan = mysqli_num_rows($res);
    if($jumlah_berjalan > 0){
        while ($row=mysqli_fetch_array($sql)) {
            $id_checklist_group =  $row['id_checklist_group'];
            $status =  $row['status'];
            $koordinator =  $row['koordinator'];
            $tgl_checklist_group = $row['tgl_checklist_group'];
        }
        
    }else{
        echo "<script> location.replace('tabel_checklist_group.php')</script>";
    }

    
?>
<meta http-equiv="refresh" content="60" />
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Checklist Group </h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="tabel_checklist_group.php" class="text-dark">Data Checklist Group</a></li>
                            <li class="active">
                                <?php if($status == "waiting"){ echo "Waiting";}else if($status == "onprocess"){echo"On Process";}?>
                            </li>
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
                    <div class="card-body card-block">
                        <div class="row">
                            <div class="col col-md-6">
                                <small
                                    class="text-secondary"><?php echo tgl_indo($tgl_checklist_group); ?></small><br />
                                <b>Petugas Pengecekan:</b>
                                <?php
                                    $nama_user = "";
                                    $status_anggota = "";
                                    $sql1=mysqli_query($conn,"SELECT * FROM user WHERE nia = '$nia';");
                                    while ($row=mysqli_fetch_array($sql1)) {
                                        $nama_user =  $row['nama_user'];
                                        $status_anggota =  $row['status_anggota'];
                                    }
                                ?>
                                <h3><?php echo $nama_user;?></h3>
                                <small><?php echo "NIA. ".$koordinator."-GG";?></small>
                                <h6><?php echo $status_anggota;?></h6>
                            </div>
                            <div class="col col-md-6 border-left">
                                <div class="container" style="float: left;">
                                    <div class="row">
                                        <div class="col col-md-8">
                                            Jumlah alat
                                        </div>
                                        <div class="col col-md-4">
                                            <?php
                                                $sql2=mysqli_query($conn,"SELECT MAX(tgl_checklist) AS tgl_check, id_alat FROM `checklist_record` WHERE kondisi != 'diputihkan' OR `status_peminjaman` != 'diambil' GROUP BY `id_alat`;");
                                                $jumlah_alat_gg = mysqli_num_rows($sql2);
                                                echo ": ".$jumlah_alat_gg;
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                        if($status == "onprocess"){
                                        $sql3=mysqli_query($conn,"SELECT * FROM `checklist_group_item` WHERE `id_checklist_group` = '$id_checklist_group' AND `id_check` = '';");
                                        $jumlah_belum = mysqli_num_rows($sql3);
                                        $jumlah_telah = $jumlah_alat_gg - $jumlah_belum;
                                    ?>
                                    <div class="row">
                                        <div class="col col-md-8">
                                            Telah dichecklist
                                        </div>
                                        <div class="col col-md-4">
                                            <?php echo ": ".$jumlah_telah; ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-8">
                                            Belum dichecklist
                                        </div>
                                        <div class="col col-md-4">
                                            <?php echo ": ".$jumlah_belum; ?>
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

        <?php 
            if($status == "onprocess"){
            $query1="SELECT c.*, a.`foto_alat`, a.`merk`, a.`type`, j.`nama_jenis_alat`, u.`nama_user` FROM `checklist_group_item` C, `alat` A, `user` U, `jenis_alat` J WHERE c.`id_checklist_group` = '$id_checklist_group' AND c.`id_check` = '' AND a.`id_jenis_alat` = j.`id_jenis_alat` AND a.`id_alat` = c.`id_alat` AND c.`petugas_check` = u.`nia`;";
            $result1=mysqli_query($conn,$query1);
            $jumlah_belum_check = mysqli_num_rows($result1);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Alat yang Belum dichecklist</strong>
                        <div class="float-right text-secondary"><?php echo "Belum dichecklist : ".$jumlah_belum_check;?>
                        </div>
                    </div>
                    <div class="card-body card-block">
                        <div class="row">
                            <?php
                                $i = 0;
                                while ($row2=mysqli_fetch_array($result1)){
                            ?>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="row no-gutters">
                                        <div class="col-md-4">
                                            <img src="images/<?php if($row2["foto_alat"] != "" || !empty($row2["foto_alat"]) || $row2["foto_alat"] != null ){echo $row2["foto_alat"];}else{echo "no_image.png";}?>"
                                                style="max-width: 120px; max-height: 120px; margin: 15px;"
                                                class="card-img-top" alt="...">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <div class="col col-md-12 border-left">
                                                    <div class="card-title">
                                                        <h6><?php echo $row2["id_alat"]; ?></h6>
                                                        <h5> <?php echo $row2["merk"]." ".$row2["type"]; ?> </h5>
                                                        <small class="text-secondary"><?php echo $row2["nama_jenis_alat"]; ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php  $i++; if($i == 2){ $i = 0; echo '</div><div class="row">';} } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
            $query2="SELECT c.*, a.`merk`, a.`type`, j.`nama_jenis_alat`, u.`nama_user`, r.`foto_alat_check`, r.`kondisi`, r.`keterangan` FROM `checklist_group_item` C, `alat` A, `user` U, `jenis_alat` J, `checklist_record` R WHERE c.`id_checklist_group` = '$id_checklist_group' AND c.`id_check` = r.`id_check` AND a.`id_jenis_alat` = j.`id_jenis_alat` AND a.`id_alat` = c.`id_alat` AND c.`petugas_check` = u.`nia`;";
            $result2=mysqli_query($conn,$query2);
            $jumlah_telah_check = mysqli_num_rows($result2);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Alat yang Telah dichecklist</strong>
                        <div class="float-right text-secondary"><?php echo "Telah dichecklist : ".$jumlah_telah_check;?>
                        </div>
                    </div>
                    <div class="card-body card-block">
                        <table id="bootstrap-data-table" class="table table-border-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 0;
                                    while ($row1=mysqli_fetch_array($result2)){
                                        $i++;
                                ?>
                                <tr>
                                    <td>
                                        <div class="card mb-12">
                                            <div class="row no-gutters">
                                                <div class="col-md-2">
                                                    <img src="images/<?php if($row1["foto_alat"] != "" || !empty($row1["foto_alat"]) || $row1["foto_alat"] != null ){echo $row1["foto_alat"];}else{echo "no_image.png";}?>"
                                                        class="card-img" alt="..."
                                                        style="max-height: 120px; max-width: 120px; margin: 15px; float:none;">
                                                </div>
                                                <div class="col-md-8 ">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col col-md-5 border-left">
                                                                <div class="card-title">
                                                                    <a class="text-dark"
                                                                        href="tampil_alat.php?id_alat=<?php echo $row1["id_alat"];?>">
                                                                        <h6><?php echo $row1["id_alat"]; ?></h6>
                                                                        <h5> <?php echo $row1["merk"]." ".$row1["type"]; ?>
                                                                        </h5>
                                                                    </a>
                                                                    <small
                                                                        class="text-secondary"><?php echo $row1["nama_jenis_alat"]." | ".$row1["nama_kat"]; ?></small>
                                                                </div>
                                                                <div class="card-text">
                                                                    <b>Deskripsi : </b><br />
                                                                    <?php echo $row1["deskripsi"]; ?><br />
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-7 border-left">
                                                                <div class="card-text">
                                                                    <b>Kondisi : </b><br />
                                                                    <?php if($status_peminjaman != ""){echo "Alat ini ".$status_peminjaman." pada nomor peminjaman <a class='text-dark' href='tampil_peminjaman.php?id_peminjaman_masuk=".$id_peminjaman_masuk."'> ".$id_peminjaman_masuk."</a>. ";} if($kondisi != ""){echo "Alat ini memiliki kondisi ".$kondisi.", ".$keterangan.". <br/><small class='text-secondary'>(".tgl_indo($tgl_checklist).", ".$nama_petugas.") </small>";} ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <img src="images/<?php if($row1["foto_alat_check"] != "" || !empty($row1["foto_alat_check"]) || $row1["foto_alat_check"] != null ){echo $row1["foto_alat_check"];}else{echo "no_image.png";}?>"
                                                        class="card-img" alt="..."
                                                        style="max-height: 120px; max-width: 120px; margin: 15px; float:none;">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>


    </div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>
<?php 
    include 'footer_admin.php'; 
?>