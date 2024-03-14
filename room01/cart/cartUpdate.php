<?php

require_once 'dbConnect.php';

$connect = new connect();

date_default_timezone_set('Asia/Tokyo');
$updateTime = date("Y-m-d H:i:s");

for ($i=0; $i < count($_POST); $i++) { 
  $updateIdArray[] = htmlspecialchars($_POST["productId"][$i], ENT_QUOTES);
  $updateNameArray[] = htmlspecialchars($_POST["productName"][$i], ENT_QUOTES);
  $updateDateArray[] = htmlspecialchars($_POST["sendDate"][$i], ENT_QUOTES);
  $updateSizeArray[] = htmlspecialchars($_POST["productSize"][$i], ENT_QUOTES);
  $updateStockArray[] = htmlspecialchars($_POST["productStock"][$i], ENT_QUOTES);
  $updatePriceArray[] = htmlspecialchars($_POST["productPrice"][$i], ENT_QUOTES);
}

$recordSet = sprintf("SELECT * FROM goods ORDER BY id ASC");

$result = $connect->select($recordSet);

$trTag = "";

foreach ($result as $key => $val) {

  $productId = $val["id"];
  $productName = $val["name"];
  $sendDate = $val["send"];
  $productSize = $val["size"];
  $productStock = $val["stock"];
  $productPrice = $val["price"];

  $isUpdate = false;

  if ($productName !== $updateNameArray[$key]) {
    $productName = $updateNameArray[$key];
    $isUpdate = true;
  }
  if ($sendDate !== $updateDateArray[$key]) {
    $sendDate = $updateDateArray[$key];
    $isUpdate = true;
  }
  if ($productSize !== $updateSizeArray[$key]) {
    $productSize = $updateSizeArray[$key];
    $isUpdate = true;
  }
  if ($productStock !== $updateStockArray[$key]) {
    $productStock = $updateStockArray[$key];
    $isUpdate = true;
  }

  if ($productPrice !== $updatePriceArray[$key]) {
    $productPrice = $updatePriceArray[$key];
    $isUpdate = true;
  }

  if($isUpdate){
    $updateRecord = sprintf("UPDATE goods SET name='%s', send='%s', size='%s', stock='%d', price='%s', update_date='%s' WHERE id = :id", $productName, $sendDate, $productSize, $productStock, $productPrice, $updateTime);

    $result = $connect->plural($updateRecord, $productId);

    $trTag.=<<<EOF
      <tr>
        <td class="tdName">{$productName}</td>
        <td class="tdDate">{$sendDate}</td>
        <td class="tdSize">{$productSize}</td>
        <td class="tdStock">{$productStock}</td>
        <td class="tdPrice">{$productPrice}円</td>
      </tr>
EOF;
  }

}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script type="text/javascript" src="../js/cartPage.js?p=<?php echo time(); ?>"></script>
  <link rel="stylesheet" href="../css/reset.css?p=<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/cartPage.css?p=<?php echo time(); ?>">
  <title>商品一覧ページ</title>
</head>
<body>
  <div class="wrapper">
  <?php if(!$trTag){?>
    <p>何も更新されていません</p>
  <?php } else { ?>
    <h2>下記内容で更新しました</h2>
    <div class="wrapperTable">
    <table>
      <tr>
        <th>商品名</th>
        <th>配送日時</th>
        <th>商品サイズ</th>
        <th>在庫</th>
        <th>金額</th>
      </tr>
      <?php echo $trTag; ?>
    </table>
    </div>
  <?php } ?>
  <a href="../cart/cartControl.php">更新ページに戻る</a>
  </div>
</body>
</html>