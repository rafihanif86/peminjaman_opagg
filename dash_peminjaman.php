<?php 
    $title_header="Peminjaman | Inventory OPA Ganendra Giri";
    $home_active="";
    $peminjaman_active="active";
    $about_active="";
    include 'header_dashboard.php';

    $id_peminjaman_masuk = $nama_instansi = $nama_kegiatan = $email_peminjam = $tgl_ambil = $tgl_kembali =  $no_wa = $lampiran_surat =  $status = $edit = null;
    $tgl_hari_ini = date('Y-m-d');
    $nik = "";
    $nama = "";
    $action_data_peminjam = "hidden";
    $action_button_peminjam = "";
    $hidden_data_peminjaman = "hidden";
    $disabled_nik_peminjam = "";
    $disabled_data_peminjam = "";
    $disabeled_data_peminjaman = "";
    $hidden_button_peminjaman = "";
    $progress = "5%";

    if(isset($_GET['id_peminjaman_masuk'])){
        $id_peminjaman_masuk = $_GET['id_peminjaman_masuk'];
    }

    if($id_peminjaman_masuk !=""){
       
        $result=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE id_peminjaman_masuk = '$id_peminjaman_masuk';");
        while ($row1=mysqli_fetch_array($result)){
            $nama_kegiatan = $row1["nama_kegiatan"];
            $tgl_ambil= $row1["tgl_ambil"];
            $tgl_kembali= $row1["tgl_kembali"];
            $status= $row1["status"];
            $nik= $row1["nik"];
            $lampiran_surat= $row1["lampiran_surat"];
        }
        if($nama_kegiatan != ""){
            $progress = "75%";
        }
        $hidden_data_peminjaman = "";
        $disabled_nik_peminjam = "disabled";
        $action_button_peminjam = "hidden";
        $action_data_peminjam = "";
        $disabled_data_peminjam = "disabled";
        $disabeled_data_peminjaman = "";
        $hidden_button_peminjaman = "hidden";
        $edit = "true";
    }

    if(isset($_POST["nik"])){
        $nik= $_POST["nik"];
        $progress = "15%";
    }
    
    if($nik != ""){
        $res3=mysqli_query($conn,"SELECT * FROM peminjam WHERE nik = '$nik';");
        while ($row1=mysqli_fetch_array($res3)){
            $nama = $row1["nama"];
            $no_wa = $row1["no_telepon"];
            $email_peminjam = $row1["email"];
            $nama_instansi = $row1["instansi"];
        }
    }


    

    if(isset($_POST["submit_peminjam"])){
        $nik = $_POST["nik"];
        
        if(($nama && $no_wa && $email_peminjam && $nama_instansi) != ""){
            $hidden_data_peminjaman = "";
            $disabled_nik_peminjam = "disabled";
            $action_button_peminjam = "hidden";
            $action_data_peminjam = "";
            $disabled_data_peminjam = "disabled";
            $progress = "45%";
        }else{
            if(($_POST["nik"] && $_POST["nama"] && $_POST["email_peminjam"] && $_POST["nama_instansi"] && $_POST["no_wa"]) != ""){
                $nik = $_POST["nik"];
                $nama = $_POST["nama"];
                $email_peminjam = $_POST["email_peminjam"];
                $nama_instansi = $_POST["nama_instansi"];
                $no_wa = $_POST["no_wa"];
                $query1="INSERT INTO peminjam (nik,nama,email,no_telepon,instansi) VALUES ('".$nik."','".$nama."','".$email_peminjam."','".$no_wa."','".$nama_instansi."');";
                $sql_insert1 = mysqli_query($conn,$query1);
                if($sql_insert1){
                    $disabled_nik_peminjam = "disabled";
                    $action_button_peminjam = "hidden";
                    $disabled_data_peminjam = "disabled";
                    $action_data_peminjam = "";
                    $hidden_data_peminjaman="";
                    echo "<script type='text/javascript'>
                    window.onload = function(){ 
                                    alert('data berhasil ditambahkan');
                                    }
                    </script>";
                }else{
                    echo "<script type='text/javascript'>
                    window.onload = function(){ 
                                    alert('data gagal ditambahkan');
                                    }
                    </script>";
                }

            }else{
                $disabled_nik_peminjam = "disabled";
                $action_data_peminjam = "";
                $action_button_peminjam = "";
             
            }
        }

    }

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
    $id_Order = $char .$date . sprintf("%03s", $noUrut);
?>


