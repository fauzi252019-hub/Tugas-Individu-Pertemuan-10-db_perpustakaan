// NAMA : FAUZY OKTAVIAN ETSA FERNANDA
KELAS : TI-2A
NIM : 250102012
PRODI : TEKNIK INFORMATIKA
PERTEMUAN : TUGAS INDIVIDU PERTEMUAN 10

<?php
// proses anggota.php - Memvalidasi data form, lalu menyimpannya dengan INSERT

// Halaman ini hanya boleh dibuka melalui pengiriman form (POST)
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: form_anggota.php");
    exit;
}

// 1. Ambil data dan bersihkan spasi di awal/akhir
$nomor_anggota          = isset($_POST["nomor_anggota"])          ? trim($_POST["nomor_anggota"])          : "";
$nama_lengkap           = isset($_POST["nama_lengkap"])           ? trim($_POST["nama_lengkap"])           : "";
$email                  = isset($_POST["email"]) ? trim($_POST["email"]) : "";
$no_hp                  = isset($_POST["no_hp"]) ? trim($_POST["no_hp"]) : "";
$jenis_anggota          = isset($_POST["jenis_anggota"]) ? trim($_POST["jenis_anggota"]) : "";
$alamat                 = isset($_POST["alamat"]) ? trim($_POST["alamat"]) : "";

// 2. Validasi di sisi server
$jenis_anggota_valid = array("Mahasiswa", "Dosen", "Tenaga Kependidikan");
$errors       = array();

if ($nomor_anggota === "") {
    $errors[] = "Nomor anggota tidak boleh kosong.";
} elseif (!ctype_digit($nomor_anggota) || strlen($nomor_anggota) > 15) {
    $errors[] = "Nomor anggota harus berupa angka dengan maksimal 15 digit.";
}

if (empty($nama_lengkap)) {
    $errors[] = "Nama lengkap tidak boleh kosong.";
} elseif (strlen($nama_lengkap) > 100) {
    $errors[] = "Nama lengkap maksimal 100 karakter.";
}

if (empty($email)) {
    $errors[] = "Email tidak boleh kosong.";
} elseif (strlen($email) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email harus valid dan maksimal 100 karakter.";
}

if (empty($no_hp)) {
    $errors[] = "Nomor HP tidak boleh kosong.";
} elseif (strlen($no_hp) > 15) {
    $errors[] = "Nomor HP maksimal 15 karakter.";
}

if (empty($jenis_anggota)) {
    $errors[] = "Jenis anggota wajib dipilih.";
} elseif (!in_array($jenis_anggota, $jenis_anggota_valid, true)) {
    $errors[] = "Jenis anggota tidak valid.";
}

if (empty($alamat)) {
    $errors[] = "Alamat tidak boleh kosong.";
}

// 3. Bila semua data valid, simpan ke database
$berhasil = false;
$pesan_db = "";

if (empty($errors)) {
    require_once "koneksi.php";

    $sql = "INSERT INTO anggota (no_anggota, nama_lengkap, email, no_hp, jenis_anggota, alamat) "
         . "VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param(
            $stmt, "ssssss", $nomor_anggota, $nama_lengkap, $email, $no_hp, $jenis_anggota, $alamat
        );

        if (mysqli_stmt_execute($stmt)) {
            $berhasil = true;
        } else {
            $pesan_db = mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $pesan_db = mysqli_error($koneksi);
    }
    mysqli_close($koneksi);

    // 4. Bila berhasil, kembali ke form dengan notifikasi
    if ($berhasil) {
        header("Location: form_anggota.php?status=sukses");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Penyimpanan Data</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { color: #1f3864; }
        .gagal { background: #fdecea; border-left: 5px solid #c0392b;
                 padding: 10px; }
    </style>
</head>
<body>
    <?php if (!empty($errors)) { ?>

        <h1>Data Tidak Valid</h1>
        <p class="gagal">Data belum dapat disimpan. Perbaiki kesalahan:</p>
        <ul>
            <?php foreach ($errors as $pesan) { ?>
                <li><?php echo htmlspecialchars($pesan); ?></li>
            <?php } ?>
        </ul>

    <?php } else { ?>

        <h1>Data Gagal Disimpan</h1>
        <p class="gagal">Terjadi kesalahan saat menyimpan data ke database.</p>
        <p>Pesan dari MySQL: <?php echo htmlspecialchars($pesan_db); ?></p>

    <?php } ?>

    <p><a href="javascript:history.back()">Kembali dan perbaiki data</a></p>
</body>
</html>
