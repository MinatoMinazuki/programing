<?php

require_once __DIR__."/class/DBC.php";

$dbc = new DBC;

$errors = [];

$eventId = $_GET['eventId'];

$eventSql = sprintf("
        SELECT
        *
        FROM
        `schedule_master`
        WHERE
        `id` = '%s'
    ", $eventId);

$eventDatas = $dbc->Dsql($eventSql);

if( empty($eventDatas) ){
    $errors["eventData"] = "無効なイベントIDです";
} else {
    $eventData = $eventDatas[0];
}


if( !empty($_POST) ){
    $uid = 1;
    $name = $_POST["name"];
    $contents = $_POST["contents"];

    //名前・投稿内容の空欄確認
    if($name == null){
        $errors['name'] = "名前を入力してください";
    }
    if($contents == null){
        $errors['contents'] = "投稿内容を入力してください";
    }

    if(!$errors){
        $sql = sprintf("
            INSERT INTO
            `schedule_bord_master`
            (
                `user_id`,
                `name`,
                `contents`,
                `event_id`
            )
            VALUES
            (
                '%s',
                '%s',
                '%s',
                '%s'
            )",
            $uid,
            $name,
            $contents,
            $eventId
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
$limitSql = sprintf("
        SELECT
        *
        FROM `schedule_bord_master`
        WHERE `event_id` = '%s'
        ORDER BY `created` DESC
        LIMIT %d, 5
        ",
        $eventId,
        $limit);

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
        <a href="/bord.php?eventId={$eventId}&page={$prev}" class="prevPage"><img src="../img/arrow_left.png" width="10" height="15"></span></a>
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
            <span><a href="./bord.php?eventId={$eventId}&page={$pageNum}">{$pageNum} </a></span>
EOF;
    }
}

//進む
if($page < $maxPages){
    $next = $page + 1;
    $pagerHTML .= <<<EOF
        <a href="/bord.php?eventId={$eventId}&page={$next}" class="nextPage"><img src="../img/arrow_right.png" width="10" height="15"></span></a>
EOF;
}


?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title><?= $eventData["event_name"] ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .thread {
            margin-bottom: 20px;
            padding: 15px;
            border-left: 5px solid #007bff;
            background: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .thread-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .post {
            margin-top: 10px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 3px solid #ccc;
        }

        .post-meta {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
            text-align: left;
        }

        .post-content {
            font-size: 16px;
            color: #333;
            text-align: left;
        }

        .post-time {
            font-size: 12px;
            color: #333;
            text-align: right;
        }

        .reply {
            margin-left: 20px;
            padding: 8px;
            background: #eef;
            border-left: 3px solid #88f;
            border-radius: 5px;
        }
    </style>
</head>
<body style="margin: 0;">
<center>
    <h1 class="postList">投稿内容一覧</h1>
    <section class="container">
        <h2 class="thread-title"><?= $eventData["event_name"] ?></h2>
        <div class="pager"><?php echo $pagerHTML; ?></div>
            <?php foreach($regist as $loop):?>
                <div class="thread">
                    <div class="post">
                        <div class="post-meta">No:<?php echo $loop['id'] ?> 名前:<?php echo $loop['name'] ?></div>
                        <div class="post-content">投稿内容:<?php echo $loop['contents'] ?></div>
                        <div class="post-time">投稿時間:<?php echo $loop['created']?></div>
                    </div>
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
        <form action="bord.php?eventId=<?= $eventId ?>" method="post">
            <div class="p-new p-name">名前 : <input type="text" name="name" value=""></div>
            <div class="p-new p-content">投稿内容: <textarea name="contents" id="" cols="" rows=""></textarea></div>
            <div><button type="submit">投稿</button></div>
        </form>
    </section>
</center>
</body>
</html>