<?php
// Parse SQL dump to extract ALL product data
$dump = file_get_contents('kitsuneoni_dump.sql');
$start = strpos($dump, "INSERT INTO `products`");
$end = strpos($dump, ";", $start);
$insert = substr($dump, $start, $end - $start + 1);

// Extract VALUES part - the part after VALUES
$valuesStart = strpos($insert, "VALUES") + 6;
$valuesStr = trim(substr($insert, $valuesStart));

// Parse individual value tuples - handle nested parentheses
$tuples = [];
$depth = 0;
$current = '';
$inString = false;
$escape = false;

for ($i = 0; $i < strlen($valuesStr); $i++) {
    $ch = $valuesStr[$i];
    
    if ($escape) { $current .= $ch; $escape = false; continue; }
    if ($ch === '\\') { $current .= $ch; $escape = true; continue; }
    
    if ($ch === "'" && !$inString) { $inString = true; $current .= $ch; continue; }
    if ($ch === "'" && $inString) { $inString = false; $current .= $ch; continue; }
    
    if (!$inString) {
        if ($ch === '(') {
            if ($depth > 0) $current .= $ch;
            $depth++;
            continue;
        }
        if ($ch === ')') {
            $depth--;
            if ($depth === 0) {
                $tuples[] = $current;
                $current = '';
                continue;
            }
            $current .= $ch;
            continue;
        }
        if ($ch === ',' && $depth === 1) {
            // Comma at depth 1 separates tuples - but we add a delimiter
            $current .= '|||';
            continue;
        }
        if ($depth >= 1) {
            $current .= $ch;
        }
    } else {
        $current .= $ch;
    }
}

echo "Found " . count($tuples) . " product tuples\n";

// Parse column names from INSERT
preg_match("/`products`\s*\(([^)]+)\)/", $insert, $colMatch);
$cols = explode(',', $colMatch[1]);
$cols = array_map(function($c) { return trim($c, "` \t\n\r\0\x0B"); }, $cols);

echo "Columns: " . implode(', ', array_slice($cols, 0, 5)) . "...\n";

// Build products array data
$allProducts = [];
foreach ($tuples as $tupleStr) {
    // Split by ||| separator
    $rawValues = explode('|||', $tupleStr);
    
    // Trim whitespace and strip surrounding quotes
    $values = [];
    foreach ($rawValues as $rv) {
        $rv = trim($rv);
        // Handle NULL
        if (strtoupper($rv) === 'NULL') {
            $values[] = null;
            continue;
        }
        // Strip surrounding quotes
        if (strlen($rv) >= 2 && $rv[0] === "'" && $rv[strlen($rv)-1] === "'") {
            $rv = substr($rv, 1, -1);
        }
        // Unescape SQL single quotes
        $rv = str_replace("''", "'", $rv);
        $rv = stripslashes($rv);
        $values[] = $rv;
    }
    
    if (count($values) !== count($cols)) {
        echo "Mismatch: " . count($values) . " values vs " . count($cols) . " columns\n";
        echo "Tuple: " . substr($tupleStr, 0, 100) . "\n";
        continue;
    }
    
    // Build associative array
    $product = array_combine($cols, $values);
    $allProducts[] = $product;
}

echo "Total products parsed: " . count($allProducts) . "\n";
echo "First: {$allProducts[0]['name']} (steel: {$allProducts[0]['steel_type']}, length: {$allProducts[0]['overall_length']})\n";
echo "Last: {$allProducts[count($allProducts)-1]['name']}\n";

// Save parsed data for use
file_put_contents('tmp_products_data.php', '<?php return ' . var_export($allProducts, true) . ';');
echo "Saved to tmp_products_data.php\n";
