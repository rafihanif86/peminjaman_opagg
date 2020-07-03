<?php 
    include "connection.php";
    $halaman = "alat";
    include "header_admin.php";
    include 'tgl_indo.php';
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
                                                                    if($row1["kondisi"] != ""){echo "Alat ini memiliki kondisi ".$row1["kondisi"].", ".$row1["keterangan"].". <br/><small class='text-secondary'>(".tgl_indo($row1['tgl_checklist']).", ".$row1["nama_user"].") </small>";} ?>
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

    </div><!-- .animated -->
</div><!-- .content -->


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