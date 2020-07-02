<?php 
	include "connection.php";

    $id_user = $nama_user = $password = $username = $nia = $posisi =  $edit = null;
    
    if(isset($_GET['edit']) and isset($_GET['id_user'])){
        $edit=$_GET['edit'];
        $id_user = $_GET['id_user'];
        $result=mysqli_query("SELECT * FROM user WHERE id_user = $id_user ");
        while ($row1=mysqli_fetch_array($result)){
            $nama_user = $row1["nama_user"];
            $username = $row1["username"];
            $password = $row1["password"];
            $nia= $row1["nia"];
            $posisi= $row1["posisi"];
        }
    }

    if(isset($_GET['nama_user']) and isset($_GET['password']) and isset($_GET['username'])){
        $nama_user = $_GET['nama_user'];
        $username = $_GET['username'];
        $password = $_GET['password'];
        $nia= $_GET["nia"];
        $posisi= $_GET["posisi"];

    }

    if(isset($_POST["reset"])){
        $id_user = $_POST["id_user"];
        $nama_user=$_POST["nama_user"];
        $username=$_POST["username"];
        $password = $_POST["password"];
        $nia= $_POST["nia"];
        $posisi= $_POST["posisi"];

        if($id_user != null){
            echo "
            <script>
                if (confirm('Do you want clean this form?')) {
                    location.replace('biodata_form.php');
                } else {
                    location.replace('biodata_form.php?edit=true&id_user=$id_user');
                }
            </script>";
        }else{
            echo "
            <script>
                if (confirm('Do you want clean this form?')) {
                    location.replace('biodata_form.php');
                } else {
                    location.replace('biodata_form.php?nama_user=$nama_user&password=$password&username=$username');
                }
            </script>";
        }
        
    }

    if(isset($_POST["submit"])){
        $nama_user=$_POST["nama_user"];
        $username=$_POST["username"];
        $password = $_POST["password"];
        $nia = $_POST["nia"];
        $posisi= $_POST["posisi"];
        $edit=$_POST['edit'];

        if($edit != true){
            if(($nama_user and $password and $username) != null){
                $query="INSERT INTO user (nama_user,password,username,nia,posisi) VALUES ('".$nama_user."','".$password."','".$username."','".$nia."','".$posisi."');";
                $sql_insert1 = mysqli_query($conn,$query);
                echo "<script>alert('Data Berhasil Ditambahkan')
                location.replace('index.php')</script>";
            }else{
                echo "<script>alert('Ada data yang kosong')</script>";
            }
        }else{
            $query="UPDATE user set nama_user = '$nama_user',password = '$password', username = '$username', nia = '$nia', posisi = '$posisi' where id_user = $id_user;";
            $sql_insert1 = mysqli_query($conn,$query);
            echo "<script>alert('Data Berhasil Diubah')
                location.replace('index.php')</script>";
        }
    }

    if(isset($_POST["reset"])){
        $nama_user = $username = $password = null;
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
                                <h1>Form User</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="dashboard_admin.php">Dashboard</a></li>
                                    <li><a href="#">Forms</a></li>
                                    <li class="active">Form User</li>
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
                                    <strong>Isikan Data User</strong>
                                </div>
                                <div class="card-body card-block">
                                <form action="form_user.php" method="post" name="frm" encusername="multipart/form-data" class="form-horizontal">
                                        
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masukkan Nama User</label></div>
                                            <div class="col-12 col-md-9"><input username="text" id="text-input" name="nama_user" placeholder="Nama User" class="form-control" value="<?php echo $nama_user; ?>"><small class="form-text text-muted">Masukkan Nama User</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masukkan Username</label></div>
                                            <div class="col-12 col-md-9"><input username="text" id="text-input" name="username" placeholder="Username" class="form-control" value="<?php echo $username; ?>"><small class="form-text text-muted">Masukkan Username    </small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masukkan Password</label></div>
                                            <div class="col-12 col-md-9"><input username="password" id="passowrd-input" name="password" placeholder="Password" class="form-control" value="<?php echo $password; ?>"><small class="form-text text-muted">Masukkan Password</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masukkan Nomor Induk Anggota</label></div>
                                            <div class="col-12 col-md-9"><input username="text" id="text-input" name="nia" placeholder="NIA" class="form-control" value="<?php echo $nia; ?>"><small class="form-text text-muted">Masukkan Nomor Induk Anggota</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masukkan Posisi User</label></div>
                                            <div class="col-12 col-md-9"><input username="text" id="text-input" name="posisi" placeholder="Posisi User" class="form-control" value="<?php echo $posisi; ?>"><small class="form-text text-muted">Masukkan Posisi User</small></div>
                                        </div>
                                                                                   
                                    </div>
                                    <div class="card-footer">
                                        <button username="submit" class="btn btn-primary btn-sm" name="submit">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button username="reset" class="btn btn-danger btn-sm" name="reset">
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
