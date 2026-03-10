<?php
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Models\Product;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$app->make('auth')->shouldUse('web');
// Simular un usuario si es necesario, pero dataTable no parece requerir uno explícitamente más allá del middleware

$controller = $app->make(ProductController::class);
$request = new Request([
    'draw' => 1,
    'start' => 0,
    'length' => 10,
    'order' => [
        0 => ['column' => 1, 'dir' => 'asc']
    ],
    'search' => ['value' => '']
]);

try {
    $response = $controller->dataTable($request);
    echo "RESPONSE_START\n";
    echo $response->getContent();
    echo "\nRESPONSE_END\n";
} catch (\Exception $e) {
    echo "ERROR_START\n";
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString();
    echo "\nERROR_END\n";
}
