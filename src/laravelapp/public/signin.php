<?php

// var_dump($_COOKIE);
require_once('function.php');
session_start();
if ($_SESSION['email'] || $_COOKIE['cookie_token']) {
  redirect_to_welcome();
}

if (isset($_POST['signin'])) {
  $name = filter_input( INPUT_POST, "name");
  $email = filter_input( INPUT_POST, "email");
  $pass = filter_input( INPUT_POST, "pass");
  
  try {
    $dsn = 'mysql:host=laravel_db;dbname=laravel_db';
    $user = 'laravel_user';
    $password = 'laravel_pass';
    $pdo = new PDO($dsn, $user, $password);
    // $a = new PDO(ローカルホスト, データベース名,ユーザー名,パスワード,その他)基本的なpdoの作成方法。
    $sql = "INSERT INTO users (name, email, password) values (:name, :email, :password) ";
    
    $statement = $pdo->prepare($sql);

    $params = array(':name' => $name, ':email' => $email, ':password' => password_hash($pass, PASSWORD_DEFAULT));
    
    $statement->execute($params);
    $statement = null;
    $pdo = null;

    $_SESSION['email'] = $email; 

    header('Location: http://localhost:8000/welcome.php');
    exit;
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
    // PDOExceptionがPDOの例外であり$eとして扱いPDOExceptionの例外の内容を表示
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録画面</title>
</head>
<body>
  <h1>新規登録画面</h1>
  <form action="" method="post">
    <p>名前<input type="text" name="name"></p>
    <p>メールアドレス<input type="email" name="email"></p>
    <p>パスワード：<input type="password" name="pass"></p>
    <p><input type="submit" name="signin" value="新規登録"></p>
  </form>
  <!-- <a href="sigin.php">新規登録</a> -->
  <a href="welcome.php">ホーム</a>
    
</body>
</html>
