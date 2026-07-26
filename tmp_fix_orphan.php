<?php
$c = file_get_contents('database/seeders/DatabaseSeeder.php');

// Find all description values with orphaned text after them
// Pattern: description ends with '</p>', then has trailing junk before the closing quote
// Fix: remove everything between the newline after '</p>' and the next line that starts with a field name

$start = strpos($c, '$products = [');
$end = strrpos($c, '];');
$before = substr($c, 0, $start + 12);
$productsArea = substr($c, $start + 12, $end - $start - 12);
$after = substr($c, $end);

// Find description values that have orphaned text after </p>
$lines = explode("\n", $productsArea);
$fixed = false;
for ($i = 0; $i < count($lines); $i++) {
    $line = $lines[$i];
    // Check if this line has 'description' => '...</p>' followed by extra content before the closing quote
    if (preg_match("/'description'\s*=>\s*'/", $line)) {
        // Check if </p> appears and there's text after it before the line ends
        $p = strpos($line, '</p>');
        if ($p !== false) {
            // Find everything after </p> to end of line
            $afterContent = substr($line, $p + 4);
            // If there's non-whitespace content after </p> that doesn't look like a proper close
            if (trim($afterContent) !== "'" && trim($afterContent) !== "'," && trim($afterContent) !== "'") {
                // Truncate at </p> and add proper closing
                $lines[$i] = substr($line, 0, $p + 4) . "',";
                $fixed = true;
            }
        }
    }
}

if ($fixed) {
    $newProductsArea = implode("\n", $lines);
    file_put_contents('database/seeders/DatabaseSeeder.php', $before . $newProductsArea . $after);
    echo "Fixed orphaned text in descriptions.\n";
} else {
    echo "No orphaned text found.\n";
}

// Also check for another issue: description ending without closing quote
if (!$fixed) {
    echo "Checking for other issues...\n";
    // Check if description values contain 's or other orphaned text
    preg_match_all("/'description'\s*=>\s*'[^']*'/s", $c, $descs);
    echo "Descriptions with clean quotes: " . count($descs[0]) . "\n";
}

// Verify PHP
passthru("php -l database/seeders/DatabaseSeeder.php 2>&1");
