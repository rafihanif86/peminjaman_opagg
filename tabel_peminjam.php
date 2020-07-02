<?php 
    include 'connection.php';
    $halaman = "lain";
    include 'header_admin.php';

    $act = "";
    $judul = "";

    $judul = "Seluruh Data";
    $query="SELECT * FROM peminjam order by nama desc;";
    $result=mysqli_query($conn,$query);
?>
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Data Peminjam | <?php echo $judul; ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li>Data Peminjam</li>
                            <li class="active"><?php echo $judul; ?></li>
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
                        <strong class="card-title">List Data Peminjam</strong>
                        <a href="laporan_peminjaman.php?action=<?php echo $act;?>"
                            class="btn btn-outline-primary btn-sm float-right" role="button" aria-pressed="true"><i
                                class="fas fa-print fa-1x"></i> Laporan</a>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Instansi</th>
                                    <th width="80px"></th>
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
                                    <td><?php echo $row1["nik"]; ?></td>
                                    <td><?php echo $row1["nama"]; ?></td>
                                    <td><?php echo $row1["email"]; ?></td>
                                    <td><?php echo $row1["no_telepon"]; ?></td>
                                    <td><?php echo $row1["instansi"]; ?></td>
                                    <td>
                                        <a class="btn btn-outline-primary "
                                            href="form_peminjam.php?nik=<?php echo $row1["nik"];?>">
                                            <i class='fa fa-pencil fa-1x'> </i> </a>
                                        <a class="btn btn-outline-danger"
                                            href="delete_peminjam.php?nik=<?php echo $row1["nik"];?>">
                                            <i class='fa fa-trash-o fa-1x'> </i> </a>
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
    include 'footer_admin.php';

    if(isset($_GET['status'])){
        if($_GET['status'] == "berhasil"){
            echo "<script type='text/javascript'> window.onload = function(){ alert('Berhasil ditambahkan'); } </script>";
        }else if($_GET['status'] == "gagal"){
            echo "<script type='text/javascript'> window.onload = function(){ alert('Gagal ditambahkan'); } </script>";
        }else if($_GET['status'] == "berhasildihapus"){
            echo "<script type='text/javascript'> window.onload = function(){  alert('Berhasil dihapus'); } </script>";
        }else if($_GET['status'] == "gagaldihapus"){
            echo "<script type='text/javascript'> window.onload = function(){  alert('Gagal dihapus'); } </script>";
        }
    }
?>