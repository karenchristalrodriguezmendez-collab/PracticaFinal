<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $count = \App\Models\Product::count();
    echo "Product count: " . $count . "\n";
    echo "DATABASE OK\n";
} catch (\Exception $e) {
    echo "DATABASE ERROR: " . $e->getMessage() . "\n";
}
