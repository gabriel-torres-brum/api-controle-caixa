<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Produto extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'produtos';
    protected $guarded = [];

    public function transacoes(): BelongsToMany
    {
        return $this->belongsToMany(Transacao::class, 'caixas_produto_transacao')
            ->withPivot(['quantidade', 'valor_unidade_final']);
    }

    public function unidadeMedida(): BelongsTo
    {
        return $this->belongsTo(UnidadeMedida::class);
    }
}
