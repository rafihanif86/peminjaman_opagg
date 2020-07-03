<?php 
    include "connection.php";
    $halaman = "peminjaman";
    include 'header_admin.php';

    $id_peminjaman_masuk = $capture_true = $foto_jaminan = $status_peminjaman = "";

    if(isset($_GET['id_peminjaman_masuk'])){
        $id_peminjaman_masuk    =   $_GET['id_peminjaman_masuk'];
        $result=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE id_peminjaman_masuk = '$id_peminjaman_masuk' ");
        while ($row1=mysqli_fetch_array($result)){
            $foto_jaminan     =   $row1["foto_jaminan"];
            $status_peminjaman = $row1["status"];
        }
    }
 ?>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Form Peminjaman</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="dashboard_admin.php" class="text-dark">Data Peminjaman</a></li>
                            <li><a class="text-dark"
                                    href="tampil_peminjaman.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>">Ringkasan
                                    Peminjaman</a></li>
                            <li class="active text-dark">Form Jaminan Peminjaman</li>
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
                        <strong>Isikan Data Peminjaman <?php echo $id_peminjaman_masuk ?></strong>
                    </div>
                    <form action="form_peminjaman_jaminan.php" method="post" name="frm" enctype="multipart/form-data"
                        class="form-horizontal">
                        <div class="card-body card-block">
                            <div class="container">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Lampirkan Foto
                                            Jaminan</label>
                                    </div>
                                    <div class="col col-md-9" <?php if($status_peminjaman != "disetujui" ){echo "hidden";}?>>
                                        <input type="file" name="gambar1[]" placeholder="Choose file"
                                            class="form-control" value="" accept="image/*" capture="camera" id="camera1" onchange="validate(this);">
                                        <img id="frame1">
                                        <small class="help-block form-text">Lampirkan foto jaminan untuk syarat
                                            pengeluaran peminjaman</small>
                                    </div>
                                </div>
                                <div class="row form-group" <?php if($status_peminjaman != "disetujui" ){echo "hidden";}?>>
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Lampirkan Foto
                                            Seluruh Alat Diserahkan</label>
                                    </div>
                                    <div class="col col-md-9">
                                        <input type="file" name="gambar2[]" placeholder="Choose file"
                                            class="form-control" value="" accept="image/*" capture="camera" id="camera2" onchange="validate(this);">
                                        <img id="frame2">
                                        <small class="help-block form-text">Lampirkan foto seluruh alat diserahkan untuk syarat
                                            pengeluaran peminjaman</small>
                                    </div>
                                </div>
                                <div class="row form-group" <?php if($status_peminjaman != "diambil" ){echo "hidden";}?>>
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Lampirkan Foto
                                            Seluruh Alat Dikembalikan</label>
                                    </div>
                                    <div class="col col-md-9">
                                        <input type="file" name="gambar3[]" placeholder="Choose file"
                                            class="form-control" value="" accept="image/*" capture="camera" id="camera3" onchange="validate(this);">
                                        <img id="frame3">
                                        <small class="help-block form-text">Lampirkan foto jaminan untuk syarat
                                            pengeluaran peminjaman</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- HIDDEN INPUT -->
                        <input type="hidden" name="id_peminjaman_masuk" class="form-control"
                            value="<?php echo $id_peminjaman_masuk; ?>" >
                        <input type="hidden" name="status" class="form-control"
                            value="<?php echo $status_peminjaman; ?>" >
                        <div class="card-footer" <?php if(isset($_GET['status'])){ if($_GET['status'] == "berhasil"){echo "hidden";}}?>>
                            <button type="submit" class="btn btn-primary btn-sm" name="submit">
                                <i class="fa fa-dot-circle-o"></i> Submit
                            </button>
                            <button type="reset" class="btn btn-danger btn-sm" name="reset" onclick="reset()">
                                <i class="fa fa-ban"></i> Reset
                            </button>
                        </div>
                </div>
                </form>
            </div>
        </div>

        <?php 
            if($id_peminjaman_masuk != ""){
                $foto_jaminan = "";
                $foto_alat_pengambilan = "";
                $foto_alat_pengembalian = "";
                $result=mysqli_query($conn,"SELECT foto_jaminan, foto_alat_pengambilan, foto_alat_pengembalian FROM peminjaman_masuk WHERE  id_peminjaman_masuk = '$id_peminjaman_masuk';");
                while ($row1=mysqli_fetch_array($result)){
                    $foto_jaminan      =   $row1["foto_jaminan"];
                    $foto_alat_pengambilan      =   $row1["foto_alat_pengambilan"];
                    $foto_alat_pengembalian      =   $row1["foto_alat_pengembalian"];
                }
        ?>
        <div class="row" <?php if($foto_jaminan == ""){echo "hidden";} ?>>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Lampiran Foto Jaminan Peminjam <?php echo $id_peminjaman_masuk; ?></strong>
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
        <div class="row" <?php if($foto_alat_pengambilan == ""){echo "hidden";} ?>>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Lampiran Foto Seluruh Alal diserahkan <?php echo $id_peminjaman_masuk; ?></strong>
                    </div>
                    <div class="card-body card-block">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img src="images/<?php echo $foto_alat_pengambilan;?>" class="d-block w-100"
                                                        alt="">
                                                    <div class="carousel-caption d-none d-md-block">
                                                        <p>File name : <?php echo $foto_alat_pengambilan;?></p>
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
        <div class="row" <?php if($foto_alat_pengembalian == ""){echo "hidden";} ?>>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Lampiran Foto Seluruh Alal Dikembalikan <?php echo $id_peminjaman_masuk; ?></strong>
                    </div>
                    <div class="card-body card-block">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img src="images/<?php echo $foto_alat_pengembalian;?>" class="d-block w-100"
                                                        alt="">
                                                    <div class="carousel-caption d-none d-md-block">
                                                        <p>File name : <?php echo $foto_alat_pengembalian;?></p>
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


        <!-- BUTTON BACK -->
        <div class="float-left">
            <?php 
                $link_back = "";
                if(isset($_POST['status'])){
                    if($_POST['status'] == "disetujui"){
                        $link_back = "form_peminjaman_pengambilan.php?id_peminjaman_masuk=".$id_peminjaman_masuk;
                    }else if($_POST['status'] == "diambil"){
                        $link_back = "form_peminjaman_pengembalian.php?id_peminjaman_masuk=".$id_peminjaman_masuk;
                    }
                }else if($status_peminjaman = "disetujui"){
                    $link_back = "form_peminjaman_pengambilan.php?id_peminjaman_masuk=".$id_peminjaman_masuk;
                }else if($status_peminjaman = "diambil"){
                    $link_back = "form_peminjaman_pengembalian.php?id_peminjaman_masuk=".$id_peminjaman_masuk;
                }
            ?>
            <a href=<?php echo $link_back;?>
                class="btn btn-secondary btn-md active float-left" role="button" aria-pressed="true">
                <i class="fas fa-chevron-left "></i> Kembali
            </a>
        </div>

        <!-- BUTTON NEXT -->
        <?php if($id_peminjaman_masuk != ""){ ?>
        <div class="float-right">
            <?php 
                $email_peminjam = "";
                $nama_peminjam = "";
                $tgl_kembali = "";
                $status = "";
                $nik = "";
                $res2=mysqli_query($conn,"SELECT U.*, p.tgl_kembali, p.status FROM peminjaman_masuk P, peminjam U WHERE p.nik = u.nik and p.id_peminjaman_masuk = '$id_peminjaman_masuk'");
                while ($row1=mysqli_fetch_array($res2)){
                    $tgl_kembali = $row1["tgl_kembali"];
                    $status = $row1["status"];
                    $nik = $row1["nik"];
                }

                $nik_potong = substr($nik,0,3);
                if($nik_potong == "910"){
                    $result=mysqli_query($conn,"SELECT * FROM user WHERE nia = '$nik';");
                    while ($row1=mysqli_fetch_array($result)){
                        $nama_peminjam      =   $row1["nama_user"];
                        $email_peminjam     =   $row1["email"];
                    }
                }else{
                    $result=mysqli_query($conn,"SELECT * FROM peminjam  WHERE nik = '$nik';");
                    while ($row1=mysqli_fetch_array($result)){
                        $nama_peminjam      =   $row1["nama"];
                        $email_peminjam     =   $row1["email"];
                    }
                }
                
                if($status == "diambil"){
            ?>
            <form id="contact-form" action="sent_email.php" method="get" role="form">
                <input type="hidden" name="email" value="<?php echo  $email_peminjam; ?>">
                <input type="hidden" name="name" value="<?php echo  $nama_peminjam; ?>">
                <input type="hidden" name="subject" value="Peminjaman Peralatan OPA Ganendra Giri">
                <input type="hidden" name="message"
                    value="Anda telah mengambil peminjaman alat dengan nomor peminjaman <?php echo $id_peminjaman_masuk;?> di sekretariat OPA Ganendra Giri. Peminjaman hingga tanggal <?php echo $tgl_kembali;?>. Anda bisa melihat detail alat yang dipinjam dengan menggunakan halaman tracking dengan mengisikan nomor peminjaman anda pada web peminjaman alat OPA Ganendra Giri.">
                <input type="hidden" name="pesan_replace"
                    value="Terima Kasih telah memproses peminjaman peralatan ini. Kami akan menginformasikan kepada peminjam bahwa permintaan peminjaman telah diproses">
                <input type="hidden" name="link"
                    value="tampil_peminjaman.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>">
                <button type="submit" class="btn btn-primary btn-md active float-right">
                    Selesai <i class="fas fa-chevron-right "></i>
                </button>
            </form>
            <?php } else {?>
            <a href="tampil_peminjaman.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>"
                class="btn btn-primary btn-md active" role="button" aria-pressed="true">
                Selesai <i class="fas fa-chevron-right "></i>
            </a>
            <?php
                } 
                if($status == "dikembalikan" ){  
                    $email = "";
                    $nama = "";
                    $status_dept = ""; 
                    $res2=mysqli_query($conn,"SELECT * FROM USER WHERE nia = '$nia';");
                    while ($row1=mysqli_fetch_array($res2)){
                        $email = $row1["email"];
                        $nama = $row1["nama_user"];
                        $status_dept = $row1["status_anggota"];
                    }
                    
                    if($status_dept != "Departemen Rumah Tangga" ){ 
            ?> 
                <form id="contact-form" action="sent_email.php" method="get" role="form">
                    <input type="hidden" name="email" value="<?php echo  $email; ?>">
                    <input type="hidden" name="name" value="<?php echo  $nama; ?>">
                    <input type="hidden" name="subject" value="Peminjaman Peralatan OPA Ganendra Giri">
                    <input type="hidden" name="message" value="Peminjaman <?php echo $id_peminjaman_masuk;?> telah dikembalikan. Segera lakukan pengecekan alat yang telah dikembalikan secara langsung di sekretariat.">
                    <input type="hidden" name="pesan_replace"
                        value="Terima Kasih telah melakukan pengecekan pengembalian alat. kami akan menginformasikan pengembalian peminjaman ini kepada Departemen Rumah Tangga.">
                    <input type="hidden" name="link"
                        value="tampil_peminjaman.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>">
                    <button type="submit" class="btn btn-primary btn-md active float-right">
                        Selesai <i class="fas fa-chevron-right "></i>
                    </button>
                </form>
                <?php 
                    } else {
                ?>
                <a href="tampil_peminjaman.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>"
                    class="btn btn-primary btn-md active" role="button" aria-pressed="true">
                    Selesai <i class="fas fa-chevron-right "></i>
                </a>
                <?php  } }?>
        </div>
        <?php } ?>

    </div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>
<?php 
    include 'footer_admin.php'; 

    if(isset($_POST["submit"])){
        $id_peminjaman_masuk    =   $_POST["id_peminjaman_masuk"];
        $status_peminjaman    =   $_POST["status"];
        $sql_insert1 ="";

        if($status_peminjaman == "disetujui"){
            $status_peminjaman = "diambil";
        }else if($status_peminjaman == "diambil"){
            $status_peminjaman = "dikembalikan";
        }

        if($id_peminjaman_masuk != "" || $id_peminjaman_masuk != null || !empty($id_peminjaman_masuk)){
            $file_name1 ="";
            $file_name2 ="";
            $file_name3 ="";
            $foto_jaminan = "";
            $foto_alat_pengambilan = "";
            $foto_alat_pengaembalian = "";

            $result=mysqli_query($conn, "SELECT * FROM peminjaman_masuk WHERE id_peminjaman_masuk = '$id_peminjaman_masuk'");
            while ($row1=mysqli_fetch_array($result)){
                $foto_jaminan            =   $row1["foto_jaminan"];
                $foto_alat_pengambilan   =   $row1["foto_alat_pengambilan"];
                $foto_alat_pengembalian  =   $row1["foto_alat_pengembalian"];                
            }

            $file_name1 = $foto_jaminan;
            $file_name2 = $foto_alat_pengambilan;
            $file_name3 = $foto_alat_pengembalian;
            $status = "";

            $jumlah1 = count($_FILES['gambar1']['name']);
            if ($jumlah1 > 0) {

                if ($file_name1  != ""){
                    $target = "images/" .$file_name1  ;
                    if(file_exists($target)){
                        unlink($target);
                    }
                }

                for ($i=0; $i < $jumlah1; $i++) { 
                    $file_name1 = $_FILES['gambar1']['name'][$i];
                    $tmp_name1 = $_FILES['gambar1']['tmp_name'][$i];
                    $file_size1 = $_FILES['gambar1']['size'][$i];
                    $jenis_gambar1 = $_FILES['gambar1']['type'][$i];
                    if($file_size1 <= 1048576){
                        if($jenis_gambar1 =="image/jpeg" || $jenis_gambar1 =="image/jpg" || $jenis_gambar1 =="image/gif" || $jenis_gambar1 =="image/x-png"){
                            move_uploaded_file($tmp_name1, "images/".$file_name1);
                        }else{
                            $file_name1=  $foto_jaminan;
                            $status = "filetype";
                        }
                        
                    }else{
                        $file_name1 =  $foto_jaminan;
                        $status = "bigsize";
                    }
                }
            }

            $jumlah2 = count($_FILES['gambar2']['name']);
            if ($jumlah2 > 0) {

                if ($file_name2  != ""){
                    $target = "images/" .$file_name2  ;
                    if(file_exists($target)){
                        unlink($target);
                    }
                }

                for ($i=0; $i < $jumlah2; $i++) { 
                    $file_name2 = $_FILES['gambar2']['name'][$i];
                    $tmp_name2 = $_FILES['gambar2']['tmp_name'][$i];
                    $file_size2 = $_FILES['gambar2']['size'][$i];
                    $jenis_gambar2 = $_FILES['gambar2']['type'][$i];
                    if($file_size2 <= 1048576){
                        if($jenis_gambar2 =="image/jpeg" || $jenis_gambar2 =="image/jpg" || $jenis_gambar2 =="image/gif" || $jenis_gambar2 =="image/x-png"){
                            move_uploaded_file($tmp_name2, "images/".$file_name2);
                        }else{
                            $file_name2=  $foto_alat_pengambilan;
                            $status = "filetype";
                        }
                        
                    }else{
                        $file_name2 =  $foto_alat_pengambilan;
                        $status = "bigsize";
                    }
                }
            }

            $jumlah3 = count($_FILES['gambar3']['name']);
            if ($jumlah3 > 0) {

                if ($file_name3  != ""){
                    $target = "images/" .$file_name3  ;
                    if(file_exists($target)){
                        unlink($target);
                    }
                }

                for ($i=0; $i < $jumlah3; $i++) { 
                    $file_name3 = $_FILES['gambar3']['name'][$i];
                    $tmp_name3 = $_FILES['gambar3']['tmp_name'][$i];
                    $file_size3 = $_FILES['gambar3']['size'][$i];
                    $jenis_gambar3 = $_FILES['gambar3']['type'][$i];
                    if($file_size3 <= 1048576){
                        if($jenis_gambar3 =="image/jpeg" || $jenis_gambar3 =="image/jpg" || $jenis_gambar3 =="image/gif" || $jenis_gambar3 =="image/x-png"){
                            move_uploaded_file($tmp_name3, "images/".$file_name3);
                        }else{
                            $file_name3=  $foto_alat_pengembalian;
                            $status = "filetype";
                        }
                        
                    }else{
                        $file_name3 =  $foto_alat_pengembalian;
                        $status = "bigsize";
                    }
                }
            }

            $query="UPDATE peminjaman_masuk set petugas_pengambilan = '$nia', foto_jaminan = '$file_name1', foto_alat_pengambilan = '$file_name2', foto_alat_pengembalian = '$file_name3', status = '$status_peminjaman' where id_peminjaman_masuk = '$id_peminjaman_masuk';";
            $sql_insert1 = mysqli_query($conn,$query);
            if($sql_insert1  && $status == ""){
                echo "<script>location.replace('form_peminjaman_jaminan.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=berhasil'')</script>";
            }else if($sql_insert1  && $status != ""){
                if($status == "bigsize"){
                    echo "<script type='text/javascript'> window.onload = function(){  alert('File gambar memiliki ukuran terlalu besar '); } </script>";
                }else if($status == "filetype"){
                    echo "<script type='text/javascript'> window.onload = function(){  alert('File gambar memiliki tipe file tidak diijinkan'); } </script>";
                }
            }
        }else{
            echo "<script>location.replace('form_peminjaman_jaminan.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=gagal')</script>";
        }
    }

    if(isset($_GET['status'])){
        if($_GET['status'] == "berhasil"){
            echo "<script type='text/javascript'> window.onload = function(){ alert('Berhasil ditambahkan'); } </script>";
        }else if($_GET['status'] == "gagal"){
            echo "<script type='text/javascript'> window.onload = function(){ alert('Gagal ditambahkan'); } </script>";
        }else if($_GET['status'] == "bigsize"){
            echo "<script type='text/javascript'> window.onload = function(){  alert('File gambar memiliki ukuran terlalu besar '); } </script>";
        }else if($_GET['status'] == "filetype"){
            echo "<script type='text/javascript'> window.onload = function(){  alert('File gambar memiliki tipe file tidak diijinkan'); } </script>";
        }else if($_GET['status'] == "berhasildihapus"){
            echo "<script type='text/javascript'> window.onload = function(){  alert('Lampiran berhasil dihapus'); } </script>";
        }else if($_GET['status'] == "gagaldihapus"){
            echo "<script type='text/javascript'> window.onload = function(){  alert('Lampiran gagal dihapus'); } </script>";
        }
    }

?>
<script>
var camera1 = document.getElementById('camera1');
var frame1 = document.getElementById('frame1');

camera1.addEventListener('change', function(e) {
    var file = e.target.files[0];
    // Do something with the image file.
    frame1.src = URL.createObjectURL(file);
});

var camera2 = document.getElementById('camera2');
var frame2 = document.getElementById('frame2');

camera2.addEventListener('change', function(e) {
    var file = e.target.files[0];
    // Do something with the image file.
    frame2.src = URL.createObjectURL(file);
});

var camera3 = document.getElementById('camera3');
var frame3 = document.getElementById('frame3');

camera3.addEventListener('change', function(e) {
    var file = e.target.files[0];
    // Do something with the image file.
    frame3.src = URL.createObjectURL(file);
});

function reset() {
    frame1.src = "";
    frame2.src = "";
    frame3.src = "";
}

var _validFileExtensions = [".jpeg",".png",".jpg"];

function validate(file) {
    if (file.type == "file") {
        var sFileName = file.value;
        if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() ==
                    sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }

            if (!blnValid) {
                alert("Maaf Hanya Boleh File yang Berextensi : " + _validFileExtensions.join(", "));
                file.value = "";
                return false;
            }
        }
    }
    return true;
}
</script>