<?php 
    include 'connection.php';
    $halaman = "dashboard"; 
    include 'header_admin.php';

    $bulan_ini = date('m');

    $dipinjam = 0;
    $valid = 0;
    $rusak = 0;
    $hilang = 0;
    $diputihkan = 0;
    $query = "SELECT a.*, k.nama_jenis_alat, i.nama_kat FROM alat A, jenis_alat K, kategori i where k.id_jenis_alat = a.id_jenis_alat and k.id_kat = i.id_kat order by a.id_alat desc;";
    $result=mysqli_query($conn,$query);
    $i = 0;
    while ($row1=mysqli_fetch_array($result)){
        $id_alat = $row1["id_alat"];
        $res1=mysqli_query($conn,"SELECT * FROM `checklist_record` WHERE `id_check` IN (SELECT MAX(`id_check`) FROM `checklist_record` WHERE `id_alat` = '$id_alat');");
        while ($row2=mysqli_fetch_array($res1)){
            $kondisi = $row2["kondisi"];
            $status_peminjaman = $row2["status_peminjaman"];

            if($kondisi == 'valid'){
                $valid++;
            }else if($kondisi == 'rusak'){
                $rusak++;
            }else if($kondisi == 'hilang'){
                $hilang++;
            }else if($kondisi == 'diputihkan'){
                $diputihkan++;
            }

            if($status_peminjaman == "diambil"){
                $dipinjam++;
            }
        }
    }
    $valid_tidakdipinjam = $valid - $dipinjam;
    $jumlah_alat = $valid + $rusak + $hilang + $diputihkan;

    $res2=mysqli_query($conn,"SELECT CONCAT(YEAR(tgl_ambil),' / ',MONTH(tgl_ambil)) AS tahun_bulan FROM peminjaman_masuk GROUP BY YEAR(tgl_ambil),MONTH(tgl_ambil);");
    $res3=mysqli_query($conn,"SELECT COUNT(*) AS jumlah_bulanan FROM peminjaman_masuk GROUP BY YEAR(tgl_ambil),MONTH(tgl_ambil);");
