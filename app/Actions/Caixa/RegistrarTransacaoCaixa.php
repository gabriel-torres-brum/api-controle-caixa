<?php

namespace App\Actions\Caixa;

use App\Enums\StatusTransacoes;
use App\Exceptions\CaixaFechadoException;
use App\Models\Caixa;
use App\Models\Transacao;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class RegistrarTransacaoCaixa
{
    use AsAction;

    public function handle(string $caixaId): array
    {
        return Transacao::query()
            ->create(['caixa_id' => $caixaId])
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
            $this->handle($caixa->id)
        );
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
            throw new CaixaFechadoException;
        }
    }
}
