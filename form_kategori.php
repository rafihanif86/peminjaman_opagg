<?php 
    include "connection.php";
    $halaman = "alat";
    include 'header_admin.php';

    $id_kat = $nama_kat = $edit = "";
    
    if(isset($_GET['id_kat'])){
        $id_kat     =   $_GET['id_kat'];
        $result=mysqli_query($conn, "SELECT * FROM kategori WHERE id_kat = $id_kat ");
        while ($row1=mysqli_fetch_array($result)){
            $nama_kat   =   $row1["nama_kat"];
        }
    }

    if(isset($_POST["submit"])){
        $id_kat     =   $_POST["id_kat"];
        $nama_kat   =   $_POST["nama_kat"];
        $status = "";

        if($id_kat == "" || $id_kat == null){
            if($nama_kat != ""){
                $jumlah = count($_FILES['gambar']['name']);
                $file_name ="";
                if ($jumlah > 0) {
                    for ($i=0; $i < $jumlah; $i++) { 
                        $file_name = $_FILES['gambar']['name'][$i];
                        $tmp_name = $_FILES['gambar']['tmp_name'][$i];
                        $file_size = $_FILES['gambar']['size'][$i];
                        $jenis_gambar = $_FILES['gambar']['type'][$i];
                        if($file_size <= 1048576){
                            if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif" || $jenis_gambar=="image/x-png"|| $jenis_gambar=="image/png"){
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
                $query="INSERT INTO kategori set nama_kat = '$nama_kat', foto_kat = '$file_name';";
                $sql_insert1 = mysqli_query($conn,$query);
                
            }else{
                echo "<script>alert('Ada data yang kosong')</script>";
            }
        }else{

            $file_name ="";
            $foto_anggota = "";
            $result=mysqli_query($conn, "SELECT * FROM kategori WHERE id_kat = $id_kat");
            while ($row1=mysqli_fetch_array($result)){
                $foto_anggota      =   $row1["foto_kat"];
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
                            $file_name =  $foto_anggota;
                            $status = "filetype";
                        }
                        
                    }else{
                        $file_name =  $foto_anggota;
                        $status = "bigsize";
                    }
                }
            }

            $query="UPDATE kategori set nama_kat = '$nama_kat', foto_kat = '$file_name' where id_kat = $id_kat;";
            $sql_insert1 = mysqli_query($conn,$query);
        }

        if($sql_insert1 && $status == ""){
            echo "<script> location.replace('tabel_kategori.php?status=berhasil')</script>";
        }else if($sql_insert1  && $status != ""){
            echo "<script> location.replace('tabel_kategori.php?status=$status')</script>";
        }else{
            echo "<script> location.replace('tabel_kategori.php?status=gagal')</script>";
        }
    }
?>

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
                                        <input type="text" id="text-input" name="nama_kat" placeholder="Kategori"
                                            class="form-control" value="<?php echo $nama_kat; ?>">
                                        <small class="form-text text-muted">Masukkan Nama Kategori</small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Lampirkan Foto
                                            kategori</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="file" name="gambar[]" placeholder="Choose file"
                                            class="form-control" value="" accept="image/jpg,image/jpeg,image/png" capture="camera" id="camera">
                                        <img id="frame">
                                        <small class="help-block form-text">Tambahkan gambar kategori. Pilih gambar untuk mengubah</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="id_kat" value="<?php echo $id_kat; ?>">
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