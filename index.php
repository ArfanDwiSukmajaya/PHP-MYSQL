<?php 

  session_start();

  if (!isset($_SESSION["login"])){
    header("Location:login.php");
    exit;
  }

  include 'functions.php';
  // include 'login.php';
  $mahasiswa = query("SELECT * FROM mahasiswa ORDER BY id ASC");  

  if (isset($_POST["cari"])){
    $mahasiswa = cari($_POST["keyword"]);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD PHP</title>
</head>
<body>
  <a href="logout.php">Logout</a>
  <header>
    <h1>Selamat Datang <?= $_SESSION["username"]; ?></h1>
  </header>
  <a href="tambah.php">Tambah Data Mahasiswa</a>
  <br>
  <br>
  <form action="" method="post">
    <input type="text" name="keyword" size="40" autofocus placeholder="Cari" autocomplete="off">
    <button type="submit"name="cari">Cari</button>
  </form>
  <br>
  <div class="main">
    <table cellspacing="0" cellpadding="10" border="1">
      <tr>
        <td>No</td>
        <td>NOBP</td>
        <td>Nama</td>
        <td>Email</td>
        <td>Foto</td>
        <td>Aksi</td>
      </tr>
      <?php $i = 1; ?>
      <?php foreach($mahasiswa as $mhs) : ?>
      <tr>
        <td><?= $i ?></td>
        <td><?= $mhs["nobp"]; ?></td>
        <td><?= $mhs["nama"]; ?></td>
        <td><?= $mhs["email"]; ?></td>
        <td><img width="40" src="img/<?= $mhs["foto"] ?>"></td>
        <td>
          <a href="ubah.php?id=<?= $mhs["id"]?>">Edit</a> | 
          <a href="hapus.php?id=<?= $mhs["id"] ?>" onclick="return confirm('yakin?')">Hapus</a>
        </td>
      </tr>
      <?php $i++; ?>
      <?php endforeach; ?>
    </table>
  </div>
</body>
</html>