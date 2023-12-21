<?php

require_once 'dbConnect.php';

$connect = new connect();

$cartContents = [];

$error = [];

$orderNum = $_POST['orderNum'];

$orderIds = [];

for ($i=0; $i < count($orderNum); $i++) { 
  if($orderNum[$i] !== ""){
    $orderIds[] = explode(",", $orderNum[$i]);
  }
}

if(empty($orderIds)){
  array_push($error, "商品が選ばれていません。");
}

for($i=0; $i < count($orderIds); $i++){

  $order = $orderIds[$i][0];
  $orderId = $orderIds[$i][1];

    $recordSet = sprintf("SELECT * FROM goods WHERE id = '%s' ORDER BY id ASC", $orderId);
    $result = $connect->select($recordSet);

  foreach ($result as $key => $val) {

    $emptyCnt = 0;

    $productId = $val["id"];
    $productName = $val["name"];
    $sendDate = $val["send"];
    $productSize = $val["size"];

    if($_POST['orders'][$key] !== "0"){
      $orderNum = $_POST['orders'][$key]; // 注文数

      $tag.=<<<EOF
            <tr>
              <td>{$productName}</td>
              <td>{$sendDate}</td>
              <td>{$productSize}</td>
              <td>{$order}</td>
              <input type="hidden" value='{$productId}'>
              <input type="hidden" value='{$orderNum}'>
            </tr>
  EOF;
    }
  }

}

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
  <link rel="stylesheet" href="../css/cartPage.css?p=<?php echo time(); ?>">
  <title>注文確認</title>
</head>
<body>
    <form method="post" action="cartConfirm.php">
    <table>
      <tr>
        <th>商品名</th>
        <th>配送日時</th>
        <th>商品サイズ</th>
        <th>注文数</th>
      </tr>
      <?php echo $tag; ?>
    </table>
    <input type="submit" value="注文を確定する">
  </form>
</body>
</html>