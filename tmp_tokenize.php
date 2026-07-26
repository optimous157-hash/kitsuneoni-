<?php
// Use PHP's tokenizer to extract all products from the corrupted seeder
$code = file_get_contents('database/seeders/DatabaseSeeder.php');

// Find $products = [...] block
$start = strpos($code, '$products = [');
$end = strrpos($code, '];');
$beforeProducts = substr($code, 0, $start + 12);
$productsContent = substr($code, $start + 12, $end - $start - 12);
$afterProducts = substr($code, $end + 2);

// Use token_get_all to parse the products content
$tokens = token_get_all("<?php\nreturn " . $productsContent . ";");
$products = eval("return " . $productsContent . ";");

echo "Parsed products: " . count($products) . "\n";
if (count($products) > 0) {
    echo "Product 0 name: " . $products[0]['name'] . "\n";
    echo "Product 0 steel: " . ($products[0]['steel_type'] ?? 'N/A') . "\n";
    echo "Product 0 length: " . ($products[0]['overall_length'] ?? 'N/A') . "\n";
    echo "Product 0 handle: " . ($products[0]['handle_material'] ?? 'N/A') . "\n";
    echo "Product 0 hardness: " . ($products[0]['hardness_hrc'] ?? 'N/A') . "\n";
}
