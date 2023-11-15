<?php

$errors = [];

session_start();

$id = (int)$_GET['id'];

if(empty($id)){
    exit("IDが不正です");
} else {

    //DB接続情報を設定
    $pdo = new PDO(
        "mysql:dbname=sousaku;host=localhost","root","root",[
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES=>false,
        ]);

    /*ここで「DB接続NG」だった場合、接続情報に誤りがある
    if($pdo){
        echo "DB接続OK";
    } else {
        echo "DB接続NG";
    }
    //*/

    //SQLを実行
    $regist = $pdo->prepare("SELECT * FROM blog_article WHERE id = :id");
    $regist->bindValue(":id", $id, PDO::PARAM_INT);
    $regist->execute();
    $res = $regist->fetch(PDO::FETCH_ASSOC);

    if(!$res){
        exit("ブログがありません");
    }

    //ここで「登録失敗」だった場合、SQLに誤りがある
    // if($regist) {
    //     echo "登録成功";
    // } else {
    //     echo "登録失敗";
    // }
}




?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ブログ記事</title>
    <link rel="stylesheet" href="blog_page_style.css">
</head>
<body style="margin: 0;">
        <h1>ブログ詳細</h1>
            <section class="new">
                <h2 class="post title">タイトル:<?php echo $res['title'] ?></h2>
                <div class="post num">No:<?php echo $res['id'] ?></div>
                <p class="category">カテゴリー:<?php echo $res['category'] ?></p>
                <hr>
                <p class="post content">本文:<?php echo $res['contents'] ?></p><br>
                <p class="post time">投稿日時:<?php echo $res['created_at']?></p>
            </section>
</body>
</html>