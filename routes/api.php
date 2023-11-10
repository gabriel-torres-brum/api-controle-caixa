<?php

use App\Actions\Caixa\AbrirCaixa;
use App\Actions\Caixa\FecharCaixa;
use App\Actions\Transacao\AdicionarProdutoTransacao;
use App\Actions\Transacao\ListarTransacoesCaixa;
use App\Actions\Transacao\RegistrarTransacao;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => ['Projeto' => config('app.name'), 'Versão' => config('app.version')]);

Route::prefix('v1')->group(function () {
    Route::get('/', fn () => ['Projeto' => config('app.name'), 'Versão' => '1.0.0']);

    Route::post('caixas/abrir', AbrirCaixa::class);
    Route::patch('caixas/{caixa}/fechar', FecharCaixa::class);
    Route::post('caixas/{caixa}/transacoes', RegistrarTransacao::class);
    Route::get('caixas/{caixa}/transacoes', ListarTransacoesCaixa::class);

    Route::post('transacoes/{transacao}/produtos/{produto}', AdicionarProdutoTransacao::class);

    // TODO: Criar endpoint para listar produtos
});
