<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false){
    print'ログインされていません<br>';
    print'<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
} else {
    print$_SESSION['staff_name'];
    print'さんログイン中<br>';
    print'<br>';
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>商品追加</title>
</head>
<body>

<?php

try {
    // 入力データを取得
    require_once('../common/common.php');

    $post=sanitize($_POST);
    $pro_name = $post['name'];
    $pro_price = $post['price'];
    $pro_gazou_name = $post['gazou_name'];
    // データベース接続設定
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL文の準備
    $sql = 'INSERT INTO mst_product(name,price,gazou) VALUES (?, ?, ?)';
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$pro_name, $pro_price, $pro_gazou_name]);

    // データベース接続を切断
    $dbh = null;

    print $pro_name . 'を追加しました。<br>';

} catch (Exception $e) {
    // エラーメッセージの表示
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    print $e->getMessage(); // デバッグ用にエラーメッセージを表示する
    exit();
}

?>

<a href="pro_list.php">戻る</a>
</body>
</html>