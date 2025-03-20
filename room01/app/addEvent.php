<?php
require_once __DIR__."/class/DBC.php";

$dbc = new DBC;

$date = !empty($_POST['date']) ? $_POST['date'] : null;
$event = !empty($_POST['event']) ? $_POST['event'] : null;
$startTime = !empty($_POST['startTime']) ? $_POST['startTime'] : null;
$endTime = !empty($_POST['endTime']) ? $_POST['endTime'] : null;
$tags = !empty($_POST['tags']) ? $_POST['tags'] : null;
$userId = !empty($_POST['userId']) ? $_POST['userId'] : null;

// if( isset($date) && isset($event) ){
//     $file = __DIR__."/data/events.json";

//     $jsonContent = file_exists($file) ? file_get_contents($file) : '{}';
//     $events = json_decode($jsonContent, true);

//     $events[$date][] = $event;
//     $result = file_put_contents($file, json_encode($events, JSON_PRETTY_PRINT));
// }

$sql = sprintf("
        INSERT INTO `schedule_master`
        (
            `event_name`,
            `event_date`,
            `event_start_time`,
            `event_end_time`,
            `tags`,
            `user_id`
        )
        VALUES
        (
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s'
        )",
        $event,
        $date,
        $startTime,
        $endTime,
        $tags,
        $userId
    );

$res = $dbc->Dsql($sql);

header( "Location: createCalendar.php?ym=".date("Y-m", strtotime($date)) );
exit();

?>