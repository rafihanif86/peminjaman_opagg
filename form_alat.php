<?php 
	include "connection.php";

    $id_alat = $merk = $id_kat = $type = $tgl_masuk = $tgl_keluar =  $edit = $id_user = null;
    
    if(isset($_GET['edit']) and isset($_GET['id_alat'])){
        $edit=$_GET['edit'];
        $id_alat = $_GET['id_alat'];
        $result=mysqli_query("SELECT * FROM alat WHERE id_alat = $id_alat ");
        while ($row1=mysqli_fetch_array($result)){
            $merk = $row1["merk"];
            $type = $row1["type"];
            $id_kat = $row1["id_kat"];
            $tgl_masuk= $row1["tgl_masuk"];
            $tgl_keluar= $row1["tgl_keluar"];
            $id_user= $row1["id_user"];
        }
    }

    if(isset($_GET['merk']) and isset($_GET['id_kat']) and isset($_GET['type'])){
        $merk = $_GET['merk'];
        $type = $_GET['type'];
        $id_kat = $_GET['id_kat'];
        $tgl_masuk= $_GET["tgl_masuk"];
        $tgl_keluar= $_GET["tgl_keluar"];
        $id_user= $_GET["id_user"];
    }

    if(isset($_POST["reset"])){
        $id_alat = $_POST["id_alat"];
        $merk=$_POST["merk"];
        $type=$_POST["type"];
        $id_kat = $_POST["id_kat"];
        $tgl_masuk= $_POST["tgl_masuk"];
        $tgl_keluar= $_POST["tgl_keluar"];
        $id_user= $_POST["id_user"];
        if($id_alat != null){
            echo "
            <script>
                if (confirm('Do you want clean this form?')) {
                    location.replace('biodata_form.php');
                } else {
                    location.replace('biodata_form.php?edit=true&id_alat=$id_alat');
                }
            </script>";
        }else{
            echo "
            <script>
                if (confirm('Do you want clean this form?')) {
                    location.replace('biodata_form.php');
                } else {
                    location.replace('biodata_form.php?merk=$merk&id_kat=$id_kat&type=$type');
                }
            </script>";
        }
        
    }

    if(isset($_POST["submit"])){
        $merk=$_POST["merk"];
        $type=$_POST["type"];
        $id_kat = $_POST["id_kat"];
        $tgl_masuk = $_POST["tgl_masuk"];
        $tgl_keluar= $_POST["tgl_keluar"];
        $id_user= $_POST["id_user"];
        $edit=$_POST['edit'];

        if($edit != true){
            if(($merk and $id_kat and $type) != null){
                $query="INSERT INTO alat (merk,id_kat,type,tgl_masuk,tgl_keluar,id_user) VALUES ('".$merk."','".$id_kat."','".$type."','".$tgl_masuk."','".$tgl_keluar."','".$id_user."');";
                $sql_insert1 = mysqli_query($conn,$query);
                echo "<script>alert('Data Berhasil Ditambahkan')
                location.replace('index.php')</script>";
            }else{
                echo "<script>alert('Ada data yang kosong')</script>";
            }
        }else{
            $query="UPDATE alat set merk = '$merk',id_kat = '$id_kat', type = '$type', tgl_masuk = '$tgl_masuk', tgl_keluar = '$tgl_keluar', id_user = '$id_user' where id_alat = $id_alat;";
            $sql_insert1 = mysqli_query($conn,$query);
            echo "<script>alert('Data Berhasil Diubah')
                location.replace('index.php')</script>";
        }
    }

    if(isset($_POST["reset"])){
        $merk = $type = $id_kat = null;
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
        include 'header_admin.php';
    ?>
<body>

        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Form Alat</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="dashboard_admin.php">Dashboard</a></li>
                                    <li><a href="#">Forms</a></li>
                                    <li class="active">Form Alat</li>
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
                                    <strong>Isikan Data Alat</strong>
                                </div>
                                <div class="card-body card-block">
                                <form action="form_alat.php" method="post" merk="frm" enctype="multipart/form-data" class="form-horizontal">
                                        
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Merk Alat</label></div>
                                            <div class="col-12 col-md-9"><input type="text" id="text-input" merk="merk" placeholder="Merk Alat" class="form-control" value="<?php echo $merk; ?>"><small class="form-text text-muted">Masukkan Merk Alat</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="type-input" class=" form-control-label">Tipe Alat</label></div>
                                            <div class="col-12 col-md-9"><input type="text" id="text-input" merk="type" placeholder="type" class="form-control" value="<?php echo $type; ?>"><small class="form-text text-muted">Masukkan Tipe Alat</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Id Kategori</label></div>
                                            <div class="col-12 col-md-9"><input type="text" id="text-input" merk="id_kat" placeholder="Nama Kegiatan" class="form-control" value="<?php echo  $id_kat; ?>"><small class="help-block form-text">Masukkan Nama Kegiatan</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Tanggal Masuk</label></div>
                                            <div class="col-12 col-md-9"><input type="text" id="text-input" merk="tgl_masuk" placeholder="Tanggal Masuk" class="form-control" value="<?php echo $tgl_masuk; ?>"><small class="help-block form-text">Masukkan Tanggal Masuk</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Tanggal Keluar</label></div>
                                            <div class="col-12 col-md-9"><input type="text" id="text-input" merk="tgl_keluar" placeholder="Tanggal Keluar" class="form-control" value="<?php echo $tgl_keluar; ?>"><small class="help-block form-text">Masukkan Tanggal Keluar</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">id User</label></div>
                                            <div class="col-12 col-md-9"><input type="text" id="text-input" merk="id_user" placeholder="Id User" class="form-control" value="<?php echo $id_user; ?>"><small class="help-block form-text">Masukkan Id User</small></div>
                                        </div>
                                            
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm" merk="submit">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm" merk="reset">
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
            include 'footer_admin.php'
        ?>
</body>
</html>
