<?php

require_once 'dbConnect.php';

$connect = new connect();

$cartContents = [];

$error = [];

$to = htmlspecialchars($_POST["mailadrres"], ENT_QUOTES);
$userName = htmlspecialchars($_POST["userName"], ENT_QUOTES);
$userAdress = htmlspecialchars($_POST["userAdress"], ENT_QUOTES);

$orderNum = $_POST['orderNum'];
$orderIds = $_POST['productId'];

$total = [];
$tag = "";

if($orderIds === ""){
}

for($i=0; $i < count($orderIds); $i++){

  $order = $orderNum[$i];
  $orderId = $orderIds[$i];
  $noItemNum = 0;

  if( empty($order) ){
    $noItemNum++;

    if($noItemNum === count($orderIds)){
      array_push($error, "商品が選ばれていません。");
    }

    continue;
  }

    $recordSet = sprintf("SELECT * FROM goods WHERE id = '%s' ORDER BY id ASC", $orderId);
    $result = $connect->select($recordSet);

  foreach ($result as $key => $val) {

    $productId = $val["id"];
    $productName = $val["name"];
    $sendDate = $val["send"];
    $productSize = $val["size"];
    $productPrice = $val["price"];

    $subtotal = $productPrice * $order;
    array_push($total, $subtotal);

    $tag.=<<<EOF
          <tr>
            <td class="tdName">{$productName}</td>
            <td class="tdDate">{$sendDate}</td>
            <td class="tdSize">{$productSize}</td>
            <td class="tdOrder">{$order}</td>
            <td class="tdSubtotal">{$subtotal}円</td>
            <input type="hidden" name="orderId[]" value='{$productId}'>
            <input type="hidden" name="orderNum[]" value='{$order}'>
          </tr>
EOF;
  }

}

$totalAmount = array_sum($total);

if(!empty($error)){
  for($i=0; $i <= count($error); $i++){
    echo $error[$i];
  };
  exit();
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
  <title>注文確認</title>
</head>
<body>
  <div class="wrapper">
    <h2>注文確認</h2>
    <form class="form" method="post" action="cartConfirm.php">
      <div class="wrapperTable">
        <table>
          <tr>
            <th>商品名</th>
            <th>配送日時</th>
            <th>商品サイズ</th>
            <th>注文数</th>
            <th>小計</th>
          </tr>
          <?php echo $tag; ?>
        </table>
        <p class="wrapperTotalAmount">
          <span class="totalAmount">合計</span>
          <span class="total"><?= $totalAmount; ?>円</span>
          <input type="hidden" name="totalAmount" value="<?= $totalAmount; ?>">
        </p>
      </div>
      <div class="userInfoWrapper check">
          <p class="userInfoTitleWrapper"><span class="userInfoTitle">お客様情報入力欄</span></p>
          <p class="userInfoOuter">
            <span class="userInfo userName">お名前：<?= $userName ?></span><input type="hidden" name="userName" value="<?= $userName; ?>">
          </p>
          <p class="userInfoOuter">
            <span class="userInfo userAdress">住所：<?= $userAdress; ?></span><input type="hidden" name="userAdress" value="<?= $userAdress; ?>">
          </p>
          <p class="userInfoOuter">
            <span class="userInfo userMailadress">メールアドレス：<?= $to; ?></span><input type="hidden" name="mailadrres" value="<?= $to; ?>">
          </p>
      </div>
      <p class="wrapperBtn wrapperbackBtn">
        <a href="javascript:history.back();" class="backBtn">商品選択へ戻る</a>
      </p>
      <p class="wrapperBtn wrapperSubmitBtn">
        <input type="submit" class="submitBtn" value="注文を確定する">
      </p>
    </form>
  </div>
</body>
</html>