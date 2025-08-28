<?php
$host = $_SERVER['HTTP_HOST'];

if (strpos($host, 'localhost') !== false) {
    $baseURL = '/fanciwheel';
} else {
    $baseURL = 'https://fanciwheel.com';
}
?>



