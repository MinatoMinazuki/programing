<?php

if( $_SERVER['HTTP_HOST'] === "redcastle.jp" ){
    define('DB_NAME', 'calendar-sns');
    define('HOST', 'localhost');
    define('UTF', 'utf8');
    define('USER', 'root');
    define('PASS', 'BuNRIMa4');
} else {
    define('DB_NAME', 'calendar-sns');
    define('HOST', 'localhost');
    define('UTF', 'utf8');
    define('USER', 'root');
    define('PASS', '');
}

?>