<?php

$errors = [];

session_start();


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

try{
    $regist = $pdo->prepare("SELECT * FROM blog_article");
    $regist->execute();
    $results = $regist->fetchall(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    exit($e);
}

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
    <title>ブログ一覧</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="margin: 0;">
        <h2>ブログ一覧</h2>
        <table>
        <tr>
            <th>No.</th>
            <th>タイトル</th>
            <th>カテゴリー</th>
        </tr>
        <?php foreach($results as $res): ?>
        <tr>
            <td><?php echo $res['id'] ?></td>
            <td><?php echo $res['title'] ?></td>
            <td><?php echo $res['category'] ?></td>
            <td><a href="blog_page.php?id=<?php echo $res['id'] ?>">詳細</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>