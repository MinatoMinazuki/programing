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
    $week = 1; // 週数を初期化
    for ($d = '1'; $d <= $days_per_month[$m]; $d++) {
        if (isset($public_holiday['2023/'. $m. '/'. $d])) {
            $holiday = true;
        } else {
            $holiday = false;
        }
        $day[] = array(
            'year' => '2023',
            'month' => $m,
            'week' => $week,
            'day' => $d,
            'week_day' => $day_of_week[$w],
            'holiday' => $holiday
        );
        $w = $d % 7;
        if ($w === 0) {
            $week++;
        }
    }
}

print_r($day);

// 各週に含まれる日付の数
$days_per_week = array();

// 週ごとに日付を分割
$weeks = array_chunk($day, 7);
$i = 1;
foreach ($weeks as $week) {
    $days_per_week[$i] = count($week); 
    $i++;
}

//前週・次週をGETパラメータから取得
if (isset($_GET['ymww'])) {
    $ymww = $_GET['ymww'];
} else {
    //それ以外は1月1週目を表示
        foreach ($weeks as $week) {
            foreach ($week as $d) {
            $ymw = $d['year'] . '-' . $d['month'] . '-' . $d['week'];
        }
        $ymww = $ymw . '-1';
       break;
    }
}

//前週を取得
$prev_w = explode('-', $ymww)[2] - 1;
$prev_ww = explode('-', $ymww)[3] - 1;
$prev_m = explode('-', $ymww)[1];
if ($ymww == '2023-1-1-1') {
    $prev_m = explode('-', $ymww)[1] + 13;
    $prev_w = explode('-', $ymww)[2] + 7;
    $prev_ww = explode('-', $ymww)[3] + 107;
} else if ($ymww == '2023-4-1-24') {
    $prev_m = explode('-', $ymww)[1] - 1;
    $prev_w = explode('-', $ymww)[2] + 6;
} else if ($ymww == '2023-7-1-47') {
    $prev_m = explode('-', $ymww)[1] - 1;
    $prev_w = explode('-', $ymww)[2] + 6;
} else if ($ymww == '2023-10-1-70') {
    $prev_m = explode('-', $ymww)[1] - 1;
    $prev_w = explode('-', $ymww)[2] + 6;
} else if ($ymww == '2023-13-1-93') {
    $prev_m = explode('-', $ymww)[1] - 1;
    $prev_w = explode('-', $ymww)[2] + 6;
} else if ($prev_w < 1) {
    $prev_m = explode('-', $ymww)[1] - '1';
    $prev_w = explode('-', $ymww)[2] + 7;
}

//次週を取得
$next_w = explode('-', $ymww)[2] + 1;
$next_ww = explode('-', $ymww)[3] + 1;
$next_m = explode('-', $ymww)[1];
if ($ymww == '2023-14-8-108') {
    $next_m = explode('-', $ymww)[1] - 13;
    $next_w = explode('-', $ymww)[2] - 7;
    $next_ww = explode('-', $ymww)[3] - 107;
} else if ($ymww == '2023-3-7-23') {
    $next_m = explode('-', $ymww)[1] + 1;
    $next_w = explode('-', $ymww)[2] - 6;
} else if ($ymww == '2023-6-7-46') {
    $next_m = explode('-', $ymww)[1] + 1;
    $next_w = explode('-', $ymww)[2] - 6;
} else if ($ymww == '2023-9-7-69') {
    $next_m = explode('-', $ymww)[1] + 1;
    $next_w = explode('-', $ymww)[2] - 6;
} else if ($ymww == '2023-12-7-92') {
    $next_m = explode('-', $ymww)[1] + 1;
    $next_w = explode('-', $ymww)[2] - 6;
} else if ($next_w > 8) {
    $next_m = explode('-', $ymww)[1] + '1';
    $next_w = explode('-', $ymww)[2] - 7;
}

//当該週
$current_week = explode('-' , $ymww)[2];
$week_all = explode('-', $ymww)[3];

//当該月
$month = explode('-' , $ymww)[1];
$ym = explode('-', $ymww)[0] .'/'. explode('-', $ymww)[1];

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

//当該月の日数を取得
$day_count = $days_per_month[$month];

//カレンダータイトル
$html_title = $ym;

//
$weekly_calendar = [];
$weekly = '';

// 1ヶ月分の日付を表示する
for ($i = $week_all - 1; $i < count($weeks) && $weeks[$i][0]['month'] == $month && $weeks[$i][0]['week'] == $current_week; $i++) {
     foreach ($weeks[$i] as $d) {
        $date = $d['year'] .'/' . $d['month'] . '/' . $d['day'];
        if ($d['week_day'] == 'Sunday') {
            $weekly .= '<td class="holiday">' . $d['day'];
        } else if ($d['week_day'] == 'Saturday') {
            $weekly .= '<td class="Saturday">' . $d['day'];
        } else {
            $weekly .= '<td>' . $d['day'];
        }

        $weekly .= '</td>';
    }
    $weekly_calendar[] = '<tr>' . $weekly . '</tr>';
    $weekly = '';
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <style>
        .Saturday {
            color: blue;
        }
        .holiday {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 class="mb-5"><a href="?ymww=<?php echo '2023-'.$prev_m.'-'.$prev_w.'-'.$prev_ww; ?>">&lt;</a> <?php echo $html_title; ?> <a href="?ymww=<?php echo '2023-'.$next_m.'-'.$next_w.'-'.$next_ww; ?>">&gt;</a><button onclick="showCalendar('month')">月間表示</button></h3>
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
                foreach ($weekly_calendar as $week) {
                    echo $week;
                }
            ?>
        </table>
    </div>
</body>
</html>

<?php

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

//前月・次月をGETパラメータから取得
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    //それ以外は1月1週目を表示
        foreach ($weeks as $week) {
            foreach ($week as $d) {
            $ym = $d['year'] . '-' . $d['month'];
        }
       break;
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
    if ($holidays[$d] == 1) {
        $week .= '<td class="holiday">'. $d;
        } else if ($day['week_day'] == 'Sunday') {
            $week .= '<td class="holiday">'. $d;
        } else if ($day['week_day'] == 'Saturday') {
            $week .= '<td class="Saturday">'. $d;
        } else {
            $week .= '<td>' . $d;
        }

    $week .= '</td>';
    
    //週終わり、または月終わりの場合
    for ($i = 0; $i <= count($saturday_dates); $i++) {

    if ($date == $saturday_dates[$i] || $d == $days_per_month[$month]) {

        if ($d == $days_per_month[$month]) {
        $week .= str_repeat('<td></td>', $last_youbi[$month]);
    }

    //weeks配列にtrと$weekを追加
    $weeks[] = '<tr>' . $week . '</tr>';

    if ($i % 7 == 0) {
        $i++;
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
    <style>
        .Saturday {
            color: blue;
        }
        .holiday {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 class="mb-5"><a href="?ym=<?php echo '2023-'.$prev; ?>">&lt;</a> <?php echo $html_title; ?> <a href="?ym=<?php echo '2023-'.$next; ?>">&gt;</a><button onclick="showCalendar('week')">週間表示</button></h3>
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