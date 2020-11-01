<?php 

  include 'functions.php';

  // ambil data dari url
  $id = $_GET["id"];
  // var_dump($id);

  $mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];
  // var_dump($mhs);

  // cek apakah data berhasil di ubah
  if(isset($_POST["tambah"])){
		if (ubah($_POST) > 0 ){
      echo " 
        <script>
          alert('Data berhasil diubah');
          document.location.href = 'index.php';
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
  <title>Edit Data</title>
</head>
<body>
  <h1>Edit Data</h1>


  <form action="" method="post" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?= $mhs["id"];?>">
  <input type="hidden" name="fotoLama" value="<?= $mhs["foto"];?>">
    <ul>
      <li>
        <label for="nobp">NOBP :</label>
        <input type="text" name="nobp" id="nobp" value="<?= $mhs["nobp"]?>">
      </li>
      <li>
        <label for="nama">Nama :</label>
        <input type="text" name="nama" id="nama" value="<?= $mhs["nama"]?>">
      </li>
      <li>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" value="<?= $mhs["email"]?>">
      </li>
      <li>
        <label for="foto">Foto :</label>
        <img src="img/<?=$mhs['foto']?>" alt="">
        <input type="file" name="foto" id="foto">
      </li>
      <li>
        <button type="submit" name="tambah">Ubah Data</button>
      </li>
    </ul>
  </form>
  
</body>
</html>