<?php 
    include "connection.php";
    include "header_admin.php";

    $cari;
    $query="SELECT * FROM peminjaman_masuk;"; //query vendor

    if(isset($_GET["search"])){
        $cari=$_GET["text_search"];
        $query="SELECT * FROM peminjaman_masuk WHERE `id_peminjaman_masuk` LIKE '%$cari%' OR `nama_instansi` LIKE '%$cari%' OR 'email_peminjam' LIKE '%$cari%',OR 'nama_kegiatan' LIKE '%$cari%'OR 'no_wa' LIKE '%$cari%';";
    }
    
    $result=mysqli_query($query,$conn);

?>
<html>
    <?php
        include 'header_admin.php';
    ?>
        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Tabel Peminjaman</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="dashboard_admin.php">Dashboard</a></li>
                                    <li><a href="#">Tabel</a></li>
                                    <li class="active">Tabel Peminjaman</li>
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
                                <strong class="card-title">Data Tabel</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Instansi</th>
                                            <th>Email Peminjam</th>
                                            <th>Nama Kegiatan</th>
                                            <th>Tanggal Ambil</th>
                                            <th>Tanggal Kembali</th>
                                            <th>Nomor WhatsApp</th>
                                            <th>Status</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $i = 0;
                                        while ($row1=mysqli_fetch_array($result)){
                                            $i++;
                                    ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $row1["id_peminjaman_masuk"]; ?></td>
                                            <td><?php echo $row1["nama_instansi"]; ?></td>
                                            <td><?php echo $row1["nama_kegiatan"]; ?></td>
                                            <td><?php echo $row1["tgl_ambil"]; ?></td>
                                            <td><?php echo $row1["tgl_kembali"]; ?></td>
                                            <td><?php echo $row1["status"]; ?></td>
                                            <td> 
                                            <div class="btn btn-outline-primary btn-sm"><a  href="form_peminjaman.php?edit=true&id_peminjaman_masuk=<?php echo $row1["id_peminjaman_masuk"];?>"> <i class="fas fa-book-open fa-2x"></i> </a></div>
                                                <div class="btn btn-outline-primary btn-sm"><a  href="form_peminjaman.php?edit=true&id_peminjaman_masuk=<?php echo $row1["id_peminjaman_masuk"];?>"> <i class='fa fa-pencil fa-2x'> </i> </a></div>
                                                <div class="btn btn-outline-danger btn-sm"><a  href="delete_peminjaman.php?id_peminjaman_masuk=<?php echo $row1["id_peminjaman_masuk"];?>"> <i class='fa fa-trash-o fa-2x'> </i> </a></div>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                    ?>
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

</body>
</html>
