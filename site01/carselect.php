<?php

$erorr = "";

$person = $_POST['person'];
$model = $_POST['model'];
$year = $_POST['year'];

if(!isset($_POST)){
    
} else {
    if (!isset($person) || !isset($model) || !isset($year)) {
        $error = "すべての項目を選んでください";
    } else {
        try {
            $pdo = new PDO('mysql:dbname=sousaku;host=localhost;charset=utf8','root', 'root',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
        } catch (PDOException $e){

        }

        $sql = sprintf('SELECT * FROM selectCarStyle WHERE person = "%s" AND model = "%s" AND year = "%s"',$person,$model,$year);
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetch();
    }
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>自動車診断メーカー</title>
</head>
<body>
    <h1>自動車診断メーカー</h1>
    <div class="wrapper">
        <form method="POST" action="carselect.php">
        <div class="capacity">
            <div>定員</div>
                <input type="radio" name="person" value="4">４人<br>
                <input type="radio" name="person" value="6">5~8人<br>
                <input type="radio" name="person" value="8">8人
        </div>
        <div class="car_model">
            <div>車種</div>
                <input type="radio" name="model" value="sedan">セダン<br>
                <input type="radio" name="model" value="4WD">４WD<br>
                <input type="radio" name="model" value="minivan">ミニバン
        </div>
        <div class="model_year">
            <div>車種</div>
                <input type="radio" name="year" value="before">2000年以前<br>
                <input type="radio" name="year" value="between">2001年〜2020年<br>
                <input type="radio" name="year" value="after">2020年以降
        </div>
        <input type="submit" name="submit" value="送信">        
        </form>
    </div>
        <div><?php if($error !== "" ){echo $error;}; ?></div>
        <?php if(isset($_POST['submit']) && $error == "" ): ?>
        <div>あなたに合う車は<?php echo $results['car_name']; ?>です</div>
        <?php endif; ?>
</body>
</html>