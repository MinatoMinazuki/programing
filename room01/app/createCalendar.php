<?php

$weekJp = ["日" ,"月", "火", "水", "木", "金", "土"];

$ym = !empty($_GET['ym']) ? $_GET['ym'] : date("Y-m");

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

$youbi = date("w", $timestamp);



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
                    <th>日</th>
                    <th>月</th>
                    <th>火</th>
                    <th>水</th>
                    <th>木</th>
                    <th>金</th>
                    <th>土</th>
                </tr>
            </thead>
            <tbody class="table_calendar-body">
                <tr>
                    <?php
                    for($i=0; $i < $youbi; $i++) {
                        echo "<td></td>";
                    }

                    for($day=1; $day <= $dayCount; $day++){
                        echo "<td>{$day}</td>";

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
</body>
</html>