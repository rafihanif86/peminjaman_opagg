<?php 
    include "connection.php";
    $halaman = "peminjaman";
    include 'header_admin.php';
    include 'tgl_indo.php';

    $id_peminjaman_masuk = $id_detail_masuk = $id_jenis_alat = $jum_kat = $jumlah = $jumlah2 = $status = "";
    $hidden_tersedia = "hidden";
    $disabeled_jenis_alat = "";
    $hidden_input_kat = "hidden";
    $tgl_ambil = "";
    $tgl_kembali ="";
    $hidJum = "hidden";
    $hidJum_tabel = "hidden";
    $hidden_list = "hidden";
    $jumlah_diminta = "";
    $jumlah_max = 0;
    $jumlah_alat_tersedia = "0";

    if(isset($_GET['tambah'])){
        $hidden_list = "";
    }

    if(isset($_GET['id_peminjaman_masuk'])){
        $id_peminjaman_masuk = $_GET['id_peminjaman_masuk'];
    }else if(isset($_POST['id_peminjaman_masuk'])){
        $id_peminjaman_masuk = $_POST['id_peminjaman_masuk'];
    }

    if(isset($_GET['id_jenis_alat'])){
        $id_jenis_alat = $_GET['id_jenis_alat'];
    }else if(isset($_POST['id_jenis_alat'])){
        $id_jenis_alat = $_POST['id_jenis_alat'];
    }

    if($id_peminjaman_masuk != ""){
        $resultChecklist=mysqli_query($conn,"SELECT status, tgl_ambil, tgl_kembali FROM peminjaman_masuk where id_peminjaman_masuk = '$id_peminjaman_masuk'") ;
        while ($row6=mysqli_fetch_array($resultChecklist)){
            $status = $row6["status"];
            $tgl_ambil = $row6["tgl_ambil"];
            $tgl_kembali = $row6["tgl_kembali"];
        }

        if($status != 'baru'){
            $hidJum_tabel = "";
        }

        if(isset($_GET['update']) && $status == "baru"){
            $que2="UPDATE peminjaman_masuk SET status = 'disetujui', petugas_menyetujui = '$nia' WHERE id_peminjaman_masuk = '$id_peminjaman_masuk';";
            $sql_ins = mysqli_query($conn,$que2);
        }
    }

    $query1="SELECT D.*, K.nama_jenis_alat, K.foto_jenis_alat  FROM detail_peminjaman_masuk D,jenis_alat K WHERE K.id_jenis_alat = D.id_jenis_alat AND id_peminjaman_masuk = '$id_peminjaman_masuk' ORDER BY D.`id_detail_masuk`";
    $result1=mysqli_query($conn,$query1) ;

    
    
    if(isset($_GET['edit']) and isset($_GET['id_peminjaman_masuk']) and isset($_GET['id_detail_masuk'])){
        $edit                   =   $_GET['edit'];
        $id_detail_masuk        =   $_GET['id_detail_masuk'];
        $queryAlatEdit = "SELECT * FROM detail_peminjaman_masuk WHERE `id_detail_masuk` = '$id_detail_masuk';";
        $resultAlatEdit=mysqli_query($conn,$queryAlatEdit) ;
        while ($row1=mysqli_fetch_array($resultAlatEdit)){
            $id_jenis_alat     =   $row1["id_jenis_alat"];
            $jumlah_diminta     =   $row1["jumlah"];
            $jumlah2     =   $row1["jumlah_dikeluarkan"];
        }
        $disabeled_jenis_alat = "disabled";
        $hidden_tersedia = "";

        $query="SELECT COUNT(a.`id_alat`) AS jumlah_alat FROM alat A, jenis_alat K WHERE a.`id_jenis_alat` = k.`id_jenis_alat` AND k.`id_jenis_alat` = '$id_jenis_alat';";
        $result=mysqli_query($conn,$query);
        while ($row2=mysqli_fetch_array($result)){
            $jumlah_alat_tersedia = $row2["jumlah_alat"];
        }

        $que="SELECT a.*, k.`nama_jenis_alat` FROM alat A, jenis_alat K WHERE a.`id_jenis_alat` = k.`id_jenis_alat` AND k.`id_jenis_alat` = '$id_jenis_alat';";
        $res=mysqli_query($conn,$que) ;
        
        if($status != 'baru'){
            $hidJum = "";
        }

        $hidden_input_kat = "";
    }

    if(isset($_POST["submit1"])){
        $jumlah                 =   $_POST["jumlah"];
        $jumlah2                =   $_POST["jumlah2"];
        $id_detail_masuk        =   $_POST["id_detail_masuk"];
        $status = $_POST["status"];
        
        if($id_detail_masuk != ""){
            $id_jenis_alat = $_POST["id_jenis_alat"];
            $jumlah_alat = "";

            $que1 = "SELECT COUNT(a.`id_alat`) AS jumlah_alat FROM alat A, jenis_alat K WHERE a.`id_jenis_alat` = k.`id_jenis_alat` AND k.`id_jenis_alat` = '$id_jenis_alat';";
            $res1=mysqli_query($conn,$que1) ;
            while ($row1=mysqli_fetch_array($res1)){
                $jumlah_alat     =   $row1["jumlah_alat"];
            }

            if(($id_detail_masuk and $id_peminjaman_masuk and $id_jenis_alat and $jumlah) != "" && $jumlah2 <= $jumlah_alat){
                $sql_insert1 = false;
                if($jumlah2 != null || $jumlah2 != ""){
                    $que="UPDATE peminjaman_masuk SET petugas_menyetujui = '$nia' WHERE id_peminjaman_masuk = '$id_peminjaman_masuk';";
                    $sql_ins = mysqli_query($conn,$que);
                }
                $query1="UPDATE detail_peminjaman_masuk SET id_jenis_alat='$id_jenis_alat', jumlah='$jumlah', jumlah_dikeluarkan='$jumlah2' WHERE id_detail_masuk = '$id_detail_masuk';";
                $sql_insert1 = mysqli_query($conn,$query1);
            }else{
                echo "<script>alert('Ada data yang salah')
                location.replace('form_peminjaman_list.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=gagal')</script>";
            }

        }else{
            $id_jenis_alat = $_POST["id_jenis_alat"];
            if(($id_peminjaman_masuk and $id_jenis_alat and $jumlah and $jumlah2) != ""){
                $sql_insert1 = false;
                $query1="INSERT INTO detail_peminjaman_masuk set id_peminjaman_masuk = '$id_peminjaman_masuk', id_jenis_alat = '$id_jenis_alat', jumlah = '$jumlah', jumlah_dikeluarkan = '$jumlah2' ;";
                $sql_insert1 = mysqli_query($conn,$query1);
            }else if(($id_peminjaman_masuk and $id_jenis_alat and $jumlah) != ""){
                $sql_insert1 = false;
                $query1="INSERT INTO detail_peminjaman_masuk set id_peminjaman_masuk = '$id_peminjaman_masuk', id_jenis_alat = '$id_jenis_alat', jumlah = '$jumlah' ;";
                $sql_insert1 = mysqli_query($conn,$query1);
            }else{
                echo "<script>location.replace('form_peminjaman_list.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=gagal')</script>";
            }
        }

        if($sql_insert1){
            echo "<script>alert('Data Berhasil Ditambahkan')
            location.replace('form_peminjaman_list.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=berhasil')</script>";
        }else{
            echo "<script>alert('Data gagal Ditambahkan')
            location.replace('form_peminjaman_list.php?id_peminjaman_masuk=$id_peminjaman_masuk&id_jenis_alat=$id_jenis_alat&jumlah=$jumlah&id_detail_masuk=$id_detail_masuk&status=gagal')</script>";
        }
    }
    if($id_jenis_alat != ""){
        $query="SELECT COUNT(a.`id_alat`) AS jumlah FROM `jenis_alat` K, `alat` A WHERE k.`id_jenis_alat` = a.`id_jenis_alat` AND k.`id_jenis_alat` = '$id_jenis_alat';";
        $result=mysqli_query($conn,$query);
        while ($row2=mysqli_fetch_array($result)){
            $jumlah_max = $row2["jumlah"];
        }
        $hidden_input_kat  = "";
    }

