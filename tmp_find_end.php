<?php
function findProductsArrayEnd($code, $startPos) {
    // $startPos is position of '$products = ['
    // Find the position of the '];' that closes the array
    // Individual products end with '],' and the array ends with '];'
    // We look for '];' at the same indentation level as '$products = ['
    
    // The $products array opens with '$products = [' at $startPos
    // It closes with '];' at some position. 
    // We scan for '];' patterns where the text after is not a continuation of the array
    
    $pos = $startPos;
    $depth = 0;
    $inString = false;
    $escape = false;
    
    for ($i = $startPos; $i < strlen($code); $i++) {
        if ($escape) { $escape = false; continue; }
        if ($code[$i] === '\\' && $inString) { $escape = true; continue; }
        if ($code[$i] === "'" && !$inString) { $inString = true; continue; }
        if ($code[$i] === "'" && $inString) { $inString = false; continue; }
        
        if (!$inString) {
            if ($code[$i] === '[') $depth++;
            if ($code[$i] === ']') $depth--;
            
            // When depth goes back to the level of the initial '[' (depth=0 means we're at the outer array level)
            // Actually, the $products array depth starts at 0 and goes to 1 when we enter [...]
            // Each product entry is [ ... ], so depth goes 1 -> 2 -> 1 -> 2 -> ...
            // The array closes with ]; where depth goes from 1 to 0
            
            if ($code[$i] === ']' && $depth === 0) {
                // Check if next non-whitespace is ; or ,
                // For the products array: ]; closes the assignment
                if ($i + 1 < strlen($code) && $code[$i + 1] === ';') {
                    return $i;
                }
            }
        }
    }
    return false;
}

// Test on current file
$c = file_get_contents('database/seeders/DatabaseSeeder.php');

// Find first $products = [
$first = strpos($c, '$products = [');
echo "First \$products at: $first\n";

// Find its end
$end = findProductsArrayEnd($c, $first);
if ($end !== false) {
    echo "End at: $end (character: '" . $c[$end] . $c[$end+1] . "')\n";
    echo "Context before: '" . substr($c, max(0,$end-30), 30) . "'\n";
    echo "Context after: '" . substr($c, $end+2, 60) . "'\n";
}

// Find ALL $products ends
$allStarts = [];
$pos = 0;
while (($pos = strpos($c, '$products = [', $pos)) !== false) {
    $allStarts[] = $pos;
    $pos++;
}
echo "\nTotal products blocks: " . count($allStarts) . "\n";
foreach ($allStarts as $i => $sp) {
    $ep = findProductsArrayEnd($c, $sp);
    if ($ep !== false) {
        echo "Block $i: $sp to $ep (len: " . ($ep-$sp) . ")\n";
    }
}

// The last products block's end + 2 is where the content after all products starts
$lastBlockEnd = findProductsArrayEnd($c, $allStarts[count($allStarts)-1]);
$afterAllProducts = substr($c, $lastBlockEnd + 2);
echo "\nAfter all products (first 200 chars):\n" . substr($afterAllProducts, 0, 200) . "\n";
echo "Contains \$products: " . (strpos($afterAllProducts, '$products = [') !== false ? 'YES' : 'NO') . "\n";
