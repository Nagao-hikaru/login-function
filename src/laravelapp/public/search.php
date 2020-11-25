<?php

// $errors = "";
ini_set("memory_limit", "512M");


if(empty($_POST)) {
  // var_dump($_POST);
	header("Location: search_form.html");
	exit();
}else{
	//名前入力判定
	if (!isset($_POST['yourname'])  || $_POST['yourname'] === "" ){
    $errors['name'] = "名前が入力されていません。";
    // var_dump($errors);
	}
}

if (!isset($errors)) {
  $dsn = 'mysql:host=laravel_db;dbname=laravel_db';
  $user = 'laravel_user';
  $password = 'laravel_pass';
  $yourname = $_POST['yourname'];
  // var_dump($yourname);
  
  try {
    $pdo = new PDO($dsn, $user, $password);
    $sql = "SELECT * from users where name like :name;";
    $stmt = $pdo->prepare($sql);
    $likeyourname = "%".$yourname."%";
    $params = array(':name' => $likeyourname);
    // var_dump($stmt);
    // var_dump($params);
    $stmt->execute($params);
    // $member = $stmt ->fetch(PDO::FETCH_ASSOC);
    $member_count = $stmt->rowCount();
    // sql文によって取得した行数を返す
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($members);

//     function escape1($str)
// {
//     return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
// }


    foreach ($members as $key => $value) {
      // var_dump($key);
      // var_dump($value);
      // $users = $member;
      // var_dump($users);
    }
    // // var_dump($value);
    // while($row = $members) {
    //   $rows[] = $row;
    // }

  } catch (PDOException $e) {
    die($e->getMessage());
  }
}



?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="user.css">
  <title>検索結果</title>
</head>
<body>
  <h1>検索結果</h1>

  <? if (isset($errors)) : ?>
    <?= $errors['name'] ?>
    <a href="welcome.php">もう一度入力してください</a>
   
  <? elseif ($member_count == 0) :?>
    <h2>ヒット件数 0件</h2>
    <?PHP echo '検索にヒットしませんでした' ?>
    <a href="welcome.php">もう一度入力してください</a>
  <? else : ?>
    <h2>ヒット件数</h2>
    <?= $member_count ?>件
    <?php foreach($members as $key => $value) : ?>
      <div class="">
        <h3>
          ID
        </h3>
        <div>
          <?= $value['id'] ?>: 名前：<?= $value['name'] ?>: email: <?= $value['email'] ?>
        </div>
      </div>
      <br>
      <?php endforeach; ?>
      <a href="welcome.php">検索画面に戻る</a>
  <?php endif ; ?>
  <br>
  
</body>
</html>