<?php
    include 'connection.php';

    $cari;
    $query="SELECT * FROM peminjaman_masuk pm inner join peminjam p on p.nik=pm.nik ORDER BY id_peminjaman_masuk DESC;"; //query vendor
    
    if(isset($_POST["cari"])){
        $cari=$_POST["search"];
        if($cari != ""){
            $query="SELECT * FROM peminjaman_masuk WHERE `id_peminjaman_masuk` LIKE '%$cari%' OR `nama_instansi` LIKE '%$cari%' OR `nama_kegiatan` LIKE '%$cari%' OR `tgl_ambil` LIKE '%$cari%' OR `tgl_kembali` LIKE '%$cari%' ORDER BY tgl_ambil ASC;";
        }
        
    }

    $result=mysqli_query($conn,$query) or die ( mysqli_error());
?>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Data Table</strong>
                    </div>
                    <div class="card-body">
                        <form action="index.php" method="POST">
                        <div class="input-group mb-3 ml-auto col-md-4">
                            
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Search: </span>
                                </div>
                                <input type="text" class="form-control" placeholder="Type here" name="search">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" name="cari">Search</button>
                                </div>
                            
                        </div>
                        </form>
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
                                    <th>Action</th>
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
                                    <td><?php echo $row1["instansi"]; ?></td>
                                    <td><?php echo $row1["nama_kegiatan"]; ?></td>
                                    <td><?php echo $row1["tgl_ambil"]; ?></td>
                                    <td><?php echo $row1["tgl_kembali"]; ?></td>
                                    <td><?php echo $row1["status"]; ?></td>
                                    <td> 
                                            <div class="btn btn-outline-primary btn-sm"><a  href="dash_peminjaman_tampil.php?id_peminjaman_masuk=<?php echo $row1["id_peminjaman_masuk"];?>"> <i class="fas fa-book-open fa-2x"></i> </a></div>
                                    </td>
                                </tr>
                            <?php
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>