<?php

$errors = [];

session_start();

//ログインされていない場合は強制的にログインページにリダイレクト
if(!isset($_SESSION['login'])){
  header("Location: /login/index.php");
  exit();
}


?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理画面</title>
</head>
<body style="margin: 0;">
        <h1>管理画面</h1>
        <ul>
            <li>
                <a href="/top_page/blog_list.php">ブログ一覧へ</a>
            </li>
            <li>
                <a href="/top_page/blog_edit.php">ブログ投稿へ</a>
            </li>
            <li>
                <a href="../index.php">トップページへ</a>
            </li>
            <li>
                <a href="/login/signUp.php">ユーザー新規登録へ</a>
            </li>
            <li>
                <a href="/login/logout.php">ログアウト</a>
            </li>
</body>
<style>
    *{
        margin: 0;
    }

    h1{
        text-align: center;
        letter-spacing: 5px;
    }

    ul{
        text-align: center;
        padding: 0;
    }

    li {
        list-style: none;
        padding-top: 10px;
    }
</style>
</html>