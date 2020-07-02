<?php 
    include "connection.php";
    $halaman = "alat";
    include 'header_admin.php';

    $id_alat = $merk = $id_jenis_alat = $type = $checklist_masuk = $checklist_keluar =  $edit = $id_user = $deskripsi = $id_kat = "";
    $dateNow= date("Y-m-d");
    $tgl_masuk = $dateNow;
    $username = $nia;
    
    if(isset($_GET['id_alat'])){
        $id_alat    =   $_GET['id_alat'];
        $result=mysqli_query($conn, "SELECT * FROM alat WHERE id_alat = '$id_alat' ");
        while ($row1=mysqli_fetch_array($result)){
            $merk = $row1["merk"];
            $type = $row1["type"];
            $id_jenis_alat = $row1["id_jenis_alat"];
            $deskripsi = $row1["deskripsi"];
        }
    }
?>
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Formulir Alat</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="dashboard_admin.php" class="text-dark">Data Alat</a></li>
                            <li class="active">Formulir Alat</li>
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
                        <strong>Isikan Data Alat </strong>
                    </div>
                    <div class="card-body card-block">
                        <form action="form_alat.php" method="post" merk="frm" enctype="multipart/form-data"
                            class="form-horizontal">
                            <div class="container">

                                <div class="row form-group" <?php if($id_alat == ""){echo "hidden";}?>>
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Nomor Inventaris</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" placeholder="ID Alat" class="form-control"
                                            value="<?php echo $id_alat; ?>" disabled>
                                        <input type="hidden" name="id_alat" value="<?php echo $id_alat; ?>">
                                        <small class="form-text text-muted">Masukkan Merk Alat</small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Jenis Alat</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select id="jenis_alat" name="id_jenis_alat" class="form-control">
                                            <option <?php if($id_jenis_alat == ""){echo "selected";}?> value="">
                                                ----- Pilih Jenis Alat -----</option>
                                            <?php
                                                    $query="SELECT * FROM jenis_alat";
                                                    $sql=mysqli_query($conn,$query);
                                                    while ($row=mysqli_fetch_array($sql)) {
                                                        $select = "";
                                                        if ($row['id_jenis_alat']==$id_jenis_alat) {
                                                            $select="selected";
                                                        }
                                                ?>
                                            <option <?php echo $select; ?> value="<?php echo $row['id_jenis_alat'];?>">
                                                <?php echo $row['nama_jenis_alat']; ?></option>
                                            <?php
                                                    }
                                                ?>
                                        </select>
                                        <small class="form-text text-muted">pilih jenis alat</small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Merk Alat</label></div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="merk" placeholder="Merk Alat"
                                            class="form-control" value="<?php echo $merk; ?>">
                                        <small class="form-text text-muted">Masukkan Merk Alat</small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="type-input" class=" form-control-label">Tipe Alat</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="type" placeholder="type"
                                            class="form-control" value="<?php echo $type; ?>">
                                        <small class="form-text text-muted">Masukkan Tipe Alat</small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="type-input" class=" form-control-label">Deskripsi</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="deskripsi" placeholder="Deskripsi"
                                            class="form-control" value="<?php echo $deskripsi; ?>">
                                        <small class="form-text text-muted">Masukkan Deskripsi Alat</small>
                                    </div>
                                </div>
                                <div class="row form-group" hidden>
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Id Checklist
                                            Masuk</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="date" id="text-input" name="checklist_masuk"
                                            placeholder="Tanggal Masuk" class="form-control"
                                            value="<?php echo $checklist_masuk; ?>"
                                            <?php if($id_alat == ""){echo "disabled";}?>>
                                    </div>
                                </div>
                                <div class="row form-group" hidden>
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Id Checklist
                                            Keluar</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="date" id="text-input" name="checklist_keluar"
                                            placeholder="Tanggal Keluar" class="form-control"
                                            value="<?php echo $checklist_keluar; ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Lampirkan Foto
                                            Alat</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="file" id="text-input" name="gambar[]" placeholder="Choose file"
                                            class="form-control" value="" accept="image/*" capture="camera" id="camera">
                                        <?php
                                                if(isset($id_alat)){
                                                    $result1=mysqli_query($conn,"SELECT * FROM alat WHERE id_alat = '$id_alat';");
                                                    while ($row2=mysqli_fetch_array($result1)){
                                            ?>
                                        <small class="help-block form-text"><?php echo $row2["foto_alat"];?></small>
                                        <?php
                                                    }
                                                }
                                            ?>
                                        <img id="frame">
                                        <small class="help-block form-text">Lampirkan Foto Alat untuk mempermudah
                                            proses pengecekan</small>
                                    </div>
                                </div>
                                <!-- hidden -->
                                <input type="text" id="text-input" name="edit" class="form-control"
                                    value="<?php echo $edit; ?>" hidden>
                            </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm" name="submit">
                            <i class="fa fa-dot-circle-o"></i> Submit
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
            if(isset($id_alat)){
                $foto_jaminan = "";
                $result=mysqli_query($conn,"SELECT foto_alat FROM alat WHERE  id_alat = '$id_alat';");
                while ($row1=mysqli_fetch_array($result)){
                    $foto_jaminan      =   $row1["foto_alat"];
                }
                $hidden_foto = "hidden";
                if($foto_jaminan != "" || $foto_jaminan != null || !empty($foto_jaminan)){ $hidden_foto = "";}

        ?>
        <div class="row" <?php echo $hidden_foto; ?>>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Lampiran Foto Alat</strong>
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

    </div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>
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
<?php 
    include 'footer_admin.php'; 

    if(isset($_POST["submit"])){
        $id_alat=$_POST["id_alat"];
        $merk=$_POST["merk"];
        $type=$_POST["type"];
        $id_jenis_alat = $_POST["id_jenis_alat"];
        $edit=$_POST['edit'];
        $deskripsi=$_POST['deskripsi'];

        
        if(($merk and $id_jenis_alat and $type) != null){
            if($id_alat =="" || $id_alat == null || empty($id_alat)){
                $jumlah = count($_FILES['gambar']['name']);
                $file_name ="";
                $status = "";
                if ($jumlah > 0) {
                    for ($i=0; $i < $jumlah; $i++) { 
                        $file_name = $_FILES['gambar']['name'][$i];
                        $tmp_name = $_FILES['gambar']['tmp_name'][$i];
                        $file_size = $_FILES['gambar']['size'][$i];
                        $jenis_gambar = $_FILES['gambar']['type'][$i];
                        if($file_size <= 1048576){
                            if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif" || $jenis_gambar=="image/x-png"){
                                move_uploaded_file($tmp_name, "images/".$file_name);
                            }else{
                                $file_name =  "";
                                $status = "filetype";
                            }
                        }else{
                            $file_name =  "";
                            $status = "bigsize";
                        }
                    }
                }

                $query =mysqli_query($conn, "SELECT MAX(SUBSTRING(id_alat, -3)) AS maxKode FROM alat;");
                $data = mysqli_fetch_array($query);
                $noOrder = $data['maxKode'];
                $noUrut = (int) $noOrder;
                $noUrut++;
                $char = "/INV-ALT/OPA-GG/";
                $id_alat = $id_jenis_alat .$char . sprintf("%03s", $noUrut);
                $tgl_masuk = date("Y-m-d");

                $query="INSERT INTO alat set id_alat = '$id_alat', merk = '$merk', id_jenis_alat = '$id_jenis_alat', type = '$type', deskripsi = '$deskripsi', foto_alat = '$file_name';";
                $sql_insert1 = mysqli_query($conn,$query);
                if($sql_insert1){
                    echo "<script> location.replace('form_checklist.php?id_alat=$id_alat&status=baru')</script>";
                }else{
                    echo"<script> location.replace('form_alat.php?status=gagal')</script>";
                }
                    
                
            }else{

                $file_name ="";
                $foto_anggota = "";
                $result=mysqli_query($conn, "SELECT * FROM alat WHERE id_alat = $id_alat");
                while ($row1=mysqli_fetch_array($result)){
                    $foto_anggota      =   $row1["foto_alat"];
                }
                $file_name = $foto_anggota;
                $status = "";

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
                            if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif" || $jenis_gambar=="image/x-png"){
                                move_uploaded_file($tmp_name, "images/".$file_name);
                            }else{
                                $file_name =  $foto_anggota;
                                $status = "filetype";
                            }
                            
                        }else{
                            $file_name =  $foto_anggota;
                            $status = "bigsize";
                        }
                    }
                }

                $query="UPDATE alat set merk = '$merk',id_jenis_alat = '$id_jenis_alat', type = '$type', deskripsi = '$deskripsi', foto_alat = '$file_name' where id_alat = $id_alat;";
                $sql_insert1 = mysqli_query($conn,$query);
                echo "<script>alert('Data Berhasil Diubah')
                    location.replace('tampil_alat.php?id_alat=$id_alat')</script>";
            }
        }else{
            echo"<script> location.replace('form_alat.php?status=gagal')</script>";
        }
    }
    
    if(isset($_GET['status'])){
        if($_GET['status'] == "gagal"){
            echo "<script type='text/javascript'>window.onload = function(){alert('Gagal Ditambahkan');}</script>";
        }
    }

?>