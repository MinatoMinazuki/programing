<?php

$erorr = "";

$person = $_POST['person'];
$model = $_POST['model'];
$year = $_POST['year'];

var_dump($person);

if (!isset($person) || !isset($model) || !isset($year)) {
    $error = "すべての項目を選んでください";
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
        <div><?php echo $error; ?></div>
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
</body>
</html>