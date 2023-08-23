<?php

require_once './dbc.php';

$files = getAllFile();

foreach ($files as $file) {
    print_r($file);
}

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
    <a href="img_upload.php">画像アップロードへ</a>
    <div>
        <?php foreach ($files as $file):?>
            <img src="<?php echo "{$file["file_path"]}" ?>" alt="">
        <?php endforeach; ?>
    </div>
</body>
</html>