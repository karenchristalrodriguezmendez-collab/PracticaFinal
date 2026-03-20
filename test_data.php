<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Login as first user to bypass auth middleware
$user = \App\Models\User::first();
if ($user) {
    $app['auth']->guard()->setUser($user);
}

$request = Illuminate\Http\Request::create('/products/data', 'GET', [
    'draw' => 1,
    'start' => 0,
    'length' => 10,
    'search' => ['value' => ''],
    'order' => [[ 'column' => 0, 'dir' => 'asc' ]],
]);

$response = $kernel->handle($request);
echo "Status: " . $response->getStatusCode() . "\n";
echo "Content: " . substr($response->getContent(), 0, 1000) . "\n";
