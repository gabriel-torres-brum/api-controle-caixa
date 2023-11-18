<?php

namespace App\Models\Statuses\Transacao;

class Concluida extends TransacaoStatus
{
    public function label(): string
    {
        return 'Concluída';
    }

    public function descricao(): string
    {
        return 'Transação concluída com sucesso.';
    }
}
