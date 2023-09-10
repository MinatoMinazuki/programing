<?php

function esc($h){
    htmlspecialchars($h, ENT_QUOTES, "UTF-8");
}

session_start();

try {
        $pdo = new PDO(
            "mysql:dbname=user_master;host=localhost","root","root",array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            )
        );
} catch (PDOException $e) {
    exit ('データベースエラー1');
}

//POSTされてこなかった場合
if(empty($_POST)) {
    $message = "";
} else {
    //ユーザー名またはパスワードが送信されてこなかった場合
    if(empty($_POST['name']) || empty($_POST['pass'])){
        $message = "ユーザー名とパスワードを入力してください";
    } else {

        $newUser = $_POST['name'];
        $newPass = $_POST['pass'];

        try {
            $stmt = $pdo -> prepare('INSERT INTO users(name, pass) VALUES (?, ?)');
            $stmt -> bindParam(1, $newUser, PDO::PARAM_STR);
            $stmt -> bindParam(2, $newPass, PDO::PARAM_STR);
            $stmt -> execute();
            $result = $stmt -> fetch(PDO::FETCH_ASSOC);

            $message = "登録に成功しました。";

        } catch (PDOException $e){
            exit('データベースエラー2');
        }
    }
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
</head>
<body>
    <h1>新規登録</h1>
        <div class="message"><?php echo $message; ?></div>
        <div class="loginform">
            <form method="post" action="signUp.php">
                <div class="login_display">
                <div class="login_name">ログイン名:<input type="text" name="name" value="<?php echo esc($login_name); ?>"></div>
                <div class="login_pass">パスワード:<input type="password" name="pass" value="<?php echo esc($login_pass); ?>"></div>
                <div class="login_btn"><input type="submit" name="signUp" value="新規登録"></div>
                </div>
        </form>
        </div>
</body>
</html>