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

foreach ($result as $key => $val) {

  $productId = $val["id"];
  $productName = $val["name"];
  $sendDate = $val["send"];
  $productSize = $val["size"];
  $productStock = $val["stock"];

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
    $updateRecord = sprintf("UPDATE goods SET name='%s', send='%s', size='%s', stock='%d', price='%s', update_date='%s' WHERE id = '%s'", $productName, $sendDate, $productSize, $productStock, $productPrice, $updateTime, $productId);

    $result = $connect->plural($updateRecord);
    $result->fetchAll(PDO::FETCH_ASSOC);
  }

}

?>
