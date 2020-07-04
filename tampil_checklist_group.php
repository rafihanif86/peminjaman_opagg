<?php 
    include "connection.php";
    $halaman = "checklist";
    $reload = true;
    include 'header_admin.php';
    include 'tgl_indo.php';

    $id_checklist_group = $id_detail_masuk = $id_jenis_alat = $tgl_checklist_group = $dokumentasi = $resume = $jum_kat = $jumlah = $status = $jumlah_belum = $jumlah_telah = "";

    if(isset($_GET['id_checklist_group'])){
        $id_checklist_group = $_GET['id_checklist_group'];
        $sql=mysqli_query($conn,"SELECT * FROM `checklist_group` WHERE `id_checklist_group` = '$id_checklist_group';");
        $jumlah_berjalan = mysqli_num_rows($res);
        while ($row=mysqli_fetch_array($sql)) {
            $id_checklist_group =  $row['id_checklist_group'];
            $status =  $row['status'];
            $koordinator =  $row['koordinator'];
            $tgl_checklist_group = $row['tgl_checklist_group'];
            $resume = $row['resume'];
            $dokumentasi = $row['dokumentasi'];
        }
    }
    
?>
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Ringkasan Checklist Group </h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="tabel_checklist_group.php" class="text-dark">Data Checklist Group</a></li>
                            <li class="active">Ringkasan</li>
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
                    <div class="row no-gutters">
                        <div class="col-md-3">
                            <img src="images/<?php if($dokumentasi != "" || !empty($dokumentasi) || $dokumentasi != null ){echo $dokumentasi;}else{echo "no_image.png";}?>"
                                style="max-height: 20rem; " class="card-img" alt="...">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body card-block">
                                <div class="float-md-left border-left">
                                    <div class="container">
                                        <small
                                            class="text-secondary"><?php echo tgl_indo($tgl_checklist_group); ?></small><br />
                                        <b>Koordinator:</b>
                                        <?php
                                            $nama_user = "";
                                            $status_anggota = "";
                                            $sql1=mysqli_query($conn,"SELECT * FROM user WHERE nia = '$koordinator';");
                                            while ($row=mysqli_fetch_array($sql1)) {
                                                $nama_user =  $row['nama_user'];
                                                $status_anggota =  $row['status_anggota'];
                                            }
                                        ?>
                                        <h3><?php echo $nama_user;?></h3>
                                        <small><?php echo "NIA. ".$koordinator."-GG";?></small>
                                        <h6><?php echo $status_anggota;?></h6>
                                    </div>
                                </div>
                                <div class="float-md-left border-left">
                                    <div class="container">
                                        <b>Rangkuman:</b> <br />
                                        <?php echo $resume; ?>
                                    </div>
                                </div>
                                <div class="float-md-right">
                                    <div class="container">
                                        <a href="export_checklist_group.php?id_checklist_group=<?php echo $id_checklist_group;?>"
                                            target="blank" class="btn btn-primary btn-sm"><i class='fa fa-file-download fa-1x'></i> file.xlx</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php 
            $query1="SELECT i.`petugas_check`, u.`nama_user`, u.`nia`, u.`foto_anggota` FROM `checklist_group` G, `checklist_group_item` I, `user` U WHERE i.`petugas_check` = u.`nia` AND i.`id_checklist_group` = g.`id_checklist_group` AND g.`id_checklist_group` = '$id_checklist_group' GROUP BY i.petugas_check;";
            $result1=mysqli_query($conn,$query1);
            $anggota_mengikuti = mysqli_num_rows($result1);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Anggota yang Mengikuti</strong>
                        <div class="float-right text-secondary">
                            <?php echo "Jumlah : ".$anggota_mengikuti;?>
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
                                            <img src="images/<?php if($row2["foto_anggota"] != "" || !empty($row2["foto_anggota"]) || $row2["foto_anggota"] != null ){echo $row2["foto_anggota"];}else{echo "no_image.png";}?>"
                                                style="max-height: 20rem; " class="card-img" alt="...">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <div class="col col-md-12 border-left">
                                                    <div class="card-title">
                                                        <a class="text-dark"
                                                            href="tampil_anggota.php?nia=<?php echo $row2["nia"];?>"
                                                            target="blank">
                                                            <h6>NIA.<?php echo $row2["nia"]; ?>-GG </h6>
                                                            <h5> <?php echo $row2["nama_user"]; ?></h5>
                                                        </a>
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
            $query2="SELECT c.*, a.`merk`, a.`type`, a.`deskripsi`, j.`nama_jenis_alat`, u.`nama_user`, r.`foto_alat_check`, r.`kondisi`, r.`keterangan`, r.`tgl_checklist`, r.`petugas` 
                        FROM `checklist_group_item` C, `alat` A, `user` U, `jenis_alat` J, `checklist_record` R 
                        WHERE c.`id_checklist_group` = '$id_checklist_group' AND c.`id_check` = r.`id_check` AND a.`id_jenis_alat` = j.`id_jenis_alat` AND a.`id_alat` = c.`id_alat` AND c.`petugas_check` = u.`nia` ORDER BY c.`id_alat` DESC;";
            $result2=mysqli_query($conn,$query2);
            $jumlah_telah_check = mysqli_num_rows($result2);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Hasil Checklist</strong>
                        <div class="float-right text-secondary">
                            <?php echo "Telah dichecklist : ".$jumlah_telah_check;?>
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
                                                    <img src="images/<?php if($row1["foto_alat_check"] != "" || !empty($row1["foto_alat_check"]) || $row1["foto_alat_check"] != null ){echo $row1["foto_alat_check"];}else{echo "no_image.png";}?>"
                                                        class="card-img" alt="..."
                                                        style="max-height: 20rem; float:none;">
                                                </div>
                                                <div class="col-md-10 ">
                                                    <div class="card-body">
                                                        <div class="float-md-left border-left">
                                                            <div class="container">
                                                                <a class="text-dark"
                                                                    href="tampil_alat.php?id_alat=<?php echo $row1["id_alat"];?>"
                                                                    target="blank">
                                                                    <h6><?php echo $row1["id_alat"]; ?></h6>
                                                                    <h5> <?php echo $row1["merk"]." ".$row1["type"]; ?>
                                                                    </h5>
                                                                </a>
                                                                <small
                                                                    class="text-secondary"><?php echo $row1["nama_jenis_alat"]; ?></small><br />
                                                                <b>Deskripsi : </b><br />
                                                                <?php echo $row1["deskripsi"]; ?><br />
                                                            </div>
                                                        </div>
                                                        <div class="float-md-left border-left">
                                                            <div class="container">
                                                                <b>Kondisi : </b><br />
                                                                <?php if($row1["kondisi"] != ""){echo "Alat ini memiliki kondisi ".$row1["kondisi"].", ".$row1["keterangan"].". <br/><small class='text-secondary'>(".tgl_indo($row1["tgl_checklist"]).", ".$row1["nama_user"].") </small>";} ?>
                                                                <br />
                                                            </div>
                                                        </div>

                                                    </div>
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

    </div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>
<?php 
    include 'footer_admin.php'; 
    
    if(isset($_GET['status'])){
        if($_GET['status'] == "selesai"){
            echo "<script type='text/javascript'> window.onload = function(){ alert('Checklist group telah selesai. Terima Kasih'); }</script>";
        }
    }
?>
<script>
var camera = document.getElementById('camera');
var frame = document.getElementById('frame');

camera.addEventListener('change', function(e) {
    var file = e.target.files[0];
    // Do something with the image file.
    frame.src = URL.createObjectURL(file);
});

function reset() {
    frame.src = "";
}
</script>