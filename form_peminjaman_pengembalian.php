<?php 
    include "connection.php";
    include 'header_admin.php';
    include "tgl_indo.php";

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
                        <strong>List Alat Yang Dipinjam | Peminjaman : <?php echo $id_peminjaman_masuk; ?></strong>
                    </div>
                    <div class="card-body card-block">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $query="SELECT d.*, a.`merk`, a.`type`, a.id_alat, a.foto_alat, a.deskripsi, k.`nama_jenis_alat`, c.`kondisi`, c.`keterangan`, c.`tgl_checklist` FROM detail_peminjaman_diterima D, `detail_peminjaman_masuk` M, alat A, jenis_alat K, `checklist_record` C WHERE d.`id_detail_masuk` = m.`id_detail_masuk` AND m.id_peminjaman_masuk = '$id_peminjaman_masuk' AND d.`id_check_keluar` = c.`id_check` AND d.`id_alat` = a.`id_alat` AND a.`id_jenis_alat` = k.`id_jenis_alat`;";
                                                $result=mysqli_query($conn,$query) ;
                                                $i = 0;
                                                while ($row2=mysqli_fetch_array($result)){
                                                    $i++;
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="card mb-12">
                                                        <div class="row no-gutters">
                                                            <div class="col-md-3">
                                                                <img src="images/<?php if($row2["foto_alat"] != "" || !empty($row2["foto_alat"]) || $row2["foto_alat"] != null ){echo $row2["foto_alat"];}else{echo "no_image.png";}?>"
                                                                    class="card-img" alt="..."
                                                                    style="max-height: 120px; max-width: 120px; margin:20px; float:none;">
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="card-body">

                                                                    <div class="row">
                                                                        <div class="col col-md-5 border-left">
                                                                            <div class="card-title">
                                                                                <h6><?php echo $row2["id_alat"]; ?></h6>
                                                                                <h5><?php echo $row2["merk"]." ".$row2["type"]; ?>
                                                                                </h5>
                                                                                <small
                                                                                    class="text-secondary"><?php echo $row2["nama_jenis_alat"]; ?></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col col-md-6 border-left">
                                                                            <div class="card-text">
                                                                                <b>Deskripsi : </b><br />
                                                                                <?php echo $row2["deskripsi"]; ?><br />
                                                                                <b>Kondisi : </b><br />
                                                                                <?php echo $row2["kondisi"].", ".$row2["keterangan"]." <small class='text-secondary'>(".tgl_indo($row2["tgl_checklist"]).") </small>"; ?><br />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col col-md-1 ">
                                                                            <?php
                                                                            $tombol_check = false;
                                                                            $id_detail = $row2["id_detail"];
                                                                            $res1=mysqli_query($conn,"SELECT id_check_masuk FROM `detail_peminjaman_diterima` WHERE `id_detail` = '$id_detail'") ;
                                                                            while ($row1=mysqli_fetch_array($res1)){
                                                                                if($row1["id_check_masuk"] == "" || $row1["id_check_masuk"] == "(NULL)" || $row1["id_check_masuk"] == null){
                                                                                    $tombol_check = true;
                                                                                }
                                                                            }
                                                                            if($tombol_check){
                                                                        ?>
                                                                            <a href="form_checklist.php?status_peminjaman=dikembalikan&id_alat=<?php echo $row2["id_alat"];?>&id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>&id_detail_masuk=<?php echo $row2["id_detail_masuk"];?>"
                                                                                class="btn btn-primary btn-md float-right">
                                                                                <i
                                                                                    class='fa fa-clipboard-check fa-1x'></i>
                                                                            </a>
                                                                            <?php } ?>
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
                        <strong>List Alat Yang Telah Periksa Pengembalian | Peminjaman :
                            <?php echo $id_peminjaman_masuk; ?></strong>
                    </div>
                    <div class="card-body card-block">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <?php
                                        $query="SELECT d.*, a.`merk`, a.`type`, a.id_alat, a.foto_alat, a.deskripsi, k.`nama_jenis_alat` FROM detail_peminjaman_diterima D, `detail_peminjaman_masuk` M, alat A, jenis_alat K WHERE d.`id_detail_masuk` = m.`id_detail_masuk` AND m.id_peminjaman_masuk = '$id_peminjaman_masuk' AND d.`id_alat` = a.`id_alat` AND a.`id_jenis_alat` = k.`id_jenis_alat`;";
                                        $result=mysqli_query($conn,$query) ;
                                        $i = 0;
                                        while ($row2=mysqli_fetch_array($result)){
                                            $i++;
                                            if($row2["id_check_keluar"] != "" && $row2["id_check_masuk"] != "" ){
                                    ?>
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
                                                                <h6><?php echo $row2["id_alat"]; ?></h6>
                                                                <h5> <?php echo $row2["merk"]." ".$row2["type"]; ?>
                                                                </h5>
                                                                <small
                                                                    class="text-secondary"><?php echo $row2["nama_jenis_alat"]; ?></small>
                                                            </div>
                                                            <div class="card-text">
                                                                <b>Deskripsi : </b> <?php echo $row2["deskripsi"]; ?><br />
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
                                    <?php
                                        }}
                                    ?>
                                    </table>
                                </div>
                            </div>
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
            <!-- BUTTON NEXT -->
            <div class="float-right">
            <?php
                $btn_selesai = true;
                $res1=mysqli_query($conn,"SELECT d.* FROM `detail_peminjaman_diterima` D, `detail_peminjaman_masuk` M WHERE m.`id_detail_masuk` = d.`id_detail_masuk` AND m.`id_peminjaman_masuk` = '$id_peminjaman_masuk';") ;
                while ($row1=mysqli_fetch_array($res1)){
                    if($row1["id_check_masuk"] == ""){
                        $btn_selesai = false;
                        break;
                    }
                }
                $status = ""; 
                $res3=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE id_peminjaman_masuk = '$id_peminjaman_masuk';");
                    while ($row1=mysqli_fetch_array($res3)){
                        $status = $row1["status"];
                }
                if($btn_selesai && $status == "diambil" ){  
                    $email = "";
                    $nama = "";
                    $nia_dept = ""; 
                    $res2=mysqli_query($conn,"SELECT * FROM USER WHERE `status_anggota` = 'Departemen Rumah Tangga';");
                    while ($row1=mysqli_fetch_array($res2)){
                        $email = $row1["email"];
                        $nama = $row1["nama_user"];
                        $nia_dept = $row1["nia"];
                    }
                    
                    if($nia_dept != $nia ){ 
            ?> 
                <form id="contact-form" action="sent_email.php" method="get" role="form">
                    <input type="hidden" name="email" value="<?php echo  $email; ?>">
                    <input type="hidden" name="name" value="<?php echo  $nama; ?>">
                    <input type="hidden" name="subject" value="Peminjaman Peralatan OPA Ganendra Giri">
                    <input type="hidden" name="message" value="Peminjaman <?php echo $id_peminjaman_masuk;?> telah dikembalikan. Segera lakukan pengecekan alat yang telah dikembalikan secara langsung di sekretariat
                    .">
                    <input type="hidden" name="pesan_replace"
                        value="Terima Kasih telah melakukan pengecekan pengembalian alat. kami akan menginformasikan pengembalian peminjaman ini kepada Departemen Rumah Tangga.">
                    <input type="hidden" name="link"
                        value="tampil_peminjaman.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>">
                    <button type="submit" class="btn btn-primary btn-md active float-right">
                        Selesai <i class="fas fa-chevron-right "></i>
                    </button>
                </form>
                <?php 
                    $q_keluar="UPDATE peminjaman_masuk set status = 'dikembalikan', petugas_pengembalian = '$nia' where id_peminjaman_masuk = '$id_peminjaman_masuk';";
                    $hasil = mysqli_query($conn,$q_keluar);
                    } else {
                ?>
                <a href="tampil_peminjaman.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>"
                    class="btn btn-primary btn-md active" role="button" aria-pressed="true">
                    Selesai <i class="fas fa-chevron-right "></i>
                </a>
                <?php 
                    $q_keluar="UPDATE peminjaman_masuk set status = 'dikembalikan', petugas_pengembalian = '$nia' where id_peminjaman_masuk = '$id_peminjaman_masuk';";
                    $hasil = mysqli_query($conn,$q_keluar);
                } }?>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>
<?php include 'footer_admin.php'; ?>