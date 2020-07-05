<?php 
    include "connection.php";
    $halaman = "checklist";
    include "header_admin.php";
    include 'tgl_indo.php';

    $tgl_hari_ini = date('Y-m-d');
    $hidden_button = "";
    $res=mysqli_query($conn,"SELECT * FROM `checklist_group` WHERE `status` = 'waiting' || `status` = 'onprocess';") ;
    $jumlah_berjalan = mysqli_num_rows($res);
    if($jumlah_berjalan > 0){
        while ($row=mysqli_fetch_array($res)) {
            $koordinator =  $row['koordinator'];
        }
        if($nia == $koordinator){
            echo "<script> location.replace('form_checklist_group.php')</script>";
        }else{
            echo "<script> location.replace('form_checklist_onprocess.php')</script>";
        }
        $hidden_button = "hidden";
    }

?>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Tabel Checklist Group</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Tabel Checklist Group</li>
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
                        <div class="row">
                            <div class="col col-md-6">
                                <strong class="card-title">Data Tabel</strong>
                            </div>
                            <div class="col col-md-6">
                                <form action="tabel_checklist_group.php" method="post" name="frm"
                                    enctype="multipart/form-data">
                                    <button type="submit" class="btn btn-primary btn-sm float-right" name="mulai"
                                        <?php echo $hidden_button;?>>
                                        <i class="fa fa-dot-circle-o"></i> Mulai Checklist Group
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-border">
                            <thead>
                                <tr>
                                    <th></th>
                            </thead>
                            <tbody>
                                <?php
                                    $query="SELECT C.*, u.nama_user FROM `checklist_group` C, user U where c.koordinator = u.nia GROUP BY `id_checklist_group`;"; 
                                    $result=mysqli_query($conn,$query);
                                    $i = 0;
                                    while ($row1=mysqli_fetch_array($result)){
                                        $i++;
                                        $id_checklist_group = $row1["id_checklist_group"];
                                ?>
                                <tr>
                                    <td>
                                        <div class="card mb-12">
                                            <div class="row no-gutters">
                                                <div class="col-md-2">
                                                    <img src="images/<?php if($row1["dokumentasi"] != "" || !empty($row1["dokumentasi"] ) || $row1["dokumentasi"]  != null ){echo $row1["dokumentasi"];}else{echo "no_image.png";}?>"
                                                        style="max-height: 20rem; " class="card-img" alt="...">
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="card-body">
                                                        <div class="float-md-left border-left">
                                                            <div class="container">
                                                                <a class="text-dark"
                                                                    href="tampil_peminjaman.php?id_peminjaman_masuk=<?php echo $row1["id_peminjaman_masuk"];?>">
                                                                    <small
                                                                        class="text-secondary"><?php echo tgl_indo($row1["tgl_checklist_group"]); ?></small><br />
                                                                    Koordinator:<br />
                                                                    <h3> <?php echo $row1["nama_user"]; ?></h3>
                                                                    Resume:<br />
                                                                    <?php echo $row1["resume"]; ?>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="float-md-left border-left">
                                                            <div class="container">
                                                                <b>Lain - lain : </b><br />
                                                                <table class="table table-sm">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col" width="80%"></th>
                                                                            <th scope="col" width="15%"></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Petugas Mengikuti</td>
                                                                            <td>
                                                                                <?php
                                                                                        $query1="SELECT i.`petugas_check`, u.`nama_user`, u.`nia`, u.`foto_anggota` FROM `checklist_group` G, `checklist_group_item` I, `user` U WHERE i.`petugas_check` = u.`nia` AND i.`id_checklist_group` = g.`id_checklist_group` AND g.`id_checklist_group` = '$id_checklist_group' GROUP BY i.petugas_check;";
                                                                                        $result1=mysqli_query($conn,$query1);
                                                                                        $anggota_mengikuti = mysqli_num_rows($result1);
                                                                                        echo $anggota_mengikuti;
                                                                                    ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Alat dichecklist</td>
                                                                            <td>
                                                                                <?php
                                                                                        $query2="SELECT c.* FROM `checklist_group_item` C, `alat` A, `user` U, `jenis_alat` J, `checklist_record` R WHERE c.`id_checklist_group` = '$id_checklist_group' AND c.`id_check` = r.`id_check` AND a.`id_jenis_alat` = j.`id_jenis_alat` AND a.`id_alat` = c.`id_alat` AND c.`petugas_check` = u.`nia` ORDER BY c.`id_alat` DESC;";
                                                                                        $result2=mysqli_query($conn,$query2);
                                                                                        $jumlah_telah_check = mysqli_num_rows($result2);
                                                                                        echo $jumlah_telah_check;
                                                                                    ?>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
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
                        <button type="button" class="btn btn-success btn-md data-toggle="modal"
                            data-target="#exampleModalCenter">
                            <i class='fa fa-file-download fa-1x'></i> Download laporan checklist bulanan file.xls
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-success btn-md" data-toggle="modal"
                    data-target="#exampleModalCenter">
                    <i class='fa fa-file-download fa-1x'></i> Download laporan checklist bulanan file.xls
                </button>
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
            <form action="export_checklist_group_seluruh.php" method="post" name="frm" enctype="multipart/form-data"
                class="form-horizontal">
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Tanggal Awal</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="date" id="tgl_awal" name="tgl_awal" placeholder="Tanggal Awal"
                                class="form-control" value="" max="<?php echo $tgl_hari_ini;  ?>" onchange="change_kembali()">
                            <small class="help-block form-text">Maksimal hari ini</small>
                        </div>
                    </div>
                    <div class="row form-group" id="kembali">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Tanggal Akhir</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="date" id="tgl_kembali" name="tgl_akhir" placeholder="Tanggal Akhir"
                                class="form-control" value="">
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
                    <button type="submit" class="btn btn-primary" name="submit_tanggal">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<?php
    include 'footer_admin.php';

    $tgl_hari_ini = date('Y-m-d');

    if(isset($_POST["mulai"])){
        $query1="INSERT INTO checklist_group (koordinator,tgl_checklist_group,status) VALUES ('".$nia."','".$tgl_hari_ini."','waiting');";
            $sql_insert1 = mysqli_query($conn,$query1);
            if($sql_insert1){
                echo "<script> location.replace('form_checklist_group.php')</script>";
            }else{
                echo "<script type='text/javascript'> window.onload = function(){  alert('Gagal memulai checklist group'); } </script>";
            }
    }
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