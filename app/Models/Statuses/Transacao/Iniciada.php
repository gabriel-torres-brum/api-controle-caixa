<?php

namespace App\Models\Statuses\Transacao;

class Iniciada extends TransacaoStatus
{
    public function label(): string
    {
        return 'Iniciada';
    }

    public function descricao(): string
    {
        return 'Transação iniciada.';
    }
}
