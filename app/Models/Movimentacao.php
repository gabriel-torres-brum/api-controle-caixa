<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movimentacao extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'movimentacoes';
    protected $guarded = [];

    public const ENTRADA = 'entrada';
    public const SAIDA = 'saida';

    public function caixa(): BelongsTo
    {
        return $this->belongsTo(Caixa::class);
    }
}
