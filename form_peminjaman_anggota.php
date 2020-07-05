<?php 
    include "connection.php";
    $halaman = "peminjaman_anggota";
    include 'header_admin.php';

    $id_peminjaman_masuk = $nama_instansi = $nama_peminjam = $nik = $nama_kegiatan = $lampiran_surat = $email_peminjam = $tgl_ambil = $tgl_kembali =  $no_wa = $status = $edit  = $foto_surat = null;
    $tgl_hari_ini = date('Y-m-d');

    if(isset($_GET['id_peminjaman_masuk'])){
        $id_peminjaman_masuk    =   $_GET['id_peminjaman_masuk'];
        $result=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE id_peminjaman_masuk = '$id_peminjaman_masuk';");
        while ($row1=mysqli_fetch_array($result)){
            $nik                =   $row1["nik"];
            $nama_kegiatan      =   $row1["nama_kegiatan"];
            $tgl_ambil          =   $row1["tgl_ambil"];
            $tgl_kembali        =   $row1["tgl_kembali"];
            
            $status             =   $row1["status"];
            $lampiran_surat         =   $row1["lampiran_surat"];
        }

        $nik_potong = substr($nik,0,3);
        if($nik_potong == "910"){
            $result=mysqli_query($conn,"SELECT * FROM user  WHERE nia = '$nik';");
            while ($row1=mysqli_fetch_array($result)){
                $nama_instansi      =   "OPA Ganendra Giri";
                $nama_peminjam      =   $row1["nama_user"];
                $email_peminjam     =   $row1["email"];
                $no_wa              =   $row1["no_telp"];
            }
        }else{
            $result=mysqli_query($conn,"SELECT * FROM peminjam  WHERE nik = '$nik';");
            while ($row1=mysqli_fetch_array($result)){
                $nama_instansi      =   $row1["instansi"];
                $nama_peminjam      =   $row1["nama"];
                $email_peminjam     =   $row1["email"];
                $no_wa              =   $row1["no_telepon"];
            }
        }
        $edit = "true";
    }else{
        $result=mysqli_query($conn,"SELECT * FROM user WHERE nia = '$nia';");
        while ($row1=mysqli_fetch_array($result)){
            $nama_instansi      =   "OPA Ganendra Giri";
            $nama_peminjam      =   $row1["nama_user"];
            $nik                =   "NIA. ".$nia."-GG";
            $email_peminjam     =   $row1["email"];
            $no_wa              =   $row1["no_telp"];
        }
        $edit = "";
        $status = "baru";

        date_default_timezone_set("Asia/Jakarta");
        $date= date("Ymd");
        $query =mysqli_query($conn, "SELECT max(id_peminjaman_masuk) as maxKode FROM peminjaman_masuk");
        $data = mysqli_fetch_array($query);
        $noOrder = $data['maxKode'];
        $noUrut = (int) substr($noOrder, 10, 3);
        $noUrut++;
        $char = "PJ";
        $tahun=substr($date, 0, 4);
        $bulan=substr($date, 5, 2);
        $id_peminjaman_masuk = $char .$date . sprintf("%03s", $noUrut);
    }

    
 ?>

