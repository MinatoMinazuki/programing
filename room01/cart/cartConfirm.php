<?php

require_once 'dbConnect.php';

$connect = new connect();

date_default_timezone_set('Asia/Tokyo');
$updateTime = date("Y-m-d H:i:s");

for ($i=0; $i < count($_POST); $i++) { 
  $orderId = htmlspecialchars($_POST['orderId'][$i], ENT_QUOTES);
  $orderNum = htmlspecialchars($_POST['orderNum'][$i], ENT_QUOTES);

  $recordSelect = sprintf("SELECT * FROM goods WHERE id = '%d' ORDER BY id ASC", $orderId);
  $resultSelect = $connect->select($recordSelect);

  foreach ($resultSelect as $key => $val) {
    $productId = $val["id"];
    $productName = $val["name"];
    $sendDate = $val["send"];
    $productSize = $val["size"];
    $productStock = $val["stock"];

    $updateStock = $productStock - $orderNum;

    if($updateStock <= 0){
      $updateStock = 0;
    }

    $tag.=<<<EOF
      <tr>
        <td>{$productName}</td>
        <td>{$sendDate}</td>
        <td>{$productSize}</td>
        <td>{$orderNum}</td>
      </tr>
EOF;

  }

  $recordUpdate = sprintf("UPDATE goods SET `stock` = '%s', `update_date` = '%s' WHERE `id` = '%s'", $updateStock, $updateTime, $productId);

  $resultUpdate = $connect->plural($recordUpdate);
  $resultUpdate->fetchAll(PDO::FETCH_ASSOC);
}



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
        <th>注文数</th>
      </tr>
      <?php echo $tag; ?>
    </table>
    <a href="index.php">商品一覧へ戻る</a>
</body>
</html>