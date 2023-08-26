<?php

require_once './dbc.php';

$files = getAllFile();


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
        <?php foreach ($files as $file): ?>
            <img src="<?php echo "{$file['file_path']}"; ?>" alt="">
        <?php endforeach; ?>
        <img src="images/20230824055037jinja_back.png" alt="">
    </div>
</body>
</html>