?>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Form List Permintaan Alat</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="dashboard_admin.php" class="text-dark">Data Peminjaman</a></li>
                            <li><a href="tampil_peminjaman.php?edit=true&id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>"
                                    class="text-dark">Ringkasan Peminjaman</a></li>
                            <li class="active text-dark">Form List Alat</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="content">
    <div class="animated fadeIn">

        <div class="row" <?php echo $hidden_list; ?>>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Alat Yang tersedia</strong>
                    </div>
                    <div class="card-body card-block">
                        <table id="bootstrap-data-table" class="table table-border-0">
                            <thead>
                                <tr>
                                    <th style="size:25%;"></th>
                                    <th style="size:25%;"></th>
                                    <th style="size:25%;"></th>
                                    <th style="size:25%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                        $id_jenis_alat_telah = "";
                                        $qu2="SELECT `id_jenis_alat` FROM `detail_peminjaman_masuk` WHERE `id_peminjaman_masuk` = '$id_peminjaman_masuk';";
                                        $re2=mysqli_query($conn,$qu2);
                                        while ($row4=mysqli_fetch_array($re2)){
                                            $id_jenis_alat_telah .= $row4["id_jenis_alat"].".";
                                        }
                                        $arr_id_jenis_alat = explode (".",$id_jenis_alat_telah);

                                        $query="SELECT * FROM jenis_alat;";
                                        $result=mysqli_query($conn,$query);
                                        $a = 0;
                                        $jumlah = 0;
                                        $jumlah_kategori = mysqli_num_rows($result);
                                        while ($row2=mysqli_fetch_array($result)){
                                            $id_jenis_alat_data = $row2["id_jenis_alat"];
                                            $print_data = true;
                                            for($i = 0 ; $i < sizeof($arr_id_jenis_alat); $i++){
                                                if($id_jenis_alat_data == $arr_id_jenis_alat[$i]){
                                                    $print_data = false;
                                                    break;
                                                }
                                            }

                                            $jumlah_alat = 0;
                                            $res3=mysqli_query($conn,"SELECT COUNT(a.`id_alat`) AS jumlah_alat FROM jenis_alat K, alat A WHERE k.`id_jenis_alat` = a.`id_jenis_alat` AND k.`id_jenis_alat` = '$id_jenis_alat_data';");
                                            while ($row4=mysqli_fetch_array($res3)){
                                                $jumlah_alat = $row4["jumlah_alat"];
                                            }
                                            
                                            if($print_data && $jumlah_alat != 0){                                    
                                    ?>
                                    <td style="size:25%;">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card" style="max-width: 15rem; max-height: 30rem">
                                                    <img src="images/<?php if($row2["foto_jenis_alat"] == "" || $row2["foto_jenis_alat"]  == "null"){echo "no_image.png";}else{echo $row2["foto_jenis_alat"];}?>"
                                                        class="card-img-top" alt="..." style="max-height: 15rem">
                                                    <div class="card-body" style="height: 5rem">
                                                        <h5 class="card-title">
                                                            <?php echo $row2["nama_jenis_alat"]; ?></h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                                                        <form action="form_peminjaman_list.php" method="post" name="frm"
                                                            enctype="multipart/form-data" class="form-horizontal">
                                                            <input type="hidden" name="id_peminjaman_masuk"
                                                                class="form-control"
                                                                value="<?php echo $id_peminjaman_masuk; ?>">
                                                            <input type="hidden" name="id_jenis_alat"
                                                                class="form-control"
                                                                value="<?php echo $row2["id_jenis_alat"]; ?>">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm btn-block"
                                                                name="submit_kat" onclick="scrolltoform()">
                                                                <i class="fa fa-check-square fa-1x"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <?php
                                                $a++;
                                                $jumlah++;
                                                if($a >= 4){
                                                    $a = 0;
                                                    echo '</tr><tr>';
                                                }
                                            } 
                                        }
                                        
                                        $kurang = 4 - $a;
                                        for($b = 0; $b < $kurang; $b++){
                                            echo "<td></td>";
                                        }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" <?php echo $hidden_input_kat;?>>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Pilih item yang akan dipinjam <?php echo $id_peminjaman_masuk; ?></strong>
                    </div>
                    <form action="form_peminjaman_list.php" method="post" name="frm" enctype="multipart/form-data"
                        class="form-horizontal">
                        <div class="card-body card-block">
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="text-input" class=" form-control-label">Jenis Alat</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <select class="form-control" disabled>
                                        <?php
                                            if($id_jenis_alat == ""){
                                                echo "<option selected>-- Pilih Jenis Alat --</option>";
                                            }
                                            $query="SELECT * FROM jenis_alat";
                                            $sql=mysqli_query($conn,$query);
                                            while ($row=mysqli_fetch_array($sql)) {
                                                $select = $valueAlat = $tampilAlat ="";
                                                $valueAlat =  $row['id_jenis_alat'];
                                                $tampilAlat = $row['nama_jenis_alat'];
                                                if ($row['id_jenis_alat']==$id_jenis_alat) {
                                                    $select="selected";
                                                }
                                        ?>
                                        <option <?php echo $select; ?> value="<?php echo $valueAlat;?>">
                                            <div class="text-center">
                                                <?php echo $tampilAlat; ?>
                                                <img src="images/<?php echo $row["foto_jenis_alat"];?>"
                                                    style="size: 20%;" class="img-responsive rounded" alt="">
                                            </div>
                                        </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <small class="form-text text-muted">pilih jenis alat</small>
                                    <input type="hidden" name="id_jenis_alat" class="form-control"
                                        value="<?php echo $id_jenis_alat; ?>">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="text-input" class=" form-control-label">Masukkan jumlah</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="number" name="jumlah" placeholder="Masukkan jumlah alat"
                                        class="form-control" value="<?php echo $jumlah_diminta; ?>" min="1"
                                        max="<?php echo $jumlah_max;?>">
                                    <small class="help-block form-text">Masukkan jumlah yang akan dipinjam</small>
                                </div>
                            </div>
                            <div class="row form-group" <?php echo $hidJum; ?>>
                                <div class="col col-md-3">
                                    <label for="text-input" class=" form-control-label">Masukkan jumlah yang
                                        disetujui</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="number" name="jumlah2"
                                        placeholder="Masukkan jumlah alat yang disetujui" class="form-control"
                                        value="<?php echo $jumlah2; ?>" min="1"
                                        max="<?php echo $jumlah;?>">
                                    <small class="help-block form-text">Masukkan jumlah yang akan disetujui</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="id_peminjaman_masuk" class="form-control"
                                value="<?php echo $id_peminjaman_masuk; ?>">
                            <input type="hidden" name="status" class="form-control" value="<?php echo $status; ?>">
                            <input type="hidden" name="id_detail_masuk" class="form-control"
                                value="<?php echo $id_detail_masuk; ?>">
                            <button type="submit" class="btn btn-primary btn-sm" name="submit1">
                                <i class="fa fa-dot-circle-o"></i> Submit
                            </button>
                            <button type="submit" class="btn btn-danger btn-sm" name="reset1">
                                <i class="fa fa-ban"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Peminjaman di waktu yang sama <?php echo $tgl_ambil;?> s/d
                            <?php echo $tgl_kembali;?></strong>
                    </div>
                    <div class="card-body card-block">
                        <table class="table table-border-0">
                            <thead>
                                <tr>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $que2="SELECT m.*, p.nama, p.instansi FROM peminjaman_masuk M, peminjam P where p.nik = m.nik";
                                    $res2=mysqli_query($conn,$que2) ;
                                    $i = 0;
                                    while ($row2=mysqli_fetch_array($res2)){
                                        $cetak = false;
                                        
                                        if($row2["tgl_ambil"] < $tgl_ambil && $row2["tgl_kembali"] > $tgl_ambil && $row2["tgl_kembali"] < $tgl_kembali ){
                                            $cetak = true;
                                        }else if($row2["tgl_ambil"] > $tgl_ambil && $row2["tgl_ambil"] < $tgl_kembali && $row2["tgl_kembali"] > $tgl_kembali ){
                                            $cetak = true;
                                        }else if($row2["tgl_ambil"] < $tgl_ambil && $row2["tgl_kembali"] > $tgl_kembali ){
                                            $cetak = true;
                                        }else if($row2["tgl_ambil"] > $tgl_ambil && $row2["tgl_kembali"] < $tgl_kembali ){
                                            $cetak = true;
                                        }

                                        if($cetak){
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
                                                                    <small class="text-secondary"><?php echo $row2["tgl_ambil"]." s/d ".$row2["tgl_kembali"]; ?></small>
                                                                    <br/>
                                                                    <a class="text-dark" target="blank"
                                                                        href="tampil_peminjaman.php?id_peminjaman_masuk=<?php echo $row2["id_peminjaman_masuk"];?>">
                                                                        <h6><?php echo $row2["id_peminjaman_masuk"]; ?>
                                                                        </h6>
                                                                        <h5> <?php echo $row2["nama"]; ?> <small class="text-secondary">(<?php echo $row2["instansi"];?>)</small></h5>
                                                                        
                                                                    </a>
                                                                    <br/>
                                                                    <?php echo $row2["nama_kegiatan"];?><br/>
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-7 border-left">
                                                                <div class="card-text">
                                                                    <b>Alat yang akan dipinjam : </b><br />
                                                                    <?php 
                                                                        $id = $row2["id_peminjaman_masuk"];
                                                                        $que11 = "SELECT d.*, k.`nama_jenis_alat` FROM `detail_peminjaman_masuk` D, `jenis_alat` K WHERE d.`id_jenis_alat` = k.`id_jenis_alat` AND d.`id_peminjaman_masuk` ='$id';";
                                                                        $res11=mysqli_query($conn,$que11) ;
                                                                        while ($row1=mysqli_fetch_array($res11)){
                                                                            echo '<div class="row">
                                                                                    <div class="col-sm-6">'.$row1["nama_jenis_alat"].'</div>
                                                                                    <div class="col-sm-1"> : </div>
                                                                                    <div class="col-sm-2">'.$row1["jumlah"].' </div>
                                                                                    ';                                                
                                                                            if($row1["jumlah_dikeluarkan"] != null || $row1["jumlah_dikeluarkan"] != ""){
                                                                                echo '<div class="col-sm-1"> <i class="fas fa-chevron-right fa-1x"></i></div> 
                                                                                        <div class="col-sm-2">'. $row1["jumlah_dikeluarkan"]. ' </div> ';
                                                                            }else{
                                                                                echo '<div class="col-sm-3"></div>'; 
                                                                            }
                                                                            echo '</div>';
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php }} ?> </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" <?php if($hidden_tersedia == "hidden" || $hidJum =="hidden"){echo "hidden";} ?>>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Alat Yang Dimiliki Oleh Ganendra Giri Berdasarkan jenis_alat Alat</strong>
                        <small class="float-right text-secondary">Alat Tersedia :
                            <?php echo mysqli_num_rows($res); ?></small>
                    </div>
                    <div class="card-body card-block">
                        <div class="container">
                            <div class="row">
                                <?php
                                    $i = 0;
                                    while ($row2=mysqli_fetch_array($res)){
                                        $i++;
                                ?>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="row no-gutters">
                                            <div class="col-md-4">
                                                <img src="images/<?php if($row2["foto_alat"] != "" || !empty($row2["foto_alat"]) || $row2["foto_alat"] != null ){echo $row2["foto_alat"];}else{echo "no_image.png";}?>"
                                                    style="max-width: 120px; max-height: 120px; margin: 15px;"
                                                    class="card-img-top" alt="...">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <div class="col-md-11 border-left">
                                                        <div class="card-title">
                                                            <h6><?php echo $row2["id_alat"]; ?>
                                                            </h6>
                                                            <h5><?php echo $row2["merk"]." ".$row2["type"]; ?>
                                                            </h5>
                                                            <small
                                                                class="text-secondary"><?php echo $row2["nama_jenis_alat"]; ?></small>
                                                        </div>
                                                        <div class="card-text text-secondary">
                                                            <small>
                                                                <b>Deskripsi : </b>
                                                                <?php echo $row2["deskripsi"]; ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if($i==2){ $i = 0; echo '</div><div claas="row">';} } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Permintaan Peminjaman Baru <?php echo $id_peminjaman_masuk; ?></strong>
                        <?php if($status == "baru" || $status == "disetujui"){?>
                        <a class="btn btn-success float-right btn-sm"
                            href="form_peminjaman_list.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>&tambah=true"
                            role="button">Tambah</a>
                        <?php } ?>
                    </div>
                    <div class="card-body card-block">
                        <div class="container">
                            <div class="row">
                                <?php
                                    $i = 0;
                                    while ($row2=mysqli_fetch_array($result1)){
                                        $i++;
                                ?>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="row no-gutters">
                                            <div class="col-md-3">
                                                <img src="images/<?php if($row2["foto_jenis_alat"] != "" || !empty($row2["foto_jenis_alat"]) || $row2["foto_jenis_alat"] != null ){echo $row2["foto_jenis_alat"];}else{echo "no_image.png";}?>"
                                                    style="max-width: 120px; max-height: 120px; margin: 15px;"
                                                    class="card-img-top" alt="...">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <div class="col-md-11 border-left">
                                                        <div class="card-title">
                                                            <h6><?php echo $row2["nama_jenis_alat"]; ?></h6>
                                                        </div>
                                                        <div class="card-text text-secondary">
                                                            <small>
                                                                <b>Permintaan : </b>
                                                                <?php echo $row2["jumlah"]; ?><br />
                                                                <?php if($status == "disetujui"){?>
                                                                <b>Disetujui : </b>
                                                                <?php echo $row2["jumlah_dikeluarkan"]; }?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="card-body" style="margin: auto;">
                                                    <?php if($status == "baru" || $status == "disetujui"){?>
                                                    <a href="form_peminjaman_list.php?edit=true&id_peminjaman_masuk=<?php echo $row2["id_peminjaman_masuk"];?>&id_detail_masuk=<?php echo $row2["id_detail_masuk"];?>"
                                                        class="btn btn-outline-primary btn-sm float-right">
                                                        <i class='fa fa-pencil fa-1x'> </i>
                                                    </a><br />
                                                    <a href="delete_detail_peminjaman.php?id_detail_masuk=<?php echo $row2["id_detail_masuk"];?>&id_peminjaman_masuk=<?php echo $row2["id_peminjaman_masuk"];?>&user=admin"
                                                        class="btn btn-outline-danger btn-sm float-right"
                                                        onClick="return confirm('Hapus item ini??')">
                                                        <i class='fa fa-trash-o fa-1x'> </i>
                                                    </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if($i==2){ $i = 0; echo '</div><div class="row">';} } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BUTTON BACK -->
        <div class="float-left">
            <a href="form_peminjaman.php?edit=true&id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>"
                class="btn btn-secondary btn-md active float-left" role="button" aria-pressed="true">
                <i class="fas fa-chevron-left "></i> Kembali ke form
            </a>
        </div>

        <!-- BUTTON NEXT -->
        <div class="float-right">
            <?php 
                $email_peminjam = "";
                $nama_peminjam = "";
                $tgl_kembali = "";
                $status = "";
                $nik = "";
                $res2=mysqli_query($conn,"SELECT U.*, p.tgl_kembali, p.status FROM peminjaman_masuk P, peminjam U WHERE p.nik = u.nik and p.id_peminjaman_masuk = '$id_peminjaman_masuk'");
                while ($row1=mysqli_fetch_array($res2)){
                    $tgl_kembali = $row1["tgl_kembali"];
                    $status = $row1["status"];
                    $nik = $row1["nik"];
                }

                $nik_potong = substr($nik,0,3);
                if($nik_potong == "910"){
                    $result=mysqli_query($conn,"SELECT * FROM user WHERE nia = '$nik';");
                    while ($row1=mysqli_fetch_array($result)){
                        $nama_peminjam      =   $row1["nama_user"];
                        $email_peminjam     =   $row1["email"];
                    }
                }else{
                    $result=mysqli_query($conn,"SELECT * FROM peminjam  WHERE nik = '$nik';");
                    while ($row1=mysqli_fetch_array($result)){
                        $nama_peminjam      =   $row1["nama"];
                        $email_peminjam     =   $row1["email"];
                    }
                }

                if($status == "disetujui"){
            ?>
            <form id="contact-form" action="sent_email.php" method="get" role="form">
                <input type="hidden" name="email" value="<?php echo  $email_peminjam; ?>">
                <input type="hidden" name="name" value="<?php echo  $nama_peminjam; ?>">
                <input type="hidden" name="subject" value="Peminjaman Peralatan OPA Ganendra Giri">
                <input type="hidden" name="message"
                    value="Yuk cek data peminjaman alat dengan nomor peminjaman <?php echo $id_peminjaman_masuk;?> di OPA Ganendra Giri. Sepertinya perkembangan di data peminjaman yang telah anda isikan. Coba lihat data anda pada halaman tracking kami. Terima Kasih">
                <input type="hidden" name="pesan_replace"
                    value="Terima Kasih telah memproses peminjaman peralatan ini. Kami akan menginformasikan kepada peminjam bahwa permintaan peminjaman telah diproses">
                <input type="hidden" name="link"
                    value="tampil_peminjaman.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>">
                <button type="submit" class="btn btn-primary btn-md active float-right">
                    Selesai <i class="fas fa-chevron-right "></i>
                </button>
            </form>
            <?php } else if($status == "baru"){?>
            <form id="contact-form" action="sent_email.php" method="get" role="form">
                <input type="hidden" name="email" value="<?php echo  $email_peminjam; ?>">
                <input type="hidden" name="name" value="<?php echo  $nama_peminjam; ?>">
                <input type="hidden" name="subject" value="Peminjaman Peralatan OPA Ganendra Giri">
                <input type="hidden" name="message"
                    value="Selamat anda telah berhasil mengisi formulir peminjaman peralatan OPA Ganendra Giri dengan nomor peminjaman <?php echo  $id_peminjaman_masuk; ?>. Saat ini peminjaman anda berstatus pending untuk disetujui oleh admin kami. Tunggu informasi lebih selanjutnya untuk perkembangan peminjaman alat anda. Jika ada pertanyaan lain bisa menghubungi Departemen Rumah Tangga OPA Ganendra Giri. Terima Kasih. ">
                <input type="hidden" name="link" value="tampil_peminjaman.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>">
                <button type="submit" class="btn btn-primary btn-md active float-right">
                    Selesai <i class="fas fa-chevron-right "></i>
                </button>
            </form>
            <?php } else {?>
                <a href="tampil_peminjaman.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>"
                class="btn btn-primary btn-md active" role="button" aria-pressed="true">
                Selesai <i class="fas fa-chevron-right "></i>
            </a>
            <?php }?>
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
