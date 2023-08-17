<?php

$dsn = "mysql:host=localhost; dbname=sousaku; charaset=utf8";
$username = "root";
$password = "root";

try{
    $dbh = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo $e->getMessage();
}

$file = $_FILES['image'];
$fileName = $file['name'];
$tmp_path = $file['tmp_name'];
$file_err = $file['error'];
$fileSize = $file['size'];
$upload_dir = '/./site01/imeges/';
$save_filename = date('YmdHis') . $fileName;

// 拡張子は画像形式か
$allow_ext = array('jpg', 'jpeg', 'png');
$file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
if(!in_array(strtolower($file_ext), $allow_ext)){
    $message = '画像ファイルを添付してください';
}

// ファイルがあるかどうか
if(is_uploaded_file($tmp_path)){
    if(move_uploaded_file($tmp_path, $upload_dir.$save_filename)){
        $message = $fileName . 'を' . $upload_dir . 'にアップしました。';
    } else {
        $message = 'ファイルのアップに失敗しました';
    }
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>画像アップロード</title>
</head>
<body>
    <h1>画像アップロード</h1>
    <?php if(isset($_POST['upload'])): ?>
        <p><?php echo $message; ?></p>
        <a href="image.php">画像表示へ</a>
        <a href="img_upload.php">アップロード画面へ</a>
    <?php else: ?>
        <form method="post" enctype="multipart/form-data">
            <p>アップロード画像</p>
            <input type="file" name="image">
            <button><input type="submit" name="upload" value="送信"></button>
        </form>
    <?php endif; ?>
</body>
</html>