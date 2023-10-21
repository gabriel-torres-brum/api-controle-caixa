<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => ['Projeto' => config('app.name'), 'Versão' => config('app.version')]);

Route::group(['prefix' => 'v1'], function () {
    Route::get('/', fn () => ['Projeto' => config('app.name'), 'Versão' => '1.0.0']);
});
