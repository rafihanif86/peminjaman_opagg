<?php
    $title_header = "Home | Inventory OPA Ganendra Giri";
    $home_active = "active";
    $peminjaman_active = "";
    $about_active = "";
    include 'header_dashboard.php';

    $result=mysqli_query($conn, "SELECT * FROM user WHERE nia = $nia_anggota");
        while ($row1=mysqli_fetch_array($result)){
            $nama_user      =   $row1["nama_user"];
            $username       =   $row1["username"];
            $password       =   $row1["password"];
            $email       =   $row1["email"];
            $nohp = $row1["no_telp"];
            $status_anggota = $row1["status_anggota"];
        }
?>
<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="3"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="4"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" style="max-height: 45rem;" src="images/IMG_4976.JPG" alt="">
            <div class="carousel-caption d-none d-md-block text-white" style="background-color: rgba(69, 59, 59, 0.5)">
                <h5>Selamat Datang </h5>
                <p class="text-white">Website ini digunakan untuk mengelola peralatan OPA Ganendra Giri. Peminjaman OPA Ganendra Giri dapat dilakukan melalui website ini. Cara peminjaman, anda bisa membacanya dibawah ini...</p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" style="max-height: 45rem;" src="images/DSC_1257.JPG" alt="">
            <div class="carousel-caption d-none d-md-block text-white" style="background-color: rgba(69, 59, 59, 0.5)">
                <h5><i>Mountainering, Survival, Navigation, Conservation</i></h5>
                <p class="text-white"><i>Mountainering, Survival, Navigation, Conservation</i> merupakan ilmu dasar yang harus dimiliki seorang pecinta alam. Sehingga para petualang dapat malakukan petualangan dengan <i>happy</i> akan tetapi juga <i>safety</i>. </p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" style="max-height: 45rem;" src="images/IMG_0446.JPG" alt="">
            <div class="carousel-caption d-none d-md-block text-white" style="background-color: rgba(69, 59, 59, 0.5)">
                <h5>Panjat Tebing</h5>
                <p class="text-white">Panjat tebing merupakan salah satu cabang olahraga yang sangat popular oleh penggiat olahraga extrim. Sehingga olahraga ini juga menjadi suatu divisi di OPA Ganendra Giri untuk dipelajari dan mencetak atlit panjat tebing.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" style="max-height: 45rem;" src="images/20180722_112123.jpg" alt="">
            <div class="carousel-caption d-none d-md-block text-white" style="background-color: rgba(69, 59, 59, 0.5)">
                <h5><i>Caving</i></h5>
                <p class="text-white"><i>Caving</i> merupakan kegiatan yang jarang diketahui orang. Kegiatan ini merupakan suatu kegiatan pengambilan data dari suatu gua untuk mencari potensi-potensi yang ada dalam goa tersebut dengan melakukan eksplorasi di dalam goa.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" style="max-height: 45rem;" src="images/IMG_8511.JPG" alt="">
            <div class="carousel-caption d-none d-md-block text-white" style="background-color: rgba(69, 59, 59, 0.5)">
                <h5>ORAD</h5>
                <p class="text-white">ORAD (Olah Raga Arus Deras) atau yang sering dikenal dengan <i>Rafting</i> ini merupakan orahraga yang menyenangkan. Dengan mengarungi derasnya sungai orahraga ini juga mencetak atlet-atlet internaional.</p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<div class="content" style="max-width: 90%; margin: auto; float:none;">
    <!-- <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p>Selamat datang di inventori OPA Ganendra Giri. Di web ini anda dapat meminjam perlatan yang
                        dimiliki OPA Ganendra Giri dengan mengisi form yang ada di tab Peminjaman. Anda juga bisa melihat peminjaman
                        yang
                        telah masuk dan melihat prosesnya</p>
                </div>
            </div>
        </div>
    </div> -->

    <hr />

    <!-- alur -->
    <div class="row">
        <div class="col-md-12">
            <img src="images/alur.png" alt="images/alur.png" class="img-thumbnail">
        </div>
    </div>

    <hr />
    <!-- tata cara melakukan peminjaman -->
    <div class="row">
        <!-- text header -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-md-center">
                        <div class="col-md-10">
                            <div class="bradcam_text text-center">
                                <h3>Tata Cara</h3>
                                <p>Melakukan Peminjaman Alat di Ukm Opa Ganendra Giri</p>
                            </div>
                            <hr />
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-md-10">
                            <div class="stroy_heading">
                                <h3>1) Klik Peminjaman Baru </h3>
                            </div>
                            <div class="row">
                                <div class="col-md-11 offset-md-1">
                                    <img src="images/index/Tatacara.png" alt="images/index/Tatacara.png"
                                        class="img-thumbnail">
                                    <div class="story_info">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <p>
                                                    Klik tab peminjaman Alat dibawah untuk menampilkan tan
                                                    peminjaman alat.
                                                    <br />
                                                    <a href="dash_peminjaman.php" class="btn btn-success btn-md"
                                                        style="border-radius: 30px;">Form Peminjaman Alat</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-md-10">
                            <div class="story_heading">
                                <h3>2) Masukkan Nomor NIK</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-11 offset-md-1">
                                    <img src="images/index/datapeminjam.png" alt="images/index/datapeminjam.png"
                                        class="img-thumbnail">
                                    <div class="story_info">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <p>Masukkan nomor NIK anda pada kolom dan click submit, setelah itu
                                                    isi
                                                    data
                                                    diri anda. fungsi
                                                    Tracking ini untuk memastikan nomor NIK tidak mengisi formulir
                                                    data
                                                    diri
                                                    lebih dari 1 kali.
                                                    Dan akan tampil tampilan seperti dibawah ini.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <img src="images/index/data.png" alt="images/index/data.png" class="img-thumbnail">
                                    <br />
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row justify-content-md-center">
                        <div class="col-md-10">
                            <div class="story_heading">
                                <h3>3) Pilih Tanggal Peminjaman Alat</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-11 offset-md-1">
                                    <img src="images/index/isidata.png" alt="images/index/data.png"
                                        class="img-thumbnail">
                                    <div class="story_info">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <p>Masukan nama kegiatan, pilih tanggal dan lampirkan foto surat
                                                    kegiatan
                                                    jika ada lalu tekan submit.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-md-10">
                            <div class="story_heading">
                                <h3>4) pilih kategori</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-11 offset-md-1">
                                    <img src="images/index/kategori.png" alt="images/index/kategori.png"
                                        class="img-thumbnail">
                                    <div class="story_info">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <p>Pilih ketegori yang akan di pinjam.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-md-10">
                            <div class="story_heading">
                                <h3>5) Pilih Jenis Alat Yang Akan Dipinjam</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-11 offset-md-1">
                                    <img src="images/index/jenisalat.png" alt="images/index/jenisalat.png"
                                        class="img-thumbnail">
                                    <div class="story_info">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <p>Pilih jenis alat yang akan dipinjam lalu masukan jumlah alat yang
                                                    akan
                                                    dipinjam.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-md-10">
                            <div class="story_heading">
                                <h3>7) Melihat Status Peminjaman</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-11 offset-md-1">
                                    <img src="images/index/Melihatdatapeminjam.png"
                                        alt="images/index/Melihatdatapeminjam.png" class="img-thumbnail">
                                    <div class="story_info">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <p>Untuk melihat status peminjaman, masukan id peminjaman di kolom
                                                    search.
                                                    Jika status peminjaman sudah disetujui maka peminjam dapat
                                                    melakukan
                                                    pengambilan alat di ukm opa ganedra giri
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-md-10">
                            <div class="story_heading">
                                <h3>8) Detail peminjaman</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-11 offset-md-1">
                                    <img src="images/index/surat.png" alt="images/index/surat.png"
                                        class="img-thumbnail">
                                    <div class="story_info">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <p>Data peminjam ini tidak perlu dicektak.
                                                </p>
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

<?php
    include 'footer_dashboard.php';
?>