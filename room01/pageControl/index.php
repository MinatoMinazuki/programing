<?php

$errors = [];

session_start();

//ログインされていない場合は強制的にログインページにリダイレクト
if(!isset($_SESSION['login'])){
  header("Location: /room01/login/index.php");
  exit();
}


?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理画面</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="margin: 0;">
        <h1>管理画面</h1>
        <ul>
            <li>
                <a href="/room01/top_page/blog_list.php">ブログ一覧へ</a>
            </li>
            <li>
                <a href="/room01/login/signUp.php">新規登録へ</a>
            </li>
            <li>
                <a href="/room01/login/logout.php">ログアウト</a>
            </li>
</body>
<style>
    *{
        margin: 0;
    }

    li {
        list-style: none;
    }
</style>
</html>