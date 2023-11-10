<?php

namespace App\Actions\Transacao;

use App\Exceptions\Caixa\CaixaFechadoHttpException;
use App\Exceptions\Produto\EstoqueProdutoInsuficienteHttpException;
use App\Exceptions\Transacao\StatusTransacaoInvalidoParaAdicionarProdutosHttpException;
use App\Models\Produto;
use App\Models\Transacao;
use App\Models\TransacoesStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class AdicionarProdutoTransacao
{
    use AsAction;

    public function handle(string $transacaoId, string $produtoId, string $quantidade): void
    {
        $transacao = Transacao::query()->with(['status', 'caixa'])->findOrFail($transacaoId);
        $produto = Produto::query()->findOrFail($produtoId);;

        DB::transaction(function () use ($transacao, $produto, $quantidade) {
            $transacao->update([
                'valor_total' => bcadd($transacao->valor_total, $this->calculaValorUnidadeProduto($produto), 2)
            ]);

            $transacao->produtos()->sync([$produto->id => ['quantidade' => $quantidade]]);
        });
    }

    public function asController(Transacao $transacao, Produto $produto, ActionRequest $request): Response
    {
        // TODO: Trocar essa linha para buscar o id do usuário autenticado
        $userId = User::first()->id;

        $this->verificaPermissaoUsuario($userId, $transacao);
        $this->verificaCaixaTransacaoAberto($transacao);
        $this->verificaStatusTransacao($transacao);

        $this->handle($transacao->id, $produto->id, $request->input('quantidade'));

        return response()->noContent();
    }

    public function rules(): array
    {
        return [
            'quantidade' => ['required', 'string', 'numeric']
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
            throw new CaixaFechadoHttpException;
        }
    }

    protected function verificaStatusTransacao(Transacao $transacao): void
    {
        if (
            !in_array(
                $transacao->status->nome,
                TransacoesStatus::STATUS_PERMITIDOS_PARA_ADICIONAR_PRODUTOS
            )
        ) {
            throw new StatusTransacaoInvalidoParaAdicionarProdutosHttpException;
        }
    }

    protected function calculaValorUnidadeProduto(Produto $produto): string
    {
        $porcentagemLucroUnidade = bcdiv($produto->porcentagem_lucro_unidade, 100, 2);
        $valorSomarValorProduto = bcmul($produto->valor_unidade, $porcentagemLucroUnidade, 2);

        return bcadd($produto->valor_unidade, $valorSomarValorProduto, 2);
    }

    protected function verificaEstoqueProduto(Produto $produto, string $quantidade): void
    {
        if ($produto->quantidade_estoque < $quantidade) {
            throw new EstoqueProdutoInsuficienteHttpException;
        }
    }
}
