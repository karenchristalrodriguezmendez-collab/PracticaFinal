<?php
try {
    require __DIR__.'/test_data.php';
} catch (\Throwable $e) {
    file_put_contents('error_trace.txt', $e->getMessage() . "\n" . $e->getTraceAsString());
}
