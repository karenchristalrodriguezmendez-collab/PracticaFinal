<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/products/data', 'GET', [
    'draw' => '1',
    'start' => '0',
    'length' => '10',
    'search' => ['value' => '', 'regex' => 'false'],
    'order' => [
        ['column' => '0', 'dir' => 'asc']
    ]
]);

// We need to bypass auth or authenticate a user
$user = \App\Models\User::first();
$app->make('auth')->login($user);

$response = $kernel->handle($request);
echo "Status: " . $response->getStatusCode() . "\n";
echo "Content: " . $response->getContent() . "\n";
