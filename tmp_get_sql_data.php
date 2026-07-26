<?php
$sql = file_get_contents('kitsuneoni_dump.sql');

// Extract FAQ insert
$fs = strpos($sql, "INSERT INTO `faqs`");
$fe = strpos($sql, ";", $fs);
$faqInsert = substr($sql, $fs, $fe - $fs + 1);
echo "FAQs:\n$faqInsert\n\n";

// Extract settings insert  
$ss = strpos($sql, "INSERT INTO `settings`");
$se = strpos($sql, ";", $ss);
$setInsert = substr($sql, $ss, $se - $ss + 1);
echo "Settings:\n$setInsert\n\n";

// Extract product_images
$pis = strpos($sql, "INSERT INTO `product_images`");
$pie = strpos($sql, ";", $pis);
$piInsert = substr($sql, $pis, $pie - $pis + 1);
echo "Product images (first 500 chars):\n" . substr($piInsert, 0, 500) . "\n";
