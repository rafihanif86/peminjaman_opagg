<?php 
    include "connection.php";
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php include 'import_header_dash.php'; ?>
    <link rel="shortcut icon" href="images/ggIcon.png">
    <title><?php echo $title_header;?></title>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-md navbar-light " style="background-color: #e3f2fd;">
        <a class="navbar-brand" href="index.php"><img src="images/gg.png" style=" width: 200px;"
                alt="Invenotry OPA Ganendra Giri"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php echo $home_active;?>">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item <?php echo $peminjaman_active;?>">
                    <a class="nav-link" href="dash_peminjaman.php">Peminjaman</a>
                </li>
                <li class="nav-item <?php echo $tracking_active;?>">
                    <a class="nav-link" href="dash_peminjaman_tampil.php">Tracking</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i></a>
                </li>
            </ul>

        </div>
    </nav>