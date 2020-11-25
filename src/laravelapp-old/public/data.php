<?php
// echo 'a';

// echo '長尾　光';

// $pdo = new PDO('mysql:host=localhost;dbname=laravel_db;charset=UTF8mb4', 'laravel_user', 'laravel_password');

$dsn = 'mysql:host=laravel_db;port=3306;dbname=laravel_db;charset=UTF8mb4';
$user = 'laravel_user';
$password = 'laravel_pass';
$pdo = new PDO($dsn, $user, $password);
// $dbname = 'dbname=laravel_db;';



$sss = $pdo->query('select * from users');
// var_dump($sss);

// foreach ($sss as $row) {
//     var_dump($row['name']);
//
$up = "UPDATE users set name = 'nagao' where id = 11";
$up_query = $pdo->query($up);

foreach ($sss as $row) {
    var_dump($row);
}
// print_r($up_query);


// $pre = "UPDATE users set name = :name where id = :id";
// $sth = $pdo->prepare($pre);
// $sth -> bindvalue(':name', 'pika');
// $sth -> bindvalue(':id', 15);
// $sth -> execute();
// var_dump($sth);



$aaa = $pdo->query('select * from users where id <= 10');

// foreach ($aaa as $aaa) {
//     var_dump($aaa);
//

// $bbb = $pdo->query('select name from users where name like "%h%" ');
// $bbb = $pdo->query('select name from users where name like "%7%" ');
$bbb = $pdo->query('select name from users where name like "__%u%" ');
// %_はワイルドカード文字と言って文字列の部分一致の際に使用する。

// var_dump($bbb);

// foreach ($bbb as $bbb) {
//     var_dump($bbb);
// };

$ccc = $pdo->query('select * from users order by id desc');

// var_dump($ccc);

// foreach ($ccc as $ccc) {
//     var_dump($ccc);


$ddd = $pdo->query('delete from users where id = 11;');

// var_dump($ddd);


// foreach($sss as $row) {
//     var_dump($row);
// }

$eee = $pdo->query('select name from users group by name');

// var_dump($eee);

// foreach ($eee as $eee) {
//     var_dump($eee);
// }

$fff = $pdo->query('select MIN(id) from users');

// var_dump($fff);

// foreach ($fff as $fff) {
//     var_dump($fff);
// }