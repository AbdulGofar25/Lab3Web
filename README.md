# Tugas Pemrograman web 2

Nama : Abdul Gofar</br>
NIM : 312210504</br>
Kelas : TI.22.B2</br>

# PHP

PHP adalah singkatan dari "Hypertext Preprocessor". Ini adalah bahasa pemrograman server-side yang digunakan secara luas untuk pengembangan web. Diciptakan oleh Rasmus Lerdorf pada tahun 1994, PHP awalnya adalah singkatan dari "Personal Home Page" (sekarang disebut "PHP: Hypertext Preprocessor"), yang menggambarkan awalnya sebagai alat untuk membangun situs web pribadi. </br>
PHP adalah bahasa skrip yang dapat disisipkan ke dalam HTML. Ini dikenal dengan kemampuannya untuk membuat halaman web dinamis dengan menyediakan fungsi untuk berinteraksi dengan basis data, menghasilkan konten yang dapat berubah secara dinamis, dan berkomunikasi dengan server web. </br>

## Langkah-langkah Praktikum

## Persiapan

Untuk memulai membuat aplikasi CRUD sederhana, yang perlu disiapkan adalah database server
menggunakan MySQL. Pastikan MySQL Server sudah dapat dijalankan melalui XAMPP. </br>

## Menjalankan MySQL Server

Untuk menjalankan MySQL Server dari menu XAMPP Contol. </br>
![img1](gambar/ss1.png)

## Mengakses MySQL Client menggunakan PHP MyAdmin

Pastikan webserver Apache dan MySQL server sudah dijalankan. Kemudian buka melalui browser: </br>
http://localhost/phpmyadmin/ </br>

## Membuat Database: Studi Kasus Data Barang

![img1](gambar/ss2.png)

### Membuat Database

CREATE DATABASE latihan1; </br>

### Membuat Tabel

    CREATE TABLE data_barang (
    id_barang int(10) auto_increment Primary Key,
    kategori varchar(30),
    nama varchar(30),
    gambar varchar(100),
    harga_beli decimal(10,0),
    harga_jual decimal(10,0),
    stok int(4)
    );

![img1](gambar/ss3.png)

### Menambahkan Data

INSERT INTO data_barang (kategori, nama, gambar, harga_beli, harga_jual,
stok)
VALUES ('Elektronik', 'HP Samsung Android', 'hp_samsung.jpg', 2000000,
2400000, 5),
('Elektronik', 'HP Xiaomi Android', 'hp_xiaomi.jpg', 1000000, 1400000, 5),
('Elektronik', 'HP OPPO Android', 'hp_oppo.jpg', 1800000, 2300000, 5);

![img1](gambar/ss4.png)

### Membuat file koneksi database

Buat file baru dengan nama koneksi.php </br>

    <?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "latihan1";
    $conn = mysqli_connect($host, $user, $pass, $db);
    if ($conn == false)
    {
    echo "Koneksi ke server gagal.";
    die();
    } #else echo "Koneksi berhasil";
    ?> 

Buka melalui browser untuk menguji koneksi database untuk menyampilkan pesan koneksi berhasil,
uncomment pada perintah echo “koneksi berhasil”; </br>

![img1](gambar/ss5.png)

### Membuat file index untuk menampilkan data (Read)

Buat file baru dengan nama index.php </br>

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
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Data Barang</title>
    </head>
    <body>
    <div class="container">
    <h1>Data Barang</h1>
    <div class="main">
    <table>
    <tr>
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

![img1](gambar/ss6.png)

### Menambah Data (Create)

Buat file baru dengan nama tambah.php </br>

    <?php
    error_reporting(E_ALL);
    include_once 'koneksi.php';
    if (isset($_POST['submit']))
    {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];
    $file_gambar = $_FILES['file_gambar'];
    $gambar = null;
    if ($file_gambar['error'] == 0)
    {
    $filename = str_replace(' ', '_',$file_gambar['name']);
    $destination = dirname(__FILE__) .'/gambar/' . $filename;
    if(move_uploaded_file($file_gambar['tmp_name'], $destination))
    {
    $gambar = 'gambar/' . $filename;;
    }}
    $sql = 'INSERT INTO data_barang (nama, kategori,harga_jual, harga_beli,
    stok, gambar) ';
    $sql .= "VALUE ('{$nama}', '{$kategori}','{$harga_jual}',
    '{$harga_beli}', '{$stok}', '{$gambar}')";
    $result = mysqli_query($conn, $sql);
    header('location: index.php');
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Tambah Barang</title>
    </head>
    <body>
    <div class="container">
    <h1>Tambah Barang</h1>
    <div class="main">

    <form method="post" action="tambah.php" enctype="multipart/form-
    data">

    <div class="input">
    <label>Nama Barang</label>
    <input type="text" name="nama" />
    </div>
    <div class="input">
    <label>Kategori</label>
    <select name="kategori">
    <option value="Komputer">Komputer</option>
    <option value="Elektronik">Elektronik</option>
    <option value="Hand Phone">Hand Phone</option>
    </select>
    </div>
    <div class="input">
    <label>Harga Jual</label>
    <input type="text" name="harga_jual" />
    </div>
    <div class="input">
    <label>Harga Beli</label>
    <input type="text" name="harga_beli" />
    </div>
    <div class="input">
    <label>Stok</label>
    <input type="text" name="stok" />
    </div>
    <div class="input">
    <label>File Gambar</label>
    <input type="file" name="file_gambar" />
    </div>
    <div class="submit">
    <input type="submit" name="submit" value="Simpan" />
    </div>
    </form>
    </div>
    </div>
    </body>
    </html>

