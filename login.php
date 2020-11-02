<?php 
  session_start();

  if( isset($_SESSION["login"])){
    header("Location:index.php");
    exit;
  }
  
  include 'functions.php';

  if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    // cek apakah ada username di databse
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if(mysqli_num_rows($result) === 1){
      // Cek passwordnya
      $row = mysqli_fetch_assoc($result);
      if(password_verify($password, $row['password'])){
        // Set session
        $_SESSION["login"] = true;
        
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
        <button type="submit" name="login">Login</button>
      </li>
    </ul>
  </form>

</body>
</html>