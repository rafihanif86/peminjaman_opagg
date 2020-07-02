<?php 
	include "connection.php";

    $id_kat = $name_kat = $edit = null;
    
    if(isset($_GET['edit']) and isset($_GET['id_kat'])){
        $edit=$_GET['edit'];
        $id_kat = $_GET['id_kat'];
        $result=mysqli_query("SELECT * FROM kategori WHERE id_kat = $id_kat ");
        while ($row1=mysqli_fetch_array($result)){
            $name_kat = $row1["name_kat"];
        }
    }

    if(isset($_GET['id_kat']) and isset($_GET['status']) and isset($_GET['name_kat'])){
        $id_kat = $_GET['id_kat'];
        $name_kat = $_GET['name_kat'];
    }

    if(isset($_POST["reset"])){
        $id_kat = $_POST["id_kat"];
        $name_kat=$_POST["name_kat"];

        if($id_kat != null){
            echo "
            <script>
                if (confirm('Do you want clean this form?')) {
                    location.replace('biodata_form.php');
                } else {
                    location.replace('biodata_form.php?edit=true&id_kat=$id_kat');
                }
            </script>";
        }else{
            echo "
            <script>
                if (confirm('Do you want clean this form?')) {
                    location.replace('biodata_form.php');
                } else {
                    location.replace('biodata_form.php?id_kat=$id_kat&status=$status&name_kat=$name_kat');
                }
            </script>";
        }
        
    }

    if(isset($_POST["submit"])){
        $id_kat=$_POST["id_kat"];
        $name_kat=$_POST["name_kat"];
        $edit=$_POST['edit'];

        if($edit != true){
            if(($id_kat and $status and $name_kat) != null){
                $query="INSERT INTO kategori (id_kat,name_kat) VALUES ('".$id_kat."','".$name_kat."');";
                $sql_insert1 = mysqli_query($conn,$query);
                echo "<script>alert('Data Berhasil Ditambahkan')
                location.replace('index.php')</script>";
            }else{
                echo "<script>alert('Ada data yang kosong')</script>";
            }
        }else{
            $query="UPDATE kategori set id_kat = '$id_kat', name_kat = '$name_kat'where id_kat = $id_kat;";
            $sql_insert1 = mysqli_query($conn,$query);
            echo "<script>alert('Data Berhasil Diubah')
                location.replace('index.php')</script>";
        }
    }

    if(isset($_POST["reset"])){
       $id_kat = $name_kat =  $edit = null;
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
                                <h1>Form Kategori</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="dashboard_admin.php">Dashboard</a></li>
                                    <li><a href="#">Forms</a></li>
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
                                <div class="card-body card-block">
                                <form action="form_kategori.php" method="post" name="frm" enctype="multipart/form-data" class="form-horizontal">
                                        
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Masukkan Nama Kategori Baru</label></div>
                                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="name_kat" placeholder="Kategori" class="form-control" value="<?php echo $name_kat; ?>"><small class="form-text text-muted">Masukkan Nama Kategori</small></div>
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
