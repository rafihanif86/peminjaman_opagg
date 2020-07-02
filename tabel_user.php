<?php 
    include "connection.php";
    include "header_admin.php";

    $cari;
    $query="SELECT * FROM user;"; //query vendor

    if(isset($_GET["search"])){
        $cari=$_GET["text_search"];
        $query="SELECT * FROM user WHERE `id_user` LIKE '%$cari%' OR `nama_user` LIKE '%$cari%' OR 'username' LIKE '%$cari%' OR 'password' LIKE '%$cari%' OR 'nia' LIKE '%$cari%' OR 'posisi' LIKE '%$cari%';";
    }
    
    $result=mysqli_query($conn,$query);

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
                                            <th>Nama User</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Nomor Induk Anggota</th>
                                            <th>Posisi</th>
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
                                            <td><?php echo $row1["nama_user"]; ?></td>
                                            <td><?php echo $row1["username"]; ?></td>
                                            <td><?php echo $row1["password"]; ?></td>
                                            <td><?php echo $row1["nia"]; ?></td>
                                            <td><?php echo $row1["posisi"]; ?></td>
                                            <td> 
                                            <div class="btn btn-outline-primary btn-sm"><a  href="vendor_form.php?edit=true&id_user=<?php echo $row1["id_user"];?>"> <i class="fas fa-book-open fa-2x"></i> </a></div>
                                                <div class="btn btn-outline-primary btn-sm"><a  href="vendor_form.php?edit=true&id_user=<?php echo $row1["id_user"];?>"> <i class='fa fa-pencil fa-2x'> </i> </a></div>
                                                <div class="btn btn-outline-danger btn-sm"><a  href="delete_user.php?id_user=<?php echo $row1["id_user"];?>"> <i class='fa fa-trash-o fa-2x'> </i> </a></div>
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
