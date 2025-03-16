<?php

$date = !empty($_POST['date']) ? $_POST['date'] : null;
$event = !empty($_POST['event']) ? $_POST['event'] : null;

if( isset($date) && isset($event) ){
    $file = __DIR__."/data/events.json";

    $jsonContent = file_exists($file) ? file_get_contents($file) : '{}';
    $events = json_decode($jsonContent, true);

    $events[$date][] = $event;
    $result = file_put_contents($file, json_encode($events, JSON_PRETTY_PRINT));
}

header( "Location: createCalendar.php?ym=".date("Y-m", strtotime($date)) );
exit();

?>