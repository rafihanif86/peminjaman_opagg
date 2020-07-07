<?php 
    include "connection.php";
    $halaman = "tracking";
    include 'header_admin.php';
    include 'tgl_indo.php';

    $id_peminjaman_masuk = $nama_instansi = $nik = $petugas_menyetujui = $lampiran_surat = $petugas_pengambilan = $petugas_pengembalian = $nama_peminjam = $nama_kegiatan = $email_peminjam = $tgl_ambil = $tgl_kembali =  $no_wa = $status = null;
    $hidden_disetujui = "hidden";
    $hidden_dikeluarkan = "hidden";
    $tgl_hari_ini = date('Y-m-d');
    
    $judul_action = "Action";
    $link_action = "#";
    $status_print = "";
    $action_button_peminjaman = "";
    $disabled_no_peminjaman = "";
    $hidden_data_peminjaman = "hidden";
    $hidden_alert = "hidden";

    if(isset($_POST['id_peminjaman_masuk'])){
        $id_peminjaman_masuk = $_POST['id_peminjaman_masuk'];
    }else if(isset($_GET['id_peminjaman_masuk'])){
        $id_peminjaman_masuk = $_GET['id_peminjaman_masuk'];
    }

    if($id_peminjaman_masuk != ""){

        $query1 = "SELECT * FROM peminjaman_masuk WHERE id_peminjaman_masuk = '$id_peminjaman_masuk';";
        $result1 = mysqli_query($conn, "SELECT count(id_peminjaman_masuk) as jumlah FROM peminjaman_masuk WHERE id_peminjaman_masuk = '$id_peminjaman_masuk';");
        while ($row1 = mysqli_fetch_array($result1)) {
            $jumlah_data = $row1["jumlah"];
        }

        if($jumlah_data > 0){ 

            $result=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE id_peminjaman_masuk = '$id_peminjaman_masuk';");
            while ($row1=mysqli_fetch_array($result)){
                $nik                =   $row1["nik"];
                $nama_kegiatan      =   $row1["nama_kegiatan"];
                $tgl_ambil          =   $row1["tgl_ambil"];
                $tgl_kembali        =   $row1["tgl_kembali"];
                $status             =   $row1["status"];
                $lampiran_surat     =   $row1["lampiran_surat"];
                $petugas_menyetujui     =   $row1["petugas_menyetujui"];
                $petugas_pengambilan     =   $row1["petugas_pengambilan"];
                $petugas_pengembalian     =   $row1["petugas_pengembalian"];                
            }

            $nik_potong = substr($nik,0,3);
            if($nik_potong == "910"){
                $result=mysqli_query($conn,"SELECT * FROM user  WHERE nia = '$nik';");
                while ($row1=mysqli_fetch_array($result)){
                    $nik = "NIA. ".$nik."-GG";
                    $nama_instansi      =   "OPA Ganendra Giri";
                    $nama_peminjam      =   $row1["nama_user"];
                    $email_peminjam     =   $row1["email"];
                    $no_wa              =   $row1["no_telp"];
                }
            }else{
                $result=mysqli_query($conn,"SELECT * FROM peminjam  WHERE nik = '$nik';");
                while ($row1=mysqli_fetch_array($result)){
                    $nama_instansi      =   $row1["instansi"];
                    $nama_peminjam      =   $row1["nama"];
                    $email_peminjam     =   $row1["email"];
                    $no_wa              =   $row1["no_telepon"];
                }
            }
                
            $query="SELECT D.*, k.nama_jenis_alat FROM detail_peminjaman_masuk D, jenis_alat K WHERE d.id_peminjaman_masuk = '$id_peminjaman_masuk' and k.id_jenis_alat = d.id_jenis_alat;"; 
            $result=mysqli_query($conn,$query); 

            $query2="SELECT k.`nama_jenis_alat`, a.`merk`, a.`type` FROM detail_peminjaman_masuk M,detail_peminjaman_diterima D, alat A, jenis_alat k WHERE m.`id_detail_masuk` = 'id_peminjaman_masuk' AND d.`id_detail_masuk` = m.`id_detail_masuk` AND d.`id_alat` = a.`id_alat` AND m.`id_jenis_alat` = k.`id_jenis_alat`;"; 
            $result2=mysqli_query($conn,$query2); 

            $hidden_data_peminjaman = "";
            $disabled_no_peminjaman = "disabled";
            $action_button_peminjaman = "hidden";

            if($status == 'baru'){
                $hidden_disetujui = "hidden";
                $status_print = 'Pending';
                $judul_action = "<i class='fa fa-check fa-1x'></i> Alat Disetujui";
                $link_action = "form_peminjaman_list.php?id_peminjaman_masuk=".$id_peminjaman_masuk."&update=true";
            }else if ($status == 'disetujui'){
                $hidden_disetujui = "";
                $status_print ='Telah disetujui';
                $judul_action = "<i class='fa fa-people-carry fa-1x'></i> Pengambilan";
                if(date('Y-m-d') >= $tgl_ambil){
                    $link_action = "form_peminjaman_pengambilan.php?id_peminjaman_masuk=".$id_peminjaman_masuk;
                }else{
                    $link_action = "#";
                }
            }else if ($status == 'diambil'){
                $hidden_dikeluarkan = "";
                $hidden_disetujui = "";
                $status_print = 'Alat Telah Diambil';
                $judul_action = "<i class='fa fa-warehouse fa-1x'></i> Pengembalian";
                $link_action = "form_peminjaman_pengembalian.php?id_peminjaman_masuk=".$id_peminjaman_masuk;
            }else if ($status == 'dikembalikan'){
                $hidden_dikeluarkan = "";
                $hidden_disetujui = "";
                $status_print = 'Alat Telah Dikembalikan';
                $judul_action = "Selesai";
                $link_action = "#";
            }
        }else{
            $hidden_alert = "";
        }
    }

