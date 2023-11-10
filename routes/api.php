<?php

use App\Actions\Caixa\AbrirCaixa;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => ['Projeto' => config('app.name'), 'Versão' => config('app.version')]);

Route::prefix('v1')->group(function () {
    Route::get('/', fn () => ['Projeto' => config('app.name'), 'Versão' => '1.0.0']);

    Route::post('caixas/abrir', AbrirCaixa::class);
});
