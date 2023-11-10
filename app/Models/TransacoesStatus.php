<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransacoesStatus extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'transacoes_status';
    protected $guarded = [];

    public const NO_CARRINHO = 'no_carrinho';
    public const CANCELADA = 'cancelada';
    public const AGUARDANDO_PAGAMENTO = 'aguardando_pagamento';
    public const PROCESSANDO_PAGAMENTO = 'processando_pagamento';
    public const ERRO_PAGAMENTO = 'erro_pagamento';
    public const FINALIZADA = 'finalizada';

    public const STATUS_PERMITIDOS_PARA_ADICIONAR_PRODUTOS = [
        self::NO_CARRINHO
    ];

    public function transacoes(): HasMany
    {
        return $this->hasMany(Transacao::class);
    }

    public static function byNome(string $nome): self
    {
        return self::query()->firstWhere('nome', $nome);
    }
}
