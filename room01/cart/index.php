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

  if($stocks > 0 && $stocks < 5){
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
                  <td><select name='{$productName}'>{$orderNum}</select></td>
            </tr>";
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
  <title>一覧ページ</title>
</head>
<body>
  <form method="post" action="cartCheck.php">
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
    <input type="submit" value="注文確定する">
  </form>
<!--   <div class="cartIconOuter" data-show="0">
    <a href="#" class="cartIcon">
      <span class="intoCartNumber">1</span>
      <img src="../img/shopping-cart-empty-1.png">
    </a>
  </div> -->
</body>
</html>