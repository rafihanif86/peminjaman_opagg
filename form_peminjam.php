<?php 
    include "connection.php";
    $halaman = "lain";
    include 'header_admin.php';
    

    $nik = $edit = "";
    
    if(isset($_GET['nik'])){
        $nik     =   $_GET['nik'];
        $result=mysqli_query($conn, "SELECT * FROM peminjam WHERE nik = $nik ");
        while ($row1=mysqli_fetch_array($result)){
            $nama   =   $row1["nama"];
            $no_telepon   =   $row1["no_telepon"];
            $email   =   $row1["email"];
            $instansi   =   $row1["instansi"];
        }
        $edit = "true";
    }

    if(isset($_POST["submit"])){
        $nik = $_POST["nik"];
        $nama = $_POST["nama"];
        $email = $_POST["email"];
        $no_telepon = $_POST["no_telepon"];
        $instansi = $_POST["instansi"];
        $edit = $_POST["edit"];

        if($edit != "true"){
            if(($nik and $nama_kat) != null){
                $jumlah = count($_FILES['gambar']['name']);
                $file_name ="";
                $query="INSERT INTO peminjam set nik = $nik, nama = '$nama', no_telepon = '$no_telepon', email = $email, instansi = $instansi;";
                $sql_insert1 = mysqli_query($conn,$query);
                
            }else{
                echo "<script>alert('Ada data yang kosong')</script>";
            }
        }else{
            $nik = $_POST["nik2"];
            $query="UPDATE peminjam set nama = '$nama', no_telepon = '$no_telepon', email = $email, instansi = $instansi; where nik = $nik;";
            $sql_insert1 = mysqli_query($conn,$query);
        }

        if($sql_insert1 && $status == ""){
            echo "<script> location.replace('tabel_peminjam.php?status=berhasil')</script>";
        }else if($sql_insert1  && $status != ""){
            echo "<script> location.replace('tabel_peminjam.php?status=$status')</script>";
        }else{
            echo "<script> location.replace('tabel_peminjam.php?status=gagal')</script>";
        }
    }

?>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Form Peminjam</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="tabel_peminjam.php">Tabel Peminjam</a></li>
                            <li class="active">Form Peminjam</li>
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
                        <strong>Isikan Data Peminjam</strong>
                    </div>
                    <form action="form_peminjam.php" method="post" name="frm" enctype="multipart/form-data"
                        class="form-horizontal">
                        <div class="card-body card-block">
                            <div class="container">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">NIK</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="number" id="text-input" name="email" placeholder="NIK"
                                            class="form-control" value="<?php echo $nik; ?>" <?php if($nik != ""){echo "disabled";}?> >
                                        <small class="form-text text-muted">Masukkan nomor NIK peminjam</small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Nama</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="nama_kat" placeholder="Nama"
                                            class="form-control" value="<?php echo $nama; ?>">
                                        <small class="form-text text-muted">Masukkan nama peminjam</small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Email</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="email" id="text-input" name="email" placeholder="Email"
                                            class="form-control" value="<?php echo $email; ?>">
                                        <small class="form-text text-muted">Masukkan email peminjam</small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Instansi</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="instansi" placeholder="NIK"
                                            class="form-control" value="<?php echo $instansi; ?>">
                                        <small class="form-text text-muted">Masukkan instansi peminjam</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="nik2" value="<?php echo $nik; ?>">
                            <input type="hidden" name="edit" value="<?php echo $edit; ?>">
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

document.getElementById('password_ulangi').style.display = 'none';

function change_ulangi() {
    document.getElementById('password_ulangi').style.display = '';
}
</script>