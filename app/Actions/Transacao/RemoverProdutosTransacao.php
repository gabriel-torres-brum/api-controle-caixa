<?php

namespace App\Actions\Transacao;

use App\Exceptions\CaixaFechadoException;
use App\Exceptions\StatusTransacaoInvalidoParaAdicionarOuRemoverProdutosException;
use App\Models\Produto;
use App\Models\Statuses\Transacao\Iniciada;
use App\Models\Transacao;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class RemoverProdutosTransacao
{
    use AsAction;

    public function handle(string $transacaoId, array $produtosIds): void
    {
        $transacao = Transacao::query()->findOrFail($transacaoId);
        $produtos = $transacao->produtos()->findMany($produtosIds);

        DB::transaction(function () use ($transacao, $produtos, $produtosIds) {
            $produtos->each(function (Produto $produto) {
                $produto->update([
                    'qtd_estoque' => bcadd($produto->qtd_estoque, $produto->pivot->quantidade, 8)
                ]);
            });

            $transacao->produtos()->detach($produtosIds);
        });
    }

    public function asController(Transacao $transacao, ActionRequest $request): Response
    {
        // TODO: Trocar essa linha para buscar o id do usuário autenticado
        $userId = User::first()->id;

        $this->verificaPermissaoUsuario($userId, $transacao);
        $this->verificaCaixaTransacaoAberto($transacao);
        $this->verificaStatusTransacao($transacao);

        $this->handle($transacao->id, $request->input('produtos'));

        return response()->noContent();
    }

    public function rules(): array
    {
        return [
            'produtos' => ['required', 'array', 'min:1'],
            'produtos.*' => ['required', 'uuid'],
        ];
    }

    /** Métodos auxiliares */

    protected function verificaPermissaoUsuario(string $userId, Transacao $transacao): void
    {
        if ($userId !== $transacao->caixa->user_id) {
            throw new ModelNotFoundException;
        }
    }

    protected function verificaCaixaTransacaoAberto(Transacao $transacao): void
    {
        if ($transacao->caixa->data_hora_fechamento) {
            throw new CaixaFechadoException;
        }
    }

    protected function verificaStatusTransacao(Transacao $transacao): void
    {
        if (!$transacao->status->equals(Iniciada::class)) {
            throw new StatusTransacaoInvalidoParaAdicionarOuRemoverProdutosException;
        }
    }
}
