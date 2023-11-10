<?php

namespace App\Actions\Transacao;

use App\Exceptions\Caixa\CaixaFechadoHttpException;
use App\Models\Caixa;
use App\Models\Transacao;
use App\Models\TransacoesStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class RegistrarTransacao
{
    use AsAction;

    public function handle(string $caixaId, string $tipo): array
    {
        return Transacao::query()
            ->create([
                'caixa_id' => $caixaId,
                'status_id' => TransacoesStatus::byNome(TransacoesStatus::NO_CARRINHO)->id,
                'tipo' => $tipo,
                'valor_total' => 0
            ])
            ->refresh()
            ->toArray();
    }

    public function asController(string $caixaId, ActionRequest $request): JsonResponse
    {
        // TODO: Trocar essa linha para buscar o id do usuário autenticado
        $userId = User::first()->id;

        $caixa = Caixa::query()->findOrFail($caixaId);

        $this->verificaPermissaoUsuario($userId, $caixa);
        $this->verificaSeOCaixaEstaAberto($caixa);

        return response()->json(
            $this->handle($caixa->id, $request->input('tipo'))
        );
    }

    public function rules(): array
    {
        return [
            'tipo' => ['required', 'in:' . implode(',', [Transacao::ENTRADA, Transacao::SAIDA])]
        ];
    }

    /** Métodos auxiliares */

    protected function verificaPermissaoUsuario(string $userId, Caixa $caixa): void
    {
        if ($userId !== $caixa->user_id) {
            throw new ModelNotFoundException;
        }
    }

    protected function verificaSeOCaixaEstaAberto(Caixa $caixa)
    {
        if ($caixa->data_hora_fechamento) {
            throw new CaixaFechadoHttpException;
        }
    }
}
