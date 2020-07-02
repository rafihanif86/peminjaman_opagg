<?php 
    include "connection.php";
    $halaman = "lain";
    include 'header_admin.php';

    $id_alat = $merk = $type = $id_jenis_alat = $tgl_masuk = $tgl_keluar =  $id_user = null;

        $id_alat = $_GET['id_alat'];
        $query1 = "SELECT * FROM alat WHERE id_alat = '$id_alat';";
        $result1=mysqli_query($conn,$query1);
        while ($row1=mysqli_fetch_array($result1)){
            $merk = $row1["merk"];
            $type = $row1["type"];
            $id_jenis_alat= $row1["id_jenis_alat"];
            $tgl_masuk= $row1["tgl_masuk"];
            $tgl_keluar= $row1["tgl_keluar"];
            $id_user= $row1["id_user"];
             
        }

    $title_header="Peminjaman | Inventory OPA Ganendra Giri";
    $home_active="";
    $peminjaman_active="active";
    $about_active="";
    
?>
<script>
    function printContent(el){
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>
<body>
    <div class="breadcrumbs col-md-12 mt-3">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Berita Acara Barang Masuk</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content" >
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="div1">
                        <img src="images/KERTASKOPGG.png" class="card-img-top"
                            style="height: 100%; width: 100%; margin-left: auto; margin-right: auto;" alt="Kop Surat">
                        <div class="card-body card-block">
                            <div class="row ml-3 mr-3">
                                <div class="col">
                                    <h3>Data Alat</h3>
                                    <hr />
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input"
                                                class=" form-control-label">Merk</label></div>
                                        <div class="col-12 col-md-9">: <?php echo $merk; ?></div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input"
                                                class=" form-control-label">Type</label></div>
                                        <div class="col-12 col-md-9">: <?php echo $type; ?></div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="email-input"
                                                class=" form-control-label">Id Kategori</label></div>
                                        <div class="col-12 col-md-9">: <?php echo $id_jenis_alat;?></div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input"
                                                class=" form-control-label">Tanggal Masuk</label></div>
                                        <div class="col-12 col-md-9">: <?php echo $tgl_masuk ?></div>
                                    </div>
                                    
                                    
                                    </div>
                                    
                                            <a class="carousel-control-prev" href="#carouselExampleIndicators"
                                                role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselExampleIndicators"
                                                role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                                
                        </div>
                    </div>
                    <button class="btn btn-outline-primary btn-sm" onclick="printContent('div1')"><i class="fas fa-print fa-2x"></i></button>
                </div>
            </div>
        </div>
    </div>
    
    </div><!-- .animated -->
    </div><!-- .content -->

    <div class="clearfix"></div>
    <?php
            include 'footer_dashboard.php'
        ?>
</body>

</html>