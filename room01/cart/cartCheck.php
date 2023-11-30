<?php

require_once 'dbConnect.php';

$connect = new connect();

$recordSet = sprintf("SELECT * FROM goods ORDER BY id ASC");
$result = $connect->select($recordSet);

$error = [];

$cartContents = [];
$orders = [];

if(isset($_POST)){

  foreach ($result as $key => $val) {

    $productId = $val["id"];
    $productName = $val["name"];
    $sendDate = $val["send"];
    $productSize = $val["size"];
    $productStock = $val["stock"];

    if($_POST[$productName] !== "0"){
      array_push($cartContents, $productName);
      array_push($orders, $_POST[$productName]);
    }

  }

} else {

  array_push($error, "商品が選ばれていません。やり直してください。");

}

var_dump($orders);
var_dump($cartContents);

?>

<!-- <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script type="text/javascript" src="../js/cartPage.js?p=<?php //echo time(); ?>"></script>
  <link rel="stylesheet" href="../css/cartPage.css?p=<?php //echo time(); ?>">
  <title>一覧ページ</title>
</head>
<body>
  <form method="post" action=>
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
   <div class="cartIconOuter" data-show="0">
    <a href="#" class="cartIcon">
      <span class="intoCartNumber">1</span>
      <img src="../img/shopping-cart-empty-1.png">
    </a>
  </div>
</body>
</html> -->