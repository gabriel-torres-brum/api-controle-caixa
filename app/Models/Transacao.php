<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transacao extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'transacoes';
    protected $guarded = [];

    public const ENTRADA = 'entrada';
    public const SAIDA = 'saida';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TransacoesStatus::class);
    }

    public function produtos(): BelongsToMany
    {
        return $this->belongsToMany(Produto::class);
    }

    public function caixa(): BelongsTo
    {
        return $this->belongsTo(Caixa::class);
    }
}
