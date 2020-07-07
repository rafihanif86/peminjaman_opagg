<?php include 'session.php';?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Inventory Ganendra Giri</title>
    <meta name="description" content="Inventory Ganendra Giri">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/ggIcon.png">
    <?php include 'import_header.php'; ?>

</head>

<body>
    <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="<?php if($halaman == "dashboard"){echo 'active';}?>">
                        <a href="dashboard_admin.php"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                    </li>
                    <?php
                        $link = ""; 
                        $res=mysqli_query($conn,"SELECT * FROM `checklist_group` WHERE `status` = 'waiting' || `status` = 'onprocess';") ;
                        $jumlah_berjalan = mysqli_num_rows($res);
                        if($jumlah_berjalan > 0){
                            while ($row=mysqli_fetch_array($res)) {
                                $koordinator =  $row['koordinator'];
                            } 
                            if($nia == $koordinator){
                                $link = "form_checklist_group.php";
                            }else{
                                $link = "form_checklist_onprocess.php";
                            }
                    ?>
                    <li class="<?php if($halaman == "checklist bulanan"){echo 'active';}?>">
                        <a href=<?php echo $link; ?>><i class="menu-icon fa fa-calendar-check"></i>Checklist Bulanan</a>
                    </li>
                    <?php
                        }
                    ?>
                    <li class="<?php if($halaman == "tracking"){echo 'active';}?>" >
                        <a href="tampil_peminjaman.php"><i class="menu-icon fa fa-search"></i>Tracking Peminjaman</a>
                    </li>
                    <li class="<?php if($halaman == "peminjaman_anggota"){echo 'active';}?>" 
                        <?php
                            $tampilkan = false;
                            $result=mysqli_query($conn, "SELECT * FROM peminjaman_masuk WHERE nik = '$nia';");
                            while ($row1=mysqli_fetch_array($result)){
                                $status_peminjaman = "";
                                $status_peminjaman = $row1["status"];
                                if($status_peminjaman != "dikembalikan" || $status_peminjaman != "" || $status_peminjaman != "(NULL)"){
                                    $tampilkan = true;
                                    break;
                                }
                            } 
                            if($tampilkan){
                                echo "hidden";
                            }
                        ?>>
                        <a href="form_peminjaman_anggota.php"><i class="menu-icon fa fa-house-user"></i>Peminjaman Anggota</a>
                    </li>
                    <li class="menu-item-has-children dropdown <?php if($halaman == 'peminjaman'){echo 'active';}?>"
                        <?php if($_SESSION['status'] != "admin"){ echo "hidden"; } ?> >
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="true">
                            <i class="menu-icon fa fa-envelope-open-text"></i>Peminjaman Alat</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-spinner"></i><a href="tabel_peminjaman.php?action=baru"> Pending</a></li>
                            <li><i class="fa fa-check"></i><a href="tabel_peminjaman.php?action=disetujui"> Pengambilan</a></li>
                            <li><i class="fa fa-people-carry"></i><a href="tabel_peminjaman.php?action=diambil"> Pengembalian</a></li>
                            <li><i class="fa fa-warehouse"></i><a href="tabel_peminjaman.php?action=dikembalikan"> Selesai</a></li>
                            <li><i class="fa fa-times"></i><a href="tabel_peminjaman.php?action=tidakdiambil"> Tidak Diambil</a></li>
                            <li><i class="fa fa-infinity"></i><a href="tabel_peminjaman.php?action=seluruh"> Seluruh</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown <?php if($halaman == 'alat'){echo 'active';}?>" 
                        <?php if($_SESSION['status'] != "admin"){ echo "hidden"; } ?>>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="true">
                            <i class="menu-icon fa fa-campground"></i>Alat</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-hiking"></i><a href="tabel_kategori.php">Kategori</a></li>
                            <li><i class="fa fa-binoculars"></i><a href="tabel_jenis_alat.php">Jenis Alat</a></li>
                            <li><i class="fa fa-infinity"></i><a href="tabel_alat.php?action=seluruh">Seluruh</a></li>
                            <li><i class="fa fa-check-circle"></i><a href="tabel_alat.php?action=valid">Valid</a></li>
                            <li><i class="fa fa-house-damage"></i><a href="tabel_alat.php?action=rusak">Rusak</a></li>
                            <li><i class="fa fa-ghost"></i><a href="tabel_alat.php?action=hilang">Hilang</a></li>
                            <li><i class="fa fa-times-circle"></i><a href="tabel_alat.php?action=diputihkan">Diputihkan</a></li>
                            <li><i class="fa fa-folder-plus"></i><a href="form_alat.php">Alat Baru</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown <?php if($halaman == 'checklist'){echo 'active';}?>"
                        <?php if($_SESSION['status'] != "admin"){ echo "hidden"; } ?>>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="true">
                            <i class="menu-icon fa fa-clipboard-list"></i>Checklist</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-list"></i><a href="tabel_checklist.php">Terbaru</a></li>
                            <li><i class="fa fa-users"></i><a href=<?php if($link != ""){echo $link;}else{echo "tabel_checklist_group.php";}?>>Checklist Group</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown <?php if($halaman == 'lain'){echo 'active';}?>"
                        <?php if($_SESSION['status'] != "admin"){ echo "hidden"; } ?>>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="true"> <i class="menu-icon fa fa-id-card-alt"></i>Pengguna</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-user-friends"></i><a href="tabel_anggota.php">Anggota</a></li>
                            <li><i class="fa fa-address-book"></i><a href="tabel_peminjam.php">Peminjam</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header" style="padding-left: 0px;">
            <div class="top-left" style="margin:auto;padding-top:7px;">
                <div class="navbar-header">
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars fa-1x"></i></a>
                    <a class="navbar-brand" href="dashboard_admin.php" style="width:auto;padding-left: 15px">
                        <img src="images/gg.png" alt="">
                    </a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <div class="header-left">
                        <!-- <button class="search-trigger float-none"><i class="fa fa-search"></i></button>
                        <div class="form-inline">
                            <form class="search-form" action="vendor_tampildata.php" method="get">
                                <input class="form-control mr-sm-2" type="text" name="text_search" placeholder="Search ..." aria-label="Search" value="">
                                <button class="search-close" type="submit" name="search"><i class="fa fa-close"></i></button>
                            </form>
                        </div> -->

                        <!-- <div class="dropdown for-notification">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell"></i>
                                <span class="count bg-danger">3</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="notification">
                                <p class="red">You have 3 Notification</p>
                                <a class="dropdown-item media" href="#">
                                    <i class="fa fa-check"></i>
                                    <p>Server #1 overloaded.</p>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <i class="fa fa-info"></i>
                                    <p>Server #2 overloaded.</p>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <i class="fa fa-warning"></i>
                                    <p>Server #3 overloaded.</p>
                                </a>
                            </div>
                        </div> -->

                        <!-- <div class="dropdown for-message">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="message" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-envelope"></i>
                                <span class="count bg-primary">4</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="message">
                                <p class="red">You have 4 Mails</p>
                                <a class="dropdown-item media" href="#">
                                    <span class="photo media-left"><img alt="avatar" src="images/avatar/1.jpg"></span>
                                    <div class="message media-body">
                                        <span class="name float-left">Jonathan Smith</span>
                                        <span class="time float-right">Just now</span>
                                        <p>Hello, this is an example msg</p>
                                    </div>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <span class="photo media-left"><img alt="avatar" src="images/avatar/2.jpg"></span>
                                    <div class="message media-body">
                                        <span class="name float-left">Jack Sanders</span>
                                        <span class="time float-right">5 minutes ago</span>
                                        <p>Lorem ipsum dolor sit amet, consectetur</p>
                                    </div>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <span class="photo media-left"><img alt="avatar" src="images/avatar/3.jpg"></span>
                                    <div class="message media-body">
                                        <span class="name float-left">Cheryl Wheeler</span>
                                        <span class="time float-right">10 minutes ago</span>
                                        <p>Hello, this is an example msg</p>
                                    </div>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <span class="photo media-left"><img alt="avatar" src="images/avatar/4.jpg"></span>
                                    <div class="message media-body">
                                        <span class="name float-left">Rachel Santos</span>
                                        <span class="time float-right">15 minutes ago</span>
                                        <p>Lorem ipsum dolor sit amet, consectetur</p>
                                    </div>
                                </a>
                            </div>
                        </div>-->
                    </div>

                    <div class="user-area dropdown float-right">
                        <?php
                            $foto_profil = "user-icon.png";
                            $result=mysqli_query($conn, "SELECT * FROM USER WHERE nia = '$nia';");
                            while ($row1=mysqli_fetch_array($result)){
                                if($row1["foto_anggota"] != ""){
                                    $foto_profil = $row1["foto_anggota"];
                                }
                            }
                        ?>
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="images/<?php echo $foto_profil;?>"
                                alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="tampil_anggota.php?nia=<?php echo $nia;?>"><i
                                    class="fa fa-user"></i>Profil</a>

                            <!-- <a class="nav-link" href="#"><i class="fa fa-bell-o"></i>Notifications <span
                                    class="count">13</span></a>

                            <a class="nav-link" href="#"><i class="fa fa-cog"></i>Settings</a> -->

                            <a class="nav-link" href="logout.php"><i class="fa fa-power-off"></i>Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header><!-- /header -->
        <!-- Header-->