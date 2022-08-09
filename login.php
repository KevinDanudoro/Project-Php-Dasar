<?php 

// Diawal program harus dimulai dengan session_start agar dapat menggunakan var $_SESSION
session_start();
require 'functions.php';

// cek apakah ada cookie?
if( isset($_COOKIE["keyU"]) && isset($_COOKIE["keyI"]) ){
    $id = $_COOKIE["keyI"];
    $username = $_COOKIE["keyU"];   

    // bandingkan dengan id dan username pada database
    $hasil = mysqli_query($conn, "SELECT username FROM user WHERE id=$id");
    $db_username = mysqli_fetch_assoc($hasil);

    // cek cookie dan username
    if( $username === hash('sha256', $db_username["username"]) ){
        $_SESSION['login'] = true;
    }

}

//Jika sudah login, maka kembalikan ke halaman index.php
if(isset($_SESSION["login"])){
    header("Location: index.php");
}


if( isset($_POST["submit"]) ){

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Jika username sesuai dengan db
    if( $result = query("SELECT * FROM user WHERE username = '$username';" )){
        
        // Cek password
        if (password_verify($password, $result[0]['password'])){
            // set session agar nilai variabel dapat di cek di halaman lain
            $_SESSION["login"] = true;

            // cek remember me
            if( isset($_POST['remember']) ){
                // buat cookie agar dapat langsung login dalam kurun waktu 60 detik
                setcookie( 'keyI', $result[0]["id"], time()+60 );
                setcookie( 'keyU', hash('sha256', $result[0]['username']), time()+60 );


            }

            header("Location: index.php");
            exit;

        } 
    }
    
    // Jika username atau password tidak sesuai/salah
    $error = true;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
</head>
<body>
    <h1>Halaman Login</h1>

    <?php if(isset($error)) : ?>
        <p style="color: red">Username / Password Salah</p>
    <?php endif ?>

    <form action="" method="post">
        <table>
            <tr>
                <td><label for="username">Username</label></td>
                <td> : <input type="text" name="username" id="username" required></td>
            </tr>
            <tr>
                <td><label for="password">Password</label></td>
                <td> : <input type="password" name="password" id="password" required></td>
            </tr>
        </table>

        <input type="checkbox" name="remember" id="remember"></input>            
        <label for="remember">Remember me</label>
        
        <br>
        <br>
        
        <button type="submit" name="submit">Login</button>

    </form>
    <a href="registrasi.php">Register</a>
    
</body>
</html>