<?php 

session_start();

if( !isset($_SESSION["login"]) ){
    header("Location: login.php");
    exit;
}

require 'functions.php';

$id_mhs = $_GET["id"];
$mhs = ambilDataID("SELECT * FROM mahasiswa WHERE id=$id_mhs");

if ( isset($_POST["submit"]) ) {
    updateDataMahasiswa($_POST, $_FILES, "mahasiswa", $id_mhs);
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Mahasiswa</title>
</head>
<body>
    <h1>Ubah Data Mahasiswa</h1>

    <form action="" method="POST" enctype="multipart/form-data">

        <table>
            <input type="hidden" name="gambarLama" value="<?= $mhs["gambar"] ?>">
            <tr>
                <td> <label for="nim">Masukkan NIM</label> </td>
                <td> : <input type="text" name="nim" id="nim" value="<?= $mhs["nim"] ?>" required> </td>
            </tr>
            <tr>
                <td> <label for="nama">Masukkan Nama</label> </td>
                <td> : <input type="text" name="nama" id="nama" value="<?= $mhs["nama"] ?>" required"> </td>
            </tr>
            <tr>
                <td> <label for="email">Masukkan Email</label> </td>
                <td> : <input type="text" name="email" id="email" value="<?= $mhs["email"] ?>" required> </td>
            </tr>
            <tr>
                <td> <label for="jurusan">Masukkan Jurusan</label> </td>
                <td> : <input type="text" name="jurusan" id="jurusan" value="<?= $mhs["jurusan"] ?>" required> </td>
            </tr>
            <tr>
                <td> <label for="gambar">Upload Gambar</label> </td>
                <td> : <input type="file" name="gambar" id="gambar" > </td>
            </tr>
    
        </table>
        
        <img src="img/<?= $mhs["gambar"] ?>" width="200px" style="padding: 15px 5px;">

        <br>
        <button type="submit" name="submit">Simpan Data</button>

    </form>
    
</body>
</html>