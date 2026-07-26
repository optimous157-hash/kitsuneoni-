<?php
$c = file_get_contents('database/seeders/DatabaseSeeder.php');
// Find which products still have AI phrases
$checks = ['differential clay tempering', 'multi-layered pattern'];
foreach ($checks as $chk) {
    $pos = strpos($c, $chk);
    if ($pos !== false) {
        $context = substr($c, max(0, $pos - 100), 200);
        echo "Found '$chk' at $pos:\n...$context...\n\n";
    }
}
