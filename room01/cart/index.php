<?php

require_once 'dbConnect.php';

$connect = new connect();

$recordSet = sprintf("SELECT * FROM goods ORDER BY id ASC");

$result = $connect->select($recordSet);

foreach ($result as $key => $val) {

  $productName = $val["name"];
  $sendDate = $val["send"];
  $productSize = $val["size"];
  $productStock = $val["stock"];

  $orderStock = intval($productStock);

  for ($i = 0; $i < $orderStock; $i++) { 
    if($i = 0){
      $orderNum = "<option value='{$i}' disabled selected>選択してください</option>";
    } else {
      $orderNum = "<option value='{$i}'>{$i}</option>";
    }
  }

  var_dump($orderStock);

  $trTag .= "<tr>
                  <td>{$productName}</td>
                  <td>{$sendDate}</td>
                  <td>{$productSize}</td>
                  <td>{$productStock}</td>
                  <td><select>{$orderNum}</select></td>
            </tr>";
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
</body>
</html>