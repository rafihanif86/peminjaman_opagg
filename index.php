<?php
    include 'header_dashboard.php';

    
?>
<div class="content">
    <div class="animated fadeIn">
        <div class="row">
        <!-- text header -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Welcome</strong>
                </div>
                <div class="card-body">
                <p>Selamat datang di inventori OPA Ganendra Giri. Di web ini anda dapat meminjam perlatan yang dimiliki Ganendra Giri dengan mengisi form yang ada di tab Peminjaman. Anda juga bisa melihat peminjaman yang telah masuk dan melihat prosesnya</p>
            </div>
        </div>
        <?php
            include 'tabel_peminjaman_dash.php';
        ?>

        </div>
    </div><!-- .animated -->
</div><!-- .content -->

<?php
    include 'footer_dashboard.php';
?>

    