<?php
session_start();
require_once("function.php");
$_SESSION['csrf_token'] = get_token(); // CSRFのトークンを取得する
$new_token = get_token();
// $_COOKIE['cookie_token'] = get_token();
$cookie_token = $_COOKIE['cookie_token'];
$email = $_SESSION['email'];
// var_dump($_COOKIE);
// var_dump($email);
// $cookie_token = get_token();
expire_token($pdo);


// var_dump($_SESSION);
try {
  if (($email)) {
    // var_dump($cookie_token);

    session_information($pdo, $email);

  } else if (($_COOKIE['cookie_token'])) {
    if (check_auto_login($cookie_token, $pdo)) {
      user_information($pdo, $cookie_token);
      cookie_update($pdo, $new_token, $cookie_token);
    } else {
      // delete_old_token($cookie_token, $pdo);
      // クッキーなどが違ったりトークンが照合されなかったらcookieをつぶしてログインページに遷移
      setCookie("cookie_token", "", time()-60);
      // var_dump($new_token);
      redirect_to_login();
    }


  } else {

    setCookie("cookie_token", '', -1, "/");
    redirect_to_login();
  }
} catch (PDOException $e) {
    die($e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="ja">
<link rel="stylesheet" href="user.css">
<body>
  <h1><?= $member['name']?>さんようこそ</h1>
  <?= $_SESSION['email'] ?>
  <div class="user_search">
    <h2 class=>ユーザーを検索する</h2>
    <form action="search.php" method="post">
      検索用語を入力<input type="text" name="yourname">
      <input type="submit" value="検索する">
    </form>
  </div>
  <div class="logout">
    <form action="logout.php" method="post">
      <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, "UTF-8") ?>">
      <input type="submit" value="ログアウト">
    </form>

  </div>
</body>
</html>





