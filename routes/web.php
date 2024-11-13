<?php

use Illuminate\Support\Facades\Route;

Route::get('/jit', function () {
  echo (function_exists('opcache_get_status')
    && opcache_get_status()['jit']['enabled']) ? 'JIT enabled' : 'JIT disabled';
});
Route::get('/csrf-token', function () {
  return response()->json(['csrf_token' => csrf_token()]);
});
