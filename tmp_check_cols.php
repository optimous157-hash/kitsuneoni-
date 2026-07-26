<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$cols = Schema::getColumnListing('faqs');
echo "FAQ columns: " . implode(', ', $cols) . "\n";
$f = DB::table('faqs')->first();
print_r($f);