?>
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Dashboard Admin</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li>Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">

        <h2>Peminjaman</h2>
        <hr/>
        <div class="row">
            <div class="col-md-12">
                <div class="card-deck">

                    <div class="card" style="max-height: 7rem;">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col col-md-5" style="width: 70px; height: 70px;">
                                    <div class="bg-success text-white rounded-lg" style="width: 70px; height: 70px;margin: auto;padding: 10px">
                                        <i class="fa fa-envelope-open-text fa-3x" style="margin: auto"></i>
                                    </div>
                                </div>
                                <div class="col col-md-7 border-left">
                                    <h6>Total Peminjaman</h6>
                                    <?php 
                                        $sql3=mysqli_query($conn,"SELECT * FROM peminjaman_masuk;");
                                        echo "<h5>".mysqli_num_rows($sql3)." <small class='text-secondary'>data</small></h5>"; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="max-height: 7rem;">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col col-md-5" style="width: 70px; height: 70px;">
                                    <div class="bg-info text-white rounded-lg" style="width: 70px; height: 70px;margin: auto;padding: 10px">
                                        <i class="fa fa-envelope-open-text fa-3x" style="margin: auto"></i>
                                    </div>
                                </div>
                                <div class="col col-md-7 border-left">
                                    <h6>Peminjaman Bulan ini</h6>
                                    <?php 
                                        $sql3=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE MONTH(tgl_ambil) = '$bulan_ini';");
                                        echo "<h5>".mysqli_num_rows($sql3)." <small class='text-secondary'>data</small></h5>"; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="max-height: 7rem;">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col col-md-5" style="width: 70px; height: 70px;">
                                    <div class="bg-primary text-white rounded-lg" style="width: 70px; height: 70px;margin: auto;padding: 10px">
                                        <i class="fa fa-user-friends fa-3x float-none" ></i>
                                    </div>
                                </div>
                                <div class="col col-md-7 border-left">
                                    <h6>Peminjam</h6>
                                    <?php 
                                        $sql3=mysqli_query($conn,"SELECT nik FROM peminjaman_masuk M GROUP BY nik;");
                                        echo "<h5>".mysqli_num_rows($sql3)." <small class='text-secondary'>orang</small></h5>"; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="max-height: 7rem;">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col col-md-5" style="width: 70px; height: 70px;">
                                    <div class="bg-secondary text-white rounded-lg" style="width: 70px; height: 70px;margin: auto;padding: 10px">
                                        <i class="fa fa-campground fa-3x" ></i>
                                    </div>
                                </div>
                                <div class="col col-md-7 border-left">
                                    <h6>Alat tersedia</h6>
                                    <?php echo "<h5>".$valid." <small class='text-secondary'>alat</small></h5>";   ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <br/>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card-deck">

                    <div class="card" style="max-height: 7rem;">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col col-md-5" style="width: 70px; height: 70px;">
                                    <div class="bg-danger text-white rounded-lg" style="width: 70px; height: 70px;margin: auto;padding: 10px">
                                        <i class="fa fa-spinner fa-3x" style="margin: auto"></i>
                                    </div>
                                </div>
                                <div class="col col-md-7 border-left">
                                    <h6>Pending</h6>
                                    <?php 
                                        $sql3=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE STATUS = 'baru';");
                                        echo "<h5>".mysqli_num_rows($sql3)." <small class='text-secondary'>data</small></h5>"; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="max-height: 7rem;">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col col-md-5" style="width: 70px; height: 70px;">
                                    <div class="bg-info text-white rounded-lg" style="width: 70px; height: 70px;margin: auto;padding: 10px">
                                        <i class="fa fa-check fa-3x" style="margin: auto"></i>
                                    </div>
                                </div>
                                <div class="col col-md-7 border-left">
                                    <h6>Disetujui</h6>
                                    <?php 
                                        $sql3=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE STATUS = 'disetujui';");
                                        echo "<h5>".mysqli_num_rows($sql3)." <small class='text-secondary'>data</small></h5>"; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="max-height: 7rem;">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col col-md-5" style="width: 70px; height: 70px;">
                                    <div class="bg-warning text-white rounded-lg" style="width: 70px; height: 70px;margin: auto;padding: 10px">
                                        <i class="fa fa-people-carry fa-3x float-none" ></i>
                                    </div>
                                </div>
                                <div class="col col-md-7 border-left">
                                    <h6>Diambil</h6>
                                    <?php 
                                        $sql3=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE STATUS = 'diambil';");
                                        echo "<h5>".mysqli_num_rows($sql3)." <small class='text-secondary'>data</small></h5>"; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="max-height: 7rem;">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col col-md-5" style="width: 70px; height: 70px;">
                                    <div class="bg-success text-white rounded-lg" style="width: 70px; height: 70px;margin: auto;padding: 10px">
                                        <i class="fa fa-warehouse fa-3x" ></i>
                                    </div>
                                </div>
                                <div class="col col-md-7 border-left">
                                    <h6>Dikembalikan</h6>
                                    <?php 
                                        $sql3=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE STATUS = 'dikembalikan';");
                                        echo "<h5>".mysqli_num_rows($sql3)." <small class='text-secondary'>data</small></h5>"; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <br/>
        
        <h2>Alat</h2>
        <hr/>
        <div class="row">
            <div class="col-md-12">
                <div class="card-deck">

                    <div class="card" style="max-height: 7rem;">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col col-md-5" style="width: 70px; height: 70px;">
                                    <div class="bg-info text-white rounded-lg" style="width: 70px; height: 70px;margin: auto;padding: 10px">
                                        <i class="fa fa-hiking fa-3x" style="margin: auto"></i>
                                    </div>
                                </div>
                                <div class="col col-md-7 border-left">
                                    <h6>Kategori</h6>
                                    <?php 
                                        $sql3=mysqli_query($conn,"SELECT * FROM kategori;");
                                        echo "<h5>".mysqli_num_rows($sql3)." <small class='text-secondary'>kategori</small></h5>"; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="max-height: 7rem;">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col col-md-5" style="width: 70px; height: 70px;">
                                    <div class="bg-secondary text-white rounded-lg" style="width: 70px; height: 70px;margin: auto;padding: 10px">
                                        <i class="fa fa-binoculars fa-3x" style="margin: auto"></i>
                                    </div>
                                </div>
                                <div class="col col-md-7 border-left">
                                    <h6>Jenis Alat</h6>
                                    <?php 
                                        $sql3=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE MONTH(tgl_ambil) = '$bulan_ini';");
                                        echo "<h5>".mysqli_num_rows($sql3)." <small class='text-secondary'>jenis</small></h5>"; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="max-height: 7rem;">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col col-md-5" style="width: 70px; height: 70px;">
                                    <div class="bg-success text-white rounded-lg" style="width: 70px; height: 70px;margin: auto;padding: 10px">
                                        <i class="fa fa-campground fa-3x float-none" ></i>
                                    </div>
                                </div>
                                <div class="col col-md-7 border-left">
                                    <h6>Total Alat</h6>
                                    <?php 
                                        $sql3=mysqli_query($conn,"SELECT * FROM alat ");
                                        echo "<h5>".mysqli_num_rows($sql3)." <small class='text-secondary'>alat</small></h5>"; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="max-height: 7rem;">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col col-md-5" style="width: 70px; height: 70px;">
                                    <div class="bg-warning text-white rounded-lg" style="width: 70px; height: 70px;margin: auto;padding: 10px">
                                        <i class="fa fa-people-carry fa-3x" ></i>
                                    </div>
                                </div>
                                <div class="col col-md-7 border-left">
                                    <h6>Dipinjam</h6>
                                    <?php  echo "<h5>".$dipinjam." <small class='text-secondary'>alat</small></h5>";  ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <br/>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card-deck">

                    <div class="card" style="max-height: 7rem;">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col col-md-5" style="width: 70px; height: 70px;">
                                    <div class="bg-success text-white rounded-lg" style="width: 70px; height: 70px;margin: auto;padding: 10px">
                                        <i class="fa fa-check-circle fa-3x" style="margin: auto"></i>
                                    </div>
                                </div>
                                <div class="col col-md-7 border-left">
                                    <h6>Valid</h6>
                                    <?php echo "<h5>".$valid." <small class='text-secondary'>alat</small></h5>"; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="max-height: 7rem;">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col col-md-5" style="width: 70px; height: 70px;">
                                    <div class="bg-warning text-white rounded-lg" style="width: 70px; height: 70px;margin: auto;padding: 10px">
                                        <i class="fa fa-house-damage fa-3x" style="margin: auto"></i>
                                    </div>
                                </div>
                                <div class="col col-md-7 border-left">
                                    <h6>Rusak</h6>
                                    <?php 
                                        $sql3=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE STATUS = 'disetujui';");
                                        echo "<h5>".mysqli_num_rows($sql3)." <small class='text-secondary'>alat</small></h5>"; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="max-height: 7rem;">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col col-md-5" style="width: 70px; height: 70px;">
                                    <div class="bg-danger text-white rounded-lg" style="width: 70px; height: 70px;margin: auto;padding: 10px">
                                        <i class="fa fa-ghost fa-3x float-none" ></i>
                                    </div>
                                </div>
                                <div class="col col-md-7 border-left">
                                    <h6>Hilang</h6>
                                    <?php echo "<h5>".$hilang." <small class='text-secondary'>alat</small></h5>";?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="max-height: 7rem;">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col col-md-5" style="width: 70px; height: 70px;">
                                    <div class="bg-info text-white rounded-lg" style="width: 70px; height: 70px;margin: auto;padding: 10px">
                                        <i class="fa fa-times-circle fa-3x" ></i>
                                    </div>
                                </div>
                                <div class="col col-md-7 border-left">
                                    <h6>Diputihkan</h6>
                                    <?php echo "<h5>".$diputihkan." <small class='text-secondary'>alat</small></h5>"; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <br/>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card-deck">

                    <div class="card">
                        <div class="card-body">
                            <h4>Grafik Peminjamanan Alat</h4>
                            <canvas id="barchart_peminjaman"></canvas>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="card-deck">

                    <div class="card">
                        <div class="card-body">
                            <div class="float-right">Jumlah Alat : <?php echo $jumlah_alat?></div>
                            <h4>Diagram Kondisi Alat Saat Ini</h4> 
                            <canvas id="piechart_alat"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <hr/>
        <div class="row">
            <div class="col-md-12">
                <div class="card-deck">

                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Anggota Online</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                    $i = 0;
                                    $result1=mysqli_query($conn,"SELECT * FROM user where login_status = 'login';");
                                    while ($row1=mysqli_fetch_array($result1)){
                                        $i++;
                                ?>
                                <div class="col col-md-3">
                                    <div class="card">
                                        <img src="images/<?php if ($row1["foto_anggota"] != "" || !empty($row1["foto_anggota"]) || $row1["foto_anggota"] != null) { echo $row1["foto_anggota"]; } else {  echo "no_image.png"; } ?>" class="card-img-top" alt="..." style="max-height: 20rem;">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $row1["nama_user"]?><br/>
                                                <small class="text-secondary">NIA. <?php echo $row1["nia"]?>-GG</small>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <?php if($i == 4){ echo "</div><div class='row'>"; $i = 0;} } ?>
                            </div>
                        </div>
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
<script  type="text/javascript">
//   var ctx = document.getElementById("barchart_peminjaman").getContext("2d");
  var barchart_peminjaman = new Chart($('#barchart_peminjaman'), {
            type: 'bar',
            data: {
                labels: [<?php while ($p = mysqli_fetch_array($res2)) { echo "'".$p['tahun_bulan']."',";}?>],
                datasets: [
                    {
                    label: "Jumlah Peminjaman",
                    data: [<?php while ($q = mysqli_fetch_array($res3)) { echo "'".$q['jumlah_bulanan']."',";}?>],
                    backgroundColor: 
                        '#29B0D0',
                    }
                ]
            },
            options: {
            legend: {
              display: false
            },
            barValueSpacing: 20,
            scales: {
              yAxes: [{
                  ticks: {
                      min: 0,
                  }
              }],
              xAxes: [{
                          gridLines: {
                              color: "rgba(0, 0, 0, 0)",
                          }
                      }]
              }
          }
        });

        var myPieChart = new Chart($('#piechart_alat'), {
                  type: 'pie',
                  data: {
                            labels: ['Valid','Dipinjam','Rusak','Hilang','Diputihkan'],
                            datasets: [
                                        {
                                            label: "Penjualan Barang",
                                            data: [<?php echo "'".$valid_tidakdipinjam."',"."'".$dipinjam."',"."'".$rusak."',"."'".$hilang."',"."'".$diputihkan."',";?>],
                                            backgroundColor: [
                                                '#29B0D0',
                                                '#2A516E',
                                                '#F07124',
                                                '#CBE0E3',
                                                '#979193'
                                            ]
                                        }
                                    ]
                },
                  options: {
                    responsive: true
                }
              });

</script>
</script>