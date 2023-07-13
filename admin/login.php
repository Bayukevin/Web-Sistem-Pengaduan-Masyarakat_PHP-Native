<!-- # @Author: Wahid Ari <wahidari>
# @Date:   8 January 2018, 5:05
# @Copyright: (c) wahidari 2018 -->
<?php
    require_once("database.php");
    // Proses dari form login
    $message = "";
    if (isset($_POST['login']) && $_POST['login'] == "Login") {
        $username    = $_POST['username']; //simpan input dari username ke var username
        $password    = $_POST['password']; //simpan input dari password ke var password

        $sql = "SELECT * FROM admin WHERE username = :username and password = SHA2(:password, 0)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password);
        $stmt->execute();
        $valid_user = $stmt->fetch(PDO::FETCH_ASSOC);
        // jika user terdaftar
        if($valid_user){
                // buat Session
                session_start();
                $_SESSION["admin"] = $username;
                // login sukses, alihkan ke halaman timeline
                header("Location: index");
        }
        // jika ada akun belum terdaftar
        else {
            $message = "Username atau Password Salah";
        }
    }
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Login - Pengaduan</title>
  <link rel="stylesheet" href="css/login2.css">
</head>

<body>
  <main>
    <h3>Login Admin</h3>
    <hr>
    <form method="post">
      <div class="wrapperr-form">
        <label>Username</label>
        <input class="form" id="username" type="text" name="username" aria-describedby="userlHelp"
          placeholder="Enter Username" required>
      </div>
      <div class="wrapperr-form">
        <label>Password</label>
        <input class="form" id="password" name="password" type="password" placeholder="Password" required>
      </div>
      <div class="wrapper-btn">
        <input class="btn-submit" type="submit" name="login" value="Login">
      </div>
    </form>
    <p class="text-center text-danger"><small><?php echo @$message; ?></small></p>
  </main>
</body>

</html>