<?php 
    include "connection.php";
    $halaman = "alat";
    include "header_admin.php";
    include 'tgl_indo.php';
 
    $act = "";
    $judul = "";

    if(isset($_GET["action"])){
        $act = $_GET["action"];
        if( $act == "valid"){
            $judul = "Valid";
        } else if( $act== "rusak"){
            $judul = "Rusak";
        }else if($act == "hilang"){
            $judul = "Hilang";
        }else if($act == "diputihkan"){
            $judul = "Diputihkan";
        }else if($act == "seluruh"){
            $judul = "Seluruh";
        }
    }

    $query = "SELECT a.*, k.nama_jenis_alat, i.nama_kat FROM alat A, jenis_alat K, kategori i where k.id_jenis_alat = a.id_jenis_alat and k.id_kat = i.id_kat order by a.id_alat desc;";

    if(isset($_GET['id_jenis_alat'])){
        $id_jenis_alat = $_GET['id_jenis_alat'];

        $res=mysqli_query($conn,"SELECT * FROM jenis_alat where id_jenis_alat = '$id_jenis_alat';");
        while ($row=mysqli_fetch_array($res)){
            $judul = $row["nama_jenis_alat"];
        }
        $query = "SELECT a.*, k.nama_jenis_alat, i.nama_kat FROM alat A, jenis_alat K, kategori i where k.id_jenis_alat = a.id_jenis_alat and k.id_kat = i.id_kat and k.id_jenis_alat = '$id_jenis_alat' order by a.id_alat desc;";
        $act = "seluruh";
    }
    
    $result=mysqli_query($conn,$query);

?>
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Data Alat <?php if($judul != ""){ echo " | ".$judul;} ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="text-dark">Data Alat</li>
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
                        <strong class="card-title">Data Tabel</strong>
                        <a href="export_data_alat.php?action=<?php echo $act;?>"  class="btn btn-success btn-md float-right" role="button"
                            aria-pressed="true"> <i class='fa fa-file-download fa-1x'></i> Data alat.xls</a>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-border-0">
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