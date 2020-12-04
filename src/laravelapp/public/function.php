<?php

session_start();


$dsn = 'mysql:host=laravel_db;dbname=laravel_db';
$user = 'laravel_user';
$password = 'laravel_pass';
$pdo = new PDO($dsn, $user, $password, get_pdo_options());

function get_token() {
  $TOKEN_LENGTH = 16;//16*2=32桁
  $bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);
  // var_dump($bytes);
  return bin2hex($bytes);
}


function get_pdo_options() {
  return array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
               PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
               PDO::ATTR_EMULATE_PREPARES => false);
}

function redirect_to_login() {
  header("Location: index.php");
}

function redirect_to_welcome() {
  header("Location: welcome.php");
}

// ログインの確認
function check_user($email, $password, $pdo) {
  $sql = "SELECT * FROM users WHERE email = :email;";
  $stmt = $pdo->prepare($sql);
  $params = array(':email' => $email);
  $stmt->execute($params);
  $member = $stmt->fetch(PDO::FETCH_ASSOC);

  if (password_verify($_POST['password'], $member['password'])) {
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $name;
    return true;
  } else {
    global $msg;
    $msg = 'メールアドレスもしくはパスワードが間違っています。';
    $_SESSION['login_error'] = 'メールアドレスもしくはパスワードが間違っています。';
    return false;
  }
}


// トークンの登録
function register_token($email, $token, $pdo) {
  $sql = "SELECT * FROM users WHERE email = :email;";
  $stmt = $pdo->prepare($sql);
  $params = array(':email' => $email);
  $stmt->execute($params);
  $member = $stmt ->fetch(PDO::FETCH_ASSOC);
  $id = $member['id'];

  $sql = "INSERT INTO auto_login ( email, token, registrated_time, user_id) VALUES (?,?,?,?);";
  $date = date('Y-m-d H:i:s');
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, $email, PDO::PARAM_STR);
  $stmt->bindValue(2, $token, PDO::PARAM_STR);
  $stmt->bindValue(3, $date, PDO::PARAM_STR);
  $stmt->bindValue(4, $id, PDO::PARAM_STR);
  $stmt->execute();
}


// ログアウト
function cookie_logout($pdo, $cookie_token) {
  $sql = "DELETE  FROM auto_login WHERE token = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, $cookie_token, PDO::PARAM_STR);
  $stmt->execute();
  setcookie('cookie_token',"", time()-60);
  $_SESSION = array();//セッション変数を削除するためにからの配列を$_SESSIONに格納する
  session_destroy();//セッションを破壊
}



// クッキーがあるuser情報の取得
function user_information($pdo, $cookie_token) {
  global $member;
  $sql = "SELECT * from auto_login where token = :token;";
  $stmt = $pdo->prepare($sql);
  $params = array(':token' => $cookie_token);
  $stmt->execute($params);
  $member = $stmt->fetch(PDO::FETCH_ASSOC);
  $id = $member['user_id'];


  $sql = "SELECT users.name from users join auto_login on users.id = :auto_login";
  $stmt = $pdo->prepare($sql);
  $params = array('auto_login' => $id);
  $stmt->execute($params);
  $member = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($member == false) {
    setCookie("cookie_token", "", time()-60);
    // var_dump($member);
    $_SESSION['error'] = 'ユーザー情報が照合できませんでした。';
    redirect_to_login();
  }
}

// sessionを用いてのログイン認証
function session_information($pdo, $email) {
  global $member;
  $sql = "SELECT * from users where email = :email;";
  $stmt = $pdo->prepare($sql);
  $params = array(':email' => $email);
  $stmt->execute($params);
  $member = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($member == false) {
    setCookie('cookie_token', "", time()-60);
    $_SESSION['error'] = 'セッション情報を認証できませんでした。';
    redirect_to_login();
  } else {
    return true;
  }
}



// クッキーを使っての自動ログイン確認
function check_auto_login($cookie_token, $pdo) {
  $sql = "SELECT * FROM auto_login WHERE token = ?;";
  $date = new DateTime("- 1 days");
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, $cookie_token, PDO::PARAM_STR);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if (count($rows) == 1) {
      //自動ログイン成功
    $_SESSION['email'] = $rows[0]['email'];
    $member = $rows[0];
    return true;
  } else {
    $_SESSION['error'] = 'トークンの照合ができませんでした。もう一度ログインしてください。';
    return false;
  }
}


// トークンの削除
function delete_old_token($cookie_token, $pdo) {
  //プレースホルダで SQL 作成
  $sql = "DELETE FROM auto_login WHERE token = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, $cookie_token, PDO::PARAM_STR);
  $stmt->execute();
}



function cookie_update($pdo, $new_token, $cookie_token) {
  // DBのクッキートークンアップデート
  $sql = "UPDATE auto_login SET token = :new_token where token = :token";
  $stmt = $pdo->prepare($sql);
  $params = array('new_token' => $new_token, 'token' => $cookie_token);
  $stmt->execute($params);
  setCookie("cookie_token", '', -1, "/");
  setCookie("cookie_token", $new_token, time()+60*60*24*14);
}

// ユーザー情報確認やクッキーがあっているのかの確認

function check_cookie($pdo, $cookie_token) {
  global $check;
  $sql = "SELECT * FROM auto_login where token = :token;";
  $stmt = $pdo->prepare($sql);
  $params = array(':token' => $cookie_token);
  $stmt->execute($params);
  $check = $stmt->fetch(PDO::FETCH_ASSOC);
}

// 有効期限切れのトークンレコードの削除
// 1日前登録したクーポンの削除
function expire_token($pdo) {
  $today = date("Y-m-d H:i:s");


  $sql = 'DELETE FROM auto_login WHERE registrated_time < DATE_SUB(CURDATE(), INTERVAL 1 DAY);';
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
}




// ユーザー詳細関連

// 詳細ユーザーの取得
function user_detail($pdo, $id) {
  global $detail;
  $sql = "SELECT * FROM users WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  // $stmt->bindValue(1, $id, PDO::PARAM_STR);
  $params = array(':id' => $id);
  $stmt->execute($params);
  $detail = $stmt->fetch(PDO::FETCH_ASSOC);

  // var_dump($detail);

}



?>