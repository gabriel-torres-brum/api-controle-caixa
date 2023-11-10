<?php

namespace App\Actions\Caixa;

use App\Exceptions\Caixa\CaixaFechadoHttpException;
use App\Models\Caixa;
use App\Models\User;
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

        $caixa->update([
            'valor_fechamento' => $this->calculaValorFechamento($caixa),
            'data_hora_fechamento' => now()
        ]);

        return $caixa->fresh()->toArray();
    }

    public function asController(Caixa $caixa, ActionRequest $request): JsonResponse
    {
        $this->verificaSeOCaixaEstaAberto($caixa);

        return response()->json($this->handle($caixa->id));
    }

    /** Métodos auxiliares */

    protected function verificaSeOCaixaEstaAberto(Caixa $caixa): void
    {
        if ($caixa->data_hora_fechamento) {
            throw new CaixaFechadoHttpException;
        }
    }

    protected function calculaValorFechamento(Caixa $caixa): string
    {
        return $caixa->transacoes->reduce(function ($initial, $transacao) {
            return bcadd($initial, $transacao->valor_total, 2);
        }, 0);
    }
}