?>
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Ringkasan Data Peminjaman Alat</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="dashboard_admin.php?action=<?php echo $status;?>" class="text-dark">Data
                                    Peminjaman</a></li>
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

        <div class="row" <?php echo $action_button_peminjaman?>>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Cari data peminjaman</strong>
                    </div>
                    <form action="tampil_peminjaman.php" method="post" name="frm" enctype="multipart/form-data"
                        class="form-horizontal">
                        <div class="card-body card-block">
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="text-input" class=" form-control-label">Nomor
                                        Peminjaman</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="text-input" name="id_peminjaman_masuk"
                                        placeholder="Nomor peminjaman" class="form-control"
                                        value="<?php echo  $id_peminjaman_masuk; ?>"
                                        <?php echo $disabled_no_peminjaman;?>>
                                    <small class="help-block form-text">Masukkan nomor peminjaman
                                        anda</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-dot-circle-o"></i> Submit
                            </button>
                            <button type="reset" class="btn btn-danger btn-sm">
                                <i class="fa fa-ban"></i> Reset
                            </button>
                            <br />

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="alert alert-warning" role="alert" <?php echo $hidden_alert?>>
            Data peminjaman anda tidak ditemukan. Harap masukkan nomor peminjaman dengan
            benar. Hubungi admin jika anda memiliki masalah peminjaman.
        </div>

        <div class="row" <?php echo $hidden_data_peminjaman;?>>
            <div class="col-lg-12" id="div1">
                <div class="card" style="border: 0;">
                    <img src="images/KERTASKOPGG.png" class="card-img-top"
                        style="height: 100%; width: 100%; margin-left: auto; margin-right: auto;" alt="Kop Surat">
                    <div class="card-body card-block" style="padding-left: 50px; padding-right: 50px;">
                        <h3>Data Peminjaman <?php echo $id_peminjaman_masuk; ?></h3>
                        <hr />
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="float-md-left">
                                        <div class="container">
                                            <div class="row form-group">
                                                <div class="col col-md-4"><label for="email-input"
                                                        class=" form-control-label">Nama
                                                        Peminjam</label></div>
                                                <div class="col col-md-8">: <?php echo $nama_peminjam;?></div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-4"><label for="email-input"
                                                        class=" form-control-label"><?php if($nik_potong == "910"){echo "NIA";}else{echo "NIK";}?></label>
                                                </div>
                                                <div class="col col-md-8">: <?php echo $nik;?></div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-4"><label for="email-input"
                                                        class=" form-control-label">Email</label></div>
                                                <div class="col col-md-8">: <?php echo $email_peminjam;?></div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-4"><label for="text-input"
                                                        class=" form-control-label">No.
                                                        Telepon</label></div>
                                                <div class="col col-md-8">:
                                                    <?php $noPottong = substr($no_wa,1);?>
                                                    <a href="https://api.whatsapp.com/send?phone=<?php echo "+62" .$noPottong; ?>&text=Halo"
                                                        target="_blank" class="text-dark">
                                                        <?php echo $no_wa; ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-4"><label for="text-input"
                                                        class=" form-control-label">Instansi</label></div>
                                                <div class="col col-md-8">: <?php echo $nama_instansi; ?></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="float-md-left border-left">
                                        <div class="container">
                                            <div class="row form-group">
                                                <div class="col col-md-4"><label for="text-input"
                                                        class=" form-control-label">Kegiatan</label></div>
                                                <div class="col col-md-8">: <?php echo $nama_kegiatan ?></div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-4"><label for="text-input"
                                                        class=" form-control-label">Tanggal Peminjaman</label></div>
                                                <div class="col col-md-8">:
                                                    <?php echo tgl_indo($tgl_ambil)." s/d ".tgl_indo($tgl_kembali); ?>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-4"><label for="text-input"
                                                        class=" form-control-label">Status</label></div>
                                                <div class="col col-md-8">:
                                                    <?php echo $status_print; ?></div>
                                            </div>
                                            <small class="text-secondary">
                                                <div class="row form-group"
                                                    <?php if($status == "baru"){echo "hidden";}?>>
                                                    <div class="col col-md-4">
                                                        <label for="text-input" class=" form-control-label">Disetujui
                                                        </label>
                                                    </div>
                                                    <div class="col col-md-8">:
                                                        <?php 
                                                    $query1 = "SELECT * FROM user WHERE nia = '$petugas_menyetujui';";
                                                    $result1=mysqli_query($conn,$query1);
                                                    while ($row1=mysqli_fetch_array($result1)){
                                                        echo $row1["nama_user"];
                                                    }
                                                ?>
                                                    </div>
                                                </div>
                                                <div class="row form-group"
                                                    <?php if($status == "baru" || $status == "disetujui"){echo "hidden";}?>>
                                                    <div class="col col-md-4">
                                                        <label for="text-input" class=" form-control-label">Petugas
                                                            Penyerahan</label>
                                                    </div>
                                                    <div class="col col-md-8">:
                                                        <?php 
                                                    $query1 = "SELECT * FROM user WHERE nia = '$petugas_pengambilan';";
                                                    $result1=mysqli_query($conn,$query1);
                                                    while ($row1=mysqli_fetch_array($result1)){
                                                        echo $row1["nama_user"];
                                                    }
                                                ?>
                                                    </div>
                                                </div>
                                                <div class="row form-group"
                                                    <?php if($status == "baru" || $status == "disetujui" || $status == "diambil"){echo "hidden";}?>>
                                                    <div class="col col-md-4">
                                                        <label for="text-input" class=" form-control-label">Penerima
                                                            Pengembalian</label>
                                                    </div>
                                                    <div class="col col-md-8">:
                                                        <?php 
                                                    $query1 = "SELECT * FROM user WHERE nia = '$petugas_pengembalian';";
                                                    $result1=mysqli_query($conn,$query1);
                                                    while ($row1=mysqli_fetch_array($result1)){
                                                        echo $row1["nama_user"];
                                                    }
                                                ?>
                                                    </div>
                                                </div>
                                            </small>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <h4>List Permintaan</h4>
                                    <hr />
                                    <div class="row">
                                        <?php
                                                $query="SELECT D.*, K.nama_jenis_alat, K.foto_jenis_alat  FROM detail_peminjaman_masuk D, jenis_alat K WHERE K.id_jenis_alat = D.id_jenis_alat AND id_peminjaman_masuk = '$id_peminjaman_masuk' ORDER BY D.`id_detail_masuk`";
                                                $result=mysqli_query($conn,$query) ;
                                                $i = 0;
                                                while ($row2=mysqli_fetch_array($result)){
                                                    $i++;
                                            ?>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="row no-gutters">
                                                    <div class="col-md-4">
                                                        <img src="images/<?php if($row2["foto_jenis_alat"] != "" || !empty($row2["foto_jenis_alat"]) || $row2["foto_jenis_alat"] != null ){echo $row2["foto_jenis_alat"];}else{echo "no_image.png";}?>"
                                                            style="max-height: 20rem; float:none;" class="card-img-top"
                                                            alt="...">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="card-body">
                                                            <div class="col col-md-12 border-left">
                                                                <div class="card-title">
                                                                    <h6><?php echo $row2["nama_jenis_alat"]; ?></h6>
                                                                </div>
                                                                <div class="card-text text-secondary">
                                                                    <small>
                                                                        <b>Permintaan : </b>
                                                                        <?php echo $row2["jumlah"]; ?><br />
                                                                        <b <?php echo  $hidden_disetujui;?>>Disetujui
                                                                            : </b>
                                                                        <?php echo $row2["jumlah_dikeluarkan"]; ?><br />
                                                                        <b <?php echo  $hidden_dikeluarkan;?>>Dikeluarkan
                                                                            : </b>
                                                                        <?php
                                                                                $id_detail_masuk = $row2["id_detail_masuk"];
                                                                                $jum_kel="";
                                                                                $queryKel="SELECT COUNT(*) AS jum_keluar FROM detail_peminjaman_diterima WHERE id_detail_masuk = '$id_detail_masuk'; ";
                                                                                $resultKel=mysqli_query($conn,$queryKel) ;
                                                                                while ($row6=mysqli_fetch_array($resultKel)){
                                                                                    $jum_kel = $row6["jum_keluar"];
                                                                                }
                                                                                if($jum_kel != "0" || $hidden_dikeluarkan != "hidden"){echo $jum_kel;}
                                                                            ?>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($i==2){ $i = 0; echo '</div><div class="row">';} } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row" <?php if($status != "diambil"){echo "hidden";}?>>
                                <div class="col">
                                    <h4>List Alat DiPinjamkan </h4>
                                    <hr />
                                    <div class="row">
                                        <?php   
                                                $query1="SELECT d.*, a.`merk`, a.`type`, a.id_alat, a.foto_alat, a.deskripsi, k.`nama_jenis_alat`, c.`kondisi`, c.`keterangan`, c.tgl_checklist FROM detail_peminjaman_diterima D, `detail_peminjaman_masuk` M, alat A, jenis_alat K, `checklist_record` C WHERE d.`id_detail_masuk` = m.`id_detail_masuk` AND m.id_peminjaman_masuk = '$id_peminjaman_masuk' AND d.`id_check_keluar` = c.`id_check` AND d.`id_alat` = a.`id_alat` AND a.`id_jenis_alat` = k.`id_jenis_alat`;";
                                                $result1=mysqli_query($conn,$query1);
                                                $i = 0;
                                                while ($row2=mysqli_fetch_array($result1)){
                                                    $i++;
                                            ?>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="row no-gutters">
                                                    <div class="col-md-4">
                                                        <img src="images/<?php if($row2["foto_alat"] != "" || !empty($row2["foto_alat"]) || $row2["foto_alat"] != null ){echo $row2["foto_alat"];}else{echo "no_image.png";}?>"
                                                            class="card-img" alt="..."
                                                            style="max-height:15rem;float:none;">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col col-md-12 border-left">
                                                                    <div class="card-title">
                                                                        <a class="text-dark"
                                                                            href="tampil_alat.php?id_alat=<?php echo $row2["id_alat"];?>"
                                                                            target="blank">
                                                                            <h6><?php echo $row2["id_alat"]; ?></h6>
                                                                            <h5> <?php echo $row2["merk"]." ".$row2["type"]; ?>
                                                                            </h5>
                                                                        </a>
                                                                        <small
                                                                            class="text-secondary"><?php echo $row2["nama_jenis_alat"]; ?></small>
                                                                    </div>
                                                                    <div class="card-text ">
                                                                        <b>Ciri:
                                                                        </b><?php echo $row2["deskripsi"]; ?><br />
                                                                        <b>Kondisi: </b>
                                                                        <?php 
                                                                                $id_detail = $row2["id_detail"];
                                                                                $res1=mysqli_query($conn,"SELECT c.`kondisi`, c.`keterangan`, c.`tgl_checklist` FROM `detail_peminjaman_diterima` D, `checklist_record` C WHERE d.`id_check_keluar` = c.`id_check` AND d.`id_detail` = '$id_detail';") ;
                                                                                while ($row1=mysqli_fetch_array($res1)){
                                                                                echo $row2["kondisi"].", ".$row2["keterangan"]." <small class='text-secondary'>(".tgl_indo($row2["tgl_checklist"]).")</small> ";
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
                                        <?php if($i == 2){echo '</div><div class="row">'; $i = 0;} } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row" <?php if($status != "dikembalikan"){echo "hidden";} ?>>
                                <div class="col">
                                    <h4>List Alat Dipinjamkan</h4>
                                    <hr />
                                    <?php   
                                            $query="SELECT d.*, a.`merk`, a.`type`, a.id_alat, a.foto_alat, a.deskripsi, k.`nama_jenis_alat` FROM detail_peminjaman_diterima D, `detail_peminjaman_masuk` M, alat A, jenis_alat K WHERE d.`id_detail_masuk` = m.`id_detail_masuk` AND m.id_peminjaman_masuk = '$id_peminjaman_masuk' AND d.`id_alat` = a.`id_alat` AND a.`id_jenis_alat` = k.`id_jenis_alat`;";
                                            $result=mysqli_query($conn,$query) ;
                                            $i = 0;
                                            while ($row2=mysqli_fetch_array($result)){
                                                $i++;
                                                if($row2["id_check_keluar"] != "" && $row2["id_check_masuk"] != "" ){
                                        ?>
                                    <div class="row">
                                        <div class="col">
                                            <div class="card mb-12">
                                                <div class="row no-gutters">
                                                    <div class="col-md-2">
                                                        <img src="images/<?php if($row2["foto_alat"] != "" || !empty($row2["foto_alat"]) || $row2["foto_alat"] != null ){echo $row2["foto_alat"];}else{echo "no_image.png";}?>"
                                                            class="card-img" alt="..."
                                                            style="max-height: 20rem; float:none;">
                                                    </div>
                                                    <div class="col-md-10 ">
                                                        <div class="card-body">
                                                            <div class="float-md-left border-left">
                                                                <div class="container">
                                                                    <a class="text-dark"
                                                                        href="tampil_alat.php?id_alat=<?php echo $row2["id_alat"];?>"
                                                                        target="blank">
                                                                        <h6><?php echo $row2["id_alat"]; ?></h6>
                                                                        <h5> <?php echo $row2["merk"]." ".$row2["type"]; ?>
                                                                        </h5>
                                                                    </a>
                                                                    <small
                                                                        class="text-secondary"><?php echo $row2["nama_jenis_alat"]; ?></small>
                                                                    <br />
                                                                    <b>Deskripsi : </b>
                                                                    <?php echo $row2["deskripsi"]; ?>
                                                                </div>
                                                            </div>
                                                            <div class="float-md-left border-left">
                                                                <div class="container">
                                                                    <b>Kondisi Penyerahan: </b><br />
                                                                    <?php 
                                                                        $id_detail = $row2["id_detail"];
                                                                        $res1=mysqli_query($conn,"SELECT c.`kondisi`, c.`keterangan`, c.`tgl_checklist` FROM `detail_peminjaman_diterima` D, `checklist_record` C WHERE d.`id_check_keluar` = c.`id_check` AND d.`id_detail` = '$id_detail';") ;
                                                                        while ($row1=mysqli_fetch_array($res1)){
                                                                        echo $row1["kondisi"].", ".$row1["keterangan"]." <small class='text-secondary'>(".tgl_indo($row1["tgl_checklist"]).")</small> ";
                                                                        } 
                                                                    ?>
                                                                    <br />
                                                                    <b>Kondisi Pengembalian: </b><br />
                                                                    <?php 
                                                                        $id_detail = $row2["id_detail"];
                                                                        $res1=mysqli_query($conn,"SELECT c.`kondisi`, c.`keterangan`, c.`tgl_checklist` FROM `detail_peminjaman_diterima` D, `checklist_record` C WHERE d.`id_check_masuk` = c.`id_check` AND d.`id_detail` = '$id_detail';") ;
                                                                        while ($row1=mysqli_fetch_array($res1)){
                                                                        echo $row1["kondisi"].", ".$row1["keterangan"]." <small class='text-secondary'>(".tgl_indo($row1["tgl_checklist"]).") </small>";
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
                                    <?php }} ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" <?php echo $hidden_data_peminjaman;?>>
            <div class="col-md-12 ">
                <div class="btn-group ">
                    <?php if(($_SESSION['status'] == "anggota" && $status =="baru")|| $tgl_kembali < $tgl_hari_ini){ ?>
                    <?php } else {?>
                    <a href="<?php echo $link_action; ?>" class="btn btn-primary btn-sm"
                        disabled><?php echo $judul_action; ?></a>
                    <?php } ?>
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                        <?php if($_SESSION['status'] == "admin" && $status == "baru"){ ?>
                        <a class="dropdown-item"
                            href="form_peminjaman_list.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>"><i
                                class='fa fa-check fa-1x'></i> Alat Disetujui</a>
                        <?php } ?>
                        <?php if($status == "disetujui" && $tgl_kembali > $tgl_hari_ini){?>
                        <a class="dropdown-item"
                            href="<?php if(date('Y-m-d') >= $tgl_ambil){echo 'form_peminjaman_pengambilan.php?id_peminjaman_masuk='.$id_peminjaman_masuk;}else{echo '#';}?>"><i
                                class='fa fa-people-carry fa-1x'></i> Pengambilan</a>
                        <?php } ?>
                        <?php if($status == "diambil"){?>
                        <a class="dropdown-item"
                            href="form_peminjaman_pengembalian.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>"><i
                                class='fa fa-warehouse fa-1x'></i> Pengembalian</a>
                        <?php } ?>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item" onclick="printContent('div1')">
                            <i class="fas fa-print fa-1x"></i> Cetak
                        </button>
                        <?php if($status == "baru" || $_SESSION['status'] == "admin"){?>
                        <a class="dropdown-item"
                            href="form_peminjaman.php?edit=true&id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>"><i
                                class='fa fa-pencil fa-1x'></i> Ubah </a>
                        <?php }?>
                        <?php if($_SESSION['status'] == "admin" && ($status == "baru" || $status == "disetujui")){ ?>
                        <a class="dropdown-item"
                            href="delete_peminjaman.php?id_peminjaman_masuk=<?php echo $id_peminjaman_masuk;?>"
                            onClick="return confirm('Hapus peminjaman ini?')">
                            <i class='fa fa-trash-o fa-1x'> </i> Hapus</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <hr />

        <?php 
                if($lampiran_surat != ""){
            ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Lampiran Surat <?php echo $id_peminjaman_masuk; ?></strong>
                    </div>
                    <div class="card-body card-block">
                        Nama File :<a href="images/<?php echo $lampiran_surat;?>" target="blank" class="text-dark">
                            <?php echo $lampiran_surat;?></a>
                        <hr />
                        <!-- <object data="images/" type="application/pdf" width="100%"
                        height="100%"></object> -->
                        <embed src="images/<?php echo $lampiran_surat;?>" quality="high" allowScriptAccess="always"
                            allowFullScreen="true" pluginspage="http://www.adobe.com/go/getreader"
                            type="application/pdf" width="800" height="600">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php 
            if($id_peminjaman_masuk != ""){
                $foto_jaminan = "";
                $foto_alat_pengambilan = "";
                $foto_alat_pengembalian = "";
                $result=mysqli_query($conn,"SELECT foto_jaminan, foto_alat_pengambilan, foto_alat_pengembalian FROM peminjaman_masuk WHERE  id_peminjaman_masuk = '$id_peminjaman_masuk';");
                while ($row1=mysqli_fetch_array($result)){
                    $foto_jaminan = $row1["foto_jaminan"];
                    $foto_alat_pengambilan = $row1["foto_alat_pengambilan"];
                    $foto_alat_pengembalian = $row1["foto_alat_pengembalian"];
                }
        ?>
        <div class="row" <?php if($foto_jaminan == ""){echo "hidden";} ?>>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Lampiran Foto Jaminan Peminjam <?php echo $id_peminjaman_masuk; ?></strong>
                    </div>
                    <div class="card-body card-block">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img src="images/<?php echo $foto_jaminan;?>" class="d-block w-100"
                                                        alt="">
                                                    <div class="carousel-caption d-none d-md-block">
                                                        <p>File name : <?php echo $foto_jaminan;?></p>
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
        </div>
        <div class="row" <?php if($foto_alat_pengambilan == ""){echo "hidden";} ?>>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Lampiran Foto Seluruh Alal diserahkan <?php echo $id_peminjaman_masuk; ?></strong>
                    </div>
                    <div class="card-body card-block">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img src="images/<?php echo $foto_alat_pengambilan;?>"
                                                        class="d-block w-100" alt="">
                                                    <div class="carousel-caption d-none d-md-block">
                                                        <p>File name : <?php echo $foto_alat_pengambilan;?></p>
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
        </div>
        <div class="row" <?php if($foto_alat_pengembalian == ""){echo "hidden";} ?>>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Lampiran Foto Seluruh Alal Dikembalikan <?php echo $id_peminjaman_masuk; ?></strong>
                    </div>
                    <div class="card-body card-block">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img src="images/<?php echo $foto_alat_pengembalian;?>"
                                                        class="d-block w-100" alt="">
                                                    <div class="carousel-caption d-none d-md-block">
                                                        <p>File name : <?php echo $foto_alat_pengembalian;?></p>
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
        </div>
        <?php } ?>

    </div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>
<?php include 'footer_admin.php'; ?>
<script>
function printContent(el) {
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    window.print();
    document.body.innerHTML = restorepage;
}
</script>