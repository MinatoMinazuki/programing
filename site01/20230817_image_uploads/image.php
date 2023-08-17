<?php

$dsn = "mysql:host=localhost; dbname=sousaku; charaset=utf8";
$username = "root";
$password = "root";
$id = rand(1, 5);

try{
    $dbh = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo $e->getMessage();
}

$sql = "SELECT * FROM images WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();
$image = $stmt->fetch();

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>画像表示</title>
</head>
<body>
    <h1>画像表示</h1>
    <img src="images/<?php echo $image['name']; ?>" width="300" height="300">
    <a href="img_upload">画像アップロード</a>
</body>
</html>