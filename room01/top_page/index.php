<?php

session_start();

//Basic認証
$basic_user = "kubo";
$basic_pass = "kubo";

$errors = [];

// DB情報
$db_name = "sousaku";
$db_host = "localhost";
$db_user = "root";
$db_pass = "root";

// if(isset($_SERVER['PHP_AUTH_USER']) && ($_SERVER['PHP_AUTH_USER'] === $basic_user && $_SERVER['PHP_AUTH_PW'] === $basic_pass){

    $pdo = new PDO("mysql:dbname={$db_name}; host={$db_host}", "{$db_user}", "{$db_pass}", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'")
    );

    $sql_news = "SELECT * FROM `news` ORDER BY `id` DESC;";

    $stmt = $pdo->query($sql_news);


// } else {
//     header("WWW-Authenticate: Basic realm=\"basic\"");
//     header("HTTP/1.0 401 Unauthorized - basic");
//     echo "<p>Unauthorized</p>";
//     exit();
// }

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>制作物の倉庫</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@200;400;500;700&family=Sawarabi+Gothic&display=swap" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
    <div id="topImage">
        <h2 class="title">深黒兎の制作物倉庫</h2>
    </div>
    <div class="header_menu">
        <span class="menuList">
            <a href="" class="home menu">HOME</a>
            <a href="" class="about menu">ABOUT</a>
            <a href="" class="items menu">ITEMS</a>
            <a href="" class="gallery menu">GALLERY</a>
            <a href="" class="news menu">NEWS</a>
        </span>
    </div>
    <div class="contents">
        <div class="content_news">
            <span class="content_title">NEWS</span>
                <?php foreach($stmt as $loop):?>
                    <div class="container container_news">
                        <span class="news_time">更新日時:<?php echo $loop['created_at'] ?></span>
                        <span class="news_content"><?php echo $loop['contents'] ?>が更新されました！</span>
                    </div>
                <?php endforeach; ?>
        </div>
        <div class="content_gall">
            <span class="content_title gall">GALLERY</span>
        </div>
    </div>
<footer>
    <a href="/room01/login/index.php" class="login">ログイン</a>
</footer>
</div>
</body>
</html>