<?php 
    include "connection.php";
    include "header_admin.php";

    $cari;
    $query="SELECT * FROM checklist_record;"; //query vendor

    if(isset($_GET["search"])){
        $cari=$_GET["text_search"];
        $query="SELECT * FROM checklist_record WHERE `id_check` LIKE '%$cari%' OR `tgl_checklist` LIKE '%$cari%' OR 'id_alat' LIKE '%$cari%',OR 'id_user' LIKE '%$cari%';";
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
                                <h1>Tabel Checklist</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="dashboard_admin.php">Dashboard</a></li>
                                    <li><a href="#">Tabel</a></li>
                                    <li class="active">Tabel Checklist</li>
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
                                            <th>Tanggal Checklist</th>
                                            <th>Id Alat</th>
                                            <th>Kondisi Alat</th>
                                            <th>Keterangan Alat</th>
                                            <th>User</th>
                                            <th>Dipinjam</th>
                                            <th>Detail Alat</th>
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
                                            <td><?php echo $row1["tgl_checklist"]; ?></td>
                                            <td><?php echo $row1["id_alat"]; ?></td>
                                            <td><?php echo $row1["kondisi"]; ?></td>
                                            <td><?php echo $row1["keterangan"]; ?></td>
                                            <td><?php echo $row1["id_user"]; ?></td>
                                            <td><?php echo $row1["dipinjam"]; ?></td>
                                            <td><?php echo $row1["id_detail"]; ?></td>
                                            <td> 
                                            <div class="btn btn-outline-primary btn-sm"><a  href="form_checklist.php?edit=true&id_check=<?php echo $row1["id_check"];?>"> <i class="fas fa-book-open fa-2x"></i> </a></div>
                                                <div class="btn btn-outline-primary btn-sm"><a  href="form_checklist.php?edit=true&id_check=<?php echo $row1["id_check"];?>"> <i class='fa fa-pencil fa-2x'> </i> </a></div>
                                                <div class="btn btn-outline-danger btn-sm"><a  href="delete_checklist.php?id_check=<?php echo $row1["id_check"];?>"> <i class='fa fa-trash-o fa-2x'> </i> </a></div>
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
