<?php
$logFile = __DIR__.'/storage/logs/laravel.log';
$lines = file($logFile);
$errors = [];
$capture = false;
$currentError = [];

// Reverse the array to search from bottom
$lines = array_reverse($lines);

for ($i = 0; $i < min(1000, count($lines)); $i++) {
    $line = $lines[$i];
    if (strpos($line, '[2026-') === 0 && strpos($line, ' local.ERROR: ') !== false) {
        $errors[] = $line;
        if (count($errors) >= 5) break;
    }
}

foreach ($errors as $error) {
    echo $error . "\n";
}
