<?php
$c = file_get_contents('database/seeders/DatabaseSeeder.php');
$start = strpos($c, '$products = [');
$end = strrpos($c, '];');
echo 'Products start: ' . $start . ', end: ' . $end . ', len: ' . ($end - $start) . PHP_EOL;
echo 'Before (last 100 chars): ' . substr($c, $start - 100, 100) . PHP_EOL;
echo 'After (first 200 chars): ' . substr($c, $end + 2, 200) . PHP_EOL;
