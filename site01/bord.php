<?php
$errors = [];
if($_POST){
    $id = null;
    $name = $_POST["name"];
    $contents = $_POST["contents"];

    //名前・投稿内容の空欄確認
    if(null == $name){
        $errors['name'] .= "名前を入力してください";
    }
    if(null == $contents){
        $errors['contents'] .= "投稿内容を入力してください";
    }

    if(!$errors){
        date_default_timezone_set('Asia/Tokyo');
        $created_at = date('Y-m-d H:i:s');
        //DB接続情報を設定
        $pdo = new PDO(
            "mysql:dbname=bord;host=localhost","root","root",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'")
        );

        /*ここで「DB接続NG」だった場合、接続情報に誤りがある
        if($pdo){
            echo "DB接続OK";
        } else {
            echo "DB接続NG";
        }
        //*/

        //SQLを実行
        $regist = $pdo->prepare("INSERT INTO post(id, name, contents, created_at) VALUES(:id,:name,:contents,:created_at)");
        $regist->bindParam(":id", $id);
        $regist->bindParam(":name", $name);
        $regist->bindParam(":contents", $contents);
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

if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $page = $_GET['page'];
} else {
    $page = 1;
}

//DB接続情報を設定
$pdo = new PDO(
    "mysql:dbname=bord;host=localhost","root","root",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'")
);

//SQLを実行
$limit = ($page - 1)*5;
$limitSql = sprintf("SELECT * FROM post ORDER BY created_at DESC LIMIT %d, 5", $limit);

$regist = $pdo->prepare($limitSql);
$regist->execute();

//ページャー機能

$pagerHTML = "";

$countSql = 'SELECT COUNT(*) as cnt FROM post';

$Counts = $pdo -> query($countSql);

$count =  $Counts -> fetch(PDO::FETCH_ASSOC);

$maxPages = ceil($count['cnt'] / 5);

//戻る
if($page > 1){
    $prev = $page - 1;
    $pagerHTML .= <<<EOF
        <a href="/bord.php?page={$prev}" class="prevPage"><img src="../img/arrow_left.png" width="10" height="15"></span></a>
EOF;
}

//ページ番号
for($pageNum = 1; $pageNum <= $maxPages; $pageNum++){
    if($pageNum == $page){
        $pagerHTML .= <<<EOF
            <span class="current">{$pageNum}</span>
EOF;
    } else {
        $pagerHTML .= <<<EOF
            <span><a href="./bord.php?page={$pageNum}">{$pageNum} </a></span>
EOF;
    }
}

//進む
if($page < $maxPages){
    $next = $page + 1;
    $pagerHTML .= <<<EOF
        <a href="/bord.php?page={$next}" class="nextPage"><img src="../img/arrow_right.png" width="10" height="15"></span></a>
EOF;
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>掲示板</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="margin: 0;">
<center>
    <h1>掲示板サンプル</h1>
    <section class="new">
        <h2>新規投稿</h2>
        <div id="error">
            <?php foreach($errors as $error); ?>
            <?php {echo $error.'<br>';}?>
        </div>
        <form action="bord.php" method="post">
            <div class="p-new p-name">名前 : <input type="text" name="name" value=""></div>
            <div class="p-new p-content">投稿内容: <textarea name="contents" id="" cols="" rows=""></textarea></div>
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