<?php 
    include 'connection.php';
    $halaman = "peminjaman";
    include 'header_admin.php';

    $act = "";
    $judul = "";

    $act = $_GET["action"];
    if($act != ""){
        $act = $_GET["action"];
        if( $act == "baru"){
            $judul = "Baru";
            $query="SELECT * FROM peminjaman_masuk WHERE status = 'baru' order by id_peminjaman_masuk desc;"; //query vendor
        } else if( $act== "disetujui"){
            $judul = "Telah disetujui";
            $query="SELECT * FROM peminjaman_masuk WHERE status = 'disetujui' order by id_peminjaman_masuk desc;"; //query vendor
        }else if($act == "diambil"){
            $judul = "Telah diambil";
            $query="SELECT * FROM peminjaman_masuk WHERE status = 'diambil' order by id_peminjaman_masuk desc;"; //query vendor
        }else if($act == "dikembalikan"){
            $judul = "Telah dikembalikan";
            $query="SELECT * FROM peminjaman_masuk WHERE  status = 'dikembalikan' order by id_peminjaman_masuk desc;"; //query vendor
        }else if($act == "seluruh"){
            $judul = "Seluruh Data";
            $query="SELECT * FROM peminjaman_masuk order by id_peminjaman_masuk desc;"; //query vendor
            }
    }

    $result=mysqli_query($conn,$query);

   
?>
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Data Peminjaman Alat | <?php echo $judul; ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li>Data Peminjaman Alat</li>
                            <li class="active"><?php echo $judul; ?></li>
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
                        <strong class="card-title">List Data Peminjaman Alat</strong>
                        <a href="laporan_peminjaman.php?action=<?php echo $act;?>"
                            class="btn btn-outline-primary btn-sm float-right" role="button" aria-pressed="true"><i
                                class="fas fa-print fa-1x"></i> Laporan</a>
                        <!-- <a href="form_peminjaman.php" class="btn btn-outline-success btn-sm float-right" role="button" style="margin-right: 5px;"
                            aria-pressed="true"><i class="fas fa-plus-circle fa-1x"></i> Peminjaman</a> -->
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table tabel-border-0">
                            <thead>
                                <tr>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 0;
                                    while ($row1=mysqli_fetch_array($result)){
                                        $i++;
                                        $status = $row1["status"];
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
                                                                    <small
                                                                        class="text-secondary"><?php echo $row1["tgl_ambil"]." s/d ".$row1["tgl_kembali"]; ?></small>
                                                                    <div class="btn-group float-right">
                                                                        <button type="button"
                                                                            class="btn btn-outline-danger btn-sm dropdown-toggle dropdown-toggle-split"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            <span class="sr-only">Toggle Dropdown</span>
                                                                        </button>
                                                                        <div class="dropdown-menu">
                                                                            <a class="dropdown-item"
                                                                                href="delete_peminjaman.php?id_peminjaman_masuk=<?php echo $row1["id_peminjaman_masuk"];?>"
                                                                                onClick="return confirm('Hapus peminjaman ini?')">
                                                                                <i class='fa fa-trash-o fa-1x'> </i>
                                                                                Hapus</a>
                                                                        </div>
                                                                    </div>
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
                                                                        <h3> <?php echo $nama_peminjam; ?> <small
                                                                                class="text-secondary">(<?php echo $nama_instansi;?>)</small>
                                                                        </h3>
                                                                    </a>
                                                                    <div class="row">
                                                                        <div class="col col-md-3 ">
                                                                            Kegitatan
                                                                        </div>
                                                                        <div class="col col-md-9 ">
                                                                            : <?php echo $row1["nama_kegiatan"];?>
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
                                                            <div class="col col-md-7 border-left">
                                                                <div class="card-text">
                                                                    <b>List Alat : </b><br />
                                                                    <table class="table table-sm">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col" width="55%">Jenis Alat
                                                                                </th>
                                                                                <th scope="col" width="15%">Permintaan
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
                                                                                <td><?php echo $row1["jumlah"]; ?></td>
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
                                    </td>
                                </tr>
                                <?php
                                        }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <i class="fa fa-spinner"></i> Pending | <i class="fa fa-check"></i> Telah Disetujui | <i
                            class="fa fa-people-carry"></i> Telah Diambil | <i class="fa fa-warehouse"></i> Telah
                        Dikembalikan
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