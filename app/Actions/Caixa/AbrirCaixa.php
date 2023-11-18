<?php

namespace App\Actions\Caixa;

use App\Exceptions\CaixaAnteriorAindaEstaAbertoException;
use App\Models\Caixa;
use App\Models\User;
use Illuminate\Http\Response;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class AbrirCaixa
{
    use AsAction;

    public function handle(string $userId): array
    {
        return Caixa::query()
            ->create([
                'user_id' => $userId
            ])
            ->refresh()
            ->toArray();
    }

    public function asController(ActionRequest $request): Response
    {
        // TODO: Trocar essa linha para buscar o id do usuário autenticado
        $userId = User::first()->id;

        $this->verificaPermissaoUsuario($userId);
        $this->verificaJaExisteUmCaixaAbertoParaOUsuario($userId);

        return response($this->handle($userId));
    }

    /** Métodos auxiliares */

    protected function verificaPermissaoUsuario(string $userId): void
    {
        // TODO: Verificar se o usuário tem permissão para abrir um caixa
    }

    protected function verificaJaExisteUmCaixaAbertoParaOUsuario(string $userId): void
    {
        $caixaAnteriorDoUsuario = Caixa::query()
            ->where('user_id', $userId)
            ->latest()
            ->first();

        if ($caixaAnteriorDoUsuario && !$caixaAnteriorDoUsuario->data_hora_fechamento) {
            throw new CaixaAnteriorAindaEstaAbertoException;
        }
    }
}
