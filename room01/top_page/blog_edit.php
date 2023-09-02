<?php

$errors = [];

if( isset($_POST) ){

    $id = null;
    $title = $_POST["title"];
    $category = $_POST["category"];

    //名前・投稿内容の空欄確認
    if(null == $title){
        $errors['title'] .= "タイトルを入力してください";
    }
    if(null == $category){
        $errors['category'] .= "カテゴリーを入力してください";
    }

    if(!$errors){
        date_default_timezone_set('Asia/Tokyo');
        $created_at = date('Y-m-d H:i:s');
        //DB接続情報を設定
        $pdo = new PDO(
            "mysql:dbname=sousaku;host=localhost","root","root",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'")
        );

        /*ここで「DB接続NG」だった場合、接続情報に誤りがある
        if($pdo){
            echo "DB接続OK";
        } else {
            echo "DB接続NG";
        }
        //*/

        //SQLを実行
        $regist = $pdo->prepare("INSERT INTO post_blog(id, title, category, created_at) VALUES(:id,:title,:category,:created_at)");
        $regist->bindParam(":id", $id);
        $regist->bindParam(":name", $title);
        $regist->bindParam(":category", $category);
        $regist->bindParam(":created_at", $created_at);
        $regist->execute();

        /*ここで「登録失敗」だった場合、SQLに誤りがある
        if($regist) {
            echo "登録成功";
        } else {
            echo "登録失敗";
        }
        //*/
    }
}



?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ブログ投稿</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="margin: 0;">
<center>
    <h1>投稿画面</h1>
    <section class="new">
        <h2>新規投稿</h2>
        <div id="error">
            <?php foreach($errors as $error); ?>
            <?php {echo $error.'<br>';}?>
        </div>
        <form action="/top_page/bord.php" method="post">
            <p>カテゴリ : <input type="text" name="category"></p>
            <p>タイトル : <input type="text" name="title"></p>
            <p>本文<br><textarea name="text" cols="50" rows="10"></textarea></p>
            <div><button type="submit">投稿</button></div>
        </form>
    </section>


    <section class="posted">
        <h2 class="post">投稿内容一覧</h2>
        <div><?php echo $pagerHTML; ?></div>
            <?php foreach($regist as $loop):?>
                <div class="container">
                <div class="post num">No:<?php echo $loop['id'] ?></div>
                <div class="post name">名前:<?php echo $loop['name'] ?></div>
                <div class="post content">投稿内容:<?php echo $loop['contents'] ?></div>
                <div class="post time">投稿時間:<?php echo $loop['created_at']?></div>
                </div>
            <?php endforeach; ?>
    </section>
</center>
</body>
</html>