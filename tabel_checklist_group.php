<?php 
    include "connection.php";
    $halaman = "checklist";
    include "header_admin.php";

    $hidden_button = "";
    $res=mysqli_query($conn,"SELECT * FROM `checklist_group` WHERE `status` = 'waiting' || `status` = 'onprocess';") ;
    $jumlah_berjalan = mysqli_num_rows($res);
    if($jumlah_berjalan > 0){
        while ($row=mysqli_fetch_array($res)) {
            $koordinator =  $row['koordinator'];
        }
        if($nia == $koordinator){
            echo "<script> location.replace('form_checklist_group.php')</script>";
        }else{
            echo "<script> location.replace('form_checklist_onprocess.php')</script>";
        }
        $hidden_button = "hidden";
    }

?>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Tabel Checklist Group</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Tabel Checklist Group</li>
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
                        <div class="row">
                            <div class="col col-md-6">
                                <strong class="card-title">Data Tabel</strong>
                            </div>
                            <div class="col col-md-6">
                                <form action="tabel_checklist_group.php" method="post" name="frm"
                                    enctype="multipart/form-data">
                                    <button type="submit" class="btn btn-primary btn-sm float-right" name="mulai"
                                        <?php echo $hidden_button;?>>
                                        <i class="fa fa-dot-circle-o"></i> Mulai Checklist Group
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-border">
                            <thead>
                                <tr>
                                    <th></th>
                            </thead>
                            <tbody>
                                <?php
                                        $query="SELECT C.*, u.nama_user FROM `checklist_group` C, user U where c.koordinator = u.nia GROUP BY `id_checklist_group`;"; 
                                        $result=mysqli_query($conn,$query);
                                        $i = 0;
                                        while ($row1=mysqli_fetch_array($result)){
                                            $i++;
                                            $id_checklist_group = "";
                                    ?>
                                <tr>
                                    <td>
                                        <div class="card mb-12">
                                            <div class="row no-gutters">
                                                <div class="col-md-12 ">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col col-md-5 ">
                                                                <div class="card-title">
                                                                    <br />
                                                                    <h5><?php echo $row1["tgl_checklist_group"]; ?></h5>
                                                                    Kordinator:<br />
                                                                    <a class="text-dark" target="blank"
                                                                        href="tampil_peminjaman.php?id_peminjaman_masuk=<?php echo $row1["id_peminjaman_masuk"];?>">
                                                                        <h3> <?php echo $row1["nama_user"]; ?></h3>
                                                                    </a>
                                                                    Resume:<br />
                                                                    <?php echo $row1["resume"]; ?>
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-7 border-left">
                                                                <div class="card-text">
                                                                    <b>Lain - lain : </b><br />
                                                                    <table class="table table-sm">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col" width="80%"></th>
                                                                                <th scope="col" width="15%"></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Petugas Mengikuti</td>
                                                                                <td>
                                                                                    <?php
                                                                                        if(isset($id_checklist_group)){
                                                                                            $jumlah_peserta = "";
                                                                                            $result1=mysqli_query($conn,"SELECT COUNT(*) AS jumlah FROM `checklist_group_item` WHERE `id_checklist_group` = '$id_checklist_group' AND GROUP BY `petugas_check`;");
                                                                                            while ($row2=mysqli_fetch_array($result1)){
                                                                                                $jumlah_peserta = $row2["jumlah"];
                                                                                            }
                                                                                            echo $jumlah_peserta;
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Alat dichecklist</td>
                                                                                <td>
                                                                                    <?php
                                                                                    if(isset($row1["id_checklist_group"])){
                                                                                        $jumlah_alat = "";
                                                                                        $result1=mysqli_query($conn,"SELECT COUNT(*) AS jumlah FROM `checklist_group_item` WHERE `id_checklist_group` = '$id_checklist_group' AND GROUP BY `id_alat`;");
                                                                                        while ($row2=mysqli_fetch_array($result1)){
                                                                                            $jumlah_alat = $row2["jumlah"];
                                                                                        }
                                                                                        echo $jumlah_alat;
                                                                                    }
                                                                                ?>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

    $tgl_hari_ini = date('Y-m-d');

    if(isset($_POST["mulai"])){
        $query1="INSERT INTO checklist_group (koordinator,tgl_checklist_group,status) VALUES ('".$nia."','".$tgl_hari_ini."','waiting');";
            $sql_insert1 = mysqli_query($conn,$query1);
            if($sql_insert1){
                echo "<script> location.replace('form_checklist_group.php')</script>";
            }else{
                echo "<script type='text/javascript'> window.onload = function(){  alert('Gagal memulai checklist group'); } </script>";
            }
    }
?>