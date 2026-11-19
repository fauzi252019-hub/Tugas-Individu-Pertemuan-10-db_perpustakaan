<?php

require_once "koneksi.php";

$sql = " SELECT * FROM  anggota ";
$hasil = (mysqli_query($koneksi, $sql));
$jumlah = mysqli_num_rows ($hasil);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 30px; }
    table { border-collapse: collapse; }
    th, td { border: 1px solid #999; padding: 6px 10px; text-align: left; }
    th { background: #1f3864; color: #fff; }
    form.inline { display: inline; }
  </style>
</head>
<body>
   <h3>Berapakah Jumlah Data yang anda simpan di database : <?php echo $jumlah ?></h3>

   <table>
    <tr>
      <th>no</th>
      <th>nomor anggota</th>
      <th>nama lengkap</th>
      <th>email</th>
      <th>no hp</th>
      <th>jenis anggota</th>
      <th>aksi</th>
</tr>
<?php $no=1; while ($baris = mysqli_fetch_assoc($hasil)) { ?>
<tr>
  <td><?php echo $no++; ?></td>
   <td><?php echo htmlspecialchars($baris['no_anggota']); ?></td>
  <td><?php echo htmlspecialchars($baris['nama_lengkap']); ?></td>
  <td><?php echo htmlspecialchars($baris['email']); ?></td>
  <td><?php echo htmlspecialchars($baris['no_hp']); ?></td>
   <td><?php echo htmlspecialchars($baris['jenis_anggota']); ?></td>
<td>
<a href="detail.php?id=<?php echo (int) $baris["id"]; ?>">Detail</a>

<form class= "inline" action="hapus.php" method="post" onsubmit="return confirm('Yakin ingin menghapus data ini?');">

<input type ="hidden" name="id" value="<?php echo (int) $baris["id"]; ?>">

<button type="submit">Hapus</button>

</form>
</td>
</tr>
<?php } ?>
</table>



</body>
</html>

