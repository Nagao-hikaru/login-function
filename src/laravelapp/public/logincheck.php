<?php
  session_start();
  require_once("function.php");
  $email = $_POST['email'];
  $password = $_POST['password'];
  $auto = $_POST['auto'];
  // ログイン情報を記録しますかのチェックボックスfalseが入っている。
  $csrf_token = $_POST['csrf_token'];
  // $cookie_token = $_COOKIE['cookie_token']; クッキーとトークンが照合できなかった場合。

  if (empty($cookie_token) && $csrf_token != $_SESSION['csrf_token']) {
    $_SESSION = array();
    session_destroy();
    session_start();
    // リダイレクト
    $_SESSION['error'] = '不正なリクエストです。';
    redirect_to_login();
    exit();
  }
  //ログイン判定フラグ
  $normal_result = false;
  $auto_result = false;
  try {
   
    //簡易ログイン
    if (empty($cookie_token)) {
     if (check_user($email, $password, $pdo)) {
        $normal_result = true;
      } else {
        // var_dump($msg);
        header("Location: welcome.php", $msg);
        // redirect_to_login();
      }
    }
   //トークン生成処理
   if (($normal_result && $auto == true) || $auto_result) {
    //トークンの作成
    $token = get_token();
    // var_dump($token);
    //トークンの登録
    // var_dump($token);
    register_token($email, $token, $pdo);
    //自動ログインのトークンを２週間の有効期限でCookieにセット
    
    setCookie("cookie_token", $token, time()+60*60*24); // secure, httponly
    // var_dump($_COOKIE);
    if ($auto_result) {
     //古いトークンの削除
     delete_old_token($cookie_token, $pdo);
    }
    // リダイレクト
    redirect_to_welcome();
    exit();
  } else if ($normal_result) {
    // ノーマルリザルトがtrueになっていない
    // リダイレクト
    redirect_to_welcome();
  } else {
    // リダイレクト
    redirect_to_login();
    exit();
  }
} catch (PDOException $e) {
  die($e->getMessage());
}

/*
* トークンの削除
*/
