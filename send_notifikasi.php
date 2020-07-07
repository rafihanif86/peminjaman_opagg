<?php 
    include 'send_notifikasi_sender.php';
    include 'tgl_indo.php';
    $subject = "Peminjaman Peralatan OPA Ganendra Giri";
    $tgl_hari_ini = date('Y-m-d');
    $tgl_besok = date('Y-m-d', strtotime('+1 days', strtotime($tgl_hari_ini)));
    $bulan_ini = date('m');
    $tahun_ini = date('Y');
    $tgl_sekarang = date('d');

    
    // besok pengambilan
    $res1=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE status = 'disetujui' and tgl_ambil = '$tgl_besok'  order by id_peminjaman_masuk desc;");
    while ($row1=mysqli_fetch_array($res1)){
        $id_peminjaman_masuk = $row1["id_peminjaman_masuk"];
        $message = "Salam lestari, Yey peminjaman peralatan anda di OPA Ganendra Giri dengan nomor peminjaman ".$id_peminjaman_masuk." besok tanggal ".tgl_indo($tgl_besok)." dapat diambil. Jangan sampai lupa langsung saja ke sekretariat OPA Ganendra Giri di gedung AS lt.2 Politeknik Negeri Malang dengan menunjukkan nomor peminjaman (".$id_peminjaman_masuk.") anda kepada anggota kami untuk memproses peminjaman anda. Dan jangan lupa untuk membawa KTP dan tanda pengenal sebagai jaminan. Terima Kasih, Salam Lestari";
        $nik_potong = substr($row1["nik"],0,3);
        $nik = $row1["nik"];
        $email = "";
        $nama_peminjam = "";
        if($nik_potong == "910"){
            $result2=mysqli_query($conn,"SELECT * FROM user  WHERE nia = '$nik';");
            while ($row2=mysqli_fetch_array($result2)){
                $email     =   $row2["email"];
                $nama_peminjam      =   $row2["nama_user"];
            }
        }else{
            $result2=mysqli_query($conn,"SELECT * FROM peminjam  WHERE nik = '$nik';");
            while ($row2=mysqli_fetch_array($result2)){
                $email     =   $row2["email"];
                $nama_peminjam      =   $row2["nama"];
            }
        }
        send_mail($nama_peminjam,$email,$subject,$message);
    }

    // hari ini pengambilan
    $res1=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE status = 'disetujui' and tgl_ambil = '$tgl_hari_ini'  order by id_peminjaman_masuk desc;");
    while ($row1=mysqli_fetch_array($res1)){
        $id_peminjaman_masuk = $row1["id_peminjaman_masuk"];
        $message = "Salam lestari, Yey peminjaman peralatan anda di OPA Ganendra Giri dengan nomor peminjaman ".$id_peminjaman_masuk." hari tanggal ".tgl_indo($tgl_besok)." dapat diambil. Jangan sampai lupa langsung saja ke sekretariat OPA Ganendra Giri di gedung AS lt.2 Politeknik Negeri Malang dengan menunjukkan nomor peminjaman (".$id_peminjaman_masuk.") anda kepada anggota kami untuk memproses peminjaman anda. Dan jangan lupa untuk membawa KTP dan tanda pengenal sebagai jaminan. Terima Kasih, Salam Lestari";
        $nik_potong = substr($row1["nik"],0,3);
        $nik = $row1["nik"];
        $email = "";
        $nama_peminjam = "";
        if($nik_potong == "910"){
            $result2=mysqli_query($conn,"SELECT * FROM user  WHERE nia = '$nik';");
            while ($row2=mysqli_fetch_array($result2)){
                $email     =   $row2["email"];
                $nama_peminjam      =   $row2["nama_user"];
            }
        }else{
            $result2=mysqli_query($conn,"SELECT * FROM peminjam  WHERE nik = '$nik';");
            while ($row2=mysqli_fetch_array($result2)){
                $email     =   $row2["email"];
                $nama_peminjam      =   $row2["nama"];
            }
        }
        send_mail($nama_peminjam,$email,$subject,$message);
    }

    // tgl pengambilan terlewat
    $res1=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE status = 'disetujui' and (tgl_ambil < '$tgl_hari_ini' and tgl_kembali > '$tgl_hari_ini')  order by id_peminjaman_masuk desc;");
    while ($row1=mysqli_fetch_array($res1)){
        $id_peminjaman_masuk = $row1["id_peminjaman_masuk"];
        $message = "Salam lestari, Anda telah terlewat untuk mengambil peminjaman peralatan anda di OPA Ganendra Giri dengan nomor peminjaman ".$id_peminjaman_masuk." yang seharusnya diambil tanggal ".tgl_indo($row1["nik"]).". Langsung saja ke sekretariat OPA Ganendra Giri di gedung AS lt.2 Politeknik Negeri Malang dengan menunjukkan nomor peminjaman (".$id_peminjaman_masuk.") anda kepada anggota kami untuk memproses peminjaman anda. Dan jangan lupa untuk membawa KTP dan tanda pengenal sebagai jaminan. Terima Kasih, Salam Lestari";
        $nik_potong = substr($row1["nik"],0,3);
        $nik = $row1["nik"];
        $email = "";
        $nama_peminjam = "";
        if($nik_potong == "910"){
            $result2=mysqli_query($conn,"SELECT * FROM user  WHERE nia = '$nik';");
            while ($row2=mysqli_fetch_array($result2)){
                $email     =   $row2["email"];
                $nama_peminjam      =   $row2["nama_user"];
            }
        }else{
            $result2=mysqli_query($conn,"SELECT * FROM peminjam  WHERE nik = '$nik';");
            while ($row2=mysqli_fetch_array($result2)){
                $email     =   $row2["email"];
                $nama_peminjam      =   $row2["nama"];
            }
        }
        send_mail($nama_peminjam,$email,$subject,$message);
    }

    // peminjaman tidak diambil
    $res1=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE status = 'disetujui' and tgl_kembali = '$tgl_hari_ini'  order by id_peminjaman_masuk desc;");
    while ($row1=mysqli_fetch_array($res1)){
        $id_peminjaman_masuk = $row1["id_peminjaman_masuk"];
        $message = "Salam lestari, Anda telah melewatkan untuk mengambil peminjaman peralatan di OPA Ganendra Giri dengan nomor peminjaman ".$id_peminjaman_masuk.". Permintaan peminjaman anda sudah tidak bisa diambil karena sudah melampaui batas pengembalian alat. Terima Kasih, Salam Lestari";
        $nik_potong = substr($row1["nik"],0,3);
        $nik = $row1["nik"];
        $email = "";
        $nama_peminjam = "";
        if($nik_potong == "910"){
            $result2=mysqli_query($conn,"SELECT * FROM user  WHERE nia = '$nik';");
            while ($row2=mysqli_fetch_array($result2)){
                $email     =   $row2["email"];
                $nama_peminjam      =   $row2["nama_user"];
            }
        }else{
            $result2=mysqli_query($conn,"SELECT * FROM peminjam  WHERE nik = '$nik';");
            while ($row2=mysqli_fetch_array($result2)){
                $email     =   $row2["email"];
                $nama_peminjam      =   $row2["nama"];
            }
        }
        send_mail($nama_peminjam,$email,$subject,$message);
    }

    // besok pengembalian
    $res1=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE status = 'diambil' and tgl_kembali = '$tgl_besok'  order by id_peminjaman_masuk desc;");
    while ($row1=mysqli_fetch_array($res1)){
        $id_peminjaman_masuk = $row1["id_peminjaman_masuk"];
        $message = "Salam lestari, Yah besok taggal ".tgl_indo($tgl_besok)." adalah hari pengembalian peminjaman peralatan anda di OPA Ganendra Giri dengan nomor peminjaman ".$id_peminjaman_masuk.". Jangan sampai lupa melakukan pengembalian peminjaman peralatan ke Sekretariat OPA Ganendra Giri besok hari. Terima Kasih, Salam Lestari";
        $nik_potong = substr($row1["nik"],0,3);
        $nik = $row1["nik"];
        $email = "";
        $nama_peminjam = "";
        if($nik_potong == "910"){
            $result2=mysqli_query($conn,"SELECT * FROM user  WHERE nia = '$nik';");
            while ($row2=mysqli_fetch_array($result2)){
                $email     =   $row2["email"];
                $nama_peminjam      =   $row2["nama_user"];
            }
        }else{
            $result2=mysqli_query($conn,"SELECT * FROM peminjam  WHERE nik = '$nik';");
            while ($row2=mysqli_fetch_array($result2)){
                $email     =   $row2["email"];
                $nama_peminjam      =   $row2["nama"];
            }
        }
        send_mail($nama_peminjam,$email,$subject,$message);
    }

    // hari ini pengembalian
    $res1=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE status = 'diambil' and tgl_kembali = '$tgl_hari_ini'  order by id_peminjaman_masuk desc;");
    while ($row1=mysqli_fetch_array($res1)){
        $id_peminjaman_masuk = $row1["id_peminjaman_masuk"];
        $message = "Salam lestari, Yah hari ini ".tgl_indo($tgl_hari_ini)." adalah hari pengembalian peminjaman peralatan anda di OPA Ganendra Giri dengan nomor peminjaman ".$id_peminjaman_masuk.". Segera lakukan pengembalian peminjaman perlatan ke Sekretariat OPA Ganendra Giri. Terima Kasih, Salam Lestari";
        $nik_potong = substr($row1["nik"],0,3);
        $nik = $row1["nik"];
        $email = "";
        $nama_peminjam = "";
        if($nik_potong == "910"){
            $result2=mysqli_query($conn,"SELECT * FROM user  WHERE nia = '$nik';");
            while ($row2=mysqli_fetch_array($result2)){
                $email     =   $row2["email"];
                $nama_peminjam      =   $row2["nama_user"];
            }
        }else{
            $result2=mysqli_query($conn,"SELECT * FROM peminjam  WHERE nik = '$nik';");
            while ($row2=mysqli_fetch_array($result2)){
                $email     =   $row2["email"];
                $nama_peminjam      =   $row2["nama"];
            }
        }
        send_mail($nama_peminjam,$email,$subject,$message);
    }

    // peminjaman belum dikembalikan
    $res1=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE status = 'diambil' and tgl_kembali < '$tgl_hari_ini'  order by id_peminjaman_masuk desc;");
    while ($row1=mysqli_fetch_array($res1)){
        $id_peminjaman_masuk = $row1["id_peminjaman_masuk"];
        $message = "Salam lestari, anda telah melewatkan waktu pengembalian alat yang seharusnya dikembalikan pada tanggal ".tgl_indo($tgl_hari_ini)." pada peminjaman peralatan anda di OPA Ganendra Giri dengan nomor peminjaman ".$id_peminjaman_masuk.". Segera lakukan pengembalian peminjaman perlatan ke Sekretariat OPA Ganendra Giri. Terima Kasih, Salam Lestari";
        $nik_potong = substr($row1["nik"],0,3);
        $nik = $row1["nik"];
        $email = "";
        $nama_peminjam = "";
        if($nik_potong == "910"){
            $result2=mysqli_query($conn,"SELECT * FROM user  WHERE nia = '$nik';");
            while ($row2=mysqli_fetch_array($result2)){
                $email     =   $row2["email"];
                $nama_peminjam      =   $row2["nama_user"];
            }
        }else{
            $result2=mysqli_query($conn,"SELECT * FROM peminjam  WHERE nik = '$nik';");
            while ($row2=mysqli_fetch_array($result2)){
                $email     =   $row2["email"];
                $nama_peminjam      =   $row2["nama"];
            }
        }
        send_mail($nama_peminjam,$email,$subject,$message);
    }

    // admin checklist bulanan
    $jumlah = 0;
    $res2=mysqli_query($conn,"SELECT * FROM checklist_group WHERE month(tgl_checklist_group) = '$bulan_ini' and year(tgl_checklist_group) = '$tahun_ini';");
    $jumlah = mysqli_num_rows($res2);
    if($tgl_sekarang == 23 and $jumlah == 0){
        $res1=mysqli_query($conn,"SELECT * FROM user WHERE status_anggota = 'Departemen Rumah Tangga';");
        while ($row1=mysqli_fetch_array($res1)){
            $message = "Salam lestari. Hari ini susah mendekati akhir bulan, segera lakukan checklist bulanan bersama Anggota Biasa. Terima Kasih, Salam Lestari";
            $email = $row2["email"];
            $nama_peminjam = $row2["nama_user"];
            send_mail($nama_peminjam,$email,$subject,$message);
        }
    }

    // admin checklist bulanan
    $jumlah = 0;
    $res2=mysqli_query($conn,"SELECT * FROM peminjaman_masuk WHERE STATUS = 'baru'");
    $jumlah = mysqli_num_rows($res2);
    if($jumlah != 0){
        $res1=mysqli_query($conn,"SELECT * FROM user WHERE status_anggota = 'Departemen Rumah Tangga';");
        while ($row1=mysqli_fetch_array($res1)){
            $message = "Salam lestari. Hari ini ada permintaan ".$jumlah." peminjaman yang harus dikonfirmasi. Ayo segera proses permintaan peminjaman yang masuk. Terima Kasih, Salam Lestari";
            $email = $row2["email"];
            $nama_peminjam = $row2["nama_user"];
            send_mail($nama_peminjam,$email,$subject,$message);
        }
    }
?>