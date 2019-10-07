<?php 
	include "connection.php";

    $id_check = $tgl_checklist = $kondisi = $id_alat = $keterangan = $id_user = $dipinjam =  $edit  = $id_detail = null;
    
    if(isset($_GET['edit']) and isset($_GET['id_check'])){
        $edit=$_GET['edit'];
        $id_check = $_GET['id_check'];
        $result=mysqli_query("SELECT * FROM checklist_record WHERE id_check = $id_check ");
        while ($row1=mysqli_fetch_array($result)){
            $tgl_checklist = $row1["tgl_checklist"];
            $id_alat = $row1["id_alat"];
            $kondisi = $row1["kondisi"];
            $keterangan= $row1["keterangan"];
            $id_user= $row1["id_user"];
            $dipinjam= $row1["dipinjam"];
            $id_detail= $_row1["id_detail"];
        }
    }

    if(isset($_GET['tgl_checklist']) and isset($_GET['kondisi']) and isset($_GET['id_alat'])){
        $tgl_checklist = $_GET['tgl_checklist'];
        $id_alat = $_GET['id_alat'];
        $kondisi = $_GET['kondisi'];
        $keterangan= $_GET["keterangan"];
        $id_user= $_GET["id_user"];
        $dipinjam= $_GET["dipinjam"];
        $id_detail= $_GET["id_detail"];
    }

    if(isset($_POST["reset"])){
        $id_check = $_POST["id_check"];
        $tgl_checklist=$_POST["tgl_checklist"];
        $id_alat=$_POST["id_alat"];
        $kondisi = $_POST["kondisi"];
        $keterangan= $_POST["keterangan"];
        $id_user= $_POST["id_user"];
        $dipinjam= $_POST["dipinjam"];
        $id_detail= $_POST["id_detail"];

        if($id_check != null){
            echo "
            <script>
                if (confirm('Do you want clean this form?')) {
                    location.replace('biodata_form.php');
                } else {
                    location.replace('biodata_form.php?edit=true&id_check=$id_check');
                }
            </script>";
        }else{
            echo "
            <script>
                if (confirm('Do you want clean this form?')) {
                    location.replace('biodata_form.php');
                } else {
                    location.replace('biodata_form.php?tgl_checklist=$tgl_checklist&kondisi=$kondisi&id_alat=$id_alat');
                }
            </script>";
        }
        
    }

    if(isset($_POST["submit"])){
        $tgl_checklist=$_POST["tgl_checklist"];
        $id_alat=$_POST["id_alat"];
        $kondisi = $_POST["kondisi"];
        $keterangan = $_POST["keterangan"];
        $dipinjam= $_POST["dipinjam"];
        $id_user= $_POST["id_user"];
        $id_detail= $_POST["id_detail"];
        $edit=$_POST['edit'];

        if($edit != true){
            if(($tgl_checklist and $kondisi and $id_alat) != null){
                $query1="INSERT INTO checklist_record (tgl_checklist,kondisi,id_alat,keterangan,dipinjam,id_user,id_detail) VALUES ('".$tgl_checklist."','".$kondisi."','".$id_alat."','".$keterangan."','".$dipinjam."','".$id_user."','".$id_detail."');";
                $sql_insert1 = mysqli_query($query1,$conn);
                echo "<script>alert('Data Berhasil Ditambahkan')
                location.replace('index.php')</script>";
            }else{
                echo "<script>alert('Ada data yang kosong')</script>";
            }
        }else{
            $query1="UPDATE checklist_record set tgl_checklist = '$tgl_checklist',kondisi = '$kondisi', id_alat = '$id_alat', keterangan = '$keterangan', dipinjam = '$dipinjam', id_user = '$id_user', id_detail = '$id_detail' where id_check = $id_check;";
            $sql_insert1 = mysqli_query($query1,$conn);
            echo "<script>alert('Data Berhasil Diubah')
                location.replace('index.php')</script>";
        }
    }

    if(isset($_POST["reset"])){
       $tgl_checklist = $kondisi = $id_alat = $keterangan = $id_user = $dipinjam =  $edit  = $id_detail = null;
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
                                <h1>Form Checklist</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="dashboard_admin.php">Dashboard</a></li>
                                    <li><a href="#">Forms</a></li>
                                    <li class="active">Form Checklist</li>
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
                                    <strong>Isikan Data Checklist</strong>
                                </div>
                                <div class="card-body card-block">
                                <form action="form_checklist.php" method="post" name="frm" encid_alat="multipart/form-data" class="form-horizontal">
                                        
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masukkan Tanggal Checklist</label></div>
                                            <div class="col-12 col-md-9"><input id_alat="text" id="text-input" name="tgl_checklist" placeholder="Tanggal Checklist" class="form-control" value="<?php echo $tgl_checklist; ?>"><small class="form-text text-muted">Masukkan Tanggal Checklist</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masukkan Id Alat</label></div>
                                            <div class="col-12 col-md-9"><input id_alat="text" id="text-input" name="id_check" placeholder="Id Alat" class="form-control" value="<?php echo $id_check; ?>"><small class="form-text text-muted">Masukkan Id Alat</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masukkan Kondisi Alat</label></div>
                                            <div class="col-12 col-md-9"><input id_alat="text" id="text-input" name="kondisi" placeholder="Kondisi" class="form-control" value="<?php echo $kondisi; ?>"><small class="form-text text-muted">Masukkan Kondisi Alat</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masukkan Keterangan Alat</label></div>
                                            <div class="col-12 col-md-9"><input id_alat="text" id="text-input" name="keterangan" placeholder="Keterangan" class="form-control" value="<?php echo $keterangan; ?>"><small class="form-text text-muted">Masukkan Keterangan Alat</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masukkan Id User</label></div>
                                            <div class="col-12 col-md-9"><input id_alat="text" id="text-input" name="id_user" placeholder="Id User" class="form-control" value="<?php echo $id_user; ?>"><small class="form-text text-muted">Masukkan Id User</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masukkan Dipinjam (?)</label></div>
                                            <div class="col-12 col-md-9"><input id_alat="text" id="text-input" name="dipinjam" placeholder="Dipinjam" class="form-control" value="<?php echo $dipinjam; ?>"><small class="form-text text-muted">Masukkan Keterangan Alatn</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masukkan Id Detail</label></div>
                                            <div class="col-12 col-md-9"><input id_alat="text" id="text-input" name="id_detail" placeholder="Id Detail" class="form-control" value="<?php echo $id_detail; ?>"><small class="form-text text-muted">Masukkan Id Detail</small></div>
                                        </div>
                                                                                                                           
                                    </div>
                                    <div class="card-footer">
                                        <button id_alat="submit" class="btn btn-primary btn-sm" name="submit">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button id_alat="reset" class="btn btn-danger btn-sm" name="reset">
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
