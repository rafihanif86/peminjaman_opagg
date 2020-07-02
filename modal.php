<a id="modal-26" href='#myModal' role="button" class="btn" data-toggle="modal">
    <button class="btn-danger">
        Delete
    </button></a>

<script type="text/javascript">
    $(window).on('load', function() {
        $('#myModal').modal('show');
    });
</script>



<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <strong>Alat Yang tersedia</strong>
            </div>
            <div class="card-body card-block">
                <table id="bootstrap-data-table" class="table table-border-0">
                    <thead>
                        <tr>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="row">
                                    <?php
                                    $id_jenis_alat_telah = "";
                                    $qu2 = "SELECT `id_jenis_alat` FROM `detail_peminjaman_masuk` WHERE `id_peminjaman_masuk` = '$id_peminjaman_masuk';";
                                    $re2 = mysqli_query($conn, $qu2);
                                    while ($row4 = mysqli_fetch_array($re2)) {
                                        $id_jenis_alat_telah .= $row4["id_jenis_alat"] . ".";
                                    }
                                    $arr_id_jenis_alat = explode(".", $id_jenis_alat_telah);

                                    $query = "SELECT * FROM jenis_alat j inner join kategori k on j.id_kat = k.id_kat";
                                    $result = mysqli_query($conn, $query);
                                    $a = 0;
                                    while ($row2 = mysqli_fetch_array($result)) {
                                        $id_jenis_alat_data = $row2["id_jenis_alat"];
                                        $print_data = true;
                                        for ($i = 0; $i < sizeof($arr_id_jenis_alat); $i++) {
                                            if ($id_jenis_alat_data == $arr_id_jenis_alat[$i]) {
                                                $print_data = false;
                                                break;
                                            }
                                        }

                                        $jumlah_alat = 0;
                                        $res3 = mysqli_query($conn, "SELECT COUNT(a.`id_alat`) AS jumlah_alat FROM jenis_alat K, alat A WHERE k.`id_jenis_alat` = a.`id_jenis_alat` AND k.`id_jenis_alat` = '$id_jenis_alat_data';");
                                        while ($row4 = mysqli_fetch_array($res3)) {
                                            $jumlah_alat = $row4["jumlah_alat"];
                                        }

                                        if ($print_data && $jumlah_alat != 0) {
                                    ?>
                                            <div class="col-sm-3">
                                                <div class="card" style="max-width: 15rem; max-height: 30rem">
                                                    <img src="images/<?php if ($row2["foto_jenis_alat"] == "" || $row2["foto_jenis_alat"]  == "null") {
                                                                            echo "no_image.png";
                                                                        } else {
                                                                            echo $row2["foto_jenis_alat"];
                                                                        } ?>" class="card-img-top" alt="..." style="max-height: 15rem">
                                                    <div class="card-body" style="height: 5rem">
                                                        <h5 class="card-title">
                                                            <?php echo $row2["nama_kat"]; ?></h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                                                        <input type="hidden" name="id_peminjaman_masuk" class="form-control" value="<?php echo $id_peminjaman_masuk; ?>">
                                                        <input type="hidden" name="id_jenis_alat" class="form-control" value="<?php echo $row2["id_jenis_alat"]; ?>">
                                                        <button type="button" data-toggle="modal" data-target="#myModal<?php echo $row2['id_jenis_alat']; ?>" class="btn btn-primary btn-sm btn-block" name="submit_kat">
                                                            <i class="fa fa-check-square fa-1x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- modal -->
                                            <div class="modal fade" id="myModal<?php echo $row2['id_jenis_alat']; ?>" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">
                                                                Edit Daftar Surat Masuk
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="dash_item_peminjaman.php" method="post" name="frm" enctype="multipart/form-data" class="form-horizontal">
                                                                <div class="card-body card-block">
                                                                    <div class="row form-group">
                                                                        <div class="col col-md-3">
                                                                            <label for="text-input" class=" form-control-label">Jenis
                                                                                Alat</label>
                                                                        </div>
                                                                        <div class="col-12 col-md-9">
                                                                            <select name="id_jenis_alat" class="form-control" disabled>
                                                                                <?php
                                                                                $query = "SELECT * FROM kategori";
                                                                                $sql = mysqli_query($conn, $query);
                                                                                while ($row10 = mysqli_fetch_array($sql)) {
                                                                                    $select = "";
                                                                                    if ($row10['id_jenis_alat'] == $row2['id_jenis_alat']) {
                                                                                ?>
                                                                                        <option selected value="<?php echo $row10['id_jenis_alat']; ?>">
                                                                                            <?php echo $row10['nama_kat']; ?>
                                                                                        </option>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <option value="<?php echo $row10['id_jenis_alat']; ?>">
                                                                                            <?php echo $row10['nama_kat']; ?>
                                                                                        </option>
                                                                                <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <small class="form-text text-muted">pilih
                                                                                jenis alat</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group">
                                                                        <div class="col col-md-3">
                                                                            <label for="text-input" class=" form-control-label">Masukkan
                                                                                jumlah</label>
                                                                        </div>
                                                                        <div class="col-12 col-md-9">

                                                                            <input type="number" name="jumlah" class="form-control" placeholder="Masukkan jumlah Peminjaman" min="1" max="<?php echo $jumlah_alat; ?>">
                                                                            <small class="help-block form-text">Masukkan
                                                                                jumlah yang akan
                                                                                dipinjam</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer">
                                                                    <input type="hidden" name="id_peminjaman_masuk" class="form-control" value="<?php echo $id_peminjaman_masuk; ?>">
                                                                    <input type="hidden" name="id_detail_masuk" class="form-control" value="<?php echo $id_detail_masuk; ?>">
                                                                    <input type="hidden" name="id_jenis_alat" class="form-control" value="<?php echo $row2["id_jenis_alat"]; ?>">
                                                                    <!-- <input type="hidden" name="id_peminjaman_masuk" class="form-control" value="<?php echo $id_peminjaman_masuk; ?>">
                                                                                        <input type="hidden" name="id_detail_masuk" class="form-control" value="<?php echo $id_detail_masuk; ?>">
                                                                                        <input type="hidden" name="id_jenis_alat" class="form-control" value="<?php echo $id_jenis_alat; ?>"> -->

                                                                    <button type="submit" class="btn btn-primary btn-sm" name="submit">
                                                                        <i class="fa fa-dot-circle-o"></i>
                                                                        Submit
                                                                    </button>
                                                                    <button type="reset" class="btn btn-danger btn-sm" name="reset">
                                                                        <i class="fa fa-ban"></i> Reset
                                                                    </button>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                    <?php
                                            $a++;
                                            if ($a >= 4) {
                                                $a = 0;
                                                echo '</div></td></tr><tr><td><div class="row">';
                                            }
                                        }
                                    }
                                    ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>





























<div class="modal fade" id="modal-container-268701<?php echo $data_suratmasuk['NOAGEN']; ?>" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">
                    Edit Daftar Surat Masuk
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="noAgen">No Agen</label>
                        <input type="text" class="form-control" name="noAgen" value="<?php echo $data_suratmasuk['NOAGEN']; ?>" disabled>
                        <input type="hidden" name="idSuratMasuk" value="<?php echo $data_suratmasuk['IDSURATMASUK']; ?>">
                        <input type="hidden" name="tahun_id" value="<?php echo $data_suratmasuk['TAHUN']; ?>">
                    </div>



                    <button type="submit" class="btn btn-primary" name="update" style="width: 100%;">Simpan Perubahan</button>
                </form>
            </div>
            <div class="modal-footer">


                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Keluar
                </button>
            </div>
        </div>

    </div>

</div>

<div class="card-body">
    <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
    <input type="hidden" name="id_peminjaman_masuk" class="form-control" value="<?php echo $id_peminjaman_masuk; ?>">
    <input type="hidden" name="id_jenis_alat" class="form-control" value="<?php echo $row2["id_jenis_alat"]; ?>">
    <button type="button" data-toggle="modal" data-target="#myModal<?php echo $row2['id_jenis_alat']; ?>" class="btn btn-primary btn-sm btn-block" name="submit_kat">
        <i class="fa fa-check-square fa-1x"></i>
    </button>
</div>


<div class="card-body card-block">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th style="width: 180px;">Foto Alat</th>
                <th>Jenis Alat</th>
                <th>Jumlah</th>
                <th style="width: 100px;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // $query = "SELECT D.*, K.nama_kat, K.foto_kat FROM detail_peminjaman_masuk D,kategori K WHERE K.id_jenis_alat = D.id_jenis_alat AND id_peminjaman_masuk = '$id_peminjaman_masuk' ORDER BY D.`id_detail_masuk`;";
            $query = "SELECT * FROM detail_peminjaman_masuk d
                                            inner join jenis_alat j
                                            on d.id_jenis_alat = j.id_jenis_alat
                                            inner join kategori k
                                            on j.id_kat = k.id_kat
                                            where d.id_peminjaman_masuk = '$id_peminjaman_masuk' ORDER BY d.id_detail_masuk;";
            $result = mysqli_query($conn, $query);
            $i = 0;
            while ($row2 = mysqli_fetch_array($result)) {
                $i++;
            ?>
                <tr>
                    <th scope="row"><?php echo $i ?></th>
                    <td>
                        <img src="images/<?php if ($row2["foto_kat"] == "" || $row2["foto_kat"]  == "null") {
                                                echo "no_image.png";
                                            } else {
                                                echo $row2["foto_kat"];
                                            } ?>" class="img-responsive rounded" alt="" style="max-width: 130px;">
                    </td>
                    <td><?php echo $row2["nama_kat"]; ?></td>
                    <td><?php echo $row2["jumlah"]; ?></td>
                    <td>
                        <a href="dash_item_peminjaman.php?edit=true&id_peminjaman_masuk=<?php echo $row2["id_peminjaman_masuk"]; ?>&id_detail_masuk=<?php echo $row2["id_detail_masuk"]; ?>" class="btn btn-primary btn-sm" onclick="scrolltoform()">
                            <i class='fa fa-pencil fa-1x'> </i>
                        </a>
                        <a href="delete_detail_peminjaman.php?id_masuk=<?php echo $row2["id_peminjaman_masuk"]; ?>&id_peminjman_masuk=<?php echo $row2["id_detail_masuk"]; ?>&user=peminjam" class="btn btn-danger btn-sm">
                            <i class='fa fa-trash-o fa-1x'> </i>
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>