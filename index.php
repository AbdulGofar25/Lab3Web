<?php
include("koneksi.php");
// query untuk menampilkan data
$sql = 'SELECT * FROM data_barang';
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link href="https://www.w3schools.com/w3css/4/w3.css" rel="stylesheet" type="text/css" />
<title>Data Barang</title>
</head>
<body>
    <div class="container">
    <h1>Data Barang</h1>
    <a href="tambah.php">Tambah Data Barang</a> <br>
    <a href="ubah.php"> Ubah data</a>
    <div class="main">
    <table class="w3-table w3-striped w3-border">
    <tr class="w3-green">
    <th>Gambar</th>
    <th>Nama Barang</th>
    <th>Katagori</th>
    <th>Harga Jual</th>
    <th>Harga Beli</th>
    <th>Stok</th>
    <th>Aksi</th>
    </tr>
    <?php if($result): ?>
    <?php while($row = mysqli_fetch_array($result)): ?>
    <tr>
    <td><img src="gambar/<?= $row['gambar'];?>" alt="<?=
    $row['nama'];?>"></td>
    <td><?= $row['nama'];?></td>
    <td><?= $row['kategori'];?></td>
    <td><?= $row['harga_beli'];?></td>
    <td><?= $row['harga_jual'];?></td>
    <td><?= $row['stok'];?></td>
    <td><?= $row['id_barang'];?></td>
    </tr>
    <?php endwhile; else: ?>
    <tr>
    <td colspan="7">Belum ada data</td>
    </tr>
    <?php endif; ?>
    </table>
    </div>
</div>
</body>
</html>