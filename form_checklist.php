<?php 
    include "connection.php";
    $halaman = "alat";
    include 'header_admin.php';
    include 'tgl_indo.php';

    $id_check = $tgl_checklist = $kondisi = $id_alat = $keterangan = $id_user = $petugas = $dipinjam = $peminjaman = $id_detail_masuk = $foto_alat = $id_peminjaman_masuk =  $edit  = $id_detail = $disAlatPinjam = $nama_user= $disIdAlat = "";
    $id_check_last = $tgl_checklist_last = $status = $deskripsi = $id_alat_last = $status_peminjaman =  $kondisi_last = $id_checklist_group_item= $keterangan_last = $capture_true = $foto_alat_check_last = $nama_user_last = $dipinjam_last = $id_peminjaman_masuk_last = $tgl_terbaru_last = $id_checklist_group = "";   
    $dateNow= date("Y-m-d");
    $header_check = "Checklist Alat ";
    $disAlatPinjam = $disIdAlat = "hidden";
    $kondisi_last = "valid";

    if(isset($_GET['status_peminjaman']) and isset($_GET['id_alat']) and isset($_GET['id_peminjaman_masuk']) and isset($_GET['id_detail_masuk'])){
        $id_alat = $_GET['id_alat'];
        $status_peminjaman = $_GET['status_peminjaman'];
        $id_peminjaman_masuk = $_GET['id_peminjaman_masuk'];
        $id_detail_masuk = $_GET['id_detail_masuk'];
        $disAlatPinjam = $disIdAlat = "";
    }

    if(isset($_GET['id_alat'])){
        $id_alat = $_GET['id_alat'];
        $tgl_checklist = $dateNow;
    }

    if(isset($_GET['status'])){
        $status = $_GET['status'];
    }
    
    if(isset($_GET['id_checklist_group'])){
        $id_checklist_group = $_GET['id_checklist_group'];
        $id_checklist_group_item = $_GET['id_checklist_group_item'];
    }

    if(isset($_GET['id_alat']) and isset($_GET['delete'])){
        $id_user = $nia;
        $id_alat        =   $_GET['id_alat'];
        $tgl_checklist = $dateNow;
        $kondisi = "diputihkan";
        $disAlatPinjam = $disIdAlat = "hidden";
    }

    
    if(isset($_GET['id_check'])){
        $id_check   =   $_GET['id_check'];
        $result=mysqli_query($conn, "SELECT * FROM checklist_record WHERE id_check = $id_check");
        while ($row1=mysqli_fetch_array($result)){
            $tgl_checklist  =   $row1["tgl_checklist"];
            $id_alat        =   $row1["id_alat"];
            $kondisi        =   $row1["kondisi"];
            $keterangan     =   $row1["keterangan"];
            $username        =   $row1["petugas"];
            $status_peminjaman       =   $row1["status_peminjaman"];
            $id_peminjaman_masuk      =   $row1["id_peminjaman_masuk"];
            $id_checklist_group      =   $row1["id_checklist_group"];

        }
    }

    if(isset($_POST["submit"])){
        $id_check       =   $_POST["id_check"];
        $tgl_checklist  =   $_POST["tgl_checklist"];
        $id_alat        =   $_POST["id_alat"];
        $kondisi        =   $_POST["kondisi"];
        $keterangan     =   $_POST["keterangan"];
        $status_peminjaman = $_POST["status_peminjaman"];
        $petugas = $_POST["petugas"];
        $id_detail_masuk = $_POST["id_detail_masuk"];
        $id_peminjaman_masuk = $_POST["id_peminjaman_masuk"];
        $id_checklist_group = $_POST["id_checklist_group"];
        $id_checklist_group_item = $_POST["id_checklist_group_item"];
        $status = $_POST["status"];

        if($id_check == "" || empty($id_check)){
            if(($tgl_checklist and $kondisi and $id_alat and $petugas) != null){
                
                $file_name ="";
                $status1 = "";
                if ($_FILES['gambar']['name'] != "") {
                    $file_name = $_FILES['gambar']['name'];
                    $tmp_name = $_FILES['gambar']['tmp_name'];
                    $file_size = $_FILES['gambar']['size'];
                    $jenis_gambar = $_FILES['gambar']['type'];
                    if($file_name != ""){
                        if($file_size <= 1048576){
                            if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif" || $jenis_gambar=="image/x-png"){
                                move_uploaded_file($tmp_name, "images/".$file_name);
                            }else{
                                $file_name =  "";
                                $status1 = "filetype";
                            }
                        }else{
                            $file_name =  "";
                            $status1 = "bigsize";
                        }
                    }
                }
                $query="INSERT INTO checklist_record set tgl_checklist = '$tgl_checklist', kondisi = '$kondisi', 
                            id_alat = '$id_alat',keterangan = '$keterangan', status_peminjaman = '$status_peminjaman', 
                            petugas = '$petugas', id_peminjaman_masuk = '$id_peminjaman_masuk', 
                            id_checklist_group = '$id_checklist_group', foto_alat_check = '$file_name' ;";
                $sql_insert1 = mysqli_query($conn,$query);

                $id_check_max = "";
                $resultChecklist=mysqli_query($conn,"SELECT MAX(`id_check`) AS id_check_max FROM checklist_record where id_alat = '$id_alat'; ") ;
                while ($row6=mysqli_fetch_array($resultChecklist)){
                    $id_check_max = $row6["id_check_max"];
                }

                if($id_checklist_group != "" && $id_checklist_group_item != "" ){
                    $q_keluar="UPDATE checklist_group_item set id_check = '$id_check_max' where id_checklist_group_item = '$id_checklist_group_item';";
                    $hasil = mysqli_query($conn,$q_keluar);
                    if($hasil){
                        echo "<script>
                            location.replace('form_checklist_onprocess.php?status=berhasil')</script>";
                    }else{
                        echo "<script>
                                location.replace('form_checklist_onprocess.php?status=gagal')</script>";
                    }
                }

                if($status == "baru"){
                    $q_keluar="UPDATE alat set checklist_masuk = '$id_check_max' where id_alat = '$id_alat';";
                    $hasil = mysqli_query($conn,$q_keluar);
                    if($hasil){
                        echo "<script>
                            location.replace('tampil_alat.php?id_alat=$id_alat&status=berhasil')</script>";
                    }else{
                        echo "<script>
                                location.replace('form_checklist.php?id_alat=$id_alat&status=baru')</script>";
                    }
                }else if($status == "diputihkan"){
                    $q_keluar="UPDATE alat set checklist_keluar = '$id_check_max' where id_alat = '$id_alat';";
                    $hasil = mysqli_query($conn,$q_keluar);
                    if($hasil){
                        echo "<script>alert('Berhasil Menambahkan Data Checklist Alat Diputihkan')
                            location.replace('form_alat?id_alat=$id_alat')</script>";
                    }else{
                        echo "<script>alert('Gagal Menambahkan Data Checklist Diputihkan')
                                location.replace('form_checklist.php?id_alat=$id_alat&status=diputihkan')</script>";
                    }
                }

                if(($id_peminjaman_masuk and $id_detail_masuk) != "" and $sql_insert1){
                    $insert_tr = "";
                    $result_ins=mysqli_query($conn,"SELECT COUNT(*) AS jumlah FROM `detail_peminjaman_diterima` WHERE `id_check_keluar` = '$id_check_max' OR `id_check_masuk` = '$id_check_max'; ") ;
                    while ($row6=mysqli_fetch_array($result_ins)){
                        $insert_tr = $row6["jumlah"];
                    }

                    if($insert_tr == "0" || $insert_tr == 0 || empty($insert_tr) || $insert_tr == ""){
                        if($status_peminjaman == 'diambil'){
                            $q_keluar="INSERT INTO detail_peminjaman_diterima set id_detail_masuk = '$id_detail_masuk', id_alat = '$id_alat', id_check_keluar = '$id_check_max';";
                            $hasil = mysqli_query($conn,$q_keluar);
                            if($hasil){
                                echo "<script>alert('Berhasil Menambahkan Data Checklist Pengambilan Peminjaman')
                                    location.replace('form_peminjaman_pengambilan.php?id_peminjaman_masuk=$id_peminjaman_masuk')</script>";
                            }else{
                                echo "<script>alert('Gagal Menambahkan Data Checklist Pengambilan Peminjaman')
                                        location.replace('form_peminjaman_pengambilan.php?id_peminjaman_masuk=$id_peminjaman_masuk')</script>";
                            }
                        }else if($status_peminjaman == 'dikembalikan'){
                            $q_keluar="UPDATE detail_peminjaman_diterima set id_check_masuk = '$id_check_max' where id_detail_masuk = '$id_detail_masuk' and id_alat = '$id_alat';";
                            $hasil = mysqli_query($conn,$q_keluar);
                            if($hasil){
                                echo "<script>alert('Berhasil Menambahkan Data Checklist Pengembalian Peminjaman')
                                    location.replace('form_peminjaman_pengembalian.php?id_peminjaman_masuk=$id_peminjaman_masuk')</script>";
                            }else{
                                echo "<script>alert('Gagal Menambahkan Data Checklist Pengembalian Peminjaman')
                                        location.replace('form_peminjaman_pengembalian.php?id_peminjaman_masuk=$id_peminjaman_masuk')</script>";
                            }
                        }

                        
                    }else{
                        echo "<script>alert('Gagal Menambahkan Data Checklist peminjaman')
                                location.replace('form_peminjaman_pengambilan.php?id_peminjaman_masuk=$id_peminjaman_masuk')</script>";
                    }
                    
                }else if($sql_insert1){
                    if($status == ""){
                        echo "<script> location.replace('tampil_alat.php?id_alat=$id_alat&status=berhasil')</script>";
                    }else if($status != ""){
                        echo "<script> location.replace('tampil_alat.php?id_alat=$id_alat&status=$status1')</script>";
                    }
                }else{
                    echo "<script> location.replace('tampil_alat.php?id_alat=$id_alat&status=gagal')</script>";
                }

            }else{
                echo "<script>alert('Gagal Menambahkan Data Checklist. Ada Data yang tidak ditemukan.')</script>";
            }
        }else{

            $file_name ="";
            $foto_anggota = "";
            $result=mysqli_query($conn, "SELECT * FROM checklist_record WHERE id_check = $id_check");
            while ($row1=mysqli_fetch_array($result)){
                $foto_anggota      =   $row1["foto_alat_check"];
            }
            $file_name = $foto_anggota;
            $status1 = "";

            if ($_FILES['gambar']['name'] != "") {

                if ($foto_anggota  != ""){
                    $target = "images/" .$foto_anggota  ;
                    if(file_exists($target)){
                        unlink($target);
                    }
                }

                $file_name = $_FILES['gambar']['name'];
                $tmp_name = $_FILES['gambar']['tmp_name'];
                $file_size = $_FILES['gambar']['size'];
                $jenis_gambar = $_FILES['gambar']['type'];
                if($file_name != ""){
                    if($file_size <= 1048576){
                        if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif" || $jenis_gambar=="image/x-png"){
                            move_uploaded_file($tmp_name, "images/".$file_name);
                        }else{
                            $file_name =  $foto_anggota;
                            $status = "filetype";
                        }
                        
                    }else{
                        $file_name =  $foto_anggota;
                        $status1 = "bigsize";
                    }
                }
            }

            $query="UPDATE checklist_record set tgl_checklist = '$tgl_checklist', kondisi = '$kondisi', id_alat = '$id_alat', 
                        keterangan = '$keterangan', status_peminjaman = '$status_peminjaman', username = '$username_check', 
                        id_peminjaman_masuk = '$id_peminjaman_masuk', id_checklist_group = '$id_checklist_group', 
                        foto_alat_check = '$file_name' where id_check = $id_check;";
            $sql_insert1 = mysqli_query($conn,$query);
            if($sql_insert1){
                if($id_peminjaman_masuk != ""){
                    echo "<script>alert('Berhasil Mengubah Data Checklist')
                            location.replace('form_peminjaman_pengambilan.php?id_peminjaman_masuk=$id_peminjaman_masuk')</script>";
                }else{
                    if($status == ""){
                        echo "<script> location.replace('tampil_alat.php?id_alat=$id_alat&status=berhasil')</script>";
                    }else if($status != ""){
                        echo "<script> location.replace('tampil_alat.php?id_alat=$id_alat&status=$status1')</script>";
                    }
                }
            }else{
                echo "<script> location.replace('tampil_alat.php?id_alat=$id_alat&status=gagal')</script>";
            }
            
        }
    }

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

