<?php 
    include "connection.php";
    $halaman = "alat";
    include 'header_admin.php';

    $id_jenis_alat = $nama_jenis_alat = $edit = "";
    
    if(isset($_GET['id_jenis_alat'])){
        $id_jenis_alat     =   $_GET['id_jenis_alat'];
        $result=mysqli_query($conn, "SELECT * FROM jenis_alat WHERE id_jenis_alat = $id_jenis_alat ");
        while ($row1=mysqli_fetch_array($result)){
            $nama_jenis_alat   =   $row1["nama_jenis_alat"];
        }
    }

    if(isset($_POST["submit"])){
        $id_jenis_alat     =   $_POST["id_jenis_alat"];
        $nama_jenis_alat   =   $_POST["nama_jenis_alat"];
        $status = "";
        $jenis_gambar="";

        if($id_jenis_alat == "" || $id_jenis_alat == null){
            if(($id_jenis_alat and $nama_jenis_alat) != null){
                $jumlah = count($_FILES['gambar']['name']);
                $file_name ="";
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
                                $status = "filetype";
                            }
                            
                        }else{
                            $file_name =  $foto_anggota;
                            $status = "bigsize";
                        }
                    }
                }
                $query="INSERT INTO kategori set id_jenis_alat = '$id_jenis_alat',nama_jenis_alat = '$nama_jenis_alat', foto_jenis_alat = '$file_name';";
                $sql_insert1 = mysqli_query($conn,$query);
            }else{
                echo "<script>alert('Ada data yang kosong')</script>";
            }
        }else{
            $file_name ="";
            $foto_anggota = "";
            $result=mysqli_query($conn, "SELECT * FROM jenis_alat WHERE id_jenis_alat = $id_jenis_alat");
            while ($row1=mysqli_fetch_array($result)){
                $foto_anggota      =   $row1["foto_jenis_alat"];
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
            $query="UPDATE kategori set nama_jenis_alat = '$nama_jenis_alat', foto_jenis_alat = '$file_name' where id_jenis_alat = $id_jenis_alat;";
            $sql_insert1 = mysqli_query($conn,$query);
        }
        if($sql_insert1 && $status == ""){
            echo "<script> location.replace('tabel_jenis_alat.php?status=berhasil')</script>";
        }else if($sql_insert1  && $status != ""){
            echo "<script> location.replace('tabel_jenis_alat.php?status=$status')</script>";
        }else{
            echo "<script> location.replace('tabel_jenis_alat.php?status=gagal$jenis_gambar')</script>";
        }
    }
?>

<body>

    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Form Kategori</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="tabel_kategori.php">Tabel Kategori</a></li>
                                <li class="active">Form Kategori</li>
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
                            <strong>Isikan Data Kategori</strong>
                        </div>
                        <form action="form_kategori.php" method="post" name="frm" enctype="multipart/form-data"
                            class="form-horizontal">
                            <div class="card-body card-block">
                                <div class="container">
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class=" form-control-label">Kategori</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <select class="form-control" name="id_kat">
                                                <?php
                                                    if($id_jenis_alat == ""){
                                                        echo "<option selected>-- Pilih Jenis Alat --</option>";
                                                    }
                                                    $query="SELECT * FROM kategori";
                                                    $sql=mysqli_query($conn,$query);
                                                    while ($row=mysqli_fetch_array($sql)) {
                                                        $select = $valueAlat = $tampilAlat ="";
                                                        $valueAlat =  $row['id_kat'];
                                                        $tampilAlat = $row['nama_kat'];
                                                        if ($row['id_kat']==$id_kat) {
                                                            $select="selected";
                                                        }
                                                ?>
                                                <option <?php echo $select; ?> value="<?php echo $valueAlat;?>"> <?php echo $tampilAlat; ?> </option>
                                                <?php } ?>
                                            </select>
                                            <small class="form-text text-muted">pilih Kategori</small>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class=" form-control-label">Masukkan Nama Jenis Alat
                                                Baru</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" id="text-input" name="nama_jenis_alat"
                                                placeholder="Kategori" class="form-control"
                                                value="<?php echo $nama_jenis_alat; ?>">
                                            <small class="form-text text-muted">Masukkan Nama Kategori</small>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class=" form-control-label">Lampirkan Foto kategori</label>
                                        </div>
                                        <div class="col-12 col-md-9"><input type="file" id="text-input" name="gambar[]"
                                                placeholder="Choose file" class="form-control" value="">
                                            <small class="help-block form-text">Lampirkan Foto Alat untuk mempermudah
                                                proses pengecekan</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="id_jenis_alat" value="<?php echo $id_jenis_alat; ?>">
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
    <?php include 'footer_admin.php'; ?>