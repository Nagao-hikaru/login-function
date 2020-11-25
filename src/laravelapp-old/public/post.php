<!DOCTYPE html>
<html lang="ja">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>get</title>
</head>
<body>
    <p>aaa</p>
    <?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    try {
      $dsn = 'mysql:host=laravel_db;dbname=laravel_db';
      $user = 'laravel_user';
      $password = 'laravel_pass';
      $pdo = new PDO($dsn, $user, $password);
      // $a = new PDO(ローカルホスト, データベース名,ユーザー名,パスワード,その他)基本的なpdoの作成方法。
      if (!empty($_POST["name"])) {
        $name = filter_input( INPUT_POST, "name");
      } else {
        echo 'この項目は未入力です';
      }
      $email = filter_input( INPUT_POST, "email");
      $password = filter_input( INPUT_POST, "password");
      // var_dump($_POST);
      
      $sql = "INSERT INTO users (name, email, password) values (:name, :email, :password) ";
      
      $statement = $pdo->prepare($sql);
      // prepareメソッドを使用によりバリューの部分がプレースホルダーとなる。次の処理でパラメータの値をキーに挿入して最終的にsqlを発行する
      
      
      // 配列で表現する場合
      $params = array(':name' => $name, ':email' => $email, ':password' => $password);
      // 配列としてキーに値を挿入、値に関してはfilter_inputで取得した情報となる
      
      // bindparamメソッドを使用した場合
      
      // var_dump($statement);
      
      // var_dump($params);
      
      $statement->execute($params);
      
      // $aaa = rsort($users);rsort関数は配列をソートする関数で
      // オブジェクトをソートするわけではない
  
      $users = $pdo->query('select * from users order by id desc');
  
      // for ($i = 0;  $i < 10; $i++) {
      //   var_dump($users->$name);
      // }
      $i = 0;
    } catch (PDOexception $e) {
      exit('データベースに接続できませんでした' . $e->getMessage());
      // exit関数はプログラムを終了する関数
    }

?>
<h2>ユーザー登録新しい１０件</h2>
  <?php foreach ($users as $user):?>
    <?php if ($i > 10):?>
      <?php break;?>
    <?php endif; ?>

)
    <p>お名前：<?= $user['name']?></p>
    <p>email：<?= $user['email']?></p>
    <a href="index.php">戻る</a>
    <?php $i++; ?>
  <?php endforeach; ?>
  <!-- 上記の説明として$usersはselect文からとってきたオブジェクト。それをforeachで回すことによってユーザー情報を表示。最後に$iがプラス１になるので１０になった段階でbreakメソッドが発動 -->
</body>　
</html>