<?php

use App\Services\FileService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    Storage::fake('public');
});

it('sube y elimina archivo', function () {
    $service = new FileService();
    $file = UploadedFile::fake()->image('f.jpg', 100, 100);
    $result = $service->upload($file, 'products');
    expect($result['success'])->toBeTrue();
    Storage::disk('public')->assertExists($result['path']);
    $deleted = $service->delete($result['path']);
    expect($deleted)->toBeTrue();
});

it('obtiene info de archivo', function () {
    $service = new FileService();
    $file = UploadedFile::fake()->image('f2.jpg');
    $result = $service->upload($file, 'products');
    $info = $service->getFileInfo($result['path']);
    expect($info['filename'])->toBe(basename($result['path']));
    expect($info['extension'])->toBe('jpg');
});