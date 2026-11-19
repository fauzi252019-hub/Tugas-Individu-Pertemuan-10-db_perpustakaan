// NAMA : FAUZY OKTAVIAN ETSA FERNANDA
KELAS : TI-2A
NIM : 250102012
PRODI : TEKNIK INFORMATIKA
PERTEMUAN : TUGAS INDIVIDU PERTEMUAN 10

<?php


mysqli_report(MYSQLI_REPORT_OFF);

//Parameter Koneksi
$host = "localhost";
$username = "root";
$password = "";
$database = "db_perpustakaan";

// Membuat Koneksi
$koneksi = mysqli_connect($host, $username, $password, $database);

// Memeriksa Koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . htmlspecialchars(mysqli_connect_error()));

}

// Mengatur karakter agar huruf dan simbol tersimpan dengan benar
mysqli_set_charset($koneksi, "utf8mb4");
