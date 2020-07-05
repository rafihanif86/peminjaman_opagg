<?php 
    include "connection.php";
    $halaman = "alat";
    include 'header_admin.php';

    $nia_anggota = $nama_user = $password = $username = $posisi =  $email = $nohp = $status_anggota = "";
    $edit = "false";
    $hidden_pass_lama = "hidden";
    
    
    if(isset($_GET['nia'])){
        $nia_anggota    =   $_GET['nia'];
        $result=mysqli_query($conn, "SELECT * FROM user WHERE nia = $nia_anggota");
        while ($row1=mysqli_fetch_array($result)){
            $nama_user      =   $row1["nama_user"];
            $username       =   $row1["username"];
            $password       =   $row1["password"];
            $email       =   $row1["email"];
            $nohp = $row1["no_telp"];
            $status_anggota = $row1["status_anggota"];
        }
       $hidden_pass_lama = "";
       $edit = "true";
    }

    if(isset($_POST["submit"])){
        $nama_user = $_POST["nama_user"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $password_lama = $_POST["password_lama"];
        $password_lama2 = $_POST["password_lama2"];
        $password2 = $_POST["password2"];
        $nia_anggota = $_POST["nia"];
        $email = $_POST["email"];
        $nohp = $_POST["nohp"];
        $login_status = $_POST["login_status"];
        $status_anggota = $_POST['status_anggota'];
        $edit = $_POST["edit"];
        $status = "";
        
        $posisi = "";
        if($status_anggota == "Ketua Umum" || $status_anggota == "Wakil Ketua 1" || $status_anggota == "Departemen" || $status_anggota == "Kepala Divisi"){
            $posisi = "admin";
        }else{
            $posisi = "anggota";
        }

        if($edit == "false"){
            if(($nama_user && $posisi && $status_anggota && $email && $nohp && $username) != null && $password == $password2){
                $file_name ="";
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
                                    $status = "filetype";
                                }
                            }else{
                                $file_name =  "";
                                $status = "bigsize";
                            }
                        }
                }

                $query="INSERT INTO user set nia = '$nia_anggota', nama_user = '$nama_user', password = '$password', username = '$username',posisi = '$posisi', login_status = 'logout', status_anggota = '$status_anggota', no_telp = '$nohp', email = '$email', foto_anggota = '$file_name';";
                $sql_insert1 = mysqli_query($conn,$query);
            }else{
                echo "<script>alert('Ada data yang kosong')</script>";
            }
        }else{
            $file_name ="";
            $foto_anggota = "";
            $result=mysqli_query($conn, "SELECT * FROM user WHERE nia = $nia_anggota");
            while ($row1=mysqli_fetch_array($result)){
                $foto_anggota      =   $row1["foto_anggota"];
            }
            $file_name = $foto_anggota;

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
                            $status = "filetype";
                        }
                        
                    }else{
                        $file_name =  $foto_anggota;
                        $status = "bigsize";
                    }
                }
            }

            $password_input = "";
            if($password != "" && $password_lama == $password_lama2 && $password == $password2){
                $password_input = $password;
            }else{
                $password_input = $password_lama;
            }

            $query="UPDATE user set nama_user = '$nama_user', password = '$password_input', username = '$username',posisi = '$posisi', login_status = 'logout', status_anggota = '$status_anggota', no_telp = '$nohp', email = '$email', foto_anggota = '$file_name' where nia = '$nia_anggota';";
            $sql_insert1 = mysqli_query($conn,$query);
        }
        if($sql_insert1 && $status == ""){
            echo "<script> location.replace('tampil_anggota.php?nia=$nia_anggota&status=berhasil')</script>";
        }else if($sql_insert1  && $status != ""){
            echo "<script> location.replace('tampil_anggota.php?nia=$nia_anggota&status=$status')</script>";
        }else{
            echo "<script> location.replace('tampil_anggota.php?nia=$nia_anggota&status=gagal')</script>";
        }
    }
?>


