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

//ログイン状態の場合ログイン後のページにリダイレクト
if(isset($_SESSION['login'])){
    session_regenerate_id(true);
    header("Location: /room01/top_page/index.php");
    exit();
}

//POSTされてこなかった場合
if(count($_POST) === 0) {
    $message = "";
} else {
    //ユーザー名またはパスワードが送信されてこなかった場合
    if(empty($_POST['name']) || empty($_POST['pass'])){
        $message = "ユーザー名とパスワードを入力してください";
    } else {
        try {
            $stmt = $pdo -> prepare('SELECT * FROM users WHERE name=?');
            $stmt -> bindParam(1, $_POST['name'], PDO::PARAM_STR);
            $stmt -> execute();
            $result = $stmt -> fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            exit('データベースエラー2');
        }

        //検索したユーザー名に対してパスワードが正しいかを検証
        //正しくない時
        if ($_POST['pass'] !== $result['pass']){
            $message = "ユーザー名かパスワードが違います";
        } else {
            session_regenerate_id(true); //セッションidを再発行
            $_SESSION['login'] = $_POST['name']; //セッションにログイン情報を登録
            header("Location: /room01/top_page/index.php");
            exit();
        }
    }
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
</head>
<body>
        <h1>ログイン画面</h1>
        <div class="message"><?php echo $message; ?></div>
        <div class="loginform">
            <form method="post" action="index.php">
                <div class="login_display">
                <div class="login_name">ログイン名:<input type="text" name="name" value="<?php echo esc($login_name); ?>"></div>
                <div class="login_pass">パスワード:<input type="password" name="pass" value="<?php echo esc($login_pass); ?>"></div>
                <div class="login_btn"><input type="submit" name="login" value="ログイン"></div>
                </div>
        </form>
        </div>
</body>
</html>