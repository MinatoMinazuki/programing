<?php

$errors = [];

session_start();

$id = $_GET['id'];

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
$regist->bindValue(":id", (int)$id, PDO::PARAM_INT);
$regist->execute();
// $results = $regist->fetch(PDO::FETCH_ASSOC);

var_dump($regist);

//ここで「登録失敗」だった場合、SQLに誤りがある
// if($regist) {
//     echo "登録成功";
// } else {
//     echo "登録失敗";
// }




?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ブログ記事</title>
    <link rel="stylesheet" href="blog_page_style.css">
</head>
<body style="margin: 0;">
        <h1>ブログ記事</h1>
        <?php foreach($results as $res):?>
            <section class="new">
                <h2 class="post title">タイトル:<?php echo $res['title'] ?></h2>
                <div class="post num">No:<?php echo $res['id'] ?></div>
                <p class="category">カテゴリー:<?php echo $res['category'] ?></p>
                <p class="post content">投稿内容:<?php echo $res['contents'] ?></p>
                <span class="post time">投稿日時:<?php echo $res['created_at']?></span>
            </section>
        <?php endforeach; ?>
</body>
</html>