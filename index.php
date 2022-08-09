<?php 

session_start();

// Jika Belum Login
if( !isset($_SESSION["login"]) ){
    header("Location: login.php");
    exit;
}


// Menghubungkan file agar fungsi di halaman lain dapat digunakan
require 'functions.php'; 
$mahasiswa = query("SELECT * FROM mahasiswa ORDER BY id ASC");  // DESC itu urutkan terbalik, kebalikan ASC

if( isset($_POST["cari"]) ){
    $mahasiswa = cari($_POST["keyword"]);
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HALAMAN ADMIN</title>
</head>
<body>
    
    <br>
    <a href="logout.php" onclick="return confirm('Yakin Ingin Logout?')">Logout</a>

    <h1>Daftar Mahasiswa</h1>

    <a href="tambah.php">Tambah Data Mahasiswa</a>
    <br><br>

    <form action="" method="post">
        <!-- autofocus = langsung meletakkan kursor saat memasuki web -->
        <!-- placeholder = meletakkan teks buram sebagai panduan pengisian input -->
        <!-- autocomplete = menyembunyikan histori pada kolom input -->
        <input type="text" name="keyword" id="keyword" size="30" autofocus placeholder="Masukkan keyword pencarian!" autocomplete="off">
        <button type="submit" name="cari" id="search">Cari</button>
        <br><br>
        
    </form>

    <br>

    <div id="container">

        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>No.</th>
                <th>Aksi</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Email</th>
                <th>Jurusan</th>
            </tr>

            <?php $noUrut = 1;  ?>
            
            <?php foreach($mahasiswa as $mhs) : ?>
                <tr>
                    <td><?php echo $noUrut; $noUrut++; ?></td>
                    <td>
                        <a href="ubah.php?id=<?= $mhs["id"]; ?>">Ubah</a>

                        <!-- Jika confirm ditekan "oke" maka kunjungi href, begitu-pun sebaliknya -->
                        <a href="hapus.php?gambar=<?= $mhs["gambar"]; ?>" onclick="return confirm('Yakin Hapus Data?')">Hapus</a>
                    </td>

                    <td> <img src="img/<?= $mhs["gambar"]; ?>" width="150px"> </td>
                    <td><?= $mhs["nama"]; ?></td>
                    <td><?= $mhs["nim"]; ?></td>
                    <td><?= $mhs["email"]; ?></td>
                    <td><?= $mhs["jurusan"]; ?></td>        
                </tr>
            <?php endforeach ?>
            
        </table>

    </div>


    <script src="js/script.js"></script>

</body>
</html>