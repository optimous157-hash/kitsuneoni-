<?php
$c = file_get_contents('database/seeders/DatabaseSeeder.php');
$pos = 3107;
echo "Context at 3107:\n";
echo substr($c, max(0,$pos-20), 100) . "\n";

// Check what's AFTER the before
$start = strpos($c, '$products = [');
$before = substr($c, 0, $start);
$beforeLines = substr_count($before, "\n") + 1;
echo "Before ends at line: $beforeLines\n";

// Show last 5 lines of before
echo "Last 200 chars of before:\n" . substr($before, -200) . "\n";

// Find the end of block 1 
$block1End = strpos($c, '];', $start + 10);
// But this finds the first ];, not the end. Need to find the matching ]; for the products array
// Let me find it by looking at context 200 chars after start
$context1 = substr($c, $start, 1000);
echo "First 300 chars of block 1:\n" . substr($context1, 0, 300) . "\n";
echo "...\nLast 200 chars:\n" . substr($context1, -200) . "\n";
