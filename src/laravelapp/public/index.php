<?php
  session_start();
  require_once("function.php");
  $_SESSION['csrf_token'] = get_token();
  $cookie_token = $_COOKIE['cookie_token'];  // var_dump($_SESSION)
  check_cookie($pdo, $cookie_token);
  // var_dump($check["token"]);
  if (isset($_COOKIE['cookie_token']) && $_COOKIE['cookie_token'] == $check['token'] ) {
    header('Location: welcome.php');
  }


  // var_dump($_SESSION);
  // global $msg;
  // var_dump($msg);

  if ($_SESSION['login_error'] || $_SESSION['error']) {
    $_SESSION['count'] = $_SESSION['count'] + 1;
    if ($_SESSION['count'] == 2) {
      unset($_SESSION['login_error']);
      unset($_SESSION['error']);
      unset($_SESSION['count']);
    }
  } 
  // var_dump($_SESSION['count']);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
</head>
<body>
  <h1>ログイン</h1>
  <h1><?php echo $msg; ?></h1>
  <?php echo $link; ?>
  <?= $_SESSION['error'] ?>
  <?= $_SESSION['login_error'] ?>
  <form action="logincheck.php" method="post">
    <p>メールアドレス<input type="email" name="email"></p>
    <p>パスワード：<input type="password" name="password"></p>
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
    <p>
      ログイン情報を記録しますか？<input type="checkbox" name="auto" value="true">
    </p>
    <p><input type="submit" name="login" value="ログイン"></p>
    <input type="reset" value="リセット">
  </form>
  <a href="signin.php">新規登録</a>


    
</body>
</html>


