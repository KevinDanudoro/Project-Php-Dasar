// ambil elemen yang dibutuhkan untuk menjalankan fitur live search
// Diantaranya adalah elemen input, tombol cari, dan tabel untuk menampilkan data

// Javascript carikan saya elemen pada html yang memiliki id keyword
const keyword = document.getElementById('keyword');

// tombol cari
const search = document.getElementById('search');

// tabel data
const tabel = document.getElementById('container');

// tambahkan event ketika user menulis di kolom pencarian
keyword.addEventListener('keyup', function () {

    // keyword.value akan mengembalikan nilai yang ditulis pada kolom pencarian
    // console.log(keyword.value);

    // Buat object ajax
    const xhr = new XMLHttpRequest();

    // Cek kesiapan ajax untuk memberikan response
    xhr.onreadystatechange = function () {
        if(xhr.readyState == 4 && xhr.status == 200){   // kalo ready akan seperti ini status objek ajaxnya
            // console.log("ajax oke");    // akan diekseskusi jika ajax berjalan baik
            console.log(xhr.responseText);  
            container.innerHTML = xhr.responseText;
        }
    }

    // eksekusi ajaxnya 
    xhr.open('GET', 'ajax/coba.txt', true);
    xhr.send();


})