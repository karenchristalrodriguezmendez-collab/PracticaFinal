<?php

use App\Models\User;

it('skipped api test', function () {
    $this->markTestSkipped('Saltado por mantenimiento');
})->group('error-types');

it('todo api test', function () {
    $this->markTestIncomplete('Pendiente de implementar roles');
})->group('error-types');

it('error api test', function () {
    throw new RuntimeException('Error simulado');
})->group('error-types');

it('risky api test', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');
})->group('error-types');