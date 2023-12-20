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
  $orderNum = ""; // 初期化

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
      $orderNum .= "<option value='{$i},{$productId}'>{$i}</option>";
    }
  }

  $trTag .= <<<EOF
            <tr>
                  <td>{$productName}</td>
                  <td>{$sendDate}</td>
                  <td>{$productSize}</td>
                  <td>{$stockText}</td>
                  <td><select name='orderNum[]'>{$orderNum}</select></td>
            </tr>
EOF;
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
  <title>商品一覧ページ</title>
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
    <input type="submit" value="注文を確認する">
  </form>
</body>
</html>