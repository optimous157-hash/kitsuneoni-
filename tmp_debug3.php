<?php
$c = file_get_contents('database/seeders/DatabaseSeeder.php');
$pos = strpos($c, '$products = [');
echo 'First at: ' . $pos . PHP_EOL;
echo 'Context: ' . substr($c, max(0, $pos-80), 200) . PHP_EOL;
echo '---' . PHP_EOL;
$pos2 = strrpos($c, '];');
echo 'Last ]; at: ' . $pos2 . PHP_EOL;
echo 'Context: ' . substr($c, max(0, $pos2-80), 160) . PHP_EOL;
echo '---' . PHP_EOL;
// Also check what's at the second $products = [
$pos3 = strpos($c, '$products = [', $pos + 1);
if ($pos3 !== false) {
    echo 'Second $products at: ' . $pos3 . PHP_EOL;
    echo 'Context: ' . substr($c, max(0, $pos3-80), 200) . PHP_EOL;
}
