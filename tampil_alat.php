<?php
include "connection.php";
$halaman = "alat";
include 'style_popup_image.php';
include 'header_admin.php';
include 'tgl_indo.php';

$id_alat = $checklist_masuk = $checklist_keluar = "";

$judul_action = "Action";
$link_action = "#";

if (isset($_POST['id_alat'])) {
    $id_alat = $_POST['id_alat'];
} else if (isset($_GET['id_alat'])) {
    $id_alat = $_GET['id_alat'];
}

if ($id_alat != "") {

    $result = mysqli_query($conn, "SELECT a.*, k.`nama_jenis_alat` FROM alat A, jenis_alat K WHERE id_alat = '$id_alat' AND k.`id_jenis_alat` = a.`id_jenis_alat`;");
    while ($row1 = mysqli_fetch_array($result)) {
        $type = $row1["type"];
        $merk = $row1["merk"];
        $id_jenis_alat = $row1["id_jenis_alat"];
        $checklist_masuk = $row1["checklist_masuk"];
        $checklist_keluar = $row1["checklist_keluar"];
        $nama_jenis_alat = $row1["nama_jenis_alat"];
        $foto_alat = $row1["foto_alat"];
        $deskripsi = $row1["deskripsi"];
    }
}

?>
<script>
function printContent(el) {
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    window.print();
    document.body.innerHTML = restorepage;
}
</script>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Ringkasan Data Alat</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="tebel_alat.php?action=seluruh" class="text-dark">Data
                                    Alat</a></li>
                            <li class="active text-dark">Ringkasan</li>
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
            <div class="col-lg-12" id="div1">
                <div class="card" style="border: 0;">
                    <div class="card-body card-block" style="padding-left: 50px; padding-right: 50px;">
                        <h3>Detail Alat</h3>
                        <hr />
                        <div class="container">
                            <div class="row">
                                <div class="col ">
                                    <div class="float-md-left">
                                        <div class="container">
                                            <div class="row form-group">
                                                <div class="col col-md-12">
                                                    <img src="images/<?php if ($foto_alat != "" || !empty($foto_alat) || $foto_alat != null) {
                                                                    echo $foto_alat;
                                                                } else {
                                                                    echo "no_image.png";
                                                                } ?>" class="rounded mx-auto d-block" alt="..."
                                                        style="max-height: 20rem;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="float-md-left border-left">
                                        <div class="container">
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label"><b>Nomor Inventaris</b></label>
                                                </div>
                                                <div class="col-12 col-md-9"><?php echo ": ";
                                                                        echo $id_alat; ?></div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label"><b>Jenis Alat</b></label></div>
                                                <div class="col-12 col-md-9"><?php echo ": ";
                                                                        echo $nama_jenis_alat; ?></div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label"><b>Merk</b></label></div>
                                                <div class="col-12 col-md-9"><?php echo ": ";
                                                                        echo $merk; ?></div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label"><b>Tipe</b></label></div>
                                                <div class="col-12 col-md-9"><?php echo ": ";
                                                                        echo $type; ?></div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input"
                                                        class=" form-control-label"><b>Deskripsi</b></label></div>
                                                <div class="col-12 col-md-9"><?php echo ": ";
                                                                        echo $deskripsi; ?></div>
                                            </div>
                                            <div class="row form-group">
                                                <?php
                                        if ($checklist_masuk != "") {
                                            $result1 = mysqli_query($conn, "SELECT c.*, u.`nama_user` FROM `checklist_record` C, `user` U WHERE c.`id_check` = '$checklist_masuk' and c.`petugas` = u.`nia`;");
                                            while ($row3 = mysqli_fetch_array($result1)) {
                                        ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <small
                                                                    class="text-secondary float-right"><?php echo tgl_indo($row3["tgl_checklist"]); ?></small>
                                                                <h5 class="card-title">Pengecekan Awal</h5>
                                                                <?php
                                                                if ($row3["status_peminjaman"] != "") {
                                                                    echo "Alat ini " . $row3["status_peminjaman"] . " pada nomor peminjaman <a class='text-dark' href='tampil_peminjaman.php?id_peminjaman_masuk=" . $row3["id_peminjaman_masuk"] . "'> " . $row3["id_peminjaman_masuk"] . "</a>. ";
                                                                }
                                                                if ($row3["kondisi"] != "") {
                                                                    echo "Alat ini memiliki kondisi " . $row3["kondisi"] . ", " . $row3["keterangan"] . ". <br/><small class='text-secondary'>(" . $row3["nama_user"] . ", NIA." . $row3["petugas"] . "-GG ) </small>";
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }

                                        if ($checklist_keluar != "") {
                                            $result1 = mysqli_query($conn, "SELECT c.*, u.`nama_user` FROM `checklist_record` C, `user` U WHERE c.`id_check` = '$checklist_keluar' and c.`petugas` = u.`nia`;");
                                            while ($row3 = mysqli_fetch_array($result1)) {
                                            ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <small
                                                                    class="text-secondary float-right"><?php echo tgl_indo($row3["tgl_checklist"]); ?></small>
                                                                <h5 class="card-title">Pengecekan Pemutihan</h5>
                                                                <?php
                                                                if ($row3["status_peminjaman"] != "") {
                                                                    echo "Alat ini " . $row3["status_peminjaman"] . " pada nomor peminjaman <a class='text-dark' href='tampil_peminjaman.php?id_peminjaman_masuk=" . $row3["id_peminjaman_masuk"] . "'> " . $row3["id_peminjaman_masuk"] . "</a>. ";
                                                                }
                                                                if ($row3["kondisi"] != "") {
                                                                    echo "Alat ini memiliki kondisi " . $row3["kondisi"] . ", " . $row3["keterangan"] . ". <br/><small class='text-secondary'>(" . $row3["nama_user"] . ", NIA." . $row3["petugas"] . "-GG ) </small>";
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php }
                                        } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <h4>Data Pengecekan Alat | <?php echo $id_alat; ?></h4>
                                    <hr />
                                    <?php
                                    $query = "SELECT * FROM `checklist_record` WHERE `id_alat` = '$id_alat' ORDER BY `tgl_checklist` DESC;";
                                    $result = mysqli_query($conn, $query);
                                    $i = 0;
                                    while ($row2 = mysqli_fetch_array($result)) {
                                        $i++;
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card mb-12">
                                                <div class="row no-gutters">
                                                    <div class="col-md-2">
                                                        <img src="images/<?php if ($row2["foto_alat_check"] != "" || !empty($row2["foto_alat_check"]) || $row2["foto_alat_check"] != null) {
                                                                                    echo $row2["foto_alat_check"];
                                                                                } else {
                                                                                    echo "no_image.png";
                                                                                } ?>" data-toggle="modal"
                                                            data-target="#myModal" class="card-img" id="myImg"
                                                            alt="Snow" style="max-height: 20rem; float:none;">
                                                    </div>
                                                    <div class="col-md-10 ">
                                                        <div class="card-body">
                                                            <div class="float-md-left border-left">
                                                                <div class="container">
                                                                    <small
                                                                        class="text-secondary"><?php echo tgl_indo($row2["tgl_checklist"]); ?></small><br />
                                                                    <b>Petugas : </b>
                                                                    <?php
                                                                            $petugas =  $row2["petugas"];
                                                                            $res2 = mysqli_query($conn, "SELECT nama_user FROM user WHERE nia = '$petugas';");
                                                                            while ($row1 = mysqli_fetch_array($res2)) {
                                                                                echo $row1["nama_user"];
                                                                            }
                                                                            ?><br />
                                                                    <?php if ($row2["id_peminjaman_masuk"] != "") { ?>
                                                                    <b>Peminjaman : </b>
                                                                    <a class="text-dark"
                                                                        href="tampil_peminjaman.php?id_peminjaman_alat=<?php echo $row2["id_peminjaman_masuk"]; ?>"><?php echo $row2["id_peminjaman_masuk"]; ?></a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <div class="float-md-left border-left">
                                                                <div class="container">
                                                                    <b>Kondisi : </b><br />
                                                                    <?php
                                                                            if ($row2["status_peminjaman"] != "") {
                                                                                echo "Alat ini " . $row2["status_peminjaman"] . " pada nomor peminjaman <a class='text-dark' href='tampil_peminjaman.php?id_peminjaman_masuk=" . $row2["id_peminjaman_masuk"] . "'> " . $row2["id_peminjaman_masuk"] . "</a>. ";
                                                                            }
                                                                            if ($row2["kondisi"] != "") {
                                                                                echo "Alat ini memiliki kondisi " . $row2["kondisi"] . ", " . $row2["keterangan"] . ".";
                                                                            }
                                                                            ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- The Modal -->


                                    <div class="modal fade" id="myModal<?php echo $row2['foto_alat_check']; ?>"
                                        role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myModalLabel">
                                                        <?php if ($row2["foto_alat_check"] != "" || !empty($row2["foto_alat_check"]) || $row2["foto_alat_check"] != null) {
                                                                echo $row2["foto_alat_check"];
                                                            } else {
                                                                echo "no_image.png";
                                                            } ?>
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img class="modal-content"
                                                        src="images/<?php if ($row2["foto_alat_check"] != "" || !empty($row2["foto_alat_check"]) || $row2["foto_alat_check"] != null) {echo $row2["foto_alat_check"];} else {echo "no_image.png";} ?>"
                                                        id="img01">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if($_SESSION['status'] == "admin"){ ?>
        <div class="row">
            <div class="col-md-12 ">
                <div class="row">
                    <!-- <div class="col-md-7">
                            <button class="btn btn-outline-primary " onclick="printContent('div1')">
                                <i class="fas fa-print fa-1x"></i>
                            </button>
                        </div> -->
                    <div class="col-md-5">
                        <div class="btn-group ">
                            <?php if ($checklist_keluar == 0) { ?>
                            <a href="form_checklist.php?id_alat=<?php echo $id_alat; ?>"
                                class="btn btn-primary btn-sm">Pengecekan Alat</a>
                            <?php } ?>
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item" onclick="printContent('div1')">
                                    <i class="fas fa-print fa-1x"></i> Cetak </button>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="form_alat.php?id_alat=<?php echo $id_alat; ?>"><i
                                        class='fa fa-pencil fa-1x'></i>Ubah</a>
                                <a class="dropdown-item"
                                    href="form_checklist.php?status=diputihkan&id_alat=<?php echo $id_alat; ?>">
                                    <i class='fa fa-trash-o fa-1x'> </i>Putihkan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <hr />

    </div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>
<?php include 'footer_admin.php'; ?>


<?php
if (isset($_GET['status'])) {
    if ($_GET['status'] == "berhasil") {
        echo "<script type='text/javascript'> window.onload = function(){ alert('Berhasil ditambahkan'); } </script>";
    } else if ($_GET['status'] == "gagal") {
        echo "<script type='text/javascript'> window.onload = function(){ alert('Gagal ditambahkan'); } </script>";
    } else if ($_GET['status'] == "bigsize") {
        echo "<script type='text/javascript'> window.onload = function(){  alert('File gambar memiliki ukuran terlalu besar '); } </script>";
    } else if ($_GET['status'] == "filetype") {
        echo "<script type='text/javascript'> window.onload = function(){  alert('File gambar memiliki tipe file tidak diijinkan'); } </script>";
    }
}
?>
<script>
// Get the modal
// var modal = document.getElementById("myModal");

// // Get the image and insert it inside the modal - use its "alt" text as a caption
// var img = document.getElementById("myImg");
// var modalImg = document.getElementById("img01");
// var captionText = document.getElementById("caption");
// img.onclick = function() {
//     modal.style.display = "block";
//     modalImg.src = this.src;
//     captionText.innerHTML = this.alt;
// }

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}
</script>