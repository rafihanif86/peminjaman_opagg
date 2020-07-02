<?php 
	include "connection.php";

    $id_detail = $id_kat = $status = $jumlah_permintaan = $jumlah_dikeluarkan = $edit = null;
    
    if(isset($_GET['edit']) and isset($_GET['id_detail'])){
        $edit=$_GET['edit'];
        $id_detail = $_GET['id_detail'];
        $result=mysqli_query("SELECT * FROM detail_peminjaman WHERE id_detail = $id_detail ");
        while ($row1=mysqli_fetch_array($result)){
            $id_kat = $row1["id_kat"];
            $jumlah_permintaan = $row1["jumlah_permintaan"];
            $status = $row1["status"];
            $jumlah_dikeluarkan= $row1["jumlah_dikeluarkan"];
        }
    }

    if(isset($_GET['id_kat']) and isset($_GET['status']) and isset($_GET['jumlah_permintaan'])){
        $id_kat = $_GET['id_kat'];
        $jumlah_permintaan = $_GET['jumlah_permintaan'];
        $status = $_GET['status'];
        $jumlah_dikeluarkan= $_GET["jumlah_dikeluarkan"];
    }

    if(isset($_POST["reset"])){
        $id_detail = $_POST["id_detail"];
        $id_kat=$_POST["id_kat"];
        $jumlah_permintaan=$_POST["jumlah_permintaan"];
        $status = $_POST["status"];
        $jumlah_dikeluarkan= $_POST["jumlah_dikeluarkan"];

        if($id_detail != null){
            echo "
            <script>
                if (confirm('Do you want clean this form?')) {
                    location.replace('biodata_form.php');
                } else {
                    location.replace('biodata_form.php?edit=true&id_detail=$id_detail');
                }
            </script>";
        }else{
            echo "
            <script>
                if (confirm('Do you want clean this form?')) {
                    location.replace('biodata_form.php');
                } else {
                    location.replace('biodata_form.php?id_kat=$id_kat&status=$status&jumlah_permintaan=$jumlah_permintaan');
                }
            </script>";
        }
        
    }

    if(isset($_POST["submit"])){
        $id_kat=$_POST["id_kat"];
        $jumlah_permintaan=$_POST["jumlah_permintaan"];
        $status = $_POST["status"];
        $jumlah_dikeluarkan = $_POST["jumlah_dikeluarkan"];

        $edit=$_POST['edit'];

        if($edit != true){
            if(($id_kat and $status and $jumlah_permintaan) != null){
                $query="INSERT INTO detail_peminjaman (id_kat,status,jumlah_permintaan,jumlah_dikeluarkan) VALUES ('".$id_kat."','".$status."','".$jumlah_permintaan."','".$jumlah_dikeluarkan."');";
                $sql_insert1 = mysqli_query($conn,$query);
                echo "<script>alert('Data Berhasil Ditambahkan')
                location.replace('index.php')</script>";
            }else{
                echo "<script>alert('Ada data yang kosong')</script>";
            }
        }else{
            $query="UPDATE detail_peminjaman set id_kat = '$id_kat',status = '$status', jumlah_permintaan = '$jumlah_permintaan', jumlah_dikeluarkan = '$jumlah_dikeluarkan' where id_detail = $id_detail;";
            $sql_insert1 = mysqli_query($conn,$query);
            echo "<script>alert('Data Berhasil Diubah')
                location.replace('index.php')</script>";
        }
    }

    if(isset($_POST["reset"])){
       $id_kat = $status = $jumlah_permintaan = $jumlah_dikeluarkan =  $edit = null;
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
                                <h1>Form Detail Peminjaman</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="dashboard_admin.php">Dashboard</a></li>
                                    <li><a href="#">Forms</a></li>
                                    <li class="active">Form Detail Peminjaman</li>
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
                                    <strong>Isikan Detail Peminjaman</strong>
                                </div>
                                <div class="card-body card-block">
                                <form action="form_detailPeminjaman.php" method="post" name="frm" enctype="multipart/form-data" class="form-horizontal">
                                        
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masukkan Id Kategori</label></div>
                                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="id_kat" placeholder="Id Kategori" class="form-control" value="<?php echo $id_kategori; ?>"><small class="form-text text-muted">Masukkan Id Kategori</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masukkan Jumlah permintaan</label></div>
                                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="jumlah_permintaan" placeholder="Jumlah permintaan" class="form-control" value="<?php echo $jumlah_permintaan; ?>"><small class="form-text text-muted">Masukkan Jumlah permintaan</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masukkan Status</label></div>
                                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="status" placeholder="Status" class="form-control" value="<?php echo $status; ?>"><small class="form-text text-muted">Masukkan Status</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masukkan Jumlah yang dikeluarkan</label></div>
                                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="jumlah_dikeluarkan" placeholder="Jumlah ynag Dikeluarkan" class="form-control" value="<?php echo $jumlah_dikeluarkan; ?>"><small class="form-text text-muted">Masukkan Jumlah yang dikeluarkan</small></div>
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
            include 'footer_admin.php'
        ?>
</body>
</html>
