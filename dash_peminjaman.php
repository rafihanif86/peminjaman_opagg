<?php 
	include "connection.php";

    $id_peminjaman_masuk = $nama_instansi = $nama_kegiatan = $email_peminjam = $tgl_ambil = $tgl_kembali =  $no_wa = $status = $edit = null;
    
    if(isset($_GET['edit']) and isset($_GET['id_peminjaman_masuk'])){
        $edit=$_GET['edit'];
        $id_peminjaman_masuk = $_GET['id_peminjaman_masuk'];
        $result=mysqli_query("SELECT * FROM peminjaman_masuk WHERE id_peminjaman_masuk = $id_peminjaman_masuk ");
        while ($row1=mysqli_fetch_array($result)){
            $nama_instansi = $row1["nama_instansi"];
            $email_peminjam = $row1["email_peminjam"];
            $nama_kegiatan = $row1["nama_kegiatan"];
            $tgl_ambil= $row1["tgl_ambil"];
            $tgl_kembali= $row1["tgl_kembali"];
            $no_wa= $row1["no_wa"];
            $status= $row1["status"];
        }
    }

    if(isset($_GET['nama_instansi']) and isset($_GET['nama_kegiatan']) and isset($_GET['email_peminjam'])){
        $nama_instansi = $_GET['nama_instansi'];
        $email_peminjam = $_GET['email_peminjam'];
        $nama_kegiatan = $_GET['nama_kegiatan'];
        $tgl_ambil= $_GET["tgl_ambil"];
        $tgl_kembali= $_GET["tgl_kembali"];
        $no_wa= $_GET["no_wa"];
        $status= $_GET["status"];
    }

    if(isset($_POST["reset"])){
        $nama_instansi=$_POST["nama_instansi"];
        $email_peminjam=$_POST["email_peminjam"];
        $nama_kegiatan = $_POST["nama_kegiatan"];
        $tgl_ambil= $_POST["tgl_ambil"];
        $tgl_kembali= $_POST["tgl_kembali"];
        $no_wa= $_POST["no_wa"];
            echo "
            <script>
                if (confirm('Do you want clean this form?')) {
                    location.replace('form_peminjaman.php');
                } else {
                    location.replace('form_peminjaman.php?nama_instansi=$nama_instansi&nama_kegiatan=$nama_kegiatan&tgl_ambil=$tgl_ambil&tgl_kembali=$tgl_kembali&email_peminjam=$email_peminjam&no_wa=$no_wa');
                }
            </script>";
        
    }

    if(isset($_POST["submit"])){
        $nama_instansi=$_POST["nama_instansi"];
        $email_peminjam=$_POST["email_peminjam"];
        $nama_kegiatan = $_POST["nama_kegiatan"];
        $tgl_ambil = $_POST["tgl_ambil"];
        $tgl_kembali= $_POST["tgl_kembali"];
        $no_wa= $_POST["no_wa"];
        $status= $_POST["status"];

            if(($nama_instansi and $nama_kegiatan and $email_peminjam and $nama_kegiatan and $tgl_ambil and $tgl_kembali and $no_wa and $status) != null){
                $query1="INSERT INTO peminjaman_masuk (nama_instansi,nama_kegiatan,email_peminjam,tgl_ambil,tgl_kembali,no_wa,status) VALUES ('".$nama_instansi."','".$nama_kegiatan."','".$email_peminjam."','".$tgl_ambil."','".$tgl_kembali."','".$no_wa."','".$status."');";
                $sql_insert1 = mysqli_query($conn,$query1);
                echo "<script>alert('Data Berhasil Ditambahkan')
                location.replace('index.php')</script>";
            }else{
                echo "<script>alert('Ada data yang kosong')</script>";
            }
    }

    if(isset($_POST["reset"])){
       $nama_instansi = $nama_kegiatan = $email_peminjam = $tgl_ambil = $tgl_kembali = $no_wa = $status=  $edit = null;
    }

    

?>
<SCRIPT LANGUAGE="JavaScript">
    if($id_vendor=null){
        document.frm.id1.hidden = "hidden";
        document.frm.id2.hidden = "hidden";
    }else{
        document.frm.id1.hidden = "";
        document.frm.id1.hidden = "";
    }
<!-- 	
function controlCK(str) {	
	document.frm.submit.disabled = !str;
}
//  End -->
</script>
<?php
        include 'header_dashboard.php';
    ?>
<body>

        <div class="breadcrumbs col-md-12 mt-3">
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
                                    <li><a href="dashboard_admin.php">Dashboard</a></li>
                                    <li><a href="#">Forms</a></li>
                                    <li class="active">Form Peminjaman</li>
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
                                    <strong>Isikan Data Peminjaman</strong>
                                </div>
                                <div class="card-body card-block">
                                <form action="dash_peminjaman.php" method="post" name="frm" enctype="multipart/form-data" class="form-horizontal">
                                        
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nama Instansi</label></div>
                                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="nama_instansi" placeholder="Nama Instansi" class="form-control" value="<?php echo $nama_instansi; ?>"><small class="form-text text-muted">Masukkan Nama Instansi</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="email-input" class=" form-control-label">Email Peminjam</label></div>
                                            <div class="col-12 col-md-9"><input type="email" id="email-input" name="email_peminjam" placeholder="Email Peminjam" class="form-control" value="<?php echo $email_peminjam; ?>"><small class="form-text text-muted">Masukkan Email Peminjam</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nama Kegiatan</label></div>
                                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="nama_kegiatan" placeholder="Nama Kegiatan" class="form-control" value="<?php echo  $nama_kegiatan; ?>"><small class="help-block form-text">Masukkan Nama Kegiatan</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Tanggal Ambil</label></div>
                                            <div class="col-12 col-md-9"><input type="date" id="text-input" name="tgl_ambil" placeholder="Tanggal Ambil" class="form-control" value="<?php echo $tgl_ambil; ?>"><small class="help-block form-text">Masukkan Tanggal Ambil</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Tanggal Kembali</label></div>
                                            <div class="col-12 col-md-9"><input type="date" id="text-input" name="tgl_kembali" placeholder="Tanggal Kembali" class="form-control" value="<?php echo $tgl_kembali; ?>"><small class="help-block form-text">Masukkan Tanggal Kembali</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nomor WhatsApp Peminjam</label></div>
                                            <div class="col-12 col-md-9"><input type="number" id="email-input" name="no_wa" placeholder="Nomor WhatsApp Peminjam" class="form-control" value="<?php echo $no_wa; ?>"><small class="help-block form-text">Masukkan Nomor WhatsApp Peminjam</small></div>
                                            <input type="text" id="email-input" name="status" hidden="hidden" class="form-control" value="baru">
                                        </div>
                                            
                                    </div>
                                    <div class="card-footer">
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
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->

    <div class="clearfix"></div>
        <?php
            include 'footer_dashboard.php'
        ?>
</body>
</html>
