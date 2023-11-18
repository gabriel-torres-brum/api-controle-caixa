<?php

use App\Actions\Caixa\AbrirCaixa;
use App\Actions\Caixa\VisualizarCaixa;
use App\Actions\Caixa\FecharCaixa;
use App\Actions\Transacao\AdicionarProdutoTransacao;
use App\Actions\Caixa\RegistrarTransacaoCaixa;
use App\Actions\Transacao\RemoverProdutosTransacao;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => ['Projeto' => config('app.name'), 'Versão' => config('app.version')]);

Route::prefix('v1')->group(function () {
    Route::get('/', fn () => ['Projeto' => config('app.name'), 'Versão' => '1.0.0']);

    Route::post('caixas', AbrirCaixa::class);
    Route::get('caixas/{caixa}', VisualizarCaixa::class);
    Route::patch('caixas/{caixa}/fechar', FecharCaixa::class);
    Route::post('caixas/{caixa}/transacoes', RegistrarTransacaoCaixa::class);

    Route::patch('transacoes/{transacao}/produtos/remover', RemoverProdutosTransacao::class);
    Route::patch('transacoes/{transacao}/produtos/{produto}', AdicionarProdutoTransacao::class);

    // TODO: Criar endpoint para listar produtos
    // TODO: Criar endpoint para remover produtos da transação
    // TODO: Criar endpoint para diminuir quantidade de um produto de uma transação
});
