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
if ($user) {
    auth()->login($user);
}

$kernel = app()->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request);

echo "STATUS_CODE: " . $response->getStatusCode() . "\n";
echo "RESPONSE_BODY_START\n";
echo $response->getContent();
echo "\nRESPONSE_BODY_END\n";
