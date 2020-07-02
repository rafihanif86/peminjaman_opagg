<?php 
    include "connection.php";
    $halaman = "alat";
    include "header_admin.php";

    $nama_kategori = "";
    $query="SELECT j.*, k.nama_kat FROM jenis_alat J, kategori k where j.id_kat = k.id_kat;";
    
    if(isset($_GET['id_kat'])){
        $id_kat = $_GET['id_kat'];
        $res=mysqli_query($conn,"SELECT * FROM kategori where id_kat = '$id_kat';");
        while ($row=mysqli_fetch_array($res)){
            $nama_kategori = $row["nama_kat"];
        }
        $query="SELECT j.*, k.nama_kat FROM jenis_alat J, kategori k where j.id_kat = k.id_kat and k.id_kat = $id_kat;"; 

    }

    $result=mysqli_query($conn,$query);
?>
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Tabel Jenis Alat</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Tabel Jenis Alat</li>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Data Jenis Alat
                            <?php if($nama_kategori != ""){echo " | ".$nama_kategori;}?></strong>
                        <a href="form_jenis_alat.php" class="btn btn-primary btn-md active float-right" role="button"
                            aria-pressed="true">Tambah Jenis Alat</a>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table border-0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                        $i = 0;
                                        $jumlah = 0;
                                        $jumlah_kategori = mysqli_num_rows($result);
                                        while ($row1=mysqli_fetch_array($result)){
                                    ?>
                                    <td>
                                        <div class="row" style="margin: auto;">
                                            <div class="col-md-12">
                                                <div class="card" style="max-width: 15rem; max-height: 30rem">
                                                    <img src="images/<?php if($row1["foto_jenis_alat"] == "" || $row1["foto_jenis_alat"]  == "null"){echo "no_image.png";}else{echo $row1["foto_jenis_alat"];}?>"
                                                        class="card-img-top" alt="..." style="max-height: 15rem">
                                                    <div class="card-body">
                                                        <a href="tabel_alat.php?id_jenis_alat=<?php echo $row1["id_jenis_alat"];?>" class="text-dark">
                                                            <h5 class="card-title"> <?php echo $row1["nama_jenis_alat"]; ?></h5>
                                                        </a>
                                                        <small
                                                            class="text-secondary"><?php echo $row1["nama_kat"]; ?></small>
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col col-md-6">
                                                                <a href="form_jenis_alat.php?edit=true&id_jenis_alat=<?php echo $row1["id_jenis_alat"];?>"
                                                                    class="btn btn-primary btn-sm btn-block">
                                                                    <i class='fa fa-pencil fa-1x'> </i> </a>
                                                            </div>
                                                            <div class="col col-md-6">
                                                                <a href="delete_jenis_alat.php?id_jenis_alat=<?php echo $row1["id_jenis_alat"];?>"
                                                                    class="btn btn-danger btn-sm btn-block">
                                                                    <i class='fa fa-trash-o fa-1x'> </i> </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <?php
                                            $i++;
                                            $jumlah++;
                                            if($i >= 4){
                                                $i = 0;
                                                echo '</tr><tr>';
                                            }
                                            if($jumlah == $jumlah_kategori){
                                                $kurang = 4 - ($jumlah_kategori % 4);
                                                for($a = 0; $a < $kurang; $a++){
                                                    echo "<td></td>";
                                                }
                                            }
                                        } 
                                    ?>
                                </tr>
                            </tbody>
                        </table>
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