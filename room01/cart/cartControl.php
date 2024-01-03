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

$result = $connect->select($recordSet);

foreach ($result as $key => $val) {

  $productId = $val["id"];
  $productName = $val["name"];
  $sendDate = $val["send"];
  $productSize = $val["size"];
  $productStock = $val["stock"];

  $trTag .= <<<EOF
            <tr>
                  <td class="edit string">{$productName}</td>
                  <td class="edit string">{$sendDate}</td>
                  <td class="edit string">{$productSize}</td>
                  <td class="edit int">{$productStock}</td>
                  <input type="hidden" name="{$productId}" value="">
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
  <form method="post" action="cartUpdate.php">
    <table>
      <tr>
        <th>商品名</th>
        <th>配送日時</th>
        <th>商品サイズ</th>
        <th>在庫</th>
      </tr>
      <?php echo $trTag; ?>
    </table>
    <input type="submit" value="注文を確認する">
  </form>
  <a href="../login/logout.php">ログアウト</a>
</body>
</html>