<div class="content" style="max-width: 90%; margin: auto; float:none;">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body card-block">
                    <div class="breadcrumbs bg-white">
                        <div class="breadcrumbs-inner">
                            <div class="row" style="padding: 5px;">
                                <div class="col-md-6">
                                    <div class="page-header float-left" style="padding-bottom: 0px; padding-top: 10px;">
                                        <div class="page-title">
                                            <h1>Form Peminjaman</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="page-header float-right "
                                        style="padding-bottom: 0px; padding-top: 10px;">
                                        <div class="page-title">
                                            <ol class="breadcrumb text-right">
                                                <li class="breadcrumb-item"> Peminjaman </li>
                                                <li class="breadcrumb-item active">Form Peminjaman</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-bottom: 10px;">
                                <div class="col-md-12">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar" aria-valuenow="<?php echo $progress;?>" aria-valuemin="0"
                                            aria-valuemax="100" style="width: <?php echo $progress;?>;"></div>
                                    </div>
                                </div>
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
                    <strong>Data Peminjam</strong>
                </div>
                <div class="card-body card-block">
                    <form action="dash_peminjaman.php" method="post" name="frm" enctype="multipart/form-data"
                        class="form-horizontal">
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">NIK</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="text-input" name="nik" placeholder="NIK anda"
                                    class="form-control" value="<?php echo  $nik; ?>"
                                    <?php echo $disabled_nik_peminjam;?>>
                                <?php 
                                    if($disabled_nik_peminjam == "disabled"){
                                        echo '<input type="hidden" id="text-input" name="nik" value="'.$nik.'">';
                                    }
                                ?>
                                <small class="help-block form-text">Masukkan NIK Anda</small>
                            </div>
                        </div>
                        <div class="row form-group" <?php echo $action_data_peminjam?>>
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Nama</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="text-input" name="nama" placeholder="Nama anda"
                                    class="form-control" value="<?php echo  $nama; ?>"
                                    <?php echo $disabled_data_peminjam?>>
                                <small class="help-block form-text">Masukkan Nama Anda</small>
                            </div>
                        </div>
                        <div class="row form-group" <?php echo $action_data_peminjam?>>
                            <div class="col col-md-3">
                                <label for="email-input" class=" form-control-label">Email</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="email" id="email-input" name="email_peminjam" placeholder="Email"
                                    class="form-control" value="<?php echo $email_peminjam; ?>"
                                    <?php echo $disabled_data_peminjam?>>
                                <small class="form-text text-muted">Masukkan Email Peminjam</small>
                            </div>
                        </div>
                        <div class="row form-group" <?php echo $action_data_peminjam?>>
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Nomor
                                    Telepon</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="number" id="number-input" name="no_wa" placeholder="Nomor Telepon"
                                    class="form-control" value="<?php echo $no_wa; ?>"
                                    <?php echo $disabled_data_peminjam?>>
                                <small class="help-block form-text">Usahakan mengisiskan nomor telepon
                                    whatsapp</small>
                            </div>
                        </div>
                        <div class="row form-group" <?php echo $action_data_peminjam?>>
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Nama
                                    Instansi</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="text-input" name="nama_instansi" placeholder="Nama Instansi"
                                    class="form-control" value="<?php echo $nama_instansi; ?>"
                                    <?php echo $disabled_data_peminjam?>>
                                <small class="form-text text-muted">Masukkan Nama Instansi</small>
                            </div>
                        </div>
                </div>
                <div class="card-footer" <?php echo $action_button_peminjam?>>
                    <button type="submit" class="btn btn-primary btn-sm" name="submit_peminjam">
                        <i class="fa fa-dot-circle-o"></i> Submit
                    </button>
                    <button type="reset" class="btn btn-danger btn-sm" name="reset">
                        <i class="fa fa-ban"></i> Reset
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row" <?php echo $hidden_data_peminjaman?>>
        <div class="col-lg-12">
            <div class="card" style="size: 80%;">
                <div class="card-header">
                    <strong>Isikan Data Peminjaman
                        <?php if($id_peminjaman_masuk != ""){echo $id_peminjaman_masuk;}else{echo $id_Order;} ?></strong>
                </div>
                <form action="dash_peminjaman.php" method="post" name="frm" enctype="multipart/form-data"
                    class="form-horizontal">
                    <div class="card-body card-block">
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Nama
                                    Kegiatan</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="text-input" name="nama_kegiatan" placeholder="Nama Kegiatan"
                                    class="form-control" value="<?php echo  $nama_kegiatan; ?>"
                                    <?php echo  $disabeled_data_peminjaman; ?>>
                                <small class="help-block form-text">Masukkan Nama Kegiatan</small>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Tanggal
                                    Pengambilan</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="date" id="tgl_awal" name="tgl_ambil" placeholder="Tanggal Ambil"
                                    class="form-control" value="<?php echo $tgl_ambil; ?>"
                                    min="<?php echo date('Y-m-d', strtotime('+3days', strtotime($tgl_hari_ini))); ?>"
                                    <?php echo  $disabeled_data_peminjaman; ?> onchange="change_kembali()">
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
                                <input type="date" id="tgl_kembali" name="tgl_kembali" placeholder="Tanggal Kembali"
                                    class="form-control" value="<?php echo $tgl_kembali; ?>"
                                    <?php echo  $disabeled_data_peminjaman; ?>>
                                <!-- <small class="help-block form-text">Masukkan Tanggal Kembali</small> -->
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Lampirkan surat</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="file" id="fileupload" name="gambar[]" placeholder="Choose file"
                                    class="form-control" accept="application/pdf"
                                    <?php echo  $disabeled_data_peminjaman; ?> onchange="validate(this);">
                                <small class="help-block form-text">Lampirkan surat (jika ada)
                                    untuk mempermudah proses peminjaman. Pastikan Lampiran berekstensi PDF</small>
                                <!-- <img id="frame" style="max-height: 350px"> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="hidden" name="status" value="baru">
                        <input type="hidden" name="id_masuk"
                            value="<?php if($id_peminjaman_masuk != ""){echo $id_peminjaman_masuk;}else{echo $id_Order;} ?>">
                        <input type="hidden" name="nik" value="<?php echo $nik; ?>">
                        <input type="hidden" name="edit" value="<?php echo $edit; ?>">
                        <button type="submit" class="btn btn-primary btn-sm" name="submit">
                            <i class="fa fa-dot-circle-o"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-danger btn-sm" name="reset">
                            <i class="fa fa-ban"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
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
                    Nama File :<a href="images/<?php echo $lampiran_surat;?>" target="blank" class="text-dark"> <?php echo $lampiran_surat;?></a>
                    <a href="delete_dash_lampiran.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk; ?>" class="btn btn-danger btn-sm float-right"> <i class='fa fa-trash-o fa-1x'> </i></a>
                    <hr />
                    <!-- <object data="images/" type="application/pdf" width="100%"
                        height="100%"></object> -->
                    <embed src="images/<?php echo $lampiran_surat;?>" type="application/pdf" width="800" height="600" >
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- BUTTON NEXT -->
    <?php if($id_peminjaman_masuk != ""){ ?>
    <div class="float-right">
        <a href="dash_item_peminjaman.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>"
            class="btn btn-primary btn-md active float-right" role="button" aria-pressed="true">
            Selanjutnya <i class="fas fa-chevron-right"></i>
        </a>
    </div>
    <br />
    <?php } ?>


