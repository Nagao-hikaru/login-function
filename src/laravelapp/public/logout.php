<?php
session_start();
require_once("function.php");
$csrf_token = $_POST['csrf_token'];
$cookie_token = $_COOKIE['cookie_token'];
//CSRF チェック
if ($csrf_token != $_SESSION['csrf_token']) {
  // リダイレクト
  redirect_to_welcome();
  exit();
}
try {

  cookie_logout($pdo, $cookie_token);
  
} catch (PDOException $e) {
  die($e->getMessage());
}
?>

<p>ログアウトしました。</p>
<a href="index.php">ログインへ</a>