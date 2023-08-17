<?php
//祝日配列
function get_public_holidays(){
    $path = "./syukujitsu.csv";
    $csv = new SplFileObject($path);
    $csv -> setFlags(SplFileObject::READ_CSV);
    $holidays = [];
    foreach ($csv as $key => $line){
        $holidays[$line[0]] = $line[1];
    }
    return $holidays;
}

$public_holiday = get_public_holidays();

//前月・次月をGETパラメータから取得
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    //それ以外は1月を表示
    $ym = '2023-1';
}

//各月の日数
    $days_per_month = array(
    '1' => 54,
    '2' => 54,
    '3' => 53,
    '4' => 53,
    '5' => 54,
    '6' => 54,
    '7' => 53,
    '8' => 53,
    '9' => 54,
    '10' => 54,
    '11' => 53,
    '12' => 53,
    '13' => 54,
    '14' => 54,
);

//曜日の配列
$day_of_week = array(
    0 => 'Sunday',
    1 => 'Monday',
    2 => 'Tuesday',
    3 => 'Wednesday',
    4 => 'Thursday',
    5 => 'Friday',
    6 => 'Saturday',
);

$day = array();
$w = 0;
for ($m = '1'; $m <= '14'; $m++) {
    for ($d = '1'; $d <= $days_per_month[$m]; $d++) {
        $day[] = array(
            'year' => '2023',
            'month' => $m,
            'week_day' => $day_of_week[$w],
            'day' => $d,
        );
        $w = ($w + 1) % 7;
    }
}

//カレンダータイトル
$html_title = explode('-', $ym)[0] . '/' . explode('-', $ym)[1];

//前月・次月を取得
$prev = explode('-' , $ym)[1] - '1';
$next = explode('-' , $ym)[1] + '1';
if ($ym == '2023-1') {
    $prev = explode('-' , $prev)[1] + '14';
} else if ($ym == '2023-14') {
    $next = explode('-' , $next)[1] + '1';
}

//当該月
$month = explode('-' , $ym)[1];

//当該月の日数を取得
$day_count = $days_per_month[$month];

//各月1日が何曜日か
$first_youbi = array();
foreach ($day as $d) {
    $m = $d['month'];
    if ($d['day'] === '1') {
        $first_youbi[$m] = array_search($d['week_day'], $day_of_week);
    }
}

//各月最終日が何曜日か
$last_youbi = array();
foreach ($day as $d) {
    $m = $d['month'];
    $days_in_month = $days_per_month[$m];
    $last_day_of_month = ($d['day'] == $days_in_month);

    if ($last_day_of_month) {
        $last_youbi[$m] = array_search($d['week_day'], $day_of_week);
    }
}

// 毎月土曜日の日付を取得
$saturday_dates = array();
foreach ($day as $d) {
    if ($d['month'] == $month && $d['week_day'] == 'Saturday') {
        $saturday_dates[] = $d['year'] .'/'. $d['month'] .'/'. $d['day'];
    }
}

//祝日を取得
$holidays = array();
for ($d = '1'; $d <= $day_count; $d++) {
    if (isset($public_holiday['2023/'. $month. '/'. $d])) {
        $holiday = true;
    } else {
        $holiday = false;
    }
    $holidays[$d] = $holiday;
}

//カレンダー作成の準備
$weeks = array();
$week = '';

//第1週目の空のセルを追加
$week .= str_repeat('<td></td>', $first_youbi[$month]);

for ($d = '1'; $d <= $day_count; $d++) {
    $date = $html_title . '/' . $d;
    if ($holidays[$d] == $date) {
        $week .= '<td class="holiday">'. $d;
        } else if ($day['week_day'] == 'Sunday') {
            $week .= '<td class="holiday">'. $d;
        } else if ($saturday_dates[$d-1] == $date) {
            $week .= '<td class="Saturday">'. $d;
        } else {
            $week .= '<td>' . $d;
        }

    $week .= '</td>';
    
    //週終わり、または月終わりの場合
    for ($i = 0; $i <= count($saturday_dates); $i++) {

    if ($date == $saturday_dates[$i] || $d == $days_per_month[$month]) {

        if ($d == $days_per_month[$month]) {
        $week .= str_repeat('<td></td>', 6 - $last_youbi[$month]);
    }


    //weeks配列にtrと$weekを追加
    $weeks[] = '<tr>' . $week . '</tr>';

    if ($i % 7 == 0) {
        $i++;
    }

    if ($d == $days_per_month[$month]){
        break;
    }

    //weekをリセット
    $week = '';
    }
}
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>月間カレンダー</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <style>
        .container {
            font-family: 'Noto Sans JP', sans-serif;
            margin-top: 80px;
        }
        a {
            text-decoration: none;
        }
        th {
            height: 30px;
            text-align: center;
        }
        td {
            height: 100px;
        }
        .holiday {
            color: red;
        }
        th:nth-of-type(1), td:nth-of-type(1) {
            color: red;
        }
        th:nth-of-type(7), td:nth-of-type(7) {
            color: blue;
        }
</style>
</head>
<body>
    <div class="container">
        <h3 class="mb-5"><a href="?ym=<?php echo '2023-'.$prev; ?>">前の月へ</a> <?php echo $html_title; ?> <a href="?ym=<?php echo '2023-'.$next; ?>">次の月へ</a></h3>
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