<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Formulir Anggota</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="dashboard_admin.php" class="text-dark">Data Anggota</a></li>
                            <li class="active">Kelola Anggota</li>
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
                        <strong>Isikan Data Anggota</strong>
                    </div>
                    <div class="card-body card-block">
                        <form action="form_anggota.php" method="post" name="frm" enctype="multipart/form-data"
                            class="form-horizontal">

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nomor
                                        Induk Anggota</label></div>
                                <div class="col-12 col-md-9">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">NIA.</span>
                                        </div>
                                        <input type="number" id="text-input" name="nia" placeholder="NIA"
                                            class="form-control" value="<?php echo $nia_anggota; ?>">
                                        <div class="input-group-append">
                                            <span class="input-group-text">-GG</span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Masukkan Nomor
                                        Induk Anggota</small>

                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input"
                                        class=" form-control-label">Nama</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="text-input" name="nama_user"
                                        placeholder="Nama " class="form-control"
                                        value="<?php echo $nama_user; ?>"><small class="form-text text-muted">Masukkan
                                        Nama Anggota</small></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input"
                                        class=" form-control-label">Email</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="email" id="text-input" name="email" placeholder="email"
                                        class="form-control" value="<?php echo $email; ?>">
                                    <small class="form-text text-muted">Masukkan
                                        Email Anggota</small>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input"
                                        class=" form-control-label">Telepon</label></div>
                                <div class="col-12 col-md-9"><input type="number" id="text-input" name="nohp"
                                        placeholder="Nomor Telepon" class="form-control"
                                        value="<?php echo $nohp; ?>"><small class="form-text text-muted">Masukkan
                                        Posisi User</small></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="text-input" class=" form-control-label">Status Keanggotaan</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <select class="browser-default custom-select" name="status_anggota">
                                        <option <?php if($status_anggota == ''){echo 'selected';}?> value="ketua umum">
                                            ----- Pilih Status Anggota ------</option>
                                        <option <?php if($status_anggota == 'Ketua Umum'){echo 'selected';}?>
                                            value="Ketua Umum">Ketua Umum</option>
                                        <option <?php if($status_anggota == 'Wakil Ketua 1'){echo 'selected';}?>
                                            value="Wakil Ketua 1">Wakil Ketua 1</option>
                                        <option <?php if($status_anggota == 'Wakil Ketua 2'){echo 'selected';}?>
                                            value="Wakil ketua 1">Wakil Ketua 2</option>
                                        <option
                                            <?php if($status_anggota == 'Departemen Rumah Tangga'){echo 'selected';}?>
                                            value="Departemen Rumah Tangga">Rumah Tangga</option>
                                        <option <?php if($status_anggota == 'Departemen Lain'){echo 'selected';}?>
                                            value="Departemen">Departemen</option>
                                        <option <?php if($status_anggota == 'Kepala Divisi'){echo 'selected';}?>
                                            value="Kepala Divisi">Kepala Divisi</option>
                                        <option <?php if($status_anggota == 'Anggota Biasa'){echo 'selected';}?>
                                            value="Anggota Biasa">Anggota Biasa</option>
                                        <option <?php if($status_anggota == 'Anggota Luar Biasa'){echo 'selected';}?>
                                            value="Anggota Luar Biasa">Anggota Luar Biasa</option>
                                    </select>
                                    <small class="form-text text-muted">Pilih Status Keanggotaan</small>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="text-input" class=" form-control-label">Lampirkan Foto
                                        Profil</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="file" name="gambar" placeholder="Choose file" class="form-control"
                                        value="" accept="image/*" capture="camera" id="camera">
                                    <img id="frame">
                                    <small class="help-block form-text">Lampirkan Foto Profil Anda</small>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input"
                                        class=" form-control-label">Username</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="text-input" name="username"
                                        placeholder="Username" class="form-control"
                                        value="<?php echo $username; ?>"><small class="form-text text-muted">Masukkan
                                        Username </small></div>
                            </div>
                            <div class="row form-group" <?php echo $hidden_pass_lama;?>>
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Password
                                        Lama</label></div>
                                <div class="col-12 col-md-9"><input type="password" name="password_lama2"
                                        placeholder="Password" class="form-control" value=""><small
                                        class="form-text text-muted">Masukkan
                                        Password Lama untuk mengubah password anda</small></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Password
                                        Baru</label></div>
                                <div class="col-12 col-md-9"><input type="password" name="password"
                                        placeholder="Password" class="form-control" value=""
                                        onchange="change_ulangi()"><small class="form-text text-muted">Masukkan
                                        Password</small></div>
                            </div>
                            <div class="row form-group" id="password_ulangi">
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Ulangi
                                        Password</label></div>
                                <div class="col-12 col-md-9"><input type="password" name="password2"
                                        placeholder="Password" class="form-control" value=""><small
                                        class="form-text text-muted">Ulangi
                                        Password Anda</small></div>
                            </div>
                            <!-- hidden input -->
                            <input type="hidden" id="text-input" name="password_lama" placeholder=""
                                class="form-control" value="<?php echo $password; ?>">
                            <input type="hidden" id="text-input" name="login_status" placeholder="" class="form-control"
                                value="<?php echo $login_status; ?>">
                            <input type="hidden" id="text-input" name="edit" placeholder="edit" class="form-control"
                                value="<?php echo $edit; ?>">
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

document.getElementById('password_ulangi').style.display = 'none';

function change_ulangi() {
    document.getElementById('password_ulangi').style.display = '';
}
</script>