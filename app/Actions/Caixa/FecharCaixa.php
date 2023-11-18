<?php

namespace App\Actions\Caixa;

use App\Enums\StatusTransacoes;
use App\Exceptions\CaixaAindaTemTransacoesAbertasException;
use App\Exceptions\CaixaFechadoException;
use App\Models\Caixa;
use App\Models\Transacao;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class FecharCaixa
{
    use AsAction;

    public function handle(string $caixaId): array
    {
        $caixa = Caixa::query()
            ->with(['user', 'transacoes'])
            ->findOrFail($caixaId);

        $this->verificaTodasTransacoesFinalizadas($caixa);

        $caixa->update([
            'data_hora_fechamento' => now(),
            'valor_fechamento' => $this->calculaValorFechamento($caixa)
        ]);

        return $caixa->fresh()->toArray();
    }

    public function asController(Caixa $caixa, ActionRequest $request): JsonResponse
    {
        // TODO: Trocar essa linha para buscar o id do usuário autenticado
        $userId = User::first()->id;

        $this->verificaSeOCaixaEstaAberto($caixa);
        $this->verificaPermissaoUsuario($userId, $caixa);

        return response()->json($this->handle($caixa->id));
    }

    /** Métodos auxiliares */

    protected function verificaPermissaoUsuario(string $userId, Caixa $caixa): void
    {
        if ($userId !== $caixa->user_id) {
            throw new ModelNotFoundException;
        }
    }

    protected function verificaSeOCaixaEstaAberto(Caixa $caixa): void
    {
        if ($caixa->data_hora_fechamento) {
            throw new CaixaFechadoException;
        }
    }

    protected function verificaTodasTransacoesFinalizadas(Caixa $caixa): void
    {
        foreach ($caixa->transacoes as $transacao) {
            if ($transacao->status === StatusTransacoes::iniciada->name) {
                throw new CaixaAindaTemTransacoesAbertasException;
            }
        }
    }

    protected function calculaValorFechamento(Caixa $caixa): string
    {
        // TODO: Adicionar ao valor total somente as transacoes que tiverem com status finalizada
        return $caixa->transacoes->reduce(function ($initial, $transacao) {
            return bcadd($initial, $transacao->valor_total ?? 0, 2);
        }, 0);
    }
}
