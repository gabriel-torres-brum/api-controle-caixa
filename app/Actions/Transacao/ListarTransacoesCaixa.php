<?php

namespace App\Actions\Transacao;

use App\Models\Caixa;
use App\Models\Transacao;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class ListarTransacoesCaixa
{
    use AsAction;

    public function handle(string $caixaId): array
    {
        return Transacao::query()
            ->where('caixa_id', $caixaId)
            ->latest()
            ->get()
            ->toArray();
    }

    public function asController(Caixa $caixa, ActionRequest $request): JsonResponse
    {
        // TODO: Trocar essa linha para buscar o id do usuário autenticado
        $userId = User::first()->id;

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
}
