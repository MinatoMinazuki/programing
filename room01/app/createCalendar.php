<?php
ini_set('display_errors', "On");
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);
date_default_timezone_set('Asia/Tokyo');

require_once __DIR__."/class/DBC.php";

$dbc = new DBC;

$userId = "1";

$weekJp = ["日" ,"月", "火", "水", "木", "金", "土"];

$ym = !empty($_GET['ym']) ? $_GET['ym'] : date("Y-m");
$d = !empty($_GET['d']) ? $_GET['d'] : "";

$timestamp = strtotime( $ym."-01" );
if( $timestamp === false ){
    $ym = date("Y-m");
    $timestamp = strtotime($ym."-01");
}

$today = date("Y-m-d");
$calDate = date("Y年m月", $timestamp);

$prevMon = date("Y-m", strtotime("-1 month", $timestamp));
$nextMon = date("Y-m", strtotime("+1 month", $timestamp));

$dayCount = date("t", $timestamp);
$firstDay = $ym."-01";
$lastDay = $ym."-".$dayCount;

$youbi = date("w", $timestamp);

$currentTime = date("H:00");
$initialEndTime = date("H:00", strtotime("+1 hour"));

$eventList = [];


$sql = sprintf("
        SELECT *
        FROM `schedule_master`
        WHERE `del_flag` = '0'
        AND   `event_date` >= '%s'
        AND   `event_date` <= '%s'
        ORDER BY
        `event_date`,
        `event_start_time`
        ",
        $firstDay,
        $lastDay
    );

$res = $dbc->Dsql($sql);

if( !empty($res) ){
    foreach ($res as $event) {
        $eventList[$event["event_date"]][] = $event;
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>カレンダー</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
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
        .today {
            background: orange !important;
        }
        th:nth-of-type(1), td:nth-of-type(1) {
            color: red;
        }
        th:nth-of-type(7), td:nth-of-type(7) {
            color: blue;
        }
        .hasEvent {
            background: lightblue;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <table class="table table-bordered">
            <thead class="table_calendar-head">
                <tr>
                    <th><a href="?ym=<?= $prevMon ?>">&lt;</a></th>
                    <th colspan="5"><?= $calDate; ?></th>
                    <th><a href="?ym=<?= $nextMon ?>">&gt;</a></th>
                </tr>
                <tr>
                    <?php foreach ($weekJp as $day) echo "<th>{$day}</th>"; ?>
                </tr>
            </thead>
            <tbody class="table_calendar-body">
                <tr>
                    <?php
                        for($i=0; $i < $youbi; $i++) {
                            echo "<td></td>";
                        }

                        for($day=1; $day <= $dayCount; $day++){
                            $date = $ym."-".sprintf("%02d", $day);
                            $todayClass = $date === $today ? "today" : "";

                            echo "<td class ='{$todayClass}'>
                                  <a href='?ym={$ym}&d={$day}'>{$day}</a><br>";

                            if(!empty($eventList[$date])){
                                foreach($eventList[$date] as $event){
                                    $startTime = date("H:i", strtotime($event["event_start_time"]));
                                    echo "<p><a href='bord.php?eventId={$event["id"]}'>
                                          <span class='hasEvent' data-event-id='{$event["id"]}'>{$event["event_name"]} {$startTime}</span>";

                                    if( $event["event_end_time"] !== "00:00:00" ){
                                        $endTime = date("H:i", strtotime($event["event_end_time"]));
                                        echo "<span class='hasEvent'> ~ {$endTime}</span>";
                                    }

                                    echo "</a></p>";
                                }

                            }

                            echo "</td>";

                            if( ($day + $youbi) % 7 === 0 ){
                                echo "</tr><tr>";
                            }
                        }

                        while ( ($day + $youbi) % 7 !== 1 ) {
                            echo "<td></td>";
                            $day++;
                        }
                    ?>
                </tr>
            </tbody>
        </table>
    </div>
    <?php if( !empty($d) ): ?>
    <div>
        <h3>予定を追加 : <?= $calDate.$d; ?>日</h3>
        <form action="addEvent.php" method="post">
            <span><input type="hidden" name="date" value="<?= $ym."-".$d; ?>"></span><br>
            <span>イベント名
                <input type="text" name="event" required>
            </span><br>
            <span>開始時間
                <input type="time" name="startTime" value="<?= $currentTime ?>" required>
            </span><br>
            <span>終了時間
                <input type="time" name="endTime"  value="<?= $initialEndTime ?>" >
            </span><br>
            <span>タグ
                <input type="text" name="tags">
            </span><br>
            <span>
                <input type="hidden" name="userId" value="<?= $userId ?>">
            </span>
            <button type="submit">追加</button>
        </form>
    </div>
    <?php endif; ?>
</body>
</html>