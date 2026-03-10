<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/products/data', 'GET', [
    'draw' => 1,
    'start' => 0,
    'length' => 10,
    'order' => [
        0 => ['column' => 0, 'dir' => 'desc']
    ]
]);
$response = $kernel->handle($request);
echo $response->getContent();
