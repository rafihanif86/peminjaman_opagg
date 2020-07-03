<?php 
    include "connection.php";
    $halaman = "alat";
    include "header_admin.php";

    $cari;
    $query="SELECT * FROM kategori;"; //query vendor
    $result=mysqli_query($conn,$query);

?>
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Tabel Kategori</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Tabel Kategori</li>
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
                        <strong class="card-title">Data Kategori</strong>
                        <a href="form_kategori.php" class="btn btn-primary btn-md active float-right" role="button"
                            aria-pressed="true">Tambah Kategori</a>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table border-0">
                            <thead>
                                <tr>
                                    <th style="size : 25%;"></th>
                                    <th style="size : 25%;"></th>
                                    <th style="size : 25%;"></th>
                                    <th style="size : 25%;"></th>
                            </thead>
                            <tbody>

                                <tr>

                                    <?php
                                        $i = 0;
                                        $jumlah = 0;
                                        $jumlah_kategori = mysqli_num_rows($result);
                                        while ($row1=mysqli_fetch_array($result)){
                                    ?>
                                    <td style="size : 25%;">
                                        <div class="row" style="margin: auto;">
                                            <div class="col-md-12">
                                                <div class="card" style="max-width: 15rem; max-height: 30rem">
                                                    <img src="images/<?php if($row1["foto_kat"] == "" || $row1["foto_kat"]  == "null"){echo "no_image.png";}else{echo $row1["foto_kat"];}?>"
                                                        class="card-img-top" alt="..." style="max-height: 15rem">
                                                    <div class="card-body" style="height: 5rem">
                                                        <a href="tabel_jenis_alat.php?id_kat=<?php echo $row1["id_kat"];?>" class="text-dark"> 
                                                            <h5 class="card-title"> <?php echo $row1["nama_kat"]; ?></h5></a>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col col-md-6">
                                                                <a href="form_kategori.php?edit=true&id_kat=<?php echo $row1["id_kat"];?>"
                                                                    class="btn btn-primary btn-sm btn-block">
                                                                    <i class='fa fa-pencil fa-1x'> </i> </a>
                                                            </div>
                                                            <div class="col col-md-6">
                                                                <a href="delete_kategori.php?id_kat=<?php echo $row1["id_kat"];?>"
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
    include 'footer_admin.php';

    if(isset($_GET['status'])){
        if($_GET['status'] == "berhasil"){
            echo "<script type='text/javascript'> window.onload = function(){ alert('Berhasil ditambahkan'); } </script>";
        }else if($_GET['status'] == "gagal"){
            echo "<script type='text/javascript'> window.onload = function(){ alert('Gagal ditambahkan'); } </script>";
        }else if($_GET['status'] == "bigsize"){
            echo "<script type='text/javascript'> window.onload = function(){  alert('File gambar memiliki ukuran terlalu besar '); } </script>";
        }else if($_GET['status'] == "filetype"){
            echo "<script type='text/javascript'> window.onload = function(){  alert('File gambar memiliki tipe file tidak diijinkan'); } </script>";
        }else if($_GET['status'] == "berhasildihapus"){
            echo "<script type='text/javascript'> window.onload = function(){  alert('Lampiran berhasil dihapus'); } </script>";
        }else if($_GET['status'] == "gagaldihapus"){
            echo "<script type='text/javascript'> window.onload = function(){  alert('Lampiran gagal dihapus'); } </script>";
        }
    }
?>