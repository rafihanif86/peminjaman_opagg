<?php 
    $id_checklist_group = $id_detail_masuk = $id_jenis_alat = $jum_kat = $jumlah = $jumlah2 = $status = "";
    include "connection.php";

    if(isset($_POST["submit"])){
        $id_checklist_group    =   $_POST["id_checklist_group"];
        $jumlah_user = "";

        $query="SELECT COUNT(*) AS jumlah_user FROM USER WHERE login_status = 'login';";
        $sql=mysqli_query($conn,$query);
        while ($row=mysqli_fetch_array($sql)) {
            $jumlah_user =  $row['jumlah_user'];
        }

        $query1="SELECT count(*) as jumlah_user FROM alat AS a INNER JOIN checklist_record AS cr ON a.id_alat = cr.id_alat INNER JOIN kategori AS k ON k.id_jenis_alat = a.id_jenis_alat WHERE cr.kondisi != 'diputihkan' ORDER BY cr.tgl_checklist DESC;";
        $sql1=mysqli_query($conn,$query1);
        while ($row=mysqli_fetch_array($sql1)) {
            $jumlah_alat =  $row['jumlah_user'];
        }

        $jumlah_perorang = $jumlah_user / $jumlah_user;

        $query3="SELECT * FROM USER WHERE login_status = 'login';";
        $sql3=mysqli_query($conn,$query3);
        while ($row=mysqli_fetch_array($sql3)) {
            $id_user_arr .= ",". $row['id_user'];
        }

        $query1="SELECT * FROM alat AS a INNER JOIN checklist_record AS cr ON a.id_alat = cr.id_alat INNER JOIN kategori AS k ON k.id_jenis_alat = a.id_jenis_alat WHERE cr.kondisi != 'diputihkan' ORDER BY cr.tgl_checklist DESC;";
        $sql1=mysqli_query($conn,$query1);
        while ($row=mysqli_fetch_array($sql1)) {
            $id_alat_arr .= ", ". $row['id_alat'];
        }
        
        $query1="SELECT * FROM alat AS a INNER JOIN checklist_record AS cr ON a.id_alat = cr.id_alat INNER JOIN kategori AS k ON k.id_jenis_alat = a.id_jenis_alat WHERE cr.kondisi != 'diputihkan' ORDER BY cr.tgl_checklist DESC;";
        $sql1=mysqli_query($conn,$query1);
        while ($row=mysqli_fetch_array($sql1)) {
            $query1="INSERT INTO checklist_group set id_checklist_group = '$id_checklist_group', ";
            $sql1=mysqli_query($conn,$query1);
        }
            
    }
?>

<?php
        include 'header_admin.php';
    ?>

    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Checklist Group <?php echo $id_checklist_group; ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="dashboard_admin.php">Data Checklist Group</a></li>
                                <li><a href="form_peminjaman.php?edit=true&id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>">Form Peminjaman</a></li>
                                <li class="active">Mulai Checklist Group</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="animated fadeIn">

            <?php 
                $query1="SELECT *  FROM user WHERE login_status = 'login'";
                $result1=mysqli_query($conn,$query1) ;
            ?>
            <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong>Anggota Yang Login</strong>
                            </div>
                            <div class="card-body card-block">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Anggota</th>
                                            <th>NIA</th>
                                            <th>Posisi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 0;
                                            while ($row2=mysqli_fetch_array($result1)){
                                                $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row2["nama_user"]; ?></td>
                                            <td><?php echo $row2["nia"]; ?></td>
                                            <td><?php echo $row2["status_anggota"]; ?></td>
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

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong>Alat yang Belum dichecklist</strong>
                            </div>
                            <div class="card-body card-block">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Foto Alat</th>
                                            <th>No. Inventaris</th>
                                            <th>Nama Alat</th>
                                            <th>Kategori</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $query1="SELECT c.*, a.`id_alat`, a.`merk`, a.`type`, a.`foto_alat`, k.`nama_jenis_alat` FROM `checklist_record` C, Alat A, `kategori` K WHERE c.`id_checklist_group` = '$id_checklist_group' AND c.`id_alat` = a.`id_alat` AND a.`id_jenis_alat` = k.`id_jenis_alat`;";
                                            $result1=mysqli_query($conn,$query1);
                                            $i = 0;
                                            while ($row2=mysqli_fetch_array($result1)){
                                                $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td>
                                                <?php if($row2["foto_alat"] != "" || !empty($row2["foto_alat"] || $row2["foto_alat"] != null)){ ?>
                                                    <div class="text-center">
                                                        <img src="images/<?php echo $row2["foto_alat"];?>" width="120px" height="120px" 
                                                            class="img-responsive rounded" alt="">
                                                    </div>
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $row2["id_alat"]; ?></td>
                                            <td><?php echo $row2["merk"]." ".$row2["merk"]; ?></td>
                                            <td><?php echo $row2["nama_jenis_alat"]; ?></td>
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

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Mulai Checklist <?php echo $id_checklist_group; ?></strong>
                        </div>
                        <form action="form_checklist_group.php" method="post" name="frm" enctype="multipart/form-data" class="form-horizontal">
                            <div class="card-body card-block">
                                <div class="row form-group" hidden>
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Id Checklist Group</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="number" id="email-input" name="id_checklist_group" placeholder="Masukkan jumlah alat yang disetujui" 
                                            class="form-control" value="<?php echo $id_checklist_group; ?>">
                                        <small class="help-block form-text">Masukkan id Checklist group</small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Mulai Checklist Group</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <button type="submit" class="btn btn-primary btn-sm" name="submit">
                                            <i class="fa fa-dot-circle-o"></i> Mulai
                                        </button>
                                        <small class="form-text text-muted">Click Untuk Checklist Group</small>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Alat yang Telah dichecklist</strong>
                        </div>
                        <div class="card-body card-block">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Foto Alat</th>
                                        <th>No. Inventaris</th>
                                        <th>Nama Alat</th>
                                        <th>Kategori</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query1="SELECT c.*, a.`id_alat`, a.`merk`, a.`type`, a.`foto_alat`, k.`nama_jenis_alat` FROM `checklist_record` C, Alat A, `kategori` K WHERE c.`id_checklist_group` = '$id_checklist_group' AND c.`id_alat` = a.`id_alat` AND a.`id_jenis_alat` = k.`id_jenis_alat`;";
                                        $result1=mysqli_query($conn,$query1) ;
                                        $i = 0;
                                        while ($row2=mysqli_fetch_array($result1)){
                                            $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <?php if($row2["foto_alat"] != "" || !empty($row2["foto_alat"] || $row2["foto_alat"] != null)){ ?>
                                                <div class="text-center">
                                                    <img src="images/<?php echo $row2["foto_alat"];?>" width="120px" height="120px" 
                                                        class="img-responsive rounded" alt="">
                                                </div>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $row2["id_alat"]; ?></td>
                                        <td><?php echo $row2["merk"]." ".$row2["merk"]; ?></td>
                                        <td><?php echo $row2["nama_jenis_alat"]; ?></td>
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
<?php include 'footer_admin.php'; ?>