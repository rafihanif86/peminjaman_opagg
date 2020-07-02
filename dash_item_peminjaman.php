<?php
$title_header = "Peminjaman | Inventory OPA Ganendra Giri";
$home_active = "";
$peminjaman_active = "active";
$about_active = "";
include 'header_dashboard.php';

$id_peminjaman_masuk = $id_detail_masuk = $id_jenis_alat = $jumlah = $nama_kat = $query = $result = "";
$hidden_input_kat = "hidden";
$jumlah_max = "";



if (isset($_GET['id_peminjaman_masuk'])) {
    $id_peminjaman_masuk = $_GET['id_peminjaman_masuk'];
} else if (isset($_POST['id_peminjaman_masuk'])) {
    $id_peminjaman_masuk = $_POST['id_peminjaman_masuk'];
}

if ($id_peminjaman_masuk == "") {
    echo "<script>alert('Nomor Peminjaman tidak ditemukan')location.replace('dash_peminjaman_tampil.php')</script>";
}

if (isset($_GET['edit']) and isset($_GET['id_peminjaman_masuk'])) {
    $edit = $_GET['edit'];
    $id_detail_masuk = $_GET['id_detail_masuk'];
    $query1 = "SELECT * FROM detail_peminjaman_masuk WHERE id_peminjaman_masuk = '$id_peminjaman_masuk' AND `id_detail_masuk` = '$id_detail_masuk' ORDER BY `id_detail_masuk`;";
    $result1 = mysqli_query($conn, $query1);
    while ($row1 = mysqli_fetch_array($result1)) {
        $id_jenis_alat = $row1["id_jenis_alat"];
        $jumlah = $row1["jumlah"];
    }
    $hidden_input_kat = "";
}

if (isset($_POST["submit"])) {
    $id_jenis_alat = $_POST["id_jenis_alat"];
    $jumlah = $_POST["jumlah"];
    $id_peminjaman_masuk = $_POST['id_peminjaman_masuk'];
    $id_detail_masuk = $_POST["id_detail_masuk"];
    $sql_insert1 = false;

    if ($id_detail_masuk != null) {
        if (($id_peminjaman_masuk and $id_jenis_alat and $jumlah and $id_detail_masuk) != null) {
            $query1 = "UPDATE detail_peminjaman_masuk SET id_jenis_alat='$id_jenis_alat', jumlah='$jumlah' WHERE id_detail_masuk = '$id_detail_masuk';";
            $sql_insert1 = mysqli_query($conn, $query1);
        } else {
            echo "<script>
            location.replace('dash_item_peminjaman.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=gagal')</script>";
        }
    } else {
        if (($id_peminjaman_masuk and $id_jenis_alat and $jumlah) != null) {
            $query1 = "INSERT INTO detail_peminjaman_masuk (`id_peminjaman_masuk`,`id_jenis_alat`,`jumlah`) VALUES ('" . $id_peminjaman_masuk . "','" . $id_jenis_alat . "','" . $jumlah . "');";
            $sql_insert1 = mysqli_query($conn, $query1);
        } else {
            echo "<script>
            location.replace('dash_item_peminjaman.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=gagal')</script>";
        }
    }

    if ($sql_insert1) {
        echo "<script>
            location.replace('dash_item_peminjaman.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=berhasil')</script>";
    } else {
        echo "<script>
            location.replace('dash_item_peminjaman.php?id_peminjaman_masuk=$id_peminjaman_masuk&status=gagal')</script>";
    }
}

?>
<script>
var elmnt = document.getElementById("form_list");

