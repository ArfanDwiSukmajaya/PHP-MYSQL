<?php 
  session_start();
  
  include 'functions.php';

  // cek cookie
  if(isset($_COOKIE["id"]) && isset($_COOKIE["key"])){
    $id = $_COOKIE["id"];
    $key = $_COOKIE["key"];

    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username berdasarkan
    if($key ===  hash('sha256',$row['username'])){
      $_SESSION["login"] = true;
    }

  }

  if( isset($_SESSION["login"])){
    header("Location:index.php");
    exit;
  }

  if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    // cek apakah ada username di databse
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if(mysqli_num_rows($result) === 1){
      // Cek passwordnya
      $row = mysqli_fetch_assoc($result);
      $_SESSION["username"] = $row["username"];
      if(password_verify($password, $row['password'])){
        // Set session 
        $_SESSION["login"] = true;

        // cek remember me
        if(isset($_POST["remember"])){
          // buat cookie
          setcookie('id',$row["id"], time() + 60 );
          setcookie('key', hash('sha256' ,$row["username"]));
        }
        
        header("Location:index.php"); 
        exit;
      }

    }
    // digunakan unutk pesan kesalahan
    $error = true;

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Login</title>
</head>
<body>

  <h1>Silahkan Login</h1>

  <?php if(isset($error)) : ?>
    <p>Username/pasword salah</p>
  <?php endif; ?>

  <form action="" method="post">
    <ul>
      <li>
        <label for="username">Username</label>
        <input type="text" name="username" id="username">
      </li>
      <li>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
      </li>
      <li>
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Remember Me</label>
      </li>
      <li>
        <button type="submit" name="login">Login</button>
      </li>
    </ul>
  </form>

</body>
</html>