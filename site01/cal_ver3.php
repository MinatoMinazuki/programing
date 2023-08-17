<?php
$id = null;
$tweets = $_POST['tweets'];

$db_host = 'localhost';
$db_user = 'root';
$db_password = 'root';
$db_db = 'calendar';

//タイムゾーンの設定
date_default_timezone_set('Asia/Tokyo');
$created_at = date('Y-m-d H:i:s');

$pdo = new PDO(
    "mysql:dbname=$db_db;host=$db_host","$db_user","$db_password",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'")
);

$register = $pdo -> prepare("INSERT INTO post(id, tweets, created_at) VALUES (:id, :tweets, :created_at)");
$register -> bindParam(":id", $id);
$register -> bindParam(":tweets", $tweets);
$register -> bindParam(":created_at", $created_at);
$register -> execute();


//前月・次月リンクが押された場合は、GETパラメータから年月を取得
if(isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    //今月の年月を表示
    $ym = date('Y-m');
}

//タイムスタンプを作成し、フォーマットをチェックする
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {

    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');

}

//今日の日付　フォーマット
$today = date('Y-m-j');

$html_title = date('Y年m月', $timestamp);

//前月・次月の取得
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

//該当月の日数を取得
$day_count = date('t', $timestamp);

//1日が何曜日か
$youbi = date('w', mktime(0,0,0, date('m', $timestamp), 1, date('Y', $timestamp)));

//カレンダー作成の準備
$weeks = [];
$week = '';

//第1週目：空のセルを追加
$week .= str_repeat('<td></td>', $youbi);

for ( $day = 1; $day <= $day_count; $day++, $youbi++) {

    $date = $ym . '-' . $day;

    if ($today == $date) {
        $week .= '<td class="today">' . $day;
    } else {
        $week .= '<td>' . $day;
    }
    $week .= '</td>';

    //週終わり、または月終わりの場合
    if ($youbi % 7 == 6 || $day == $day_count ) {

        if ($day == $day_count) {
            //付きのシア秀美の場合、空セルを追加
            $week .= str_repeat('<td></td>', 6 - $youbi % 7);
        }

        //weeks配列にtrと$weekを追加
        $weeks[] = '<tr>' . $week . '</tr>';

        //weekをリセット
        $week = '';
    }
}

?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>カレンダー</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sawarabi+Gothic&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style_cal.css">
</head>
<body>
    <div class="diary">
    <section class="new">
        <h2>今日の一言</h2>
        <form action="cal_ver3.php" method="post">
            <p><div class="p-new p-content">投稿内容: <textarea name="tweets" id="" cols="" rows=""></textarea></div></p>
            <div><button type="submit">投稿</button></div>
        </form>
    </section>
    </div>

    <div class="container">
        <h3 class="mb-5"><a href="?ym=<?php echo $prev; ?>">&lt;</a> <?php echo $html_title; ?><a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
        <table class="table table-bordered">
            <tr>
                <th>日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th>土</th>
            </tr>
            <?php
                foreach ($weeks as $week) {
                    echo $week;
                }
            ?>
        </table>
    </div>
</body>
</html>