<?php 

require '../functions.php';
$keyword = $_GET["keyword"];

$query = "SELECT * FROM mahasiswa WHERE 
        nama LIKE '%$keyword%' OR
        nim LIKE '%$keyword%' OR
        jurusan LIKE '%$keyword%' OR
        email LIKE '%$keyword%' 
        ;";

$mahasiswa = query($query);

?>

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