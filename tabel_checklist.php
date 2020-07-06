<?php 
    include "connection.php";
    $halaman = "alat";
    include "header_admin.php";
    include 'tgl_indo.php';

    $tgl_hari_ini = date('Y-m-d');

?>
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Tabel Checklist</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Tabel Checklist</li>
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
                        <strong class="card-title">Data Tabel</strong>
                        <!-- <a href="form_checklist.php" class="btn btn-primary btn-md active float-right" role="button" aria-pressed="true">Form Checklist</a> -->
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table border-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $result=mysqli_query($conn,"SELECT c.*, a.`merk`, a.`type`, j.`nama_jenis_alat`, u.`nama_user` FROM checklist_record c, alat a, `jenis_alat` j, USER u WHERE c.`id_alat` = a.`id_alat` AND a.`id_jenis_alat` = j.`id_jenis_alat` AND c.`petugas` = u.`nia` ORDER BY tgl_checklist DESC;");
                                    $i = 0;
                                    while ($row1=mysqli_fetch_array($result)){
                                        $i++;
                                ?>
                                <tr>
                                    <td>
                                        <div class="card mb-12">
                                            <div class="row no-gutters">
                                                <div class="col-md-10 ">
                                                    <div class="card-body">
                                                        <div class="float-md-left border-left">
                                                            <div class="container">
                                                                <small class='text-secondary'>(<?php echo $row1['tgl_checklist'].", ".$row1["nama_user"];?>) </small>
                                                                <a class="text-dark"
                                                                    href="tampil_alat.php?id_alat=<?php echo $row1["id_alat"];?>">
                                                                    <h6><?php echo $row1["id_alat"]; ?></h6>
                                                                    <h5> <?php echo  $row1["merk"]." ". $row1["type"];; ?>
                                                                    </h5>
                                                                </a>
                                                                <small
                                                                    class="text-secondary"><?php echo  $row1["nama_jenis_alat"]; ?></small>
                                                            </div>
                                                        </div>
                                                        <div class="float-md-left border-left">
                                                            <div class="container">
                                                                <b>Kondisi : </b><br />
                                                                <?php if($row1["status_peminjaman"] != ""){echo "Alat ini ".$row1["status_peminjaman"]." pada nomor peminjaman <a class='text-dark' href='tampil_peminjaman.php?id_peminjaman_masuk=".$row1["id_peminjaman_masuk"]."'> ".$row1["id_peminjaman_masuk"]."</a>. ";} 
                                                                    if($row1["kondisi"] != ""){echo "Alat ini memiliki kondisi ".$row1["kondisi"].", ".$row1["keterangan"].".";} ?>
                                                                <br />
                                                                <a href="form_checklist.php?edit=true&id_check=<?php echo $row1["id_check"];?>"
                                                                    class="btn btn-primary btn-sm">
                                                                    <i class='fa fa-pencil fa-1x'> </i> </a>
                                                                <a href="delete_checklist.php?id_check=<?php echo $row1["id_check"];?>"
                                                                    class="btn btn-danger btn-sm ">
                                                                    <i class='fa fa-trash-o fa-1x'> </i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <img src="images/<?php if($row1["foto_alat_check"] != "" || !empty($row1["foto_alat_check"]) || $row1["foto_alat_check"] != null ){echo $row1["foto_alat_check"];}else{echo "no_image.png";}?>"
                                                        class="card-img" alt="..."
                                                        style="max-height: 20rem; float:none;">
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
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                    data-target="#exampleModalCenter">
                    <i class='fa fa-file-download fa-1x'></i> Download laporan checklist file.xls
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
            <form action="export_checklist_terbaru.php" method="post" name="frm" enctype="multipart/form-data"
                class="form-horizontal">
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Tanggal Awal</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="date" id="tgl_awal" name="tgl_awal" placeholder="Tanggal Awal"
                                class="form-control" value="" max="<?php echo $tgl_hari_ini;?>" onchange="change_kembali()">
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
                    <button type="submit" class="btn btn-success" name="submit_tanggal"><i class='fa fa-file-download fa-1x'></i> Download</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="clearfix"></div>

<?php
    include 'footer_admin.php';

    if(isset($_GET['status'])){
        if($_GET['status'] == "berhasildihapus"){
            echo "<script type='text/javascript'> window.onload = function(){  alert('Berhasil dihapus'); } </script>";
        }else if($_GET['status'] == "gagaldihapus"){
            echo "<script type='text/javascript'> window.onload = function(){  alert('Gagal dihapus'); } </script>";
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