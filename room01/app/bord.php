<?php

require_once __DIR__."/class/DBC.php";

$dbc = new DBC;

$errors = [];
if($_POST){
    $uid = 1;
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
        $sql = sprintf("
            INSERT INTO
            `schedule_bord_master`
            (
                `user_id`,
                `name`,
                `contents`
            )
            VALUES
            (
                '%s',
                '%s',
                '%s'
            )",
            $uid,
            $name,
            $contents
            );

        $dbc->Dsql($sql);
    }
}

if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $page = $_GET['page'];
} else {
    $page = 1;
}


//SQLを実行
$limit = ($page - 1)*5;
$limitSql = sprintf("SELECT * FROM `schedule_bord_master` ORDER BY `created` DESC LIMIT %d, 5", $limit);

$regist = $dbc->Dsql($limitSql);

//ページャー機能

$pagerHTML = "";

$countSql = 'SELECT COUNT(*) as `cnt` FROM `schedule_bord_master`';

$count =  $dbc->Dsql($countSql);

$maxPages = ceil($count[0]['cnt'] / 5);

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
    <section class="posted">
        <h2 class="post">投稿内容一覧</h2>
        <div><?php echo $pagerHTML; ?></div>
            <?php foreach($regist as $loop):?>
                <div class="container">
                <div class="post num">No:<?php echo $loop['id'] ?></div>
                <div class="post name">名前:<?php echo $loop['name'] ?></div>
                <div class="post content">投稿内容:<?php echo $loop['contents'] ?></div>
                <div class="post time">投稿時間:<?php echo $loop['created']?></div>
                </div>
            <?php endforeach; ?>
    </section>

    <section class="new">
        <h2>新規投稿</h2>
        <?php if( !empty($errors) ): ?>
            <div id="error">
                <?php foreach($errors as $error); ?>
                <?php {echo $error.'<br>';}?>
            </div>
        <?php endif; ?>
        <form action="bord.php" method="post">
            <div class="p-new p-name">名前 : <input type="text" name="name" value=""></div>
            <div class="p-new p-content">投稿内容: <textarea name="contents" id="" cols="" rows=""></textarea></div>
            <div><button type="submit">投稿</button></div>
        </form>
    </section>
</center>
</body>
</html>