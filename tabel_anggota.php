<?php 
    include "connection.php";
    $halaman = "lain";
    include "header_admin.php";

    $cari;
    $query="SELECT * FROM user;"; //query vendor
    $result=mysqli_query($conn,$query);

?>
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Data Anggota</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Data Anggota</li>
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
                        <a href="form_anggota.php" class="btn btn-primary btn-md active float-right" role="button"
                            aria-pressed="true">Tambah Anggota</a>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        $i = 0;
                                        while ($row1=mysqli_fetch_array($result)){
                                            $i++;
                                    ?>
                                <tr>
                                    <td>
                                        <div class="card mb-12">
                                            <div class="row no-gutters">
                                                <div class="col-md-2">
                                                    <img src="images/<?php if($row1["foto_anggota"] != "" || !empty($row1["foto_anggota"]) || $row1["foto_anggota"] != null ){echo $row1["foto_anggota"];}else{echo "user-icon.png";}?>"
                                                        class="card-img" alt="..."
                                                        style="max-height: 120px; max-width: 120px; margin: 15px; float:none;">
                                                </div>
                                                <div class="col-md-10 ">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col col-md-5 border-left">
                                                                <div class="card-title">
                                                                    <a class="text-dark"
                                                                        href="tampil_anggota.php?nia=<?php echo $row1["nia"];?>">
                                                                        <h6>NIA.<?php echo $row1["nia"]; ?>-GG</h6>
                                                                        <h5> <?php echo $row1["nama_user"]; ?></h5>
                                                                    </a>
                                                                    <?php echo $row1["status_anggota"]; ?><br />
                                                                    <?php if($row1["login_status"] == "login"){$pesan =  "Online";$style = "text-warning";}else if($row1["login_status"] == "logout"){$pesan = "Offline"; $style = "text-secondary";} ?>
                                                                    <small
                                                                        class="<?php echo $style; ?>"><?php echo $pesan; ?></small>
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-7 border-left">
                                                                <div class="card-text">
                                                                    <b>Email : </b>
                                                                    <?php echo $row1["email"]; ?><br />
                                                                </div>
                                                                <div class="card-text">
                                                                    <b>Telepon : </b>
                                                                    <?php if($row1["no_telp"] != ""){
                                                                        $noPottong = substr($row1["no_telp"],1);?>
                                                                    <a href="https://api.whatsapp.com/send?phone=<?php echo "+62" .$noPottong; ?>&text=Halo"
                                                                        target="_blank" class="text-dark">
                                                                        <?php echo $row1["no_telp"]; ?>
                                                                    </a>
                                                                    <?php } ?>
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
    include 'footer_admin.php'
?>