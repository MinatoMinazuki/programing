<?php

session_start();

//ログインされていない場合は強制的にログインページにリダイレクト
if(!isset($_SESSION['login'])){
  header("Location: /room01/login/index.php");
  exit();
}

require_once 'dbConnect.php';

$connect = new connect();

$recordSet = sprintf("SELECT * FROM goods ORDER BY id ASC");

$resultSelect = $connect->select($recordSet);

foreach ($resultSelect as $key => $val) {

  $productId = $val["id"];
  $productName = $val["name"];
  $sendDate = $val["send"];
  $productSize = $val["size"];
  $productStock = $val["stock"];
  $productPrice = $val["price"];

  $trTag .= <<<EOF
            <tr>
                  <td class="edit"><span data-show="1">{$productName}</span><input type="text" name="productName[]" value="{$productName}" data-show="0"></td>
                  <td class="edit"><span data-show="1">{$sendDate}</span><input type="text" name="sendDate[]" value="{$sendDate}" data-show="0"></td>
                  <td class="edit"><span data-show="1">{$productSize}</span><input type="text" name="productSize[]" value="{$productSize}" data-show="0"></td>
                  <td class="edit"><span data-show="1">{$productStock}</span><input type="number" name="productStock[]" value="{$productStock}" data-show="0"></td>
                  <input type="hidden" name="productId[]" value="{$productId}">
                  <td class="edit"><span data-show="1">{$productPrice}</span><input type="number" name="productPrice[]" value="{$productPrice}" data-show="0">円</td>
                  <input type="hidden" name="productId[]" value="{$productId}">
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
  <link rel="stylesheet" href="../css/reset.css?p=<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/cartPage.css?p=<?php echo time(); ?>">
  <title>商品一覧ページ</title>
</head>
<body>
  <div class="wrapper">
  <form class="form" method="post" action="cartUpdate.php">
    <div class="wrapperTable">
    <table>
      <tr>
        <th>商品名</th>
        <th>配送日時</th>
        <th>商品サイズ</th>
        <th>在庫</th>
      </tr>
      <?php echo $trTag; ?>
    </table>
    </div>
    <input type="submit" value="内容を更新する">
  </form>
</div>
</body>
</html>