<body>

    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-5">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Form Peminjaman Untuk Anggota</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li class="active">Form Peminjaman Anggota</li>
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
                            <strong>Data Peminjam</strong>
                        </div>
                        <div class="card-body card-block">
                            <div class="container">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">NIA</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="nik" placeholder="NIK Peminjam"
                                            class="form-control" value="<?php echo $nik; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Nama</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="nama_peminjam"
                                            placeholder="Nama Peminjam" class="form-control"
                                            value="<?php echo $nama_peminjam; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Nomor Telepon</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="number" id="email-input" name="no_wa"
                                            placeholder="Nomor WhatsApp Peminjam" class="form-control"
                                            value="<?php echo $no_wa; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="email-input" class=" form-control-label">Email</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="email_peminjam"
                                            placeholder="Email Peminjam" class="form-control"
                                            value="<?php echo $email_peminjam; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Instansi</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="nama_instansi"
                                            placeholder="Nama Instansi" class="form-control"
                                            value="<?php echo $nama_instansi; ?>" disabled>
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
                            <strong>Isikan Data Peminjaman <?php echo $id_peminjaman_masuk ?></strong>
                        </div>
                        <form action="form_peminjaman_anggota.php" method="post" name="frm"
                            enctype="multipart/form-data" class="form-horizontal">
                            <div class="card-body card-block">
                                <div class="container">
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class=" form-control-label">Nama Kegiatan</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" id="text-input" name="nama_kegiatan"
                                                placeholder="Nama Kegiatan" class="form-control"
                                                value="<?php echo  $nama_kegiatan; ?>">
                                            <small class="help-block form-text">Masukkan Nama Kegiatan</small>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class=" form-control-label">Tanggal
                                                Pengambilan</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="date" id="tgl_awal" name="tgl_ambil"
                                                placeholder="Tanggal Ambil" class="form-control"
                                                value="<?php echo $tgl_ambil; ?>"
                                                min="<?php echo date('Y-m-d', strtotime('+1days', strtotime($tgl_hari_ini))); ?>"
                                                onchange="change_kembali()">
                                            <small class="help-block form-text">Maksimal tanggal ambil adalah 3 hari
                                                setelah
                                                data dimasukkan</small>
                                        </div>
                                    </div>
                                    <div class="row form-group" id="kembali">
                                        <div class="col col-md-3">
                                            <label for="text-input" class=" form-control-label">Tanggal
                                                Pengembalian</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="date" id="tgl_kembali" name="tgl_kembali"
                                                placeholder="Tanggal Kembali" class="form-control"
                                                value="<?php echo $tgl_kembali; ?>">
                                            <!-- <small class="help-block form-text">Masukkan Tanggal Kembali</small> -->
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class=" form-control-label">Lampirkan surat</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="file" id="fileupload" name="gambar" placeholder="Choose file"
                                                class="form-control" accept="application/pdf" onchange="validate(this);">
                                            <small class="help-block form-text">Lampirkan surat (jika ada)
                                                untuk mempermudah proses peminjaman. Pastikan Lampiran berekstensi
                                                PDF</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- HIDDEN INPUT -->
                            <input type="hidden" name="id_peminjaman_masuk" class="form-control"
                                value="<?php echo $id_peminjaman_masuk; ?>">
                            <input type="hidden" name="status" class="form-control" value="<?php echo $status; ?>">
                            <input type="hidden" name="nik" class="form-control" value="<?php echo $nik; ?>">
                            <input type="hidden" name="edit" class="form-control" value="<?php echo $edit; ?>">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm" name="submit">
                                    <i class="fa fa-dot-circle-o"></i> Submit
                                </button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>


            <?php 
                if($lampiran_surat != ""){
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Lampiran Surat <?php echo $id_peminjaman_masuk; ?></strong>
                        </div>
                        <div class="card-body card-block">
                            Nama File :<a href="images/<?php echo $lampiran_surat;?>" target="blank" class="text-dark">
                                <?php echo $lampiran_surat;?></a>
                            <a href="delete_lampiran.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk; ?>"
                                class="btn btn-danger btn-sm float-right"> <i class='fa fa-trash-o fa-1x'> </i></a>
                            <hr />
                            <!-- <object data="images/" type="application/pdf" width="100%"
                        height="100%"></object> -->
                            <embed src="images/<?php echo $lampiran_surat;?>" type="application/pdf" width="800"
                                height="600">
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>


            <!-- BUTTON BACK -->
            <div class="float-left">
                <a href="dashboard_admin.php" class="btn btn-secondary btn-md active float-left" role="button"
                    aria-pressed="true">
                    <i class="fas fa-chevron-left "></i> Kembali </a>
            </div>

            <!-- BUTTON NEXT -->
            <?php if(isset($_GET['id_peminjaman_masuk'])){ ?>
            <div class="float-right">
                <a href="form_peminjaman_list.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>"
                    class="btn btn-primary btn-md active float-right" role="button" aria-pressed="true">
                    Selanjutnya <i class="fas fa-chevron-right "></i>
                </a>
            </div>
            <?php } ?>

        </div><!-- .animated -->
    </div><!-- .content -->

    <div class="clearfix"></div>
    <?php include 'footer_admin.php'; ?>
    <script>
    if (document.getElementById("tgl_awal").value == '') {
        document.getElementById('kembali').style.display = 'none';
    } else {
        document.getElementById('kembali').style.display = '';
    }

    function change_kembali() {
        document.getElementById('kembali').style.display = '';
        var tgl_ambil = document.getElementById("tgl_awal").value;
        // document.getElementById("tgl_kembali").setAttribute("min", tgl_ambil);
        document.getElementById("tgl_kembali").min = tgl_ambil;
    }

    // var camera = document.getElementById('camera');
    // var frame = document.getElementById('frame');



    // camera.addEventListener('change', function(e) {
    //     var file = e.target.files[0];
    //     // Do something with the image file.
    //     frame.src = URL.createObjectURL(file);
    // });
    </script>
    <?php
if(isset($_POST["submit"])){
    $id_peminjaman_masuk=$_POST["id_peminjaman_masuk"];
    $nama_kegiatan = $_POST["nama_kegiatan"];
    $tgl_ambil = $_POST["tgl_ambil"];
    $tgl_kembali= $_POST["tgl_kembali"];
    $nik = $_POST["nik"];
    $status= $_POST["status"];
    $edit = $_POST["edit"];
    $sql_insert1 ="";
    $status1 = "";

    if($edit != "true"){
        if(($nama_kegiatan and $tgl_ambil and $tgl_kembali and $id_peminjaman_masuk and $nik and $status) != null){

            $file_name ="";
            if ($_FILES['gambar']['name'] != "") {
                    $file_name = $_FILES['gambar']['name'];
                    $tmp_name = $_FILES['gambar']['tmp_name'];
                    $file_size = $_FILES['gambar']['size'];
                    $jenis_gambar = $_FILES['gambar']['type'];
                    if($file_name != ""){
                        if($file_size <= 1048576){
                            if($jenis_gambar=="application/pdf"){
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
            $status = "baru";
            $query1="INSERT INTO peminjaman_masuk (id_peminjaman_masuk,nik,nama_kegiatan,tgl_ambil,tgl_kembali,status,lampiran_surat) VALUES ('".$id_peminjaman_masuk."','".$nia."','".$nama_kegiatan."','".$tgl_ambil."','".$tgl_kembali."','".$status."','".$file_name."');";
            $sql_insert1 = mysqli_query($conn,$query1);
            
        }else{
            echo "<script type='text/javascript'>
            window.onload = function(){ 
                            alert('Ada data yang kosong');
                            }
            </script>";
        }
    }else{
        if(($nama_kegiatan and $tgl_ambil and $tgl_kembali and $status) != null){
            $file_name ="";
            $foto_anggota = "";
            $result=mysqli_query($conn, "SELECT * FROM peminjaman_masuk WHERE id_peminjaman_masuk = $id_peminjaman_masuk");
            while ($row1=mysqli_fetch_array($result)){
                $foto_anggota      =   $row1["lampiran_surat"];
            }
            $file_name = $foto_anggota;

            if ($_FILES['gambar']['name'] != "") {

                if ($foto_anggota  != "" || $foto_anggota != "(NULL)"){
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
                        if($jenis_gambar=="application/pdf"){
                            move_uploaded_file($tmp_name, "images/".$file_name);
                        }else{
                            $status1 = "filetype";
                        }
                        
                    }else{
                        $file_name =  $foto_anggota;
                        $status1 = "bigsize";
                    }
                }
            }

            $query="UPDATE peminjaman_masuk set nama_kegiatan = '$nama_kegiatan', tgl_ambil = '$tgl_ambil', tgl_kembali = '$tgl_kembali', 
                        status = '$status', lampiran_surat = '$file_name' where id_peminjaman_masuk = '$id_peminjaman_masuk';";
            $sql_insert1 = mysqli_query($conn,$query);
        }else{
            echo "<script>alert('Ada data yang kosong')</script>";
        }
    }
    if($sql_insert1 && $status1 == ""){
        echo "<script> location.replace('form_peminjaman_anggota.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=berhasil')</script>";
    }else if($sql_insert1  && $status1 != ""){
        echo "<script> location.replace('form_peminjaman_anggota.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=$status1')</script>";
    }else{
        echo "<script type='text/javascript'> window.onload = function(){ alert('Gagal ditambahkan'); } </script>";
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
var _validFileExtensions = [".pdf"];

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