<?php
$c = file_get_contents('database/seeders/DatabaseSeeder.php');
preg_match_all("/'short_description'\s*=>\s*'([^']+)'/", $c, $sm);
echo "Total short_descriptions: " . count($sm[1]) . "\n";
for ($i = 0; $i < min(5, count($sm[1])); $i++) {
    echo "  $i: {$sm[1][$i]}\n";
}
// Verify no AI-sounding phrases remain
$checks = ['hand-forged T10', 'differential clay tempering', 'multi-layered pattern', 'hand-forged from high-carbon', 'premium collectible'];
foreach ($checks as $chk) {
    if (str_contains($c, $chk)) {
        echo "FOUND AI phrase: $chk\n";
    } else {
        echo "OK - $chk removed\n";
    }
}