?>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1><?php echo $header_check; echo $dateNow;?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="tabel_checklist.php" class="text-dark">Data Checklist Alat</a></li>
                            <li class="active">Form Checklist</li>
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
                                            <div class="row form-group" <?php if($dipinjam_last == ""){echo "hidden";}?>>
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Status Peminjaman</label></div>
                                                <div class="col-12 col-md-9">
                                                    <?php echo ": "; if($dipinjam_last != ""){echo "$dipinjam_last";}else{echo "-";} ?>
                                                </div>
                                            </div>
                                            <div class="row form-group" <?php if($id_peminjaman_masuk_last == ""){echo "hidden";}?>>
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label">Nomor Peminjaman</label></div>
                                                <div class="col-12 col-md-9">
                                                    <?php echo ": "; if($id_peminjaman_masuk_last != ""){echo "$id_peminjaman_masuk_last";}else{echo "-";}?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="float-md-left ">
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

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Isikan Data Checklist Alat <?php echo $id_alat; ?></strong>
                    </div>
                    <form action="form_checklist.php" method="post" name="frm" enctype="multipart/form-data"
                        class="form-horizontal">
                        <div class="card-body card-block">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="row form-group" <?php if($id_check == ""){echo 'hidden';}?>>
                                            <div class="col col-md-3">
                                                <label for="text-input" class=" form-control-label">Id
                                                    Checklist</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="text" placeholder="Id Checklist" class="form-control"
                                                    value="<?php echo $id_check; ?>" disabled>
                                                <input type="hidden" name="id_check" placeholder="Id Checklist"
                                                    class="form-control" value="<?php echo $id_check; ?>">
                                                <small class="form-text text-muted">Id Check akan terisi
                                                    otomatis.</small>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="text-input" class=" form-control-label">Nomor
                                                    Inventaris</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="text" id="text-input"="id_alat" placeholder="Id Alat"
                                                    class="form-control" value="<?php echo $id_alat; ?>" disabled>
                                                <input type="hidden" id="text-input" name="id_alat"
                                                    placeholder="Nomor Inventaris" class="form-control"
                                                    value="<?php echo $id_alat; ?>">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="text-input" class=" form-control-label">Petugas</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="text" id="text-input" placeholder="Username"
                                                    class="form-control" value="<?php 
                                                        $queryKel="SELECT * FROM user WHERE nia = '$nia'; ";
                                                        $resultKel=mysqli_query($conn,$queryKel) ;
                                                        while ($row6=mysqli_fetch_array($resultKel)){
                                                            echo $row6["nama_user"];
                                                        }
                                                    ?>" disabled>
                                                <input type="hidden" id="text-input" name="petugas"
                                                    placeholder="Username" class="form-control"
                                                    value="<?php echo $nia; ?>">
                                                <small class="form-text text-muted">Petugas Checklist akan
                                                    terisi
                                                    otomatis</small>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="text-input" class=" form-control-label">Tanggal
                                                    Pengecekan</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="date" id="date-input" name="tgl_checklist"
                                                    placeholder="Tanggal Checklist" class="form-control"
                                                    value="<?php echo $tgl_checklist; ?>">
                                                <small class="form-text text-muted">Masukkan Tanggal
                                                    Checklist</small>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="text-input" class=" form-control-label">Masukkan
                                                    Kondisi
                                                    Alat</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <select class="browser-default custom-select" name="kondisi"
                                                    placeholder="Masukkan Kondisi Alat">
                                                    <?php $kon = ""; if($id_alat == "" || empty($id_alat)){$kon = $kondisi_last;}else{$kon = $kondisi;}?>
                                                    <option <?php if($kon == 'valid'){echo 'selected';}?> value="valid">
                                                        Valid</option>
                                                    <option <?php if($kon == 'rusak'){echo 'selected';}?> value="rusak">
                                                        Rusak</option>
                                                    <option <?php if($kon == 'hilang'){echo 'selected';}?>
                                                        value="hilang">Hilang</option>
                                                    <option <?php if($kon == 'diputihkan'){echo 'selected';}?>
                                                        value="diputihkan">Diputihkan</option>
                                                </select>
                                                <small class="form-text text-muted">Masukkan Kondisi
                                                    Alat</small>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="text-input" class=" form-control-label">Keterangan
                                                    Kondisi
                                                    Alat</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="text" id="text-input" name="keterangan"
                                                    placeholder="Keterangan" class="form-control"
                                                    value="<?php echo $keterangan; ?>">
                                                <small class="form-text text-muted">Berikan keterangan kondisi
                                                    alat
                                                    secara rinci</small>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="text-input" class=" form-control-label">Lampirkan
                                                    Foto
                                                    Alat</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="file" name="gambar" placeholder="Choose file"
                                                    class="form-control" value="" accept="image/*" capture="camera"
                                                    id="camera">
                                                <img id="frame">
                                                <?php
                                                    if(isset($_GET['id_check'])){
                                                        $result1=mysqli_query($conn,"SELECT * FROM checklist_record WHERE id_check = '$id_check' ");
                                                        while ($row2=mysqli_fetch_array($result1)){
                                                ?>
                                                <?php echo $row2["foto_alat_check"];?>
                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                <small class="help-block form-text">Lampirkan Foto Alat untuk
                                                    mempermudah proses pengecekan</small>
                                            </div>
                                        </div>
                                        <div class="row form-group"
                                            <?php if($peminjaman == "" || empty($peminjaman)){echo "hidden";}?>>
                                            <div class="col col-md-3">
                                                <label for="text-input" class=" form-control-label">Status
                                                    Peminjaman</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <select class="browser-default custom-select" name="status_peminjaman">
                                                    <option
                                                        <?php if($status_peminjaman == 'diambil'){echo 'selected';}?>
                                                        value="diambil">Diambil</option>
                                                    <option
                                                        <?php if($status_peminjaman == 'dikembalikan'){echo 'selected';}?>
                                                        value="dikembalikan">Dikembalikan</option>
                                                    <option <?php if($status_peminjaman == ''){echo 'selected';}?>
                                                        value="">Tidak Dipinjam</option>
                                                </select>
                                                <small class="form-text text-muted">Pilih Status
                                                    Peminjaman</small>
                                            </div>
                                        </div>
                                        <div class="row form-group"
                                            <?php if($id_peminjaman_masuk == "" or empty($id_peminjaman_masuk)){echo "hidden";}?>>
                                            <div class="col col-md-3">
                                                <label for="text-input" class=" form-control-label">Nomor
                                                    Peminjaman</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="text" placeholder="Id Peminjaman Masuk"
                                                    class="form-control" value="<?php echo $id_peminjaman_masuk; ?>"
                                                    disabled>
                                                <input type="hidden" name="id_peminjaman_masuk"
                                                    placeholder="Id Peminjaman Masuk" class="form-control"
                                                    value="<?php echo $id_peminjaman_masuk; ?>">
                                                <small class="form-text text-muted">Masukkan Nomor
                                                    Peminjaman</small>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id_checklist_group"
                                                    value="<?php echo $id_checklist_group; ?>">
                                        <input type="hidden" name="id_checklist_group_item"
                                                    value="<?php echo $id_checklist_group_item; ?>">
                                        <input type="hidden" name="id_detail_masuk"
                                            value="<?php echo $id_detail_masuk; ?>">
                                        <input type="hidden" name="status" value="<?php echo $status; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm" name="submit" onClick="simpan()">
                                <i class="fa fa-dot-circle-o"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-danger btn-sm" name="reset" onclick="reset()">
                                <i class="fa fa-ban"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php 
            if(isset($id_check)){
                $foto_jaminan = "";
                $result=mysqli_query($conn,"SELECT foto_alat_check FROM checklist_record WHERE  id_check = '$id_check';");
                while ($row1=mysqli_fetch_array($result)){
                    $foto_jaminan      =   $row1["foto_alat_check"];
                }
                $hidden_foto = "hidden";
                if($foto_jaminan != "" || $foto_jaminan != null || !empty($foto_jaminan)){ $hidden_foto = "";}

        ?>
        <div class="row" <?php echo $hidden_foto; ?>>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Lampiran Foto Alat Checklist</strong>
                    </div>
                    <div class="card-body card-block">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img src="images/<?php echo $foto_jaminan;?>" class="d-block w-100"
                                                        alt="">
                                                    <div class="carousel-caption d-none d-md-block">
                                                        <p>File name : <?php echo $foto_jaminan;?></p>
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

        <?php if($id_peminjaman_masuk != "") { ?>
        <div class="float-left">
            <a href="<?php if($status_peminjaman == 'diambil'){echo 'form_peminjaman_pengambilan.php?id_peminjaman_masuk='.$id_peminjaman_masuk;}
                            else if($status_peminjaman == 'dikembalikan'){echo 'form_peminjaman_pengembalian.php?id_peminjaman_masuk='.$id_peminjaman_masuk;}?>"
                class="btn btn-secondary btn-md active float-left" role="button" aria-pressed="true">
                <i class="fas fa-chevron-left "></i> Kembali</a>
        </div>
        <?php } ?>

    </div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>
<?php
    include 'footer_admin.php'
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