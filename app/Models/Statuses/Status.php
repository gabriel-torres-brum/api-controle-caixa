<?php

namespace App\Models\Statuses;

use Spatie\ModelStates\State;

abstract class Status extends State
{
    abstract public function label(): string;

    abstract public function descricao(): string;

    public static function getMorphClass(): string
    {
        return static::$nome ?? str(last(explode("\\", static::class)))->slug()->value();
    }
}
