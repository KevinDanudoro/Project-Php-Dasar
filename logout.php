<?php 

// Menghapus session agar nilai login hilang
session_start();
$_SESSION = [];
session_unset();
session_destroy();

// Hapus cookie login dengan cara mengatur cookie dengan nama yg sama, namun dengan waktu expire di masa lalu
setcookie('keyI', '', time() - 3600 );
setcookie('keyU', '', time() - 3600 );

header("Location: login.php");
exit;

?>