<?php

session_start();
require_once("function.php");
$email = $_SESSION['email'];

$id = $_GET['id'];

var_dump($id);

// ログイン済みなのかの確認
session_information($pdo, $email);

user_detail($pdo, $id);

// var_dump($detail);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="search.css">
   <title>ユーザー詳細</title>
</head>
<body>
   <header>
       <div class="login-header">
           <h4><?= $member['name']?>さん</h4>
           <p><a href="logout.php">ログアウト</a></p>
       </div>
   </header>
   <main>
       <ul>
           <li>名前: <?= $detail['name'];?></li>
           <li>email: <?= $detail['email']?></li>
       </ul>
       <h3>記事一覧</h3>
   </main>
</body>
</html>