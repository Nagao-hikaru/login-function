<!DOCTYPE html>
<html lang="ja">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>get</title>
</head>
<body>
    <p>aaa</p>
    <?php
    $name = $_GET["name"];
    $gender = $_GET["gender"];
    $blood = $_GET["blood"];
    $opinion = $_GET["opinion"];
// if (isset($_GET['name']) === TRUE) {
//     print 'ここに入力した名前を表示： ' . htmlspecialchars($_GET['name']);
// } else {
//     print '名前が送られていません';
// }
// ?>
    <p>お名前：<?= $name?></p>
    <p>性別：<?=$gender?></p>
  　<p>血液型：<?= $blood?></p>
  　<p>ご意見：<?= $opinion?></p>
    <a href="index.php">戻る</a>
</body>　
</html>