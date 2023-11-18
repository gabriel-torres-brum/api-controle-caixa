<?php

namespace App\Models\Statuses\Transacao;

use Spatie\ModelStates\StateConfig;
use App\Models\Statuses\Status;

abstract class TransacaoStatus extends Status
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Iniciada::class)
            ->allowTransition(Iniciada::class, Concluida::class)
            ->allowTransition(Iniciada::class, Cancelada::class);
    }
}
