<?php

require_once 'dbConnect.php';

$connect = new connect();

$recordSet = sprintf("UPDATE goods SET `stock` = `stock` - `%s` WHERE `id` = :id",  1);

$result = $connect->plural($recordSet, 1);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script type="text/javascript" src="../js/cartPage.js?p=<?php echo time(); ?>"></script>
  <link rel="stylesheet" href="../css/cartPage.css?p=<?php echo time(); ?>">
  <title>購入確定</title>
</head>
<body>
  <h2>注文が確定されました</h2>
  <p>注文内容</p>
    <table>
      <tr>
        <th>商品名</th>
        <th>配送日時</th>
        <th>商品サイズ</th>
        <th>在庫</th>
        <th>注文数</th>
      </tr>
    </table>
    <a href="index.php">商品一覧へ戻る</a>
</body>
</html>