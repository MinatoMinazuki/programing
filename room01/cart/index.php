<?php

require_once 'dbConnect.php';

$connect = new connect();

$recordSet = sprintf("SELECT * FROM goods ORDER BY id ASC");

$result = $connect->select($recordSet);

foreach ($result as $key => $val) {

  $productId = $val["id"];
  $productName = $val["name"];
  $sendDate = $val["send"];
  $productSize = $val["size"];
  $productStock = $val["stock"];

  $orderStock = intval($productStock);
  $orderNum = "";

  $stocks = intval($productStock);

  if($stocks > 0 && $stocks <= 5){
    $stockText = "残りわずか";
  } else if($stocks === 0){
    $stockText = "品切れ";
  } else {
    $stockText = "在庫あり";
  }

  for ($i = 0; $i <= $orderStock; $i++) { 
    if($i === 0){
      $orderNum .= "<option value='{$i}' selected>選択</option>";
    } else {
      $orderNum .= "<option value='{$i}'>{$i}</option>";
    }
  }

  $trTag .= "<tr>
                  <td>{$productName}</td>
                  <td>{$sendDate}</td>
                  <td>{$productSize}</td>
                  <td>{$stockText}</td>
                  <td><select>{$orderNum}</select></td>
                  <td><input type=button value='カートに入れる' class='intoCartBtn' data-product-id='{$productId}' data-product-stock='{$productStock}'></td>
            </tr>";
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="../js/cartPage.js"></script>
  <link rel="stylesheet" href="../css/cartPage.css">
  <title>一覧ページ</title>
</head>
<body>
  <table>
    <tr>
      <th>商品名</th>
      <th>配送日時</th>
      <th>商品サイズ</th>
      <th>在庫</th>
      <th>注文数</th>
    </tr>
    <?php echo $trTag; ?>
  </table>
  <div class="cartIconOuter" data-show="0">
    <a href="#" class="cartIcon">
      <img src="../img/shopping-cart-empty-1.png">
    </a>
  </div>
</body>
</html>