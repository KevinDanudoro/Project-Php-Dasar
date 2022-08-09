<?php 

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");


// Mengambil seluruh data pada mysql
function query ($query) {
    global $conn;

    try {
        $result = mysqli_query($conn, $query); 
        $rows = [];
    
        while ($mhs = mysqli_fetch_assoc($result)){
            $rows[] = $mhs;
        }
        return $rows;
        
    } catch (mysqli_sql_exception) {
        return false;
    }
} 

// Mengambil sebagian data pada mysql
function ambilDataID($query){
    global $conn;

    try{
        $result = mysqli_query($conn, $query); 
        $mhs = mysqli_fetch_assoc($result);
        return $mhs;
    } 
    
    catch(mysqli_sql_exception){
        echo 
            "<script>
                alert('Data Mengalami Error');
                document.location.href = 'index.php';
            </script>";
    }
}



// Membuat query untuk menambahkan data mahasiswa
function addDataMahasiswa($post, $files, $tabel){
    // diberi fungsi html... agar user tidak dapat mengeksekusi sintaks html melalui form yang diisi
    $nim = htmlspecialchars($post["nim"]);
    $nama = htmlspecialchars($post["nama"]);
    $jurusan = htmlspecialchars($post["jurusan"]);
    $email = htmlspecialchars($post["email"]);

    // upload gambar 
    $gambar = upload($files);

    if( !$gambar ){
        return mysqliAddData("gagal");
    }

    $query = "INSERT INTO $tabel
        VALUES(
            '', 
            '$nama', 
            '$nim', 
            '$email', 
            '$jurusan',
            '$gambar'
        )";

    mysqliAddData($query);
}

// Melakukan penambahan data pada mahasiswa sekaligus error handling
function mysqliAddData($query){
    try {
        global $conn;
        mysqli_query($conn, $query);
        echo "<script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'index.php';
            </script>";

    } catch (mysqli_sql_exception) {
        echo 
            "<script>
                alert('Data Gagal Ditambahkan');
                document.location.href = 'index.php';
            </script>";
    }
}

// fungsi upload gambar
function upload($files){
    $namaFile = $files["gambar"]["name"];
    $ukuranFile = $files["gambar"]["size"];
    $error = $files["gambar"]["error"];
    $tmpName = $files["gambar"]["tmp_name"];

    // Cek apakah ada gambar yg diupload
    if( $error === 4 ){
        echo 
            "<script>
                alert('Silahkan Pilih File Gambar Terlebih Dahulu');
            </script>";

        return false;
    }

    // Cek file yg diupload agar hanya gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];

    // fungsi untuk mengetahui ekstensi file sekaligus mengubah nama ekstensi jadi huruf kecil
    $ekstensiGambar = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION)); 

    // Jika tak terdapat tipe ekstensi pada var ekstensiGambar yang sama denagn var ekstensiGambarValid
    // in_array() =>  akan menghasilkan nilai true bila terdapat nilai yg cocok, begitupun sebaliknya
    if( !in_array($ekstensiGambar, $ekstensiGambarValid) ){
        echo 
            "<script>
                alert('Tipe File Yang Anda Upload Tidak Sesuai Kriteria');
            </script>";
        
            return false;
    }

    // cek jika ukuran file terlalu besar ( > 1MB)
    if( $ukuranFile > 1000000 ){
        echo 
            "<script>
                alert('Ukuran File Terlalu Besar');
            </script>";

        return false;   
    }

    // Gambar siap di upload 
    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    return $namaFileBaru;
}



function hapusDataMahasiswa($gambar, $tabel){
    $query = "DELETE FROM $tabel WHERE gambar='$gambar'";
    mysqliHapusData($query, $gambar);
}

function mysqliHapusData($query, $gambar){
    global $conn;
    
    try {
        mysqli_query($conn, $query);
        unlink('img/' . $gambar);
        echo "<script>
                alert('Data Berhasil Dihapus');
                document.location.href = 'index.php';
            </script>";

    } catch (mysqli_sql_exception) {
        echo 
            "<script>
                alert('Data Gagal Dihapus');
                document.location.href = 'index.php';
            </script>";
    }
}



// Update data mahasiswa
function updateDataMahasiswa($post, $files, $tabel, $id){
    $nim = htmlspecialchars($post["nim"]);
    $nama = htmlspecialchars($post["nama"]);
    $jurusan = htmlspecialchars($post["jurusan"]);
    $email = htmlspecialchars($post["email"]);
    
    if( $files["gambar"]["error"] === 4 ){
        $gambar = $post["gambarLama"];
    } 
    else {
        unlink('img/' . $post["gambarLama"]); 
        $gambar = upload($files);
    }

    $query = "UPDATE $tabel SET
        nim='$nim', 
        nama='$nama', 
        email='$email', 
        jurusan='$jurusan', 
        gambar='$gambar'
        WHERE id=$id;";

    mysqliUpdateData($query);
}

function mysqliUpdateData($query){
    global $conn;
    
    try {
        mysqli_query($conn, $query);
        echo "<script>
                alert('Data Berhasil Diubah');
                document.location.href = 'index.php';
            </script>";

    } catch (mysqli_sql_exception) {
        echo 
            "<script>
                alert('Data Gagal Diubah');
                document.location.href = 'index.php';
            </script>";
    }
}



function cari($keyword){
    // "Like" itu "seperti". Tidak Perlu sama persis. % berfungsi untuk mengabaikan karakter setelah/sebelumnya
    $query = "SELECT * FROM mahasiswa WHERE 
        nama LIKE '%$keyword%' OR
        nim LIKE '%$keyword%' OR
        jurusan LIKE '%$keyword%' OR
        email LIKE '%$keyword%' 
        ;";
    
    // Mengembalikan array hasil return fungsi query().
    return query($query);
}


function registrasi($post){
    global $conn;
    $username = strtolower(stripslashes($post["username"]));
    $password = mysqli_real_escape_string($conn, $post["password"]);
    $confirm = mysqli_real_escape_string($conn, $post["confirm"]);

    if($password !== $confirm){
        echo 
            "<script>
            alert('Password Tidak Sama');
            </script>";
        
        return false;
    }
    

    // Mengambil data username pada db user
    if( query("SELECT username FROM user WHERE username = '$username';" )){
        echo 
            "<script>
            alert('Username Sudah Digunakan');
            </script>";
            
        return false; 
    }

    
    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    

    // Tambahkan user baru ke database
    $query = "INSERT INTO user VALUES(
            '',
            '$username',
            '$password'
        );";
    
    try {
        mysqli_query($conn, $query);
        echo "<script>
                alert('User Berhasil Ditambahkan');
                document.location.href = 'index.php';
            </script>";
        
        return $username;

    } catch (mysqli_sql_exception) {
        echo 
            "<script>
                alert('User Gagal Ditambahkan');
            </script>";

        return false;
    }

    




    
}

?>