<?php
$request = Illuminate\Http\Request::create('/products/data', 'GET', [
    'draw' => '1',
    'start' => '0',
    'length' => '10',
    'search' => ['value' => '', 'regex' => 'false'],
    'order' => [
        ['column' => '0', 'dir' => 'asc']
    ]
]);

$user = \App\Models\User::first();
auth()->login($user);

try {
    $response = app()->make(Illuminate\Contracts\Http\Kernel::class)->handle($request);
    echo "Status: " . $response->getStatusCode() . "\n";
    echo "Content: " . substr($response->getContent(), 0, 500) . "...\n";
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}
