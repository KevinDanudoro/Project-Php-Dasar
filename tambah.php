<?php 

session_start();

if( !isset($_SESSION["login"]) ){
    header("Location: login.php");
    exit;
}

require 'functions.php';

if ( isset($_POST["submit"]) ) {
    // Memeriksa isi dari var $_POST dan $_FILES
    // var_dump($_POST); 
    // var_dump($_FILES);

    addDataMahasiswa($_POST, $_FILES, "mahasiswa");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mahasiswa</title>
</head>
<body>
    <h1>Tambah Data Mahasiswa</h1>

    <!-- Pemberian atribut enctype berfungsi agar file gambar dapat dikelola oleh var global $_FILE -->
    <form action="" method="POST" enctype="multipart/form-data">

        <table>
            <tr>
                <td> <label for="nim">Masukkan NIM</label> </td>
                <td> : <input type="text" name="nim" id="nim" required> </td>
            </tr>
            <tr>
                <td> <label for="nama">Masukkan Nama</label> </td>
                <td> : <input type="text" name="nama" id="nama" required> </td>
            </tr>
            <tr>
                <td> <label for="email">Masukkan Email</label> </td>
                <td> : <input type="text" name="email" id="email" required> </td>
            </tr>
            <tr>
                <td> <label for="jurusan">Masukkan Jurusan</label> </td>
                <td> : <input type="text" name="jurusan" id="jurusan" required> </td>
            </tr>
            <tr>
                <td> <label for="gambar">Upload Gambar</label> </td>
                <td> : <input type="file" name="gambar" id="gambar" </td>
            </tr>
        </table>

        <br>
        <button type="submit" name="submit">Simpan Data</button>

    </form>
    
</body>
</html>