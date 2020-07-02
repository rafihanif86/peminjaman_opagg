<?php
    include 'connection.php';

    $cari;
    $query="SELECT * FROM peminjaman_masuk ORDER BY tgl_ambil ASC;"; //query vendor
    $result=mysqli_query($conn,$query);

    if(isset($_POST["submit"])){
        $cari=$_POST["search"];
        if($cari != ""){
            $query="SELECT * FROM peminjaman_masuk WHERE `id_peminjaman_masuk` LIKE '%$cari%' OR `nama_instansi` LIKE '%$cari%' OR `nama_kegiatan` LIKE '%$cari%' OR `tgl_ambil` LIKE '%$cari%' OR `tgl_kembali` LIKE '%$cari%' ORDER BY tgl_ambil ASC;";
        }
        
    }

    $result=mysqli_query($conn,$query);
?>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Data Table</strong>
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3 ml-auto col-md-4">
                            <form action="tabel_peminjaman_dash.php" method="post"></form>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Search: </span>
                                </div>
                                <input type="text" class="form-control" placeholder="Type here" name="search">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" name="submit">Search</button>
                                </div>
                            </form>
                        </div>
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No. Peminjaman</th>
                                    <th>Instansi</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Tgl Ambil</th>
                                    <th>Tgl Keluar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i = 0;
                                while ($row1=mysqli_fetch_array($result)){
                                    $i++;
                            ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $row1["id_peminjaman_masuk"]; ?></td>
                                    <td><?php echo $row1["nama_instansi"]; ?></td>
                                    <td><?php echo $row1["nama_kegiatan"]; ?></td>
                                    <td><?php echo $row1["tgl_ambil"]; ?></td>
                                    <td><?php echo $row1["tgl_kembali"]; ?></td>
                                    <td><?php echo $row1["status"]; ?></td>
                                </tr>
                            <?php
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>