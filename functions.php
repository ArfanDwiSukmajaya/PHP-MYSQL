<?php 

  $host = 'localhost';
  $user = 'root';
  $pass = '';
  $db   = 'db_lat_wpu';

  $conn = mysqli_connect($host, $user, $pass, $db);


  function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ( $row = mysqli_fetch_assoc($result)){
      $rows[] = $row;
    }
    return $rows;
  }
	
	function tambah($data){
		global $conn;
		$nobp = htmlspecialchars($data["nobp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    // $foto = htmlspecialchars($data["foto"]);

    // upload foto
    $foto = upload();
    if(!$foto){
      return false;
    }

    // Query insert data in
    $sql = "INSERT INTO mahasiswa (nobp, nama, email, foto) VALUES ('$nobp', '$nama', '$email', '$foto')";

    mysqli_query($conn, $sql);
    // var_dump($query);
		
    return mysqli_affected_rows($conn);
  }



  function upload(){
    
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];


    // Cek apakah tidak ada gambar yg d uoload
    if($error == 4){
      echo "
        <script>
          alert('Pilih gambar terlebih dahulu');
        </script>
      ";
      return false;
    }

    // Cek apakah yang di upload gambar atau bukan
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
      // memecah gambar
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if( !in_array($ekstensiGambar, $ekstensiGambarValid)){
      echo "
        <script>
          alert('Yang anda upload bukan gambar');
        </script>
      ";
      return false;
    }

    // Cek jika ukurannya terlalu besar
    if($ukuranFile > 1000000){
      echo "
        <script>
          alert('Ukuran gambar terlalu besar');
        </script>
      ";
      return false;
    }


    // Lolos pengecekan gambar siap di upload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;


  }



  function hapus($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
    return mysqli_affected_rows($conn);
  }

  function ubah($data){
    global $conn;

    $id = $data["id"];
    $nobp = htmlspecialchars($data["nobp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $fotoLama = htmlspecialchars($data["fotoLama"]);
    $foto = htmlspecialchars($data["foto"]);
    
    // cek apakah user pilih gambar / tidak dari
    if($_FILES['foto']['error'] === 4){
      $foto = $fotoLama;
    }else{
      $foto = upload();
    }


    // Query insert data in
    $sql = "UPDATE mahasiswa SET
            nobp = '$nobp',
            nama = '$nama',
            email = '$email',
            foto = '$foto'
            WHERE id = $id
            ";

    mysqli_query($conn, $sql);
    // var_dump($query);
		
    return mysqli_affected_rows($conn);

  }


  function cari($keyword){
    $query = "SELECT * FROM mahasiswa WHERE nama 
              LIKE '%$keyword%' OR nobp LIKE '%$keyword%' ";
    return query($query);
  }



  function registrasi($data){
    global $conn;

    $username = strtolower(stripcslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);


    // Cek username udah ad atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");



    if(mysqli_fetch_assoc($result)){
      echo"
        <script>
          alert('username sudah ada');
        </script>
      ";
      return false;
    }

  // cek konfirmasi password
  if($password !== $password2){
    echo "
      <script>
        alert('konfirmasi password tidak sesuai');
      </script>
    ";
    return false;
  }

  // enkripsi password
  $password = password_hash($password, PASSWORD_DEFAULT);
  // var_dump($password);

  // tambahkan userbaru ke database
  $sql = "INSERT INTO user(username, password) VALUES('$username', '$password')";
  mysqli_query($conn, $sql);

  return mysqli_affected_rows($conn);
  
  }


?>