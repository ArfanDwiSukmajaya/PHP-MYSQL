<?php
  include 'functions.php';

  // Cek apakh tombol submit udah ditekan atau belum
  if(isset($_POST["tambah"])){


		if (tambah($_POST) > 0 ){
      echo "
        <script>
          alert('Data berhasil ditambahkan');
          document.location.href = 'index.php';
        </script>
      ";
		}else{
      echo "
        <script>
          alert('Data Gagal ditambahkan');
        </script>
      ";
    }
  }

  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Data mahasiswa</title>
</head>
<body>
  <h1>Tambah Data Mahasiswa</h1>

  <form action="" method="post" enctype="multipart/form-data">
    <ul>
      <li>
        <label for="nobp">NOBP :</label>
        <input type="text" name="nobp" id="nobp">
      </li>
      <li>
        <label for="nama">Nama :</label>
        <input type="text" name="nama" id="nama">
      </li>
      <li>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email">
      </li>
      <li>
        <label for="foto">Foto :</label>
        <input type="file" name="foto" id="foto">
      </li>
      <li>
        <button type="submit" name="tambah">Tambah Data</button>
      </li>
    </ul>
  </form>
  
</body>
</html>