function scrolltoform() {
    elmnt.scrollIntoView();
}
</script>
<div class="content" style="max-width: 90%; margin: auto; float:none;">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body card-block">
                    <div class="breadcrumbs bg-white">
                        <div class="breadcrumbs-inner">
                            <div class="row" style="padding: 5px;">
                                <div class="col-md-6">
                                    <div class="page-header float-left" style="padding-bottom: 0px; padding-top: 10px;">
                                        <div class="page-title">
                                            <h1>List Permintaan Alat</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="page-header float-right "
                                        style="padding-bottom: 0px; padding-top: 10px;">
                                        <div class="page-title">
                                            <ol class="breadcrumb text-right">
                                                <li class="breadcrumb-item">Peminjaman</li>
                                                <li class="breadcrumb-item">Form Peminjaman</li>
                                                <li class="breadcrumb-item active">List Alat</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-bottom: 10px;">
                                <div class="col-md-12">
                                    <?php
                        $jumlah_data_dipinjam = 0;
                        $progress = "75%";
                        $resu3 = mysqli_query($conn, "SELECT COUNT(id_detail_masuk) AS jumlah FROM detail_peminjaman_masuk WHERE id_peminjaman_masuk = '$id_peminjaman_masuk';");
                        while ($row2 = mysqli_fetch_array($resu3)) {
                            $jumlah_data_dipinjam = $row2["jumlah"];
                        }

                        if ($jumlah_data_dipinjam > 0) {
                            $progress = "100%";
                        } else {
                            $progress = "75%";
                        }
                    ?>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar" aria-valuenow="<?php echo $progress; ?>"
                                            aria-valuemin="0" aria-valuemax="100"
                                            style="width: <?php echo $progress; ?>;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- pilih kategori -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Pilh Kategori Yang Akan Dipinjam </strong>
                </div>
                <div class="card-body card-block">
                    <table class="table table-border-0">
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
                                    $query="SELECT * FROM kategori;";
                                    $result=mysqli_query($conn,$query);
                                    $a = 0;
                                    $jumlah = 0;
                                    $jumlah_kategori = mysqli_num_rows($result);
                                    while ($row2=mysqli_fetch_array($result)){
                                        $id_kat = $row2["id_kat"];
                                        $res4=mysqli_query($conn,"SELECT * FROM jenis_alat where id_kat = '$id_kat';");
                                        $jumlah_jenis = mysqli_num_rows($res4);
                                        if($jumlah_jenis > 0){
                                ?>
                                <td style="size:25%;">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card" style="max-width: 15rem; max-height: 30rem">
                                                <img src="images/<?php if($row2["foto_kat"] == "" || $row2["foto_kat"]  == "null"){echo "no_image.png";}else{echo $row2["foto_kat"];}?>"
                                                    class="card-img-top" alt="..." style="max-height: 15rem">
                                                <div class="card-body" style="height: 5rem">
                                                    <h5 class="card-title">
                                                        <?php echo $row2["nama_kat"]; ?></h5>
                                                </div>
                                                <div class="card-body">
                                                    <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                                                    <form action="dash_item_peminjaman.php" method="post" name="frm"
                                                        enctype="multipart/form-data" class="form-horizontal">
                                                        <input type="hidden" name="id_peminjaman_masuk"
                                                            class="form-control"
                                                            value="<?php echo $id_peminjaman_masuk; ?>">
                                                        <input type="hidden" name="id_kat" class="form-control"
                                                            value="<?php echo $row2["id_kat"]; ?>">
                                                        <button type="submit" class="btn btn-primary btn-sm btn-block"
                                                            name="submit_kat"
                                                            <?php if(isset($_POST['id_kat'])){if($_POST['id_kat'] == $row2["id_kat"]){echo "disabled";}}?>>
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

    <div class="row " <?php if(!isset($_POST['id_kat'])){echo "hidden";}?>>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Alat Yang tersedia</strong>
                </div>
                <div class="card-body card-block">
                    <table id="bootstrap-data-table" class="table table-border-0">
                        <thead>
                            <tr>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="row">
                                        <?php
                                            $id_jenis_alat_telah = "";
                                            $qu2 = "SELECT `id_jenis_alat` FROM `detail_peminjaman_masuk` WHERE `id_peminjaman_masuk` = '$id_peminjaman_masuk';";
                                            $re2 = mysqli_query($conn, $qu2);
                                            while ($row4 = mysqli_fetch_array($re2)) {
                                                $id_jenis_alat_telah .= $row4["id_jenis_alat"] . ".";
                                            }
                                            $arr_id_jenis_alat = explode(".", $id_jenis_alat_telah);

                                            $id_kat = $_POST['id_kat'];
                                            $query = "SELECT * FROM jenis_alat  where id_kat='$id_kat'";
                                        
                                            $result = mysqli_query($conn, $query);
                                            $a = 0;
                                            while ($row2 = mysqli_fetch_array($result)) {
                                                $id_jenis_alat_data = $row2["id_jenis_alat"];
                                                $print_data = true;
                                                for ($i = 0; $i < sizeof($arr_id_jenis_alat); $i++) {
                                                    if ($id_jenis_alat_data == $arr_id_jenis_alat[$i]) {
                                                        $print_data = false;
                                                        break;
                                                    }
                                                }

                                                $jumlah_alat = 0;
                                                $res3 = mysqli_query($conn, "SELECT COUNT(a.`id_alat`) AS jumlah_alat FROM jenis_alat K, alat A WHERE k.`id_jenis_alat` = a.`id_jenis_alat` AND k.`id_jenis_alat` = '$id_jenis_alat_data';");
                                                while ($row4 = mysqli_fetch_array($res3)) {
                                                    $jumlah_alat = $row4["jumlah_alat"];
                                                }

                                                if ($print_data && $jumlah_alat != 0) {
                                        ?>
                                        <div class="col-sm-3">
                                            <div class="card" style="max-width: 15rem; max-height: 30rem">
                                                <img src="images/<?php if ($row2["foto_jenis_alat"] == "" || $row2["foto_jenis_alat"]  == "null") {
                                                                                                echo "no_image.png";
                                                                                            } else {
                                                                                                echo $row2["foto_jenis_alat"];
                                                                                            } ?>" class="card-img-top"
                                                    alt="..." style="max-height: 15rem">
                                                <div class="card-body" style="height: 5rem">
                                                    <h5 class="card-title">
                                                        <?php echo $row2["nama_jenis_alat"]; ?></h5>
                                                </div>
                                                <div class="card-body">
                                                    <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                                                    <input type="hidden" name="id_peminjaman_masuk" class="form-control"
                                                        value="<?php echo $id_peminjaman_masuk; ?>">
                                                    <input type="hidden" name="id_jenis_alat" class="form-control"
                                                        value="<?php echo $row2["id_jenis_alat"]; ?>">
                                                    <button type="button" data-toggle="modal"
                                                        data-target="#myModal<?php echo $row2['id_jenis_alat']; ?>"
                                                        class="btn btn-primary btn-sm btn-block" name="submit_kat">
                                                        <i class="fa fa-check-square fa-1x"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- modal -->
                                        <div class="modal fade" id="myModal<?php echo $row2['id_jenis_alat']; ?>"
                                            role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myModalLabel">
                                                            Edit Daftar Surat Masuk
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="dash_item_peminjaman.php" method="post" name="frm"
                                                            enctype="multipart/form-data" class="form-horizontal">
                                                            <div class="card-body card-block">
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3">
                                                                        <label for="text-input"
                                                                            class=" form-control-label">Jenis
                                                                            Alat</label>
                                                                    </div>
                                                                    <div class="col-12 col-md-9">
                                                                        <select name="id_jenis_alat"
                                                                            class="form-control" disabled>
                                                                            <?php
                                                                                $query = "SELECT * FROM jenis_alat";
                                                                                $sql = mysqli_query($conn, $query);
                                                                                while ($row10 = mysqli_fetch_array($sql)) {
                                                                                    $select = "";
                                                                                    if ($row10['id_jenis_alat'] == $row2['id_jenis_alat']) {
                                                                            ?>
                                                                            <option selected
                                                                                value="<?php echo $row10['id_jenis_alat']; ?>">
                                                                                <?php echo $row10['nama_jenis_alat']; ?>
                                                                            </option>
                                                                            <?php
                                                                                                        } else {
                                                                                                        ?>
                                                                            <option
                                                                                value="<?php echo $row10['id_jenis_alat']; ?>">
                                                                                <?php echo $row10['nama_jenis_alat']; ?>
                                                                            </option>
                                                                            <?php
                                                                                                        }
                                                                                                    }
                                                                                                    ?>
                                                                        </select>
                                                                        <small class="form-text text-muted">pilih
                                                                            jenis alat</small>
                                                                    </div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3">
                                                                        <label for="text-input"
                                                                            class=" form-control-label">Masukkan
                                                                            jumlah</label>
                                                                    </div>
                                                                    <div class="col-12 col-md-9">

                                                                        <input type="number" name="jumlah"
                                                                            class="form-control"
                                                                            placeholder="Masukkan jumlah Peminjaman"
                                                                            min="1" max="<?php echo $jumlah_alat; ?>">
                                                                        <small class="help-block form-text">Masukkan
                                                                            jumlah yang akan
                                                                            dipinjam</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer">
                                                                <input type="hidden" name="id_peminjaman_masuk"
                                                                    class="form-control"
                                                                    value="<?php echo $id_peminjaman_masuk; ?>">
                                                                <input type="hidden" name="id_detail_masuk"
                                                                    class="form-control"
                                                                    value="<?php echo $id_detail_masuk; ?>">
                                                                <input type="hidden" name="id_jenis_alat"
                                                                    class="form-control"
                                                                    value="<?php echo $row2["id_jenis_alat"]; ?>">

                                                                <button type="submit" class="btn btn-primary btn-sm"
                                                                    name="submit">
                                                                    <i class="fa fa-dot-circle-o"></i>
                                                                    Submit
                                                                </button>
                                                                <button type="reset" class="btn btn-danger btn-sm"
                                                                    name="reset">
                                                                    <i class="fa fa-ban"></i> Reset
                                                                </button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                                    $a++;
                                                    if ($a >= 4) {
                                                        $a = 0;
                                                        echo '</div></td></tr><tr><td><div class="row">';
                                                    }
                                                }
                                            }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- alat yang akan dipinjam -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Alat Yang akan dipinjam <?php echo $id_peminjaman_masuk; ?></strong>
                </div>
                <div class="card-body card-block">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 30px;">#</th>
                                <th style="width: 180px;">Foto Alat</th>
                                <th>Jenis Alat</th>
                                <th>Jumlah</th>
                                <th style="width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // $query = "SELECT D.*, K.nama_kat, K.foto_kat FROM detail_peminjaman_masuk D,kategori K WHERE K.id_jenis_alat = D.id_jenis_alat AND id_peminjaman_masuk = '$id_peminjaman_masuk' ORDER BY D.`id_detail_masuk`;";
                                $query = "SELECT * FROM detail_peminjaman_masuk d
                                inner join jenis_alat j
                                on d.id_jenis_alat = j.id_jenis_alat
                                inner join kategori k
                                on j.id_kat = k.id_kat
                                where d.id_peminjaman_masuk = '$id_peminjaman_masuk' ORDER BY d.id_detail_masuk;";
                                $result = mysqli_query($conn, $query);
                                $i = 0;
                                while ($row2 = mysqli_fetch_array($result)) {
                                    $i++;
                            ?>
                            <tr>
                                <th scope="row"><?php echo $i ?></th>
                                <td>
                                    <img src="images/<?php if ($row2["foto_jenis_alat"] == "" || $row2["foto_jenis_alat"]  == "null") { 
                                                                                echo "no_image.png";
                                                                            } else {
                                                                                echo $row2["foto_jenis_alat"];
                                                                            } ?>" class="img-responsive rounded" alt=""
                                        style="max-width: 130px;">
                                </td>
                                <td><?php echo $row2["nama_jenis_alat"]; ?></td>
                                <td><?php echo $row2["jumlah"]; ?></td>
                                <td>
                                    <a href="delete_item_peminjaman.php?id_detail_masuk=<?php echo $row2["id_detail_masuk"]; ?>&id_peminjaman_masuk=<?php echo $row2["id_peminjaman_masuk"]; ?>"
                                        class="btn btn-danger btn-sm">
                                        <i class='fa fa-trash-o fa-1x'> </i>
                                    </a>
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
    <!-- BUTTON BACK -->
    <div class="float-left">
        <a href="dash_peminjaman.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk; ?>"
            class="btn btn-secondary btn-md active float-left" role="button" aria-pressed="true">
            <i class="fas fa-chevron-left "></i> Kembali </a>
    </div>

    <!-- BUTTON NEXT -->
    <?php if ($id_peminjaman_masuk != "" && $progress == "100%") {

    ?>
    <div class="float-right">
        <?php
            $email_peminjam = "";
            $nama_peminjam = "";
            $res2 = mysqli_query($conn, "SELECT U.* FROM peminjaman_masuk P, peminjam U WHERE p.nik = u.nik and p.id_peminjaman_masuk = '$id_peminjaman_masuk'");
            while ($row1 = mysqli_fetch_array($res2)) {
                $email_peminjam = $row1["email"];
                $nama_peminjam = $row1["nama"];
            }
            ?>
        <form id="contact-form" action="sent_email.php" method="get" role="form">
            <input type="hidden" name="email" value="<?php echo  $email_peminjam; ?>">
            <input type="hidden" name="name" value="<?php echo  $nama_peminjam; ?>">
            <input type="hidden" name="subject" value="Peminjaman Peralatan OPA Ganendra Giri">
            <input type="hidden" name="message"
                value="Selamat status peminjaman anda <?php echo  $id_peminjaman_masuk; ?> telah diperbarui menjadi Telah Diperbarui. Anda bisa melihat detail peminjaman anda melalui halaman Tracking Peminjaman di web Inventory OPA Ganendra Giri">
            <input type="hidden" name="pesan_replace"
                value="Terima kasih anda telah mengisi formulir peminjaman alat OPA Ganandra Giri. Sebuah pesan telah dikirim ke email anda.">
            <input type="hidden" name="link"
                value="dash_peminjaman_tampil.php?id_peminjaman_masuk=<?php echo  $id_peminjaman_masuk; ?>">
            <button type="submit" class="btn btn-primary btn-md active float-right">
                Selesai <i class="fas fa-chevron-right "></i>
            </button>
        </form>
    </div>
    <?php } ?>

    <br />

</div><!-- .content -->

<div class="clearfix"></div>
<?php
    include 'footer_dashboard.php';
    if (isset($_GET["status"])) {
        if ($_GET["status"] == 'berhasil') {
            echo "<script type='text/javascript'> window.onload = function(){ alert('Data berhasil ditambahkan'); } </script>";
        } else if ($_GET["status"] == 'gagal') {
            echo "<script type='text/javascript'> window.onload = function(){ alert('Data gagal ditambahkan'); } </script>";
        }else if ($_GET["status"] == 'berhasildihapus') {
            echo "<script type='text/javascript'> window.onload = function(){ alert('Berhasil dihapus'); } </script>";
        }else if ($_GET["status"] == 'gagaldihapus') {
            echo "<script type='text/javascript'> window.onload = function(){ alert('Data gagal dihapus'); } </script>";
        }
    }
?>