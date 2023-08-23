<?php

require_once './dbc.php';

date_default_timezone_set("Asia/Tokyo");

$file = $_FILES['image'];
$fileName = $file['name'];
$tmp_path = $file['tmp_name'];
$file_err = $file['error'];
$fileSize = $file['size'];
$upload_dir = '/site01/images/';
$save_filename = date('YmdHis') . $fileName;
$save_path = $upload_dir . $save_filename;

var_dump($tmp_path);
var_dump($upload_dir);
var_dump($save_path);

// 拡張子は画像形式か
$allow_ext = array('jpg', 'jpeg', 'png');
$file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
if(!in_array(strtolower($file_ext), $allow_ext)){
    $message = '画像ファイルを添付してください';
}

// ファイルがあるかどうか
if(is_uploaded_file($tmp_path)){
    if(move_uploaded_file($tmp_path, $upload_dir)){
        $message = $fileName . 'を' . $upload_dir . 'にアップしました。';
        // DBに保存する(ファイル名、ファイルパス)
        $result = filesave($fileName, $save_path);

        if($result){
            echo "データベースに保存しました。";
        } else {
            echo "データベースへの保存に失敗しました。";
        }
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