</div><!-- .content -->

<div class="clearfix"></div>
<?php
    include 'footer_dashboard.php';
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
    $id_peminjaman_masuk=$_POST["id_masuk"];
    $nama_kegiatan = $_POST["nama_kegiatan"];
    $tgl_ambil = $_POST["tgl_ambil"];
    $tgl_kembali= $_POST["tgl_kembali"];
    $status= $_POST["status"];
    $edit = $_POST["edit"];
    $sql_insert1 ="";
    $status1 = "";

    if($edit != "true"){
        if(($nama_kegiatan and $tgl_ambil and $tgl_kembali and $id_peminjaman_masuk and $nik and $status) != null){

            $jumlah = count($_FILES['gambar']['name']);
                $file_name ="";
                if ($jumlah > 0) {
                    for ($i=0; $i < $jumlah; $i++) { 
                        $file_name = $_FILES['gambar']['name'][$i];
                        $tmp_name = $_FILES['gambar']['tmp_name'][$i];
                        $file_size = $_FILES['gambar']['size'][$i];
                        $jenis_gambar = $_FILES['gambar']['type'][$i];
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

            $query1="INSERT INTO peminjaman_masuk (id_peminjaman_masuk,nik,nama_kegiatan,tgl_ambil,tgl_kembali,status,lampiran_surat) VALUES ('".$id_peminjaman_masuk."','".$nik."','".$nama_kegiatan."','".$tgl_ambil."','".$tgl_kembali."','".$status."','".$file_name."');";
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

            $jumlah = count($_FILES['gambar']['name']);
            if ($jumlah > 0) {

                if ($foto_anggota  != ""){
                    $target = "images/" .$foto_anggota  ;
                    if(file_exists($target)){
                        unlink($target);
                    }
                }

                for ($i=0; $i < $jumlah; $i++) { 
                    $file_name = $_FILES['gambar']['name'][$i];
                    $tmp_name = $_FILES['gambar']['tmp_name'][$i];
                    $file_size = $_FILES['gambar']['size'][$i];
                    $jenis_gambar = $_FILES['gambar']['type'][$i];
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
        echo "<script> location.replace('dash_peminjaman.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=berhasil')</script>";
    }else if($sql_insert1  && $status != ""){
        echo "<script> location.replace('dash_peminjaman.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=$status1')</script>";
    }else{
        echo "<script> location.replace('dash_peminjaman.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=gagal')</script>";
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