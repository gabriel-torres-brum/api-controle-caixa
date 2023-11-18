<?php

namespace App\Models\Statuses\Transacao;

class Cancelada extends TransacaoStatus
{
    public function label(): string
    {
        return 'Cancelada';
    }

    public function descricao(): string
    {
        return 'Transação cancelada.';
    }
}
