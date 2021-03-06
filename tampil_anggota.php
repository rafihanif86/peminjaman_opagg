<?php 
    include "connection.php";
    $halaman = "lain";
    include 'style_popup_image.php';
    include 'header_admin.php';
    include 'tgl_indo.php';

    $nia_anggota = $checklist_masuk = $checklist_keluar = "";
    
    $judul_action = "Action";
    $link_action = "#";

    if(isset($_POST['nia'])){
        $nia_anggota = $_POST['nia'];
    }else if(isset($_GET['nia'])){
        $nia_anggota = $_GET['nia'];
    }

    if($nia_anggota != ""){

        $result=mysqli_query($conn, "SELECT * FROM USER WHERE nia = '$nia_anggota';");
        while ($row1=mysqli_fetch_array($result)){
            $nama = $row1["nama_user"];
            $email = $row1["email"];
            $telepon = $row1["no_telp"];
            $foto_anggota = $row1["foto_anggota"];
            $status_anggota = $row1["status_anggota"];
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
            <div class="col-sm-5">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Ringkasan Data Anggota</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="tebel_alat.php?action=seluruh" class="text-dark">Data
                                    Anggota</a></li>
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
        <div id="div1">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card" style="border: 0;">
                        <div class="card-body card-block" style="padding-left: 50px; padding-right: 50px;">
                            <h3>Data Anggota</h3>
                            <hr />
                            <div class="container">
                                <div class="row">
                                    <div class="col ">
                                        <div class="float-md-left">
                                            <div class="container">
                                                <div class="row form-group">
                                                    <div class="col col-md-12">
                                                        <img src="images/<?php if($foto_anggota != "" || !empty($foto_anggota) || $foto_anggota != null ){echo $foto_anggota;}else{echo "user-icon.png";}?>"
                                                            class="rounded mx-auto d-block" alt="..."
                                                            style="max-height: 20rem;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="float-md-left border-left">
                                            <div class="container">
                                                <div class="row form-group">
                                                    <div class="col col-md-3"><label for="text-input"
                                                            class=" form-control-label"><b>Nomor Induk
                                                                Anggota</b></label>
                                                    </div>
                                                    <div class="col-12 col-md-9">
                                                        <?php echo ": NIA. ".$nia_anggota."-GG"; ?>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col col-md-3"><label for="text-input"
                                                            class=" form-control-label"><b>Nama</b></label></div>
                                                    <div class="col-12 col-md-9"><?php echo ": "; echo $nama; ?></div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col col-md-3"><label for="text-input"
                                                            class=" form-control-label"><b>Email</b></label></div>
                                                    <div class="col-12 col-md-9"><?php echo ": "; echo $email; ?></div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col col-md-3"><label for="text-input"
                                                            class=" form-control-label"><b>Telepon</b></label></div>
                                                    <div class="col-12 col-md-9"><?php echo ": "; echo $telepon; ?>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col col-md-3"><label for="text-input"
                                                            class=" form-control-label"><b>Status Anggota</b></label>
                                                    </div>
                                                    <div class="col-12 col-md-9">
                                                        <?php echo ": "; echo $status_anggota; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Data peminjaman yg dipinjam</strong>
                        </div>
                        <div class="card-body">
                            <?php
                            $result=mysqli_query($conn,"SELECT * FROM peminjaman_masuk where nik = '$nia_anggota' order by id_peminjaman_masuk desc;"); //query vendor
                            $i = 0;
                            while ($row1=mysqli_fetch_array($result)){
                                $i++;
                                $status = $row1["status"];
                        ?>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="card mb-12">
                                        <div class="row no-gutters">
                                            <div class="col-md-12 ">
                                                <div class="card-body">
                                                    <div class="float-md-left">
                                                        <div class="container">
                                                            <small
                                                                class="text-secondary"><?php echo $row1["tgl_ambil"]." s/d ".$row1["tgl_kembali"]; ?></small>
                                                            <br />
                                                            <a class="text-dark"
                                                                href="tampil_peminjaman.php?id_peminjaman_masuk=<?php echo $row1["id_peminjaman_masuk"];?>">
                                                                <h5><?php echo $row1["id_peminjaman_masuk"]; ?>
                                                                </h5>
                                                                <?php
                                                            $nama_instansi      =   "";
                                                            $nama_peminjam      =   "";
                                                            $nik_potong = substr($row1["nik"],0,3);
                                                            $nik = $row1["nik"];
                                                            if($nik_potong == "910"){
                                                                $result2=mysqli_query($conn,"SELECT * FROM user  WHERE nia = '$nik';");
                                                                while ($row2=mysqli_fetch_array($result2)){
                                                                    $nama_instansi      =   "OPA Ganendra Giri";
                                                                    $nama_peminjam      =   $row2["nama_user"];
                                                                }
                                                            }else{
                                                                $result2=mysqli_query($conn,"SELECT * FROM peminjam  WHERE nik = '$nik';");
                                                                while ($row2=mysqli_fetch_array($result2)){
                                                                    $nama_instansi      =   $row2["instansi"];
                                                                    $nama_peminjam      =   $row2["nama"];
                                                                }
                                                            }
                                                        ?>
                                                                <h3> <?php echo $nama_peminjam; ?>
                                                                    <small
                                                                        class="text-secondary">(<?php echo $nama_instansi;?>)</small>
                                                                </h3>
                                                            </a>
                                                            <div class="row">
                                                                <div class="col col-md-3 ">
                                                                    Kegitatan
                                                                </div>
                                                                <div class="col col-md-9 ">
                                                                    :
                                                                    <?php echo $row1["nama_kegiatan"];?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col col-md-3 ">
                                                                    Status
                                                                </div>
                                                                <div class="col col-md-9 ">:
                                                                    <?php
                                                                $query2 = ""; 
                                                                if($status == "baru"){
                                                                    echo '<i class="fa fa-spinner"></i>';
                                                                    $query2="";
                                                                }else if($status == "disetujui"){
                                                                    echo '<i class="fa fa-check"></i>';
                                                                    $query2="SELECT * FROM user U WHERE U.`nia` =  ". $row1["petugas_menyetujui"];
                                                                }else if($status == "diambil"){
                                                                    echo '<i class="fa fa-people-carry"></i>';
                                                                    $query2="SELECT * FROM user U WHERE U.`nia` =  ". $row1["petugas_pengambilan"];
                                                                }else if($status == "dikembalikan"){
                                                                    echo '<i class="fa fa-warehouse"></i>';
                                                                    $query2="SELECT * FROM user U WHERE U.`nia` =  ". $row1["petugas_pengambilan"];
                                                                }
                                                                
                                                                if($query2 != ""){
                                                                    $result2=mysqli_query($conn,$query2);
                                                                    while ($row2=mysqli_fetch_array($result2)){
                                                                        echo " | ".$row2["nama_user"];
                                                                    }
                                                                }
                                                            ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="float-md-left border-left">
                                                        <div class="container">
                                                            <h5>List Alat : </h5><br />
                                                            <table class="table table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col" width="55%">
                                                                            Jenis Alat
                                                                        </th>
                                                                        <th scope="col" width="15%">
                                                                            Permintaan
                                                                        </th>
                                                                        <th scope="col" width="15%"
                                                                            <?php if($status == "baru"){echo "hidden";}?>>
                                                                            Disetujui</th>
                                                                        <th scope="col" width="15%"
                                                                            <?php if($status == "baru" || $status == "disetujui"){echo "hidden";}?>>
                                                                            Dikeluarkan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                    $id = $row1["id_peminjaman_masuk"];
                                                                    $que11 = "SELECT d.*, k.`nama_jenis_alat` FROM `detail_peminjaman_masuk` D, `jenis_alat` K WHERE d.`id_jenis_alat` = k.`id_jenis_alat` AND d.`id_peminjaman_masuk` ='$id';";
                                                                    $res11=mysqli_query($conn,$que11) ;
                                                                    $i = 0;
                                                                    while ($row1=mysqli_fetch_array($res11)){
                                                                        $i++;
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $row1["nama_jenis_alat"]; ?>
                                                                        </td>
                                                                        <td><?php echo $row1["jumlah"]; ?>
                                                                        </td>
                                                                        <td
                                                                            <?php if($status == "baru"){echo "hidden";}?>>
                                                                            <?php echo $row1["jumlah_dikeluarkan"]; ?>
                                                                        </td>
                                                                        <td
                                                                            <?php if($status == "baru" || $status == "disetujui"){echo "hidden";}?>>
                                                                            <?php
                                                                            $id_detail_masuk = $row1["id_detail_masuk"];
                                                                            $jum_kel="";
                                                                            $queryKel="SELECT COUNT(*) AS jum_keluar FROM detail_peminjaman_diterima WHERE id_detail_masuk = '$id_detail_masuk'; ";
                                                                            $resultKel=mysqli_query($conn,$queryKel) ;
                                                                            while ($row6=mysqli_fetch_array($resultKel)){
                                                                                $jum_kel = $row6["jum_keluar"];
                                                                            }
                                                                            if($jum_kel != "0" || $hidden_dikeluarkan != "hidden"){echo $jum_kel;}
                                                                        ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php  } ?>
                        </div>
                        <div class="card-footer">
                            <i class="fa fa-spinner"></i> Pending | <i class="fa fa-check"></i> Telah Disetujui | <i
                                class="fa fa-people-carry"></i> Telah Diambil | <i class="fa fa-warehouse"></i>
                            Telah
                            Dikembalikan
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Checklist Bulanan Yang Diikuti</strong>
                        </div>
                        <div class="card-body">
                            <?php
                                $query="SELECT g.*, u.nama_user FROM `checklist_group_item` I, `checklist_group` G, USER U WHERE g.`koordinator` = u.`nia` AND g.`id_checklist_group` = i.`id_checklist_group` AND (i.`petugas_check` = '$nia_anggota' or g.`koordinator` = '$nia_anggota') GROUP BY i.`id_checklist_group`; "; 
                                $result=mysqli_query($conn,$query);
                                $i = 0;
                                while ($row1=mysqli_fetch_array($result)){
                                    $i++;
                                    $id_checklist_group = $row1["id_checklist_group"];
                            ?>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="card mb-12">
                                        <div class="row no-gutters">
                                            <div class="col-md-2">
                                                <img src="images/<?php if($row1["dokumentasi"] != "" || !empty($row1["dokumentasi"] ) || $row1["dokumentasi"]  != null ){echo $row1["dokumentasi"];}else{echo "no_image.png";}?>"
                                                    style="max-height: 20rem; " class="card-img" alt="...">
                                            </div>
                                            <div class="col-md-10">
                                                <div class="card-body">
                                                    <div class="float-md-left border-left">
                                                        <div class="container">
                                                            <a class="text-dark"
                                                                href="<?php if($_SESSION['status'] == "admin"){ echo "tampil_peminjaman.php?id_peminjaman_masuk=".$row1['id_peminjaman_masuk'];}?>">
                                                                <small
                                                                    class="text-secondary"><?php echo $row1["tgl_checklist_group"]; ?></small><br />
                                                                Koordinator:<br />
                                                                <h3> <?php echo $row1["nama_user"]; ?></h3>
                                                                Resume:<br />
                                                                <?php echo $row1["resume"]; ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="float-md-left border-left">
                                                        <div class="container">
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
                                                                                $query1="SELECT i.`petugas_check`, u.`nama_user`, u.`nia`, u.`foto_anggota` FROM `checklist_group` G, `checklist_group_item` I, `user` U WHERE i.`petugas_check` = u.`nia` AND i.`id_checklist_group` = g.`id_checklist_group` AND g.`id_checklist_group` = '$id_checklist_group' GROUP BY i.petugas_check;";
                                                                                $result1=mysqli_query($conn,$query1);
                                                                                $anggota_mengikuti = mysqli_num_rows($result1);
                                                                                echo $anggota_mengikuti;
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Alat dichecklist</td>
                                                                        <td>
                                                                            <?php
                                                                                $query2="SELECT c.* FROM `checklist_group_item` C, `alat` A, `user` U, `jenis_alat` J, `checklist_record` R WHERE c.`id_checklist_group` = '$id_checklist_group' AND c.`id_check` = r.`id_check` AND a.`id_jenis_alat` = j.`id_jenis_alat` AND a.`id_alat` = c.`id_alat` AND c.`petugas_check` = u.`nia` ORDER BY c.`id_alat` DESC;";
                                                                                $result2=mysqli_query($conn,$query2);
                                                                                $jumlah_telah_check = mysqli_num_rows($result2);
                                                                                echo $jumlah_telah_check;
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
                            </div>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Alat yang dichecklist</strong>
                            <!-- <a href="form_peminjaman.php" class="btn btn-outline-success btn-sm float-right" role="button" style="margin-right: 5px;"
                            aria-pressed="true"><i class="fas fa-plus-circle fa-1x"></i> Peminjaman</a> -->
                        </div>
                        <div class="card-body">
                            <?php
                                    $result=mysqli_query($conn,"SELECT c.*, a.`merk`, a.`type`, j.`nama_jenis_alat`, u.`nama_user` FROM checklist_record c, alat a, `jenis_alat` j, USER u WHERE c.`id_alat` = a.`id_alat` AND a.`id_jenis_alat` = j.`id_jenis_alat` AND c.`petugas` = u.`nia` AND c.`petugas` = '$nia_anggota' ORDER BY tgl_checklist DESC;");
                                    $i = 0;
                                    while ($row1=mysqli_fetch_array($result)){
                                        $i++;
                                ?>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="card mb-12">
                                        <div class="row no-gutters">
                                            <div class="col-md-10 ">
                                                <div class="card-body">
                                                    <div class="float-md-left border-left">
                                                        <div class="container">
                                                            <small
                                                                class='text-secondary'>(<?php echo $row1['tgl_checklist'].", ".$row1["nama_user"];?>)
                                                            </small>
                                                            <a class="text-dark"
                                                                href="<?php if($_SESSION['status'] == "admin"){ echo "tampil_alat.php?id_alat=".$row1["id_alat"];}?>">
                                                                <h6><?php echo $row1["id_alat"]; ?></h6>
                                                                <h5> <?php echo  $row1["merk"]." ". $row1["type"];; ?>
                                                                </h5>
                                                            </a>
                                                            <small
                                                                class="text-secondary"><?php echo  $row1["nama_jenis_alat"]; ?></small>
                                                        </div>
                                                    </div>
                                                    <div class="float-md-left border-left">
                                                        <div class="container">
                                                            <b>Kondisi : </b><br />
                                                            <?php if($row1["status_peminjaman"] != ""){echo "Alat ini ".$row1["status_peminjaman"]." pada nomor peminjaman <a class='text-dark' href='tampil_peminjaman.php?id_peminjaman_masuk=".$row1["id_peminjaman_masuk"]."'> ".$row1["id_peminjaman_masuk"]."</a>. ";} 
                                                                    if($row1["kondisi"] != ""){echo "Alat ini memiliki kondisi ".$row1["kondisi"].", ".$row1["keterangan"].".";} ?>
                                                            <br />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <img src="images/<?php if($row1["foto_alat_check"] != "" || !empty($row1["foto_alat_check"]) || $row1["foto_alat_check"] != null ){echo $row1["foto_alat_check"];}else{echo "no_image.png";}?>"
                                                    class="card-img" alt="..." style="max-height: 20rem; float:none;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                            <!-- <a href="form_checklist.php?id_alat=<?php echo $id_alat;?>"
                                class="btn btn-primary btn-sm">Pengecekan Alat</a> -->
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item" onclick="printContent('div1')">
                                    <i class="fas fa-print fa-1x"></i> Cetak </button>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="form_anggota.php?nia=<?php echo $nia_anggota;?>"><i
                                        class='fa fa-pencil fa-1x'></i>Ubah</a>
                                <?php if($_SESSION['status'] == "admin"){ ?>
                                <a class="dropdown-item" href="delete_anggota.php?nia=<?php echo $nia_anggota;?>">
                                    <i class='fa fa-trash-o fa-1x'> </i>Hapus</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>
<?php include 'footer_admin.php'; ?>

<!-- The Modal -->
<div id="myModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
</div>

<?php 

if(isset($_GET['status'])){
    if($_GET['status'] == "berhasil"){
        echo "<script type='text/javascript'> window.onload = function(){ alert('Berhasil ditambahkan'); } </script>";
    }else if($_GET['status'] == "gagal"){
        echo "<script type='text/javascript'> window.onload = function(){ alert('Gagal ditambahkan'); } </script>";
    }else if($_GET['status'] == "bigsize"){
        echo "<script type='text/javascript'> window.onload = function(){  alert('File gambar memiliki ukuran terlalu besar '); } </script>";
    }else if($_GET['status'] == "filetype"){
        echo "<script type='text/javascript'> window.onload = function(){  alert('File gambar memiliki tipe file tidak diijinkan'); } </script>";
    }
}
?>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function() {
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}
</script>