<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;

class TestDataTable extends Command
{
    protected $signature = 'test:datatable';
    protected $description = 'Test the datatable logic manually';

    public function handle()
    {
        $request = Request::create('/products/data', 'GET', [
            'draw' => 1,
            'start' => 0,
            'length' => 10,
            'search' => ['value' => ''],
            'order' => [['column' => 0, 'dir' => 'asc']]
        ]);

        $controller = app(ProductController::class);
        $response = $controller->dataTable($request);
        
        $this->info("STATUS CODE: " . $response->getStatusCode());
        $this->info("CONTENT: " . $response->getContent());
    }
}
