<?php

$recColors = $_POST['recommendColor'];
$depColors = $_POST['deprecatedColor'];

echo $recColors;
echo $depColors;

try {
    $pdo = new PDO('mysql:host=localhost;dbname=sousaku','root','root',[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
    $sql = "INSERT INTO colors (recommend, deprecated) VALUES ('222,333', '444')";
    $stmt = $pdo->prepare($sql);
    // $params = array(':recommend'=>$recColors, ':deprecated'=>$depColors);
    // $stmt->execute($params);
} catch (PDOException $e) {
    exit('データベースエラー: ' . $e->getMessage());
}


?>