![img1](gambar/ss7.png)

### Mengubah Data (Update)

Buat file baru dengan nama ubah.php </br>

    <?php
    error_reporting(E_ALL);
    include_once 'koneksi.php';
    if (isset($_POST['submit']))
    {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];
    $file_gambar = $_FILES['file_gambar'];
    $gambar = null;
    if ($file_gambar['error'] == 0)
    {
    $filename = str_replace(' ', '_', $file_gambar['name']);
    $destination = dirname(__FILE__) . '/gambar/' . $filename;
    if (move_uploaded_file($file_gambar['tmp_name'], $destination))
    {
    $gambar = 'gambar/' . $filename;;
    }
    }
    $sql = 'UPDATE data_barang SET ';
    $sql .= "nama = '{$nama}', kategori = '{$kategori}', ";
    $sql .= "harga_jual = '{$harga_jual}', harga_beli = '{$harga_beli}',
    stok = '{$stok}' ";
    if (!empty($gambar))
    $sql .= ", gambar = '{$gambar}' ";
    $sql .= "WHERE id_barang = '{$id}'";
    $result = mysqli_query($conn, $sql);
    header('location: index.php');
    }
    $id = $_GET['id'];
    $sql = "SELECT * FROM data_barang WHERE id_barang = '{$id}'";
    $result = mysqli_query($conn, $sql);
    if (!$result) die('Error: Data tidak tersedia');
    $data = mysqli_fetch_array($result);
    function is_select($var, $val) {
    if ($var == $val) return 'selected="selected"';
    return false;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Ubah Barang</title>
    </head>
    <body>
    <div class="container">
    <h1>Ubah Barang</h1>
    <div class="main">

    <form method="post" action="ubah.php" enctype="multipart/form-
    data">

    <div class="input">
    <label>Nama Barang</label>
    <input type="text" name="nama" value="<?php echo
    $data['nama'];?>" />
    </div>
    <div class="input">
    <label>Kategori</label>
    <select name="kategori">
    <option <?php echo is_select
    ('Komputer', $data['kategori']);?> value="Komputer">Komputer</option>
    <option <?php echo is_select
    ('Komputer', $data['kategori']);?> value="Elektronik">Elektronik</option>
    <option <?php echo is_select
    ('Komputer', $data['kategori']);?> value="Hand Phone">Hand Phone</option>
    </select>
    </div>
    <div class="input">
    <label>Harga Jual</label>
    <input type="text" name="harga_jual" value="<?php echo
    $data['harga_jual'];?>" />
    </div>
    <div class="input">
    <label>Harga Beli</label>
    <input type="text" name="harga_beli" value="<?php echo
    $data['harga_beli'];?>" />
    </div>
    <div class="input">
    <label>Stok</label>
    <input type="text" name="stok" value="<?php echo
    $data['stok'];?>" />
    </div>
    <div class="input">
    <label>File Gambar</label>
    <input type="file" name="file_gambar" />
    </div>
    <div class="submit">
    <input type="hidden" name="id" value="<?php echo
    $data['id_barang'];?>" />
    <input type="submit" name="submit" value="Simpan" />
    </div>
    </form>
    </div>
    </div>
    </body>
    </html>

![img1](gambar/ss8.png)

### Menghapus Data (Delete)
Buat file baru dengan nama hapus.php </br>

    <?php
    include_once 'koneksi.php';
    $id = $_GET['id'];
    $sql = "DELETE FROM data_barang WHERE id_barang = '{$id}'";
    $result = mysqli_query($conn, $sql);
    header('location: index.php');
    ?>

## Terimakasih :-)