<?php 

require 'functions.php';

if( isset($_POST["register"]) ){
    registrasi($_POST);
    
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>


</head>
<body>
    <h1>Halaman Registrasi</h1>
    
    <form action="" method="POST">
        <table>
            <tr>
                <td> <label for="username">Username</label> </td>
                <td> : <input type="text" name="username" id="username"></td>
            </tr>
            <tr>
                <td> <label for="password">Password</label> </td>
                <td> : <input type="password" name="password" id="password"></td>
            </tr>
            <tr>
                <td> <label for="confirm">Konfirmasi Password</label> </td>
                <td> : <input type="password" name="confirm" id="confirm"></td>
            </tr>
        </table> 

        <button type="submit" name="register">Register</button>

    </form>
    
</